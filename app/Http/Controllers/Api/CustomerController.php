<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\Point;
use App\User;

class CustomerController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function orders(){
        $user = auth('api')->user();
        $data['orders'] = Order::with(['order_detail'])->where('user_id', $user->id)->latest()->paginate(10);
        $data['balance'] = Point::where('user_id', $user->id)->first();
        return $this->sendResponse($data, 'Data fetched successfully');
    }

    public function myorder_details($id)
    {
        $user = auth('api')->user();
        if ($user->type != 'user'){
            return $this->sendError('Error', 'Unauthorized Request');
        }

        $user_id = $user->id;
        $data['balance'] = Point::where('user_id', $user_id)->first();
        $data['customer'] = User::where('id', $user_id)->first();
        $data['order'] = Order::where('id', $id)->first();
        return $this->sendResponse($data, 'Data fetched successfully');
    }
}
