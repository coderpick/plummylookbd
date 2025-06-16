<?php

namespace App\Http\Controllers;

use App\Order;
use App\Voucher;
use App\VoucherUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['notVendor','notOperator']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.coupon.index');
        $data['title'] = 'Coupon';
        $data['vouchers'] = Voucher::withTrashed()->paginate(10);
        return view('back.voucher.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('app.coupon.index');
        $data['title'] = 'Coupon';
        return view('back.voucher.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required|unique:vouchers',
            'coupon_type'=>'required',
            'value'=>'required',
            'min_limit'=>'required',
            'expires_at'=>'required',
        ]);
        $data = $request->except('_token');

        $slug = Str::slug($request->code, '-');
        $data['slug'] = $slug;


        Voucher::create($data);
        session()->flash('success','Coupon Created Successfully');
        return redirect()->route('coupon.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        Gate::authorize('app.coupon.index');
        $data['title'] = 'Coupon';
        $data['voucher'] = Voucher::where('slug', $slug)->first();
        return view('back.voucher.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'code'=>'required',
            'coupon_type'=>'required',
            'value'=>'required',
            'min_limit'=>'required',
            'expires_at'=>'required',
        ]);

        $voucher = Voucher::where('slug', $slug)->first();
        $data = $request->except('_token');

        if (!$request->type){
            $data['type'] = 0;
        }

        $slug = Str::slug($request->code, '-');
        $data['slug'] = $slug;


        $voucher->update($data);
        session()->flash('success','Coupon Updated Successfully');
        return redirect()->route('coupon.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $voucher = Voucher::where('slug', $slug)->first();
        $voucher->delete();
        session()->flash('success','Coupon Deleted Successfully');
        return redirect()->route('coupon.index');
    }

    public function restore($id)
    {
        $voucher = Voucher::onlyTrashed()->findOrFail($id);
        $voucher->restore();
        session()->flash('success','Coupon Restored Successfully');
        return redirect()->route('coupon.index');
    }

    public function delete($id)
    {
        $voucher = Voucher::onlyTrashed()->findOrFail($id);
        $voucher->forceDelete();
        session()->flash('success','Coupon Permanently Removed');
        return redirect()->route('coupon.index');
    }


    public function discount(Request $request,$id)
    {
        $order = Order::findOrFail($id) ;

        //check voucher exist or not
        $coupon = Voucher::where('code', $request->coupon_code)->first();
        if (!$coupon) {
            session()->flash('error','Invalid Voucher Code');
            return redirect()->back();
        }


        //check voucher used or not
        $coupon_user = VoucherUser::where(['user_id' => Auth::user()->id, 'voucher_id' => $coupon->id])->first();
        if ($coupon_user) {
            session()->flash('error','Coupon Already Used');
            return redirect()->back();
        }


        $date = Carbon::today()->toDateString();
        $exp = $coupon->expires_at;

        if ($exp >= $date){
            $total = $order->amount - $order->shipping;

            if ($order->discount == null && $total >= $coupon->min_limit){

                if ($coupon->coupon_type == 'percentage'){
                    $amount = $order->amount - $order->shipping;
                    $amount = $amount / 100;
                    $dis = $amount*$coupon->value;
                    $dis = round($dis);
                    $total = $order->amount - $dis;
                    $discount = $coupon->value.'%';
                }
                if ($coupon->coupon_type == 'fixed'){
                    $discount = $coupon->value;
                    $total = $order->amount - $coupon->value;
                }


                //check voucher type once or not and insert user data
                if ($coupon->type == 1) {
                    $data['user_id']= Auth::user()->id;
                    $data['voucher_id']= $coupon->id;
                    VoucherUser::create($data);
                }


                $order->update(['amount' => $total, 'discount' => $discount]);

                session()->flash('success','Coupon Applied Successfully');
                return redirect()->back();
            }
            else{
                session()->flash('error','Not eligible for Coupon');
                return redirect()->back();
            }
        }
        else{
            session()->flash('error','Coupon Expired');
            return redirect()->back();
        }


    }


    public function coupon_apply(Request $request)
    {
        $total = 0;
        $coupon_id = session('coupon_id');

        //cart total
        if(session('cart') != null){
            foreach (session('cart') as $item){
                $total += $item['quantity'] * ($item['new_price'])? $item['new_price']: $item['price'];
            }
        }

        //check voucher exist or not
        $coupon = Voucher::where('code', $request->coupon_code)->first();
        if (!$coupon) {
            session()->flash('error','Invalid Voucher Code');
            return redirect()->back();
        }

        //check one time voucher used or not
        if (Auth::user()){
            $coupon_user = VoucherUser::where(['user_id' => Auth::user()->id, 'voucher_id' => $coupon->id])->first();
            if ($coupon_user) {
                session()->flash('error','Coupon Already Used');
                return redirect()->back();
            }
        }

        //coupon check to prevent double use
        if ($coupon_id == $coupon->id) {
            session()->flash('error','Already Used');
            return redirect()->back();
        }

        $date = Carbon::today()->toDateString();
        $exp = $coupon->expires_at;
        if ($exp >= $date){

            if ($total >= $coupon->min_limit){

                if ($coupon->coupon_type == 'percentage'){
                    $amount = $total;
                    $amount = $amount / 100;
                    $dis = $amount*$coupon->value;
                    $dis = round($dis);
                    $total = $total - $dis;
                    $discount = $dis;
                    $percent = $coupon->value;
                }
                if ($coupon->coupon_type == 'fixed'){
                    $discount = $coupon->value;
                    $total = $total - $coupon->value;
                    $percent = null;
                }

                //check voucher type once or not and store data in session
                session()->put('coupon_type', $coupon->type);
                session()->put('coupon_id', $coupon->id);
                session()->put('discount', $discount);
                session()->put('percent', $percent);

                session()->flash('success','Coupon Applied Successfully');
                return redirect()->back();
            }
            else{
                session()->flash('error','Not eligible for Coupon');
                return redirect()->back();
            }
        }
        else{
            session()->flash('error','Coupon Expired');
            return redirect()->back();
        }

    }

}
