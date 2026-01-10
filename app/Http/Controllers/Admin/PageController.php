<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['pages'] = Page::get();
        $data['title'] = 'Pages';

        return view('back.page.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Page Create';

        return view('back.page.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages,slug,except,id',
            'description' => 'required',
        ]);

        Page::create([
            'title' => $request->title,
            'slug' => Str::slug($request->slug, '-'),
            'content' => $request->description,
            'status' => $request->input('status') ? 1 : 0
        ]);

        session()->flash('success', 'Page Created Successfully');

        return redirect()->route('page.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $page = Page::findOrFail($id);
        $data['page'] = $page;
        $data['title'] = 'Page Details';
        return view('back.page.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = Page::findOrFail($id);
        $data['page'] = $page;
        $data['title'] = 'Page Edit';

        return view('back.page.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages,slug,'.$page->id,
            'description' => 'required|string',
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => Str::slug($request->slug, '-'),
            'content' => $request->description,
            'status' => $request->input('status') ? 1 : 0
        ]);

        session()->flash('success', 'Page Updated Successfully');

        return redirect()->route('page.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        session()->flash('success', 'Page Deleted Successfully');
          return redirect()->route('page.index');
    }
}
