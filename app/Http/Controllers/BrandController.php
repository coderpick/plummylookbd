<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('notVendor');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.brand.index');
        $data['title'] = 'Brand';
        $data['brands'] = Brand::withTrashed()->get();
        return view('back.brand.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Brand';
        return view('back.brand.create',$data);
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
            'name'=>'required|unique:brands',
        ]);
        $data = $request->except('_token');

        $slug = Str::slug($request->name, '-');
        $data['slug'] = $slug;


        Brand::create($data);
        session()->flash('success','Brand Created Successfully');
        return redirect()->route('brand.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $data['title'] = 'Brand';
        $data['brand'] = $brand;
        return view('back.brand.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name'=>'required',
        ]);
        $data = $request->except('_token');

        $slug = Str::slug($request->name, '-');
        $data['slug'] = $slug;


        $brand->update($data);
        session()->flash('success','Brand Updated Successfully');
        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        session()->flash('success','Brand Deleted Successfully');
        return redirect()->route('brand.index');
    }

    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore();
        session()->flash('success','Brand Restored Successfully');
        return redirect()->route('brand.index');
    }

    public function delete($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->forceDelete();
        session()->flash('success','Brand Permanently Removed');
        return redirect()->route('brand.index');
    }
}
