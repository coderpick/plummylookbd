<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addToCart($product_id)
    {



        $product = Product::findOrFail($product_id);


        $carts = session('cart');
        $cartStatus = true;
        if($carts != null)
        {
            foreach ($carts as $id=>$cart)
            {
                if($cart['product_id']== $product->id){
                    $carts[$id]['quantity'] = $cart['quantity']+1;
                    session()->remove('cart');
                    session()->put('cart',$carts);
                    $cartStatus = false;
                    break;
                }
            }
        }
        if($cartStatus && $product->stock > 0){
            $sesionData['product_id'] = $product->id;
            $sesionData['shop_id'] = $product->shop_id;
            $sesionData['point'] = $product->point;
            $sesionData['slug'] = $product->slug;
            $sesionData['name'] = $product->name;
            $sesionData['quantity'] = 1;
            $sesionData['price'] = $product->price;
            $sesionData['new_price'] = $product->new_price;
            $sesionData['flash_price'] = isset($product->flash->flash_price)? $product->flash->flash_price : null;
            $sesionData['image'] = isset($product->product_image[0]) ? $product->product_image[0]->file_path : 'uploads/default.jpg';
            session()->push('cart', $sesionData);
        }

        /*if($product->stock > 0) {
            $sesionData['product_id'] = $product->id;
            $sesionData['name'] = $product->name;
            $sesionData['quantity'] = 1;
            $sesionData['price'] = $product->price;
            $sesionData['image'] = isset($product->product_image[0]) ? $product->product_image[0]->file_path : 'assets/frontend/images/no-image.jpg';
            session()->push('cart', $sesionData);
        }*/




        $data['cart'] = session('cart');
        //$data['cart__price'] = view('front.ajax.cart__price',$data)->render();
        
        $price = isset($product->flash->flash_price) ? (float) $product->flash->flash_price : ($product->new_price ? (float) $product->new_price : (float) $product->price);
        $data['added_product'] = [
            'item_id' => (string) $product->id,
            'item_name' => $product->name,
            'item_brand' => optional($product->brand)->name ?? '',
            'item_category' => optional($product->category)->name ?? '',
            'price' => $price,
            'quantity' => 1
        ];

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request)
    {
//        return $request;
        $carts = session('cart');
        if($carts != null)
        {
            foreach ($carts as $id=>$cart)
            {
                for($i=0;$i<count($request->id);$i++){

                    if($cart['product_id']== $request->id[$i]){
                        $carts[$id]['quantity'] = $request->quantity[$i];
                        session()->remove('cart');
                        session()->put('cart',$carts);
                        break;
                    }

                }

            }
        }
        session()->flash('success','Cart Updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete( $product_id)
    {
        $carts = session('cart');
        if($carts != null)
        {
            foreach ($carts as $id=>$cart)
            {
                if($cart['slug']== $product_id){
                    unset($carts[$id]);
                    session()->remove('cart');
                    session()->put('cart',$carts);
                    break;
                }
            }
        }
        session()->flash('success','Item Removed');
        return redirect()->back();
    }



    public function add( Request $request, $product_id)
    {
//        return $request;
        $carts = session('cart');
        if($carts != null)
        {
            foreach ($carts as $id=>$cart)
            {
                if($cart['product_id']== $product_id){
                    $carts[$id]['quantity'] = $request->quantity;
                    session()->remove('cart');
                    session()->put('cart',$carts);
                    break;
                }
                if($cart['product_id']!= $product_id){
                    $product = Product::findOrFail($product_id);
                    $cartStatus = true;
                    if($cartStatus && $product->stock > 0){
                        $sesionData['product_id'] = $product->id;
                        $sesionData['shop_id'] = $product->shop_id;
                        $sesionData['point'] = $product->point;
                        $sesionData['slug'] = $product->slug;
                        $sesionData['name'] = $product->name;
                        $sesionData['quantity'] = $request->quantity;
                        $sesionData['price'] = $product->price;
                        $sesionData['new_price'] = $product->new_price;
                        $sesionData['flash_price'] = isset($product->flash->flash_price)? $product->flash->flash_price : null;
                        $sesionData['image'] = isset($product->product_image[0]) ? $product->product_image[0]->file_path : 'uploads/default.jpg';
                        session()->push('cart', $sesionData);
                    }
                }
            }
        }
        else{
            $product = Product::findOrFail($product_id);
            $cartStatus = true;
            if($cartStatus && $product->stock > 0){
                $sesionData['product_id'] = $product->id;
                $sesionData['shop_id'] = $product->shop_id;
                $sesionData['point'] = $product->point;
                $sesionData['slug'] = $product->slug;
                $sesionData['name'] = $product->name;
                $sesionData['quantity'] = $request->quantity;
                $sesionData['price'] = $product->price;
                $sesionData['new_price'] = $product->new_price;
                $sesionData['flash_price'] = isset($product->flash->flash_price)? $product->flash->flash_price : null;
                $sesionData['image'] = isset($product->product_image[0]) ? $product->product_image[0]->file_path : 'uploads/default.jpg';
                session()->push('cart', $sesionData);
            }
        }
        session()->flash('success','Added To Cart');
        return redirect()->back();
    }
}
