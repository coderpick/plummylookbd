<?php

namespace App\Http\Controllers;

use App\Flash;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FlashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.product.flash');
        if (Auth::user()->type == 'vendor'){
            $data['products'] = Product::with(['category','brand','back_flash'])->where('shop_id', Auth::user()->shop->id)->whereHas('back_flash', function($q)
            {
                $q->orderBy('expires_at', 'ASC');
            })->where('stock', '>', 0)->where('status', 'active')->get();
        }
        else{
            $data['products'] = Product::with(['category','brand','back_flash'])->whereHas('back_flash', function($q)
            {
                $q->orderBy('expires_at', 'ASC');
            })->where('status', 'active')->get();
        }

        $data['title'] = 'Flash Sale';

        return view('back.product.flash.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Add to Flash Sale';

        $flash= Flash::all()->pluck('product_id')->toArray();

        if (Auth::user()->type == 'vendor'){
            $products = Product::where('shop_id', Auth::user()->shop->id)->get();
        }
        else{
            $products = Product::get();
        }

        $filtered = $products->reject(function ($product) use ($flash) {
            return in_array($product->id,$flash);
        });

        $data['products']=$filtered;


        return view('back.product.flash.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        /*$request->validate([
            'id.*' => 'required',
            'flash.*' => 'required',
            'flash_price.*' => 'required',
            'flash_stock.*' => 'required',
            'expires_at.*' => 'required'
        ]);*/

        //dd($request->all());
        $flashes = $request->flash;
        if(! $flashes ){
            session()->flash('error','No Item Selected');
            return redirect()->back();
        }
        //$ids = $request->id;
        $prices = $request->flash_price;
        $stocks = $request->flash_stock;
        $expires  = $request->expires_at;

        foreach($flashes as $key => $fla) {
                $flash  =new Flash;
                $flash->product_id = $fla ;
                $flash->flash_price = isset($prices[$key]) ? $prices[$key] : '' ;
                $flash->flash_stock = isset($stocks[$key]) ? $stocks[$key] : '' ;
                $flash->expires_at = isset($expires[$key]) ? $expires[$key] : '' ;
                $flash->save();
        }


        session()->flash('success','Flash Item Added Successfully');
        return redirect()->route('flash.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Flash  $flash
     * @return \Illuminate\Http\Response
     */
    public function show(Flash $flash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Flash  $flash
     * @return \Illuminate\Http\Response
     */
    public function edit(Flash $flash)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flash  $flash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'id' => 'required',
            'flash_price' => 'required',
            'flash_stock' => 'required',
            'expires_at' => 'required'
        ]);
        $data = $request->except('_token');

        $flash = Flash::findOrFail($id);

        $flash->flash_price = $request->flash_price;
        $flash->flash_stock = $request->flash_stock;
        $flash->expires_at = $request->expires_at;
        $flash->update();

        session()->flash('success','Flash Item Updated Successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flash  $flash
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $flash = Flash::findOrFail($id);
        $flash->forceDelete();
        session()->flash('success','Flash Item Deleted Successfully');
        return redirect()->back();
    }
}
