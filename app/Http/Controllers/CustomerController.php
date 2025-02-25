<?php

namespace App\Http\Controllers;

use App\Dispute;
use App\District;
use App\Flash;
use App\Mail\OrderPlaceMail;
use App\Order;
use App\OrderDetail;
use App\Point;
use App\Product;
use App\Review;
use App\Shipping;
use App\Ticket;
use App\User;
use App\UserDetail;
use App\VoucherUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //check user is admin or not
        if (Auth::user()->type !== 'user'){
            return redirect()->route('user.info');
        }

        $data['title'] = 'My Account';
        $data['districts'] = District::orderBy('name','ASC')->get();
        $id = Auth::user()->id;
        $data['order_count'] = Order::where('user_id', $id)->count();
        $data['dispute_count'] = Dispute::withTrashed()->where('user_id', $id)->count();
        $data['ticket_count'] = Ticket::withTrashed()->where('user_id', $id)->count();
        $data['review_count'] = Review::withTrashed()->where('user_id', $id)->count();
        $data['balance'] = Point::where('user_id', $id)->first();
        return view('front.customer.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*if (Auth::user()->type !== 'user'){
            session()->flash('error', 'Unauthorized Request');
            return redirect()->back();
        }*/

        if (Auth::user()->detail == null){
            session()->flash('warning', 'Address Not Found, Complete Profile First');
            return redirect()->route('account');
        }

        //Transaction start
        DB::beginTransaction();
        try {

           $customer = Auth::user();


            //order store
            $order['order_number'] = '#'.$customer->id.time();
            $order['user_id'] = $customer->id;
            $order['name'] = $customer->name;
            $order['email'] = $customer->email;
            $order['phone'] = $customer->phone;
            $order['transaction_id'] = rand(000,999).uniqid();
            $order['payment_type'] = $request->payment_type;
            $order['date'] = now();
            if ($request->address_1 != null){
                $order['address'] = $request->address_1.', '.$request->address_2;
                $order['district_id'] = $request->district;
                $order['zip'] = $request->zip;
            }
            else{
                $order['address'] = $customer->detail->address_1.', '. $customer->detail->address_2;
                $order['district_id'] = $customer->detail->district->id;
                $order['zip'] = $customer->detail->zip;
            }

            $order_id = Order::insertGetId($order);

            //dd($order_id);


            //order details store
            $cart = session('cart');
            $total = 0;
            $shipping = 0;
            $sub_total = 0;

            $setting = Shipping::first();
           // $shipping = $setting->shipping;
           // $free_shipping = $setting->free_shipping;

            if (count($cart)) {
                foreach ($cart as $item) {
                    $product = Product::findOrFail($item['product_id']);

                    if(isset($item['flash_price']) && $item['flash_price'] != null){
                        $pr_stock = $product->flash->flash_stock;
                    }else{
                        $pr_stock = $product->stock;
                    }

                    if ($pr_stock >= $item['quantity']){

                        $order_details['order_id'] = $order_id;
                        $order_details['product_id'] = $item['product_id'];
                        $order_details['shop_id'] = $item['shop_id'];
                        $order_details['product_name'] = $item['name'];

                        if (isset($item['flash_price']) && $item['flash_price'] != null){
                            $order_details['price'] = $item['flash_price'];
                        }else{
                            $order_details['price'] = ($item['new_price'])? $item['new_price']: $item['price'];
                        }

                        $order_details['quantity'] = $item['quantity'];
                        $order_details['status'] = 'Pending';

                        $order_details['total'] = $item['quantity'] * $order_details['price'];
                        $order_details['point'] = $item['quantity'] * $item['point'];

                        OrderDetail::create($order_details);

                        $total += $order_details['total'];



                        if ($request->district == 47){
                            if ($setting->charge_by == 'quantity'){
                                $shipping += $item['quantity'] * $setting->shipping;
                            }
                            if ($setting->charge_by == 'product'){
                                $shipping += $setting->shipping;
                            }
                            if ($setting->charge_by == 'order'){
                                $shipping = $setting->shipping;
                            }
                        }
                        else{
                            if ($setting->charge_by == 'quantity'){
                                $shipping += $item['quantity'] * $setting->shipping2 ;
                            }
                            if ($setting->charge_by == 'product'){
                                $shipping += $setting->shipping2 ;
                            }
                            if ($setting->charge_by == 'order'){
                                $shipping = $setting->shipping2 ;
                            }
                        }

                        //product stock update
                        $product->stock = $product->stock - $item['quantity'];
                        $product->save();

                        //flash stock update
                        $flash = Flash::where('product_id', $item['product_id'])->first();
                        if($flash){
                            $flash->flash_stock = $flash->flash_stock - $item['quantity'];
                            $flash->save();
                        }
                    }
                    else{
                        session()->flash('warning',ucfirst($item['name']).' '.'is out of stock');
                        return redirect()->route('cart');
                    }
                }
            }

            $coupon_id = session('coupon_id');
            $coupon_type = session('coupon_type');
            $discount = session('discount');

            if ($coupon_type == 1) {
                $data['user_id']= Auth::user()->id;
                $data['voucher_id']= $coupon_id;
                VoucherUser::create($data);
            }

            if ($total >= $setting->free_shipping){
                if ($discount != null){
                    $total = $total - $discount;
                }

                Order::findOrFail($order_id)->update(['amount' => $total, 'discount' => $discount]);
            }
            else{
                if ($discount != null){
                    $total = $total - $discount;
                }
                Order::findOrFail($order_id)->update(['amount' => $total+$shipping,'shipping' => $shipping, 'discount' => $discount]);
            }





            //Confirmation mail send
            //$customer = User::findOrFail($customer_id);


            Mail::to($customer->email)->send(new OrderPlaceMail($order_id));

            //Transaction commit
            DB::commit();


            session()->flash('success','Order Placed Successfully');
            session()->flash('s_msg','Successful');
            return redirect()->route('payment',[$customer->slug,base64_encode($order_id)]);


        }catch (\Exception $exception)
        {
            DB::rollBack();
            Log::error('CustomerController@store Message-'.$exception->getMessage());
            session()->flash('error','Something Went Wrong');
            return redirect()->back();
        }
        //Transaction end
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'district' => 'required',
            'address_1' => 'required',
            'zip' => 'required',
            'image' => 'image',
            'email' => 'required|email',
            'password' => 'confirmed'
        ]);

        $data = $request->except('_token', 'password', 'image','district', 'address_1', 'address_2', 'zip');
        $user = User::withTrashed()->where('slug', $slug)->first();

        $details = UserDetail::withTrashed()->where('user_id', $user->id)->first();


        $slug = Str::slug($request->name, '-').'-'.rand(000, 999);
        $data['slug'] = $slug;

        if ($request->password)
        {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = $slug.rand(000,999).$file->getClientOriginalName();
            $file->move('uploads/customer/',$file_name);
            if ($user->image != null){
                unlink($user->image);
            }
            $data['image'] = 'uploads/customer/' . $file_name;
        }

        if($details){
            $details->user_id = $user->id;
            $details->district_id = $request->district;
            $details->address_1 = $request->address_1;
            $details->address_2 = $request->address_2;
            $details->zip = $request->zip;
            $details->save();
        }
        else{
            $details = new UserDetail;
            $details->user_id = $user->id;
            $details->district_id = $request->district;
            $details->address_1 = $request->address_1;
            $details->address_2 = $request->address_2;
            $details->zip = $request->zip;
            $details->save();
        }


        $user->update($data);
        session()->flash('success', 'Information Updated Successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
