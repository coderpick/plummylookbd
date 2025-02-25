<?php

namespace App\Http\Controllers;

use App\Order;
use App\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function point_pay($id)
    {
        $order = Order::where('id', $id)->first();
        $amount = $order->amount;
        $point = Point::where('user_id', Auth::user()->id)->first();

        $balance = $point->point - $amount;

        $order->update(['payment_status'=> 'paid', 'point_pay'=> $amount]);
        $point->update(['point'=>$balance]);

        session()->flash('success','Payment Successful');
        return redirect()->back();
    }
}
