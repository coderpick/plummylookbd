<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
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
        Gate::authorize('app.subCategory.index');
        $data['title'] = 'Sub-Category';
        $data['categories']=Category::all();
        $data['sub_categories'] = SubCategory::with('category')->withTrashed()->get();
        return view('back.sub_category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Sub-Category';
        $data['categories']=Category::orderBy('name')->get();
        return view('back.sub_category.create',$data);
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
            'name'=>'required',
            'category_id'=>'required',
            'icon'=>'required|image',
        ]);
        $category = $request->except('_token');

        $slug = Str::slug($request->name, '-');
        $category['slug'] = $slug;

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $file_name = $slug.rand(0000,9999).$file->getClientOriginalName();
            $file->move('uploads/category/',$file_name);
            $category['icon'] = 'uploads/category/' . $file_name;
        }

        SubCategory::create($category);
        session()->flash('success','Sub-Category Created Successfully');
        return redirect()->route('sub-category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        $data['title'] = 'SubCategory';
        $data['categories']=Category::orderBy('name')->get();
        $data['subcategories'] = $subCategory;
        return view('back.sub_category.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'name'=>'required|unique:categories',
            'category_id'=>'required',
            'icon'=>'image',
        ]);
        $subcategory_data = $request->except('_token','_method');

        $slug = Str::slug($request->name, '-');
        $subcategory_data['slug'] = $slug;
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $file_name = $slug.rand(0000,9999).$file->getClientOriginalName();
            $file->move('uploads/category/',$file_name);
            if ($subCategory->icon != null){
                unlink($subCategory->icon);
            }
            $subcategory_data['icon'] = 'uploads/category/' . $file_name;
        }

        $subCategory->update($subcategory_data);
        session()->flash('success','Sub-Category Updated Successfully');
        return redirect()->route('sub-category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        session()->flash('success','Sub-Category Deleted Successfully');
        return redirect()->route('sub-category.index');
    }

    public function restore($id)
    {
        $sub_category = SubCategory::onlyTrashed()->findOrFail($id);
        $sub_category->restore();
        session()->flash('success','Sub-Category Restored Successfully');
        return redirect()->route('sub-category.index');
    }


    public function delete($id)
    {
        $sub_category = SubCategory::onlyTrashed()->findOrFail($id);
        $sub_category->forceDelete();
        session()->flash('success','Sub-Category Permanently Removed');
        return redirect()->route('sub-category.index');
    }


    public function subcategories(Request $request){
        if (!$request->category_id) {
            $html = '<option value="">No Sub-Category Available</option>';
        } else {
            $html = '<option value="">Select Sub-Category</option>';
            $subcategories = SubCategory::where('category_id', $request->category_id)->get();
            foreach ($subcategories as $subcat) {
                $html .= '<option value="'.$subcat->id.'">'.ucfirst($subcat->name).'</option>';
            }
        }
        //$html = '<option value="'.$request->category_id.'"> --Select Thana--</option>';
        return response()->json(['html' => $html]);
    }
}
