<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Order;
use App\OrderAdvance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderAdvanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'sender_account'=>'required|numeric|min:11',
            'account_no'=>'required',
            'trx_id'=>'required',
            'trx_type'=>'required',
            'amount'=>'required',
        ]);

        $data = $request->except('_token');

        $order =Order::findOrFail($request->order_id);
        $order->advance = $request->amount;
        $order->save();

        OrderAdvance::create($data);
        session()->flash('success','Advance Payment Submitted Successfully');
        return redirect()->back();
    }


    public function report_create()
    {
        $data['title'] = 'Report';
        return view('back.report', $data);
    }

    public function report_store(Request $request)
    {
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required',
        ]);

        $fromDate       = $request->from_date;
        $toDate         = date('Y-m-d', strtotime($request->to_date . ' + 1 days'));

        $orders = Order::whereBetween('created_at', array($fromDate, $toDate))
            ->get();

        if ($orders->count() == 0){
            session()->flash('error','No data found, Please modify your request');
            return redirect()->back();
        }

        $currentTime        = now()->format('d-m-Y h:i:sa');
        $file_name          = 'report_'.$currentTime.'_'.uniqid();
        $file_name = $file_name.'.xlsx';

        return Excel::download(new OrdersExport($orders), $file_name);

    }
}
