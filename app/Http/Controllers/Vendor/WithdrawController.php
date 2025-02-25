<?php

namespace App\Http\Controllers\Vendor;
use App\Http\Controllers\Controller;

use App\OrderDetail;
use App\Shop;
use App\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('notOperator');
        $this->middleware('notVendor')->except(['index','create','store']);
    }

    public function index()
    {

        if (Auth::user()->type == 'vendor'){
            $user = Auth::user();
            $data['title'] = $user->shop->name;
            $data['withdraws'] = Withdraw::withTrashed()->where('shop_id', $user->shop->id)->get();
        }
        else{
            $data['title'] = 'Withdraws';
            $data['withdraws'] = Withdraw::withTrashed()->with('user')->latest()->get();
        }

        return view('back.vendor.withdraw.index', $data);
    }

    public function single($slug)
    {
        //$id = base64_decode($id);
        $shop = Shop::where('slug', $slug)->first();
        $data['title'] = $shop->name;
        $data['withdraws'] = Withdraw::withTrashed()->where('shop_id', $shop->id)->get();

        return view('back.vendor.withdraw.index', $data);
    }


    public function pending()
    {
        $data['title'] = 'Pending Withdraws';
        $data['withdraws'] = Withdraw::with('user')->where('status', 'Pending')->get();

        return view('back.vendor.withdraw.index', $data);
    }

    public function processing()
    {
        $data['title'] = 'Processing Withdraws';
        $data['withdraws'] = Withdraw::where('status', 'Processing')->get();

        return view('back.vendor.withdraw.index', $data);
    }

    public function completed()
    {
        $data['title'] = 'Completed Withdraws';
        $data['withdraws'] = Withdraw::where('status', 'Completed')->get();

        return view('back.vendor.withdraw.index', $data);
    }

    public function rejected()
    {
        $data['title'] = 'Rejected Withdraws';
        $data['withdraws'] = Withdraw::onlyTrashed()->get();

        return view('back.vendor.withdraw.index', $data);
    }


    public function change_status($id,$status)
    {
        if($status == 'Pending' || $status == 'Processing' || $status == 'Completed')
        {
            Withdraw::findOrFail($id)->update(['status'=>$status,'updated_by'=>Auth::user()->id]);

            //update mail send to user
            /*$order = Order::with('user')->findOrFail($order_id);
            $email = $order->user->email;
            Mail::to($email)->send(new OrderUpdate($order));*/


            session()->flash('success','Status Changed');
        }
        else{
            session()->flash('error','Something Went Wrong');
        }
        return redirect()->back();
    }


    public function create()
    {
        $data['title'] = 'Withdraw';
        $user = Auth::user();

        // balance calculation
        $last_withdraw = Withdraw::where('shop_id', $user->shop->id)->latest()->first();
        if ($last_withdraw){
            $sell = OrderDetail::where('shop_id', $user->shop->id)->where('status', 'Delivered')->where('created_at','>', $last_withdraw->created_at)->sum('total');
        }
        else{
            $sell = OrderDetail::where('shop_id', $user->shop->id)->where('status', 'Delivered')->sum('total');
        }
        $calculation = $sell / 100 * $user->shop->commission;
        $commission = round($calculation);
        $net_sell = $sell  - $commission;
        //$withdraw = Withdraw::where('shop_id', $user->shop->id)->sum(\DB::raw('amount'));
        $available = $net_sell + $user->shop->balance;

        $data['balance'] = $available;

        return view('back.vendor.withdraw.create', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'amount'=>'required|numeric',
        ]);
        $data = $request->except('_token');

        $user = Auth::user();

        if ($user->shop->bank == null || $user->shop->acc_no == null || $user->shop->acc_name == null){
            session()->flash('error','Bank Information Not Found');
            return redirect()->route('vendor.shop');
        }
        $data['shop_id'] = $user->shop->id;
        $data['bank'] = $user->shop->bank;
        $data['branch'] = $user->shop->branch;
        $data['acc_name'] = $user->shop->acc_name;
        $data['acc_no'] = $user->shop->acc_no;
        $data['routing_no'] = $user->shop->routing_no;


        //balance calculation and check
        $last_withdraw = Withdraw::where('shop_id', $user->shop->id)->latest()->first();
        if ($last_withdraw){
            $sell = OrderDetail::where('shop_id', $user->shop->id)->where('status', 'Delivered')->where('created_at','>', $last_withdraw->created_at)->sum('total');
        }
        else{
            $sell = OrderDetail::where('shop_id', $user->shop->id)->where('status', 'Delivered')->sum('total');
        }
        $calculation = $sell / 100 * $user->shop->commission;
        $commission = round($calculation);
        $net_sell = $sell  - $commission;

        //$withdraw = Withdraw::where('shop_id', $user->shop->id)->sum(\DB::raw('amount'));
        $available = $net_sell + $user->shop->balance;

        $balance = $available - $request->amount;

        if ($request->amount > $available){
            session()->flash('error','Insufficient Balance');
            return redirect()->back();
        }


        //check this month withdraw
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $find = Withdraw::withTrashed()->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->first();
        if ($find){
            session()->flash('error','Already have an withdraw, Plz wait for the next withdraw');
            return redirect()->back();
        }



        Withdraw::create($data);
        $user->shop->update(['balance'=>$balance]);

        session()->flash('success','Withdraw submitted Successfully');
        return redirect()->route('withdraw.index');

    }


    public function destroy($id)
    {
        $withdraw = Withdraw::findOrFail($id);
        $updated = $withdraw->update(['updated_by'=>Auth::user()->id]);
        $withdraw->delete();

        session()->flash('success','Withdraw Rejected Successfully');
        return redirect()->back();
    }


    public function restore($id)
    {
        $withdraw = Withdraw::onlyTrashed()->findOrFail($id);
        $updated = $withdraw->update(['updated_by'=>Auth::user()->id]);
        $withdraw->restore();

        session()->flash('success','Withdraw Reopened Successfully');
        return redirect()->back();
    }

}
