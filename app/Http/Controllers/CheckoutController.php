<?php

namespace App\Http\Controllers;

use App\Contact;
use App\District;
use App\Order;
use App\Point;
use App\Shipping;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        //check user is admin or not
        if (Auth::user()->type !== 'user'){
            session()->flash('error', 'Unauthorized Request');
            return redirect()->back();
        }

        //check cart is empty or not
        $cart = session('cart');
        if (!$cart){
            session()->flash('error', 'Cart is Empty');
            return redirect()->back();
        }

        /*session()->remove('coupon_type');
        session()->remove('coupon_id');
        session()->remove('discount');
        session()->remove('percent');*/


        $data['title'] = 'Checkout';
        $data['setting'] = Shipping::first();
        $data['cart'] = session('cart');
        $data['districts'] = District::orderBy('name','ASC')->get();

        return view('front.customer.checkout',$data);
    }

    public function cart()
    {
        $data['title'] = 'Cart Details';
        $data['cart'] = session('cart');

        session()->remove('coupon_type');
        session()->remove('coupon_id');
        session()->remove('discount');
        session()->remove('percent');

        return view('front.cart',$data);
    }

    public function clear()
    {
        session()->remove('cart');
        return redirect()->back();
    }


    public function payment($slug,$order_id)
    {
        $user = Auth::user();
        $data['balance'] = Point::where('user_id', $user->id)->first();
        $order_id = base64_decode($order_id);
        $data['title'] = 'Payment';
        $data['customer'] = User::where('slug', $slug)->first();
        $data['order'] = Order::findOrFail($order_id);
        $data['date'] = Carbon::parse($data['order']->date)->addDays(3)->format('d-M-Y');
        $data['cart'] = session('cart');

        $contact = Contact::latest()->first();
        $data['bkash'] = $contact->bkash;
        $data['nagad'] = $contact->nagad;

        session()->remove('cart');
        session()->remove('coupon_type');
        session()->remove('coupon_id');
        session()->remove('discount');
        session()->remove('percent');
        //session()->flash('success','Order Placed Successfully');
        return view('front.customer.payment',$data);
    }

}
