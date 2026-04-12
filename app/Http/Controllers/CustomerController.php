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
    
    public function index()
    {
        if (Auth::user()->type !== 'user'){
            return redirect()->route('user.info');
        }

        $data['title'] = 'My Dashboard';
        $id = Auth::user()->id;
        $data['user'] = User::with('detail','detail.district')->findOrFail($id);
        $data['balance'] = Point::where('user_id', $id)->first();
        return view('front.customer.index', $data);
    }

    
    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {
     
        if (Auth::user() && Auth::user()->type !== 'user'){
            session()->flash('error', 'Unauthorized Request');
            return redirect()->back();
        }

        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'email' => 'nullable|email',
            'district' => 'required',
            'address_1' => 'required',
            'zip' => 'nullable|numeric',
        ]);

        //Transaction start
        DB::beginTransaction();
        try {
            $customerUser = $this->resolveCustomer($request);
            
            $order_id = $this->createOrder($request, $customerUser);

            $shippingResult = $this->processOrderItems($request, $order_id);
            if ($shippingResult instanceof \Illuminate\Http\RedirectResponse) {
                DB::rollBack();
                return $shippingResult;
            }

            $this->applyDiscountsAndTotals($order_id, $shippingResult['shipping'], $shippingResult['total']);

            if ($customerUser->email != null) {
                try {
                    Mail::to($customerUser->email)->send(new OrderPlaceMail($order_id));
                } catch (\Exception $e) {
                    //Log::warning("Email to failed: " . $e->getMessage());
                }
            }

            //Transaction commit
            DB::commit();

            session()->remove('cart');
            session()->flash('success','Order Placed Successfully');
            session()->flash('s_msg','Successful');
            
            $slug = isset($customerUser->slug) ? $customerUser->slug : 'guest';
            return redirect()->route('order.success', [$slug, base64_encode($order_id)]);

        }catch (\Exception $exception)
        {
            DB::rollBack();
            Log::error('CustomerController@store Message-'.$exception->getMessage());
            session()->flash('error','Something Went Wrong');
            return redirect()->back();
        }
        //Transaction end
    }

    private function resolveCustomer(Request $request)
    {
        $exist = User::where('email', $request->email)->first();
        if ($exist) {
            Auth::login($exist);
            return $exist;
        }

        if ($request->email != null) {
            $user['name'] = $request->name;
            $user['phone'] = $request->phone;
            $user['email'] = $request->email;
            $user['password'] = bcrypt($request->phone);
            $user['slug'] = str_slug($request->name);
            $user['type'] = 'user';
            $user['status'] = 1;
            $user['email_verified_at'] = now();
            $user['created_at'] = now();
            $user['updated_at'] = now();

            $user_id = User::insertGetId($user);
            
            $detail['user_id'] = $user_id;
            $detail['address_1'] = $request->address_1;
            $detail['address_2'] = $request->address_2;
            $detail['district_id'] = $request->district;
            $detail['zip'] = $request->zip;
            $detail['created_at'] = now();
            $detail['updated_at'] = now();
            $detail['account_status'] = 'active';
            UserDetail::insert($detail);

            Auth::loginUsingId($user_id);
            return Auth::user();
        }

        return $request;
    }

    private function createOrder(Request $request, $customer)
    {
        $order['order_number'] = '#'.date('ymd').uniqid();
        $order['user_id'] = $customer->id ?? null;
        $order['name'] = $customer->name;
        $order['email'] = $customer->email;
        $order['phone'] = $request->phone;
        $order['transaction_id'] = rand(000,999).uniqid();
        $order['payment_type'] = $request->payment_type;
        $order['date'] = now();
        if ($request->address_1 != null) {
            $order['address'] = $request->address_1.', '.$request->address_2;
            $order['district_id'] = $request->district;
            $order['zip'] = $request->zip;
        }

        return Order::insertGetId($order);
    }

    private function processOrderItems(Request $request, $order_id)
    {
        $cart = session('cart');
        $total = 0;
        $shipping = 0;

        $setting = Shipping::first();

        if (count($cart)) {
            foreach ($cart as $item) {
                $product = Product::findOrFail($item['product_id']);

                if(isset($item['flash_price']) && $item['flash_price'] != null){
                    $pr_stock = $product->flash->flash_stock;
                }else{
                    $pr_stock = $product->stock;
                }

                if ($pr_stock >= $item['quantity']) {
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

                    // Shipping logic
                    if ($request->district == 47) {
                        if ($setting->charge_by == 'quantity') {
                            $shipping += $item['quantity'] * $setting->shipping;
                        } elseif ($setting->charge_by == 'product') {
                            $shipping += $setting->shipping;
                        } elseif ($setting->charge_by == 'order') {
                            $shipping = $setting->shipping;
                        }
                    } else {
                        if ($setting->charge_by == 'quantity') {
                            $shipping += $item['quantity'] * $setting->shipping2 ;
                        } elseif ($setting->charge_by == 'product') {
                            $shipping += $setting->shipping2 ;
                        } elseif ($setting->charge_by == 'order') {
                            $shipping = $setting->shipping2 ;
                        }
                    }

                    // Stock update
                    $product->stock = $product->stock - $item['quantity'];
                    $product->save();

                    // Flash stock update
                    $flash = Flash::where('product_id', $item['product_id'])->first();
                    if($flash){
                        $flash->flash_stock = $flash->flash_stock - $item['quantity'];
                        $flash->save();
                    }
                } else {
                    session()->flash('warning',ucfirst($item['name']).' '.'is out of stock');
                    return redirect()->route('cart');
                }
            }
        }

        return ['total' => $total, 'shipping' => $shipping];
    }

    private function applyDiscountsAndTotals($order_id, $shipping, $total)
    {
        $setting = Shipping::first();
        $coupon_id = session('coupon_id');
        $coupon_type = session('coupon_type');
        $discount = session('discount');

        if ($coupon_type == 1 && Auth::check()) {
            $data['user_id'] = Auth::user()->id;
            $data['voucher_id'] = $coupon_id;
            VoucherUser::create($data);
        }

        if ($discount != null) {
            $total = $total - $discount;
        }

        if ($total >= $setting->free_shipping) {
            Order::findOrFail($order_id)->update(['amount' => $total, 'discount' => $discount]);
        } else {
            Order::findOrFail($order_id)->update(['amount' => $total + $shipping, 'shipping' => $shipping, 'discount' => $discount]);
        }
    }


  
    public function show()
    {
        if (Auth::user()->type !== 'user'){
            return redirect()->route('user.info');
        }
        $id = Auth::user()->id;
        $data['title'] = 'Profile Information';
        $data['districts'] = District::orderBy('name','ASC')->get();
        $data['balance'] = Point::where('user_id', $id)->first();
        $data['user'] = User::findOrFail($id);
        return view('front.customer.edit', $data);
    }

 
    public function edit($id)
    {
        //
    }

  
    public function update(Request $request, $slug)
    {
        // Strictly fetch the currently logged-in user to prevent editing the wrong user in case of slug collisions.
        $user = \Illuminate\Support\Facades\Auth::user();

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'district' => 'required',
            'address_1' => 'required',
            'zip' => 'required',
            'image' => 'image',
            'email' => [
                'required',
                'email',
                \Illuminate\Validation\Rule::unique('users', 'email')->ignore($user->id)
            ],
            'password' => 'nullable|confirmed'
        ]);

        $data = $request->except('_token', 'password', 'image','district', 'address_1', 'address_2', 'zip');

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

    public function destroy($id)
    {
        //
    }
}
