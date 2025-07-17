<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Services\PathaoCourierService;

class PathaoController extends Controller
{
    protected $pathao;

    public function __construct(PathaoCourierService $pathao)
    {
        $this->pathao = $pathao;
    }

    public function showForm($id)
    {
        $id = base64_decode($id);
        $data['title'] = 'Send to Pathao';
        $data['order'] = Order::findOrFail($id);
        $data['cities'] = $this->pathao->getCities()['data']['data'] ?? [];

        return view('back.order.pathao_form', $data);
    }

    public function createOrder(Request $request, $id)
    {
       $validated = $request->validate([
            'recipient_city' => 'required|integer',
            'recipient_zone' => 'required|integer',
            'recipient_area' => 'required|integer',
            'item_weight' => 'required',
        ]);

        $id = base64_decode($id);
        $order = Order::withCount('order_detail')->findOrFail($id);
        $order->update($validated); // update DB with zone/area/city if needed

        $orderData = [
            "store_id" => 1234, // your actual store_id
            "merchant_order_id" => "ORD-" . $order->order_number,
            "recipient_name" => $order->name,
            "recipient_phone" => $order->phone,
            "recipient_address" => $order->address,
            "recipient_city" => $order->recipient_city,
            "recipient_zone" => $order->recipient_zone,
            "recipient_area" => $order->recipient_area,
            "delivery_type" => 48,
            "item_type" => 2,
            "item_quantity" => $order->order_detail_count,
            "item_weight" => $request->item_weight,
            "amount_to_collect" => $order->amount,
            "item_description" => "Order " . $order->order_number,
            "special_instruction" => "Handle with care"
        ];

        $response = $this->pathao->createOrder($orderData);

        if (isset($response['data']['consignment_id'])) {
            $order->update([
                'consignment_id' => $response['data']['consignment_id'],
                'pathao_status' => 'sent-to-pathao',
                'status' => 'Shipped',
            ]);
            session()->flash('success','Order sent to Pathao successfully');
            return redirect()->back();
        }

        session()->flash('error','Failed to send to Pathao');
        return redirect()->back();
    }

    public function cities()
    {
        return $this->pathao->getCities();
    }

    public function zones($cityId)
    {
        return $this->pathao->getZones($cityId);
    }

    public function areas($zoneId)
    {
        return $this->pathao->getAreas($zoneId);
    }
}

