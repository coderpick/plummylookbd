<?php

namespace App\Http\Controllers\Vendor;
use App\Http\Controllers\Controller;


use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{

    public function commission(Request $request,$id)
    {
        $request->validate([
            'commission'=>'numeric|min:0|not_in:0',
        ]);

        $shop = Shop::where('id', $id )->first();

        if (isset($request->commission)){
            $data['commission'] = $request->commission;
        }
        if (isset($request->routing_no)){
            $data['routing_no'] = $request->routing_no;
        }



        $shop->update($data);

        session()->flash('success','Updated Successfully');
        return redirect()->back();
    }
}

