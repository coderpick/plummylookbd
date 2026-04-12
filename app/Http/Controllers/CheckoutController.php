<?php

namespace App\Http\Controllers;

use App\Contact;
use App\District;
use App\Order;
use App\Point;
use App\Product;
use App\Shipping;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // check user is admin or not
        if (Auth::user() && Auth::user()->type !== 'user') {
            session()->flash('error', 'Unauthorized Request');

            return redirect()->back();
        }

        // check cart is empty or not
        $cart = session('cart');
        if (! $cart) {
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
        $data['districts'] = District::orderBy('name', 'ASC')->get();

        return view('front.customer.checkout', $data);
    }

    public function cart()
    {
        $data['title'] = 'Cart Details';
        $data['cart'] = session('cart');

        session()->remove('coupon_type');
        session()->remove('coupon_id');
        session()->remove('discount');
        session()->remove('percent');

        return view('front.cart', $data);
    }

    public function clear()
    {
        session()->remove('cart');

        return redirect()->back();
    }

    public function payment($slug, $order_id)
    {
        $user = Auth::user();
        $data['balance'] = Point::where('user_id', $user->id)->first();
        $order_id = base64_decode($order_id);
        $data['title'] = 'Payment';
        $data['customer'] = User::where('slug', $slug)->first();
        $data['order'] = Order::with('order_detail.product')->findOrFail($order_id);
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

        return view('front.customer.payment', $data);
    }

    public function orderSuccess($slug, $order_id)
    {
        $user = Auth::user();
        if ($user) {
            $data['balance'] = Point::where('user_id', $user->id)->first();
        }
        $order_id = base64_decode($order_id);
        $data['title'] = 'Order Success';
        $data['customer'] = User::where('slug', $slug)->first();
        $data['order'] = Order::with('order_detail.product')->findOrFail($order_id);
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

        if (!$data['customer']) {
            // Support guest checkouts where the slug might be dummy
            $data['customer'] = (object)[
                'name' => $data['order']->name,
                'email' => $data['order']->email,
                'phone' => $data['order']->phone,
                'slug' => 'guest'
            ];
        }

        return view('front.customer.order-success', $data);
    }

    public function buy($slug)
    {
        session()->remove('cart');

        $product = Product::where('slug', $slug)->first();
        if (! $product) {
            abort(404);
        }
        if ($product->stock > 0) {
            $sesionData['product_id'] = $product->id;
            $sesionData['shop_id'] = $product->shop_id;
            $sesionData['point'] = $product->point;
            $sesionData['slug'] = $product->slug;
            $sesionData['name'] = $product->name;
            $sesionData['quantity'] = 1;
            $sesionData['price'] = $product->price;
            $sesionData['new_price'] = $product->new_price;
            $sesionData['flash_price'] = isset($product->flash->flash_price) ? $product->flash->flash_price : null;
            $sesionData['image'] = isset($product->product_image[0]) ? $product->product_image[0]->file_path : 'uploads/default.jpg';
            session()->push('cart', $sesionData);

            return redirect()->route('checkout');
        } else {
            session()->flash('error', 'Product is out of stock');

            return redirect()->back();
        }

    }
}
