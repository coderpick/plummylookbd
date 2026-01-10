<?php

namespace App\Http\Controllers;

use App\Brand;
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
        $data['brands'] = Brand::withTrashed()->orderBy('name', 'ASC')->get();

        return view('back.brand.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Brand';

        return view('back.brand.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands',
            'icon' => 'required|image',
        ]);
        $data = $request->except('_token');

        $slug = Str::slug($request->name, '-');
        $data['slug'] = $slug;
        $data['published_to_web'] = $request->input('published_to_web') ? 1 : 0;

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $file_name = $slug.rand(0000, 9999).$file->getClientOriginalName();
            $file->move('uploads/brand/', $file_name);
            $data['icon'] = 'uploads/brand/'.$file_name;
        }

        Brand::create($data);
        session()->flash('success', 'Brand Created Successfully');

        return redirect()->route('brand.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $data['title'] = 'Brand';
        $data['brand'] = $brand;

        return view('back.brand.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'nullable|image',
        ]);
        $data = $request->except('_token');

        $slug = Str::slug($request->name, '-');
        $data['slug'] = $slug;
        $data['published_to_web'] = $request->input('published_to_web') ? 1 : 0;
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $file_name = $slug.rand(0000, 9999).$file->getClientOriginalName();
            $file->move('uploads/brand/', $file_name);
            if ($brand->icon != null) {
                unlink($brand->icon);
            }
            $data['icon'] = 'uploads/brand/'.$file_name;
        }

        $brand->update($data);
        session()->flash('success', 'Brand Updated Successfully');

        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        session()->flash('success', 'Brand Deleted Successfully');

        return redirect()->route('brand.index');
    }

    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore();
        session()->flash('success', 'Brand Restored Successfully');

        return redirect()->route('brand.index');
    }

    public function delete($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        if ($brand->icon != null) {
            unlink($brand->icon);
        }
        $brand->forceDelete();
        session()->flash('success', 'Brand Permanently Removed');

        return redirect()->route('brand.index');
    }
}
