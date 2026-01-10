<?php

namespace App\Http\Controllers;

use App\Favourite;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Favourites';

        $user = Auth::user();
        if ($user) {
            $favourites = Favourite::where('user_id', $user->id)->get();
            $products = new Collection;
            foreach ($favourites as $favourite) {
                $products = $products->merge(Product::where('id', $favourite->product_id)->get());
            }
            $data['products'] = $products;
        } else {
            $data['products'] = null;
        }

        return view('front.favourite', $data);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        /* $user = Auth::user();
         if (!isset($user)){
             session()->flash('error','You Need To Login First');
             return redirect()->back();
         }*/

        if (Auth::user()->type != 'user') {
            session()->flash('error', 'Please Login First To Add Favorite');

            return redirect()->back();
        }

        $product = Product::where('slug', $slug)->first();
        $product_id = $product->id;

        $exists = Favourite::where('user_id', Auth::user()->id)->where('product_id', $product_id)->first();
        if ($exists) {
            session()->flash('error', 'Already Added');

            return redirect()->back();
        }

        $favrt = new Favourite;
        $favrt->user_id = Auth::user()->id;
        $favrt->product_id = $product_id;

        $favrt->save();
        session()->flash('success', 'Added To Favourite');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Favourite  $favourite
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, $product_id)
    {
        $carts = session('cart');
        if ($carts != null) {
            foreach ($carts as $id => $cart) {
                if ($cart['product_id'] == $product_id) {
                    $carts[$id]['quantity'] += 1;
                    session()->remove('cart');
                    session()->put('cart', $carts);
                    break;
                }
                if ($cart['product_id'] != $product_id) {
                    $product = Product::findOrFail($product_id);
                    $cartStatus = true;
                    if ($cartStatus && $product->stock > 0) {
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
                    }
                }
            }
        } else {
            $product = Product::findOrFail($product_id);
            $cartStatus = true;
            if ($cartStatus && $product->stock > 0) {
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
            }
        }

        $data = Favourite::where('product_id', $product_id)->first();
        $remove = $data->delete();
        session()->flash('success', 'Added To Cart');

        return redirect()->back();
    }

    public function remove(Request $request, $id)
    {
        $data = Favourite::where('product_id', $id)->first();
        $remove = $data->delete();
        session()->flash('success', 'Item removed');

        return redirect()->back();
    }

    public function clear($id)
    {
        $favourites = Favourite::where('user_id', $id)->get();

        foreach ($favourites as $favourite) {
            $remove = $favourite->delete();
        }

        session()->flash('success', 'Favourite List Cleared');

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favourite $favourite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favourite $favourite)
    {
        //
    }
}
