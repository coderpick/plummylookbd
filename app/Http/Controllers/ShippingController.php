<?php

namespace App\Http\Controllers;

use App\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['notVendor','notOperator']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.shipping.index');
            $data['title'] = 'Shipping Charge';
            $data['shipping'] = Shipping::withTrashed()->first();

            return view('back.shipping.index',$data);
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
        $request->validate([
            'charge_by'=>'required',
            'shipping'=>'required',
            'shipping2'=>'required',
            'free_shipping'=>'required',
        ]);
        $shipping = $request->except('_token');

        $table_data=Shipping::withTrashed()->first();

        if($table_data){
            Shipping::find($table_data->id)->update($shipping);
            session()->flash('success','Shipping Updated Successfully');
        }
        else{
            Shipping::create($shipping);
            session()->flash('success','Shipping Inserted Successfully');
        }


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function show(Shipping $shipping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipping $shipping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipping $shipping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipping $shipping)
    {
        //
    }
}
