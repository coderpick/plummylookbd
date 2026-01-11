<?php

namespace App\Http\Controllers;

use App\BlogCategory;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        Gate::authorize('app.post.index');
        $data['title'] = 'Posts';
        $data['posts'] = Post::withTrashed()->select('id', 'user_id', 'blog_category_id', 'title', 'slug', 'short_description', 'image', 'deleted_at', 'created_at')->with('blogCategory')->latest()->get();

        return view('back.post.index', $data);
    }

    public function create()
    {
        Gate::authorize('app.post.create');
        $data['title'] = 'Create Post';
        $data['categories'] = BlogCategory::orderBy('name', 'ASC')->get();
        $data['postTags'] = Tag::select('id', 'name')->orderBy('name', 'ASC')->where('tag_for', 'post')->get();

        return view('back.post.create', $data);
    }

    public function store(Request $request)
    {

        Gate::authorize('app.post.create');
        $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'slug' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'photo' => 'required|mimes:jpg,jpeg,png,svg|max:1024',
            'tags' => 'required',
        ]);
        $slug = Str::slug($request->slug, '-');
        $post = new Post;
        $slug = Str::slug($request->slug, '-');
        // Keep original author - remove or comment out the line below
        // $post->user_id = auth()->user()->id;
        $post->title = $request->title;
        $post->slug = $slug;
        $post->short_description = $request->short_description;
        $post->body = $request->description;
        $post->meta_title = $request->meta_title;
        $post->meta_key = $request->meta_keywords;
        $post->meta_description = $request->meta_description;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $file_name = uniqid().rand(000, 9999).'.'.$file->getClientOriginalExtension();
            $file->move('uploads/post/', $file_name);
            $post->image = 'uploads/post/'.$file_name;
        }
        $post->save();

        /* Post tags */
        $dropdownData = json_decode($request->input('tags'), true);
        $tagIds = collect($dropdownData)->map(function ($item) {
            return Tag::firstOrCreate(
                ['slug' => Str::slug($item['value'])],
                ['name' => $item['value'], 'tag_for' => 'post']
            )->id;
        })->toArray();

        // Sync tags with product
        $post->tags()->attach($tagIds);

        session()->flash('success', 'Post Created Successfully');

        return redirect()->route('post.index');
    }

    public function show($id)
    {
        Gate::authorize('app.post.index');
        $post = Post::with(['tags', 'blogCategory'])->findOrFail($id);
        $data['post'] = $post;
        $data['title'] = $post->title ?? '';

        return view('back.post.show', $data);
    }

    public function edit($id)
    {
        Gate::authorize('app.post.edit');
        $post = Post::with('tags')->findOrFail($id);
        $data['title'] = 'Edit Post';
        $data['post'] = $post;
        $data['categories'] = BlogCategory::orderBy('name', 'ASC')->get();
        $tags = $post->tags()->pluck('id')->toArray();
        $data['selectedTags'] = Tag::whereIn('id', $tags)->get();
        $data['postTags'] = Tag::select('id', 'name')->orderBy('name', 'ASC')->where('tag_for', 'post')->get();

        return view('back.post.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('app.post.edit');
        $post = Post::findOrFail($id);
        $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'slug' => 'required|string|unique:posts,slug,'.$post->id,
            'short_description' => 'required',
            'description' => 'required',
            'tags' => 'required',
            'photo' => 'nullable|mimes:jpg,jpeg,png,svg|max:1024',
        ]);
        $slug = Str::slug($request->slug, '-') ?? $request->slug;
        $post->user_id = auth()->user()->id;
        $post->blog_category_id = $request->category;
        $post->title = $request->title;
        $post->slug = $slug;
        $post->short_description = $request->short_description;
        $post->body = $request->description;
        $post->meta_title = $request->meta_title;
        $post->meta_key = $request->meta_keywords;
        $post->meta_description = $request->meta_description;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $file_name = uniqid().rand(000, 9999).'.'.$file->getClientOriginalExtension();
            $file->move('uploads/post/', $file_name);
            if ($post->image != null && file_exists($post->image)) {
                unlink($post->image);
            }
            $post->image = 'uploads/post/'.$file_name;
        }
        $post->save();

        /* product tags */
        $dropdownData = json_decode($request->input('tags'), true);
        $tagIds = collect($dropdownData)->map(function ($item) {
            return Tag::firstOrCreate(
                ['slug' => Str::slug($item['value'])],
                ['name' => $item['value'], 'tag_for' => 'post']
            )->id;
        })->toArray();

        // Sync tags with product
        $post->tags()->sync($tagIds);

        session()->flash('success', 'Updated Successfully');

        return redirect()->route('post.index');
    }

    public function trash($id)
    {
        Gate::authorize('app.post.destroy');
        $post = Post::findOrFail($id);
        $post->delete();
        session()->flash('success', 'Trashed Successfully');

        return redirect()->back();
    }

    public function restore($id)
    {
        Gate::authorize('app.post.destroy');
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        session()->flash('Restore Successfully', 'Success');

        return redirect()->back();
    }

    public function destroy($id)
    {
        Gate::authorize('app.post.destroy');
        $post = Post::withTrashed()->findOrFail($id);
        $post->tags()->detach();
        $post->forceDelete();
        session()->flash('success', 'Deleted Successfully');

        return redirect()->back();
    }
}
