<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    public function index()
    {
        Gate::authorize('app.tag.index');
        $data['title'] = 'Tag';
        $data['tags'] = Tag::get();

        return view('back.tag.index', $data);
    }

    public function store(Request $request)
    {
        Gate::authorize('app.tag.create');
        $route = Route::currentRouteName();
        Session::flash('create_route', $route);
        $request->validate([
            'tag_name' => 'required',
        ]);
        $tag = new Tag;
        $slug = str_slug($request->tag_name);
        $tag->name = $request->tag_name;
        $tag->tag_for = 'post';
        $tag->slug = $slug;
        $tag->save();
        session()->flash('success', 'Created successfully');

        return redirect()->route('tag.index');
    }

    public function edit(Request $request)
    {
        return Tag::where('id', $request->id)->first();
    }

    public function update(Request $request)
    {
        Gate::authorize('app.tag.edit');
        $route = Route::currentRouteName();
        Session::flash('edit_route', $route);
        $request->validate([
            'tag_name' => 'required',
        ]);
        $tag = Tag::where('id', $request->tag_id)->first();
        $slug = str_slug($request->tag_name);
        $tag->name = $request->tag_name;
        $tag->slug = $slug;
        $tag->save();
        session()->flash('success', 'Updated successfully');

        return redirect()->route('tag.index');
    }

    public function destroy($id)
    {
        Gate::authorize('app.tag.destroy');
        $tag = Tag::where('id', $id)->first();
        if (! $tag) {
            session()->flash('success', 'Deleted successfully');
        }
        $tag->delete();
        session()->flash('Deleted successfully', 'Success');

        return redirect()->route('tag.index');
    }
}
