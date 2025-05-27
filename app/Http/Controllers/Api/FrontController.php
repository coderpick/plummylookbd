<?php

namespace App\Http\Controllers\Api;

use App\Contact;
use App\District;
use App\Link;
use App\Product;
use App\Shop;
use App\Slider;

class FrontController extends BaseController
{
    public function slider(){
        $sliders = Slider::latest()->get();
        return $this->sendResponse($sliders, 'Data fetched successfully');
    }

    public function products(){
        $products = Shop::select('id','name','slug','image')->with('product:id,shop_id,name,slug,price,new_price,stock,size,point','product.product_image:product_id,file_path')->orderBy('sequence','ASC')->get();
        return $this->sendResponse($products, 'Data fetched successfully');
    }

    public function sale()
    {
        $products = Product::with('product_image:product_id,file_path')->where('new_price', '!=', null)
            ->where('status', 'active')
            ->select('id','name','slug','price','new_price','stock','size','point')
            ->latest()->paginate(20);
        $data['products'] = $products;
        return $this->sendResponse($data, 'Data fetched successfully');
    }

    public function details($slug){
        $product = Product::with('product_image:product_id,file_path')
            ->where('slug', $slug)
            ->select('id','shop_id','name','slug','price','new_price','stock','size','color','point','details','meta_key','meta_description','youtube_link')
            ->first();
        $product->view_count = $product->view_count+1;
        $product->save();
        $data['product'] = $product;
        return $this->sendResponse($data, 'Data fetched successfully');
    }

    public function contact()
    {
        $data['contact'] = Contact::latest()
            ->first()?->makeHidden(['id','deleted_at','updated_at', 'created_at']);
        $data['social'] = Link::selectRaw('pinterest AS instagram, links.*')
            ->latest()
            ->first()
            ?->makeHidden(['id', 'deleted_at', 'updated_at', 'created_at','pinterest']);
        return $this->sendResponse($data, 'Data fetched successfully');
    }

    public function district()
    {
        $data['districts'] = District::select('id','name')->get();

        return $this->sendResponse($data, 'Data fetched successfully');
    }

}
