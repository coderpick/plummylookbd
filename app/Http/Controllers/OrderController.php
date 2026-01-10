<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Dispute;
use App\Jobs\OrderUpdateJob;
use App\Link;
use App\Mail\OrderUpdate;
use App\Meta;
use App\Order;
use App\OrderDetail;
use App\Point;
use App\Product;
use App\Review;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        Gate::authorize('app.order.index');
        $data['title'] = 'Orders';

        if (Auth::user()->type == 'vendor') {
            $shop_id = Auth::user()->shop->id;
            $data['orders'] = Order::with('order_advance')->latest()->whereHas('order_detail', function ($query) use ($shop_id) {
                $query->where('shop_id', $shop_id);
            })->get();

            return view('back.order.index', $data);
        }

        $data['orders'] = Order::with('order_advance')->get();

        return view('back.order.index', $data);
    }

    public function pending()
    {
        Gate::authorize('app.order.index');
        $data['title'] = 'Pending Orders';

        if (Auth::user()->type == 'vendor') {
            $shop_id = Auth::user()->shop->id;
            $data['orders'] = Order::with('order_advance')->where('status', 'Pending')->whereHas('order_detail', function ($query) use ($shop_id) {
                $query->where('shop_id', $shop_id);
            })->get();

            return view('back.order.index', $data);
        }

        $data['orders'] = Order::with('order_advance')->where('status', 'Pending')->get();

        return view('back.order.index', $data);
    }

    public function confirmed()
    {
        Gate::authorize('app.order.index');
        $data['title'] = 'Confirmed Orders';

        if (Auth::user()->type == 'vendor') {
            $shop_id = Auth::user()->shop->id;
            $data['orders'] = Order::with('order_advance')->where('status', 'Confirmed')->whereHas('order_detail', function ($query) use ($shop_id) {
                $query->where('shop_id', $shop_id);
            })->get();

            return view('back.order.index', $data);
        }

        $data['orders'] = Order::with('order_advance')->where('status', 'Confirmed')->get();

        return view('back.order.index', $data);
    }

    public function processing()
    {
        Gate::authorize('app.order.index');
        $data['title'] = 'Processing Orders';

        if (Auth::user()->type == 'vendor') {
            $shop_id = Auth::user()->shop->id;
            $data['orders'] = Order::with('order_advance')->where('status', 'Processing')->whereHas('order_detail', function ($query) use ($shop_id) {
                $query->where('shop_id', $shop_id);
            })->get();

            return view('back.order.index', $data);
        }

        $data['orders'] = Order::with('order_advance')->where('status', 'Processing')->get();

        return view('back.order.index', $data);
    }

    public function shipped()
    {
        Gate::authorize('app.order.index');
        $data['title'] = 'Shipped Orders';

        if (Auth::user()->type == 'vendor') {
            $shop_id = Auth::user()->shop->id;
            $data['orders'] = Order::with('order_advance')->where('status', 'Shipped')->whereHas('order_detail', function ($query) use ($shop_id) {
                $query->where('shop_id', $shop_id);
            })->get();

            return view('back.order.index', $data);
        }

        $data['orders'] = Order::with('order_advance')->where('status', 'Shipped')->get();

        return view('back.order.index', $data);
    }

    public function delivered()
    {
        Gate::authorize('app.order.index');
        $data['title'] = 'Delivered Orders';

        if (Auth::user()->type == 'vendor') {
            $shop_id = Auth::user()->shop->id;
            $data['orders'] = Order::with('order_advance')->where('status', 'Delivered')->whereHas('order_detail', function ($query) use ($shop_id) {
                $query->where('shop_id', $shop_id);
            })->get();

            return view('back.order.index', $data);
        }

        $data['orders'] = Order::with('order_advance')->where('status', 'Delivered')->get();

        return view('back.order.index', $data);
    }

    public function canceled()
    {
        Gate::authorize('app.order.index');
        $data['title'] = 'Canceled Orders';

        if (Auth::user()->type == 'vendor') {
            $shop_id = Auth::user()->shop->id;
            $data['orders'] = Order::with('order_advance')->where('status', 'Canceled')->whereHas('order_detail', function ($query) use ($shop_id) {
                $query->where('shop_id', $shop_id);
            })->get();

            return view('back.order.index', $data);
        }

        $data['orders'] = Order::with('order_advance')->where('status', 'Canceled')->get();

        return view('back.order.index', $data);
    }

    public function show($id)
    {
        Gate::authorize('app.order.index');
        $id = base64_decode($id);
        $data['title'] = 'Order Details';
        $data['order'] = Order::with(['order_detail', 'user', 'order_advance'])->findOrFail($id);
        $data['user'] = User::where('id', $data['order']->updated_by)->first();

        return view('back.order.show', $data);
    }

    public function invoice($id)
    {
        Gate::authorize('app.order.index');
        $id = base64_decode($id);
        $data['title'] = 'Invoice';
        $data['order'] = Order::findOrFail($id);
        $data['contact'] = Contact::latest()->first();
        $data['link'] = Link::latest()->first();
        $data['meta'] = Meta::latest()->first();

        return view('back.order.invoice', $data);
    }

    public function customer($slug)
    {
        Gate::authorize('app.order.index');
        $customer = User::where('slug', $slug)->first();
        $data['title'] = $customer->name;
        $data['orders'] = Order::where('user_id', $customer->id)->get();

        return view('back.order.index', $data);
    }

    public function change_status($order_id, $status)
    {
        $order_id = base64_decode($order_id);

        if ($status == 'Pending' || $status == 'Confirmed' || $status == 'Processing' || $status == 'Shipped' || $status == 'Delivered' || $status == 'Canceled') {

            $order = Order::with('user')->findOrFail($order_id);
            if ($order->status == 'Canceled') {
                session()->flash('error', 'Unauthorized Request');

                return redirect()->back();
            }

            if ($status == 'Delivered') {

                $exist = Point::where('user_id', $order->user_id)->first();

                /*if ($exist){
                        $balance = $exist->point + $order->order_detail->sum('point');
                        $exist->update(['point'=>$balance]);
                    }
                    else{
                        $data['user_id'] = $order->user_id;
                        $data['point'] = $order->order_detail->sum('point');
                        Point::create($data);
                    }*/

                // order detail status change
                $items = OrderDetail::where('order_id', $order->id)->get();
                foreach ($items as $item) {
                    $item->status = 'Delivered';
                    $item->save();
                }

                $order->update(['payment_status' => 'paid']);
            }

            // stock add
            if ($status == 'Canceled') {
                $items = OrderDetail::where('order_id', $order->id)->get();
                foreach ($items as $item) {
                    $product = Product::where('id', $item->product_id)->first();
                    $product->stock = $product->stock + $item->quantity;
                    $product->save();

                    $item->status = 'Canceled';
                    $item->save();
                }
            }
            Order::findOrFail($order_id)->update(['status' => $status, 'updated_by' => Auth::user()->id]);

            // update mail send to user
            $email = $order->email;
            if (! $email) {
                try {
                    Mail::to($email)->send(new OrderUpdate($order));
                } catch (\Exception $e) {
                    // Log::warning("Email to $email failed: " . $e->getMessage());
                }
            }

            /* dispatch(new OrderUpdateJob($order))->delay(Carbon::now()->addSeconds(3)); */

            session()->flash('success', 'Status Changed and Mail Sent to User');
        } else {
            session()->flash('error', 'Something Went Wrong');
        }

        return redirect()->back();
    }

    public function change_detail($id, $detail)
    {
        if ($detail == 'Processing' || $detail == 'Warehouse' || $detail == 'Received') {

            $item = OrderDetail::where('id', $id)->first();

            $order = Order::findOrFail($item->order_id);

            if ($order->status == 'Canceled') {
                session()->flash('error', 'Unauthorized Request');

                return redirect()->back();
            }

            $item->update(['status' => $detail]);

            session()->flash('success', 'Status Changed');
        } else {
            session()->flash('error', 'Something Went Wrong');
        }

        return redirect()->back();
    }

    public function myorder()
    {
        if (Auth::user()->type != 'user') {
            session()->flash('error', 'Unauthorized Request');

            return redirect()->back();
        }

        $data['title'] = 'My Orders';
        $id = Auth::user()->id;
        $data['order_count'] = Order::where('user_id', $id)->count();
        $data['dispute_count'] = Dispute::withTrashed()->where('user_id', $id)->count();
        $data['ticket_count'] = Ticket::withTrashed()->where('user_id', $id)->count();
        $data['review_count'] = Review::withTrashed()->where('user_id', $id)->count();
        $data['balance'] = Point::where('user_id', $id)->first();

        $id = Auth::user()->id;
        $orders = new Order;
        $orders = $orders->with(['order_detail.product:id,slug']);
        $orders = $orders->where('user_id', $id)->orderBy('id', 'DESC')->paginate(5);

        $data['orders'] = $orders;

        return view('front.customer.orders', $data);
    }

    public function myorder_details($id)
    {
        if (Auth::user()->type != 'user') {
            session()->flash('error', 'Unauthorized Request');

            return redirect()->back();
        }

        $id = base64_decode($id);
        $data['title'] = 'Order Details';
        $user_id = Auth::user()->id;
        $data['order_count'] = Order::where('user_id', $user_id)->count();
        $data['dispute_count'] = Dispute::withTrashed()->where('user_id', $user_id)->count();
        $data['ticket_count'] = Ticket::withTrashed()->where('user_id', $user_id)->count();
        $data['review_count'] = Review::withTrashed()->where('user_id', $user_id)->count();
        $data['balance'] = Point::where('user_id', $user_id)->first();
        $data['customer'] = User::where('id', $user_id)->first();

        $data['order'] = Order::findOrFail($id);

        return view('front.customer.order_details', $data);
    }

    public function track($slug, $order_id)
    {
        $order_id = base64_decode($order_id);
        $user = Auth::user();
        $data['balance'] = Point::where('user_id', $user->id)->first();
        $data['title'] = 'Track';
        $data['customer'] = User::where('slug', $slug)->first();
        $data['order'] = Order::findOrFail($order_id);
        $data['date'] = Carbon::parse($data['order']->date)->addDays(3)->format('d-M-Y');

        $contact = Contact::latest()->first();
        $data['bkash'] = $contact->bkash;
        $data['nagad'] = $contact->nagad;

        return view('front.customer.payment', $data);
    }

    public function change_multiple(Request $request)
    {
        $multiple_ids = $request->ids;
        if (! $multiple_ids) {
            session()->flash('error', 'No Item Selected');

            return redirect()->back();
        }
        if ($request->status == null) {
            session()->flash('error', 'Select Status First');

            return redirect()->back();
        }

        if ($request->status == 'Invoice') {
            $data['title'] = 'Multi Invoice';
            $data['orders'] = Order::whereIn('id', (array) $request->ids)->get();
            $data['contact'] = Contact::latest()->first();
            $data['link'] = Link::latest()->first();
            $data['meta'] = Meta::latest()->first();

            return view('back.order.multi_invoice', $data);

        }

        foreach ($multiple_ids as $key => $id) {
            if ($request->status == 'Pending' || $request->status == 'Confirmed' || $request->status == 'Processing' || $request->status == 'Shipped' || $request->status == 'Delivered' || $request->status == 'Canceled') {

                $order = Order::with('user')->findOrFail($id);
                if ($order->status == 'Canceled') {
                    session()->flash('error', 'Unauthorized Request');

                    return redirect()->back();
                }

                if ($request->status == 'Delivered') {

                    /*$exist = Point::where('user_id', $order->user_id )->first();

                    if ($exist){
                        $balance = $exist->point + $order->order_detail->sum('point');
                        $exist->update(['point'=>$balance]);
                    }
                    else{
                        $data['user_id'] = $order->user_id;
                        $data['point'] = $order->order_detail->sum('point');
                        Point::create($data);
                    }*/

                    // order detail status change
                    $items = OrderDetail::where('order_id', $order->id)->get();
                    foreach ($items as $item) {
                        $item->status = 'Delivered';
                        $item->save();
                    }

                    $order->update(['payment_status' => 'paid']);
                }

                // stock add
                if ($request->status == 'Canceled') {
                    $items = OrderDetail::where('order_id', $order->id)->get();
                    foreach ($items as $item) {
                        $product = Product::where('id', $item->product_id)->first();
                        $product->stock = $product->stock + $item->quantity;
                        $product->save();

                        $item->status = 'Canceled';
                        $item->save();
                    }
                }
                Order::findOrFail($id)->update(['status' => $request->status, 'updated_by' => Auth::user()->id]);

                // update mail send to user
                $email = $order->email;
                if (! $email) {
                    try {
                        Mail::to($email)->send(new OrderUpdate($order));
                    } catch (\Exception $e) {
                        // Log::warning("Email to $email failed: " . $e->getMessage());
                    }
                }

                session()->flash('success', 'Status Changed and Mail Sent to User');
            } else {
                session()->flash('error', 'Something Went Wrong');
            }

        }

        return redirect()->back();
    }

    public function cancel($order_id, $status)
    {
        $order = Order::with('user')->findOrFail($order_id);

        // stock add
        if ($status == 'Canceled') {
            $items = OrderDetail::where('order_id', $order->id)->get();
            foreach ($items as $item) {
                $product = Product::where('id', $item->product_id)->first();
                $product->stock = $product->stock + $item->quantity;
                $product->save();

                $item->status = 'Canceled';
                $item->save();
            }
        } else {
            session()->flash('error', 'Unauthorized Request');
        }

        Order::findOrFail($order_id)->update(['status' => $status, 'updated_by' => Auth::user()->id]);

        // update mail send to user
        // $email = $order->user->email;
        // Mail::to($email)->send(new OrderUpdate($order));

        session()->flash('success','Order has been canceled');

        return redirect()->back();
    }
}
