<?php

namespace App\Http\Controllers;

use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.category.index');
        if (Auth::user()->type == 'vendor'){
            $data['title'] = 'Category Suggestion';
            $data['categories'] = Category::withTrashed()->where('user_id',Auth::user()->id)->get();
        }
        else{
            $data['title'] = 'Category';
            $data['categories'] = Category::withTrashed()->where('status',null)->orWhere('status', 'active')->get();
        }


        return view('back.category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->type == 'vendor'){
            $data['title'] = 'Category Suggestion';
        }
        else{
            $data['title'] = 'Category';
        }

        return view('back.category.create',$data);
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
            'name'=>'required|unique:categories',
            'icon'=>'required|image',
            'banner'=>'nullable|image',
        ]);
        $data = $request->except('_token');

        $slug = Str::slug($request->name, '-');
        $data['slug'] = $slug;

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $file_name = $slug.rand(0000,9999).$file->getClientOriginalName();
            $file->move('uploads/category/',$file_name);
            $data['icon'] = 'uploads/category/' . $file_name;
        }

        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $file_name = $slug.rand(0000,9999).$file->getClientOriginalName();
            $file->move('uploads/category/',$file_name);
            $data['banner'] = 'uploads/category/' . $file_name;
        }


        if (Auth::user()->type == 'vendor'){
            $data['user_id'] = Auth::user()->id;
            $data['status'] = 'pending';
            $data['deleted_at'] = Carbon::now();
        }
        Category::create($data);


        if (Auth::user()->type == 'vendor'){
            session()->flash('success','Category Suggested Successfully');
        }
        else{
            session()->flash('success','Category Created Successfully');
        }

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $data['title'] = 'Category';
        $data['category'] = $category;
        return view('back.category.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'=>'required',
            'icon'=>'image',
            'banner'=>'image',
        ]);
        $data = $request->except('_token');

        if (!$request->home_view){
            $data['home_view'] = 0;
        }
        if (!$request->concern){
            $data['concern'] = 0;
        }


        $slug = Str::slug($request->name, '-');
        $data['slug'] = $slug;

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $file_name = $slug.rand(0000,9999).$file->getClientOriginalName();
            $file->move('uploads/category/',$file_name);
            if ($category->icon != null){
                unlink($category->icon);
            }
            $data['icon'] = 'uploads/category/' . $file_name;
        }

        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $file_name = $slug.rand(0000,9999).$file->getClientOriginalName();
            $file->move('uploads/category/',$file_name);
            if ($category->banner != null){
                unlink($category->banner);
            }
            $data['banner'] = 'uploads/category/' . $file_name;
        }

        $category->update($data);
        session()->flash('success','Category Updated Successfully');
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success','Category Deleted Successfully');
        return redirect()->route('category.index');
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        session()->flash('success','Category Restored Successfully');
        return redirect()->route('category.index');
    }

    public function delete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        if ($category->icon != null){
            unlink($category->icon);
        }
        $category->forceDelete();
        session()->flash('success','Category Permanently Removed');
        return redirect()->route('category.index');
    }


    public function categories()
    {
        $data['title']= 'Categories';
        $data['categories']= Category::latest()->paginate(24);

        return view('front.shops',$data);
    }
}
