<?php

namespace App\Http\Controllers\Admin;

use App\BlogCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('blog_category_index');
        $data['title'] = 'Blog Category';
        $data['categories'] = BlogCategory::get();

        return view('back.blog_category.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('blog_category_create');
        $route = Route::currentRouteName();
        Session::flash('create_route', $route);
        $request->validate([
            'category_name' => 'required',
        ]);
        BlogCategory::create([
            'name' => $request->category_name,
            'slug' => str_slug($request->category_name),
        ]);
        session()->flash('Category Created successfully', 'Success');

        return redirect()->route('blog_category.index');
    }

    public function edit(Request $request)
    {
        return BlogCategory::where('id', $request->id)->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        Gate::authorize('blog_category_edit');
        $route = Route::currentRouteName();
        Session::flash('edit_route', $route);
        $category = BlogCategory::where('id', $request->category_id)->first();
        $request->validate([
            'category_name' => 'required',
        ]);
        $category->update([
            'name' => $request->category_name,
            'slug' => str_slug($request->category_name),
        ]);
        session()->flash('Updated successfully', 'Success');

        return redirect()->route('blog_category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('app.tag.destroy');
        $category = BlogCategory::where('id', $id)->first();
        $category->delete();
        session()->flash('Deleted successfully', 'Success');

        return redirect()->route('blog_category.index');
    }
}
