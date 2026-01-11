<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Concern;
use App\Http\Requests\ProductStoreRequest;
use App\Product;
use App\ProductImage;
use App\Review;
use App\StaticReview;
use App\SubCategory;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = 'Product List';
        // Gate::authorize('app.product.index');
        if (Auth::user()->type == 'vendor') {
            $data['products'] = Product::withTrashed()
                ->select('id', 'shop_id', 'name', 'slug', 'code', 'price', 'new_price', 'stock', 'status', 'is_featured', 'made_in', 'deleted_at')
                ->with(['product_image:product_id,file_path',  'category:id,name', 'brand:id,name'])
                ->where('shop_id', Auth::user()->shop->id)->get();
        } else {
            $data['products'] = Product::withTrashed()
                ->select('id', 'shop_id', 'category_id', 'brand_id', 'name', 'slug', 'code', 'price', 'new_price', 'stock', 'status', 'is_featured', 'made_in', 'deleted_at')
                ->with(['product_image:product_id,file_path', 'category:id,name', 'brand:id,name'])->get();
        }

        return view('back.product.index', $data);
    }

    public function featured()
    {
        if (Auth::user()->type == 'vendor') {
            $data['products'] = Product::withTrashed()
                ->where('shop_id', Auth::user()->shop->id)
                ->where('is_featured', 1)->get();
        } else {
            $data['products'] = Product::withTrashed()->where('is_featured', 1)->get();
        }

        $data['title'] = 'Featured Product';

        return view('back.product.index', $data);
    }

    /*public function flash()
    {
        if (Auth::user()->type == 'vendor'){
            $data['products'] = Product::withTrashed()
                ->where('shop_id', Auth::user()->shop->id)
                ->where('flash_sale',1)->get();
        }
        else{
            $data['products'] = Product::withTrashed()->where('flash_sale',1)->get();
        }

        $data['title'] = 'Flash Sale Product';

        return view('back.product.index',$data);
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Gate::authorize('app.product.create');
        $data['title'] = 'Product Create';
        $data['categories'] = Category::orderBy('name')->pluck('name', 'id');
        $data['brands'] = Brand::orderBy('name')->pluck('name', 'id');
        $data['concerns'] = Concern::orderBy('name')->pluck('name', 'id');
        $data['productTags'] = Tag::select('id', 'name')->orderBy('name', 'ASC')->where('tag_for', 'product')->get();

        return view('back.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        // return $request;
        // Product create
        $product = $request->except('_token', 'images.*');
        if (Auth::user()->type == 'vendor') {
            if (Auth::user()->shop) {
                $product['shop_id'] = Auth::user()->shop->id;
            } else {
                $product['shop_id'] = null;
            }
        }

        $product = Product::create($product);

        // Multiple image upload
        if ($request->images != null && count($request->images)) {
            foreach ($request->images as $image) {
                $product_image['product_id'] = $product->id;
                $file_name = $product->id.'-'.time().'-'.rand(0000, 9999).'.'.$image->getClientoriginalExtension();
                $image->move('uploads/products/', $file_name);
                $product_image['file_path'] = 'uploads/products/'.$file_name;
                ProductImage::create($product_image);
            }
        }

        /*if ($request->review != null){
           $static_reviews = StaticReview::inRandomOrder()->limit($request->review)->get();
           foreach ($static_reviews as $st_review){
               $review = new Review;
               $review->user_id = null;
               $review->name = $st_review->name;
               $review->product_id = $product->id;
               $review->rating = $st_review->rating;
               $review->review = $st_review->review;
               $review->save();
           }
        }*/
        /* product tags */
        $dropdownData = json_decode($request->input('input-custom-dropdown'), true);
        $tagIds = collect($dropdownData)->map(function ($item) {
            return Tag::firstOrCreate(
                ['slug' => Str::slug($item['value'])],
                ['name' => $item['value'], 'tag_for' => 'product']
            )->id;
        })->toArray();

        // Sync tags with product
        $product->tags()->attach($tagIds);

        session()->flash('success', 'Product Created Successfully');

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data['title'] = 'Product Details';
        $data['product'] = Product::with(['category', 'brand', 'product_image'])->where('slug', $slug)->first();
        $tags = $data['product']->tags()->pluck('id')->toArray();
        $data['selectedTags'] = Tag::whereIn('id', $tags)->get();

        return view('back.product.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // Gate::authorize('app.product.edit');
        $data['title'] = 'Product Update';
        $data['product'] = $product;
        $tags = $product->tags()->pluck('id')->toArray();
        $data['selectedTags'] = Tag::whereIn('id', $tags)->get();
        $data['categories'] = Category::orderBy('name')->pluck('name', 'id');
        $data['sub_categories'] = SubCategory::where('category_id', $data['product']->category_id)->latest()->get();
        $data['brands'] = Brand::orderBy('name')->pluck('name', 'id');
        $data['concerns'] = Concern::orderBy('name')->pluck('name', 'id');
        $data['productTags'] = Tag::select('id', 'name')->orderBy('name', 'ASC')->where('tag_for', 'product')->get();

        return view('back.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'code' => 'nullable',
            'shop_id' => 'nullable',
            'size' => 'nullable',
            'color' => 'nullable',
            'details' => 'nullable',
            'meta_key' => 'nullable',
            'meta_description' => 'nullable',
            'price' => 'required|numeric|min:0|not_in:0',
            'new_price' => 'nullable|numeric|min:0|not_in:0',
            'stock' => 'required|numeric|min:0',
            'point' => 'nullable|numeric|min:0|not_in:0',
            'status' => 'required',
            'images.*' => 'required|image',
        ]);

        $product_data = $request->except('_token', 'images.*');
        /*if ($request->name != $product->name){
            $slug = Str::slug($request->name, '-');
            $product_data['slug'] = $slug.'-'.rand(001,99999);
        }*/

        if (! $request->has('is_featured')) {
            $product_data['is_featured'] = 0;
        }

        $product->update($product_data);

        // Multiple image update
        if ($request->images != null && count($request->images)) {
            // delete old images
            ProductImage::where('product_id', $product->id)->delete();

            foreach ($request->images as $image) {
                $product_image['product_id'] = $product->id;
                $file_name = $product->id.'-'.time().'-'.rand(0000, 9999).'.'.$image->getClientoriginalExtension();
                $image->move('uploads/products/', $file_name);
                $product_image['file_path'] = 'uploads/products/'.$file_name;
                ProductImage::create($product_image);
            }
        }

        /*if ($request->review != null){
            $static_reviews = StaticReview::inRandomOrder()->limit($request->review)->get();
            foreach ($static_reviews as $st_review){
                $review = new Review;
                $review->user_id = null;
                $review->name = $st_review->name;
                $review->product_id = $product->id;
                $review->rating = $st_review->rating;
                $review->review = $st_review->review;
                $review->save();
            }
        }*/
        /* product tags */
        $dropdownData = json_decode($request->input('input-custom-dropdown'), true);
        $tagIds = collect($dropdownData)->map(function ($item) {
            return Tag::firstOrCreate(
                ['slug' => Str::slug($item['value'])],
                ['name' => $item['value'], 'tag_for' => 'product']
            )->id;
        })->toArray();

        // Sync tags with product
        $product->tags()->sync($tagIds);

        session()->flash('success', 'Product Updated Successfully');

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Gate::authorize('app.product.destroy');
        $product->delete();
        session()->flash('success', 'Product Deleted Successfully');

        return redirect()->route('product.index');
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        session()->flash('success', 'Product Restored Successfully');

        return redirect()->route('product.index');
    }

    public function delete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        /* Delete all tags */
        $product->tags()->detach();

        $images = ProductImage::where('product_id', $id)->get();
        foreach ($images as $image) {
            unlink($image->file_path);
        }

        $reviews = Review::where('product_id', $id)->get();
        foreach ($reviews as $review) {
            $review->forceDelete();
        }

        $product->product_image()->delete();
        $product->forceDelete();
        session()->flash('success', 'Product Permanently Removed');

        return redirect()->route('product.index');
    }

    public function delete_image($image_id)
    {
        $image = ProductImage::findOrFail($image_id);
        unlink($image->file_path);
        $image->delete();
        session()->flash('success', 'Product image has been deleted.');

        return redirect()->back();
    }

    public function apply_multiple(Request $request)
    {
        $multiple_ids = $request->ids;
        if (! $multiple_ids) {
            session()->flash('error', 'No Item Selected');

            return redirect()->back();
        }
        if ($request->product_type == null) {
            session()->flash('error', 'Select Product Type First');

            return redirect()->back();
        }

        foreach ($multiple_ids as $key => $id) {
            $product = Product::findOrFail($id);
            $product->is_featured = $request->product_type;
            $product->save();

            session()->flash('success', 'Product Type Applied Successfully');
        }

        return redirect()->back();
    }
}
