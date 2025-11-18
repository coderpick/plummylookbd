<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Category;
use App\Post;
use App\PostTag;
use App\SubCategory;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        Gate::authorize('app.post.index');
        $data['title'] = 'Posts';
        $data['posts'] = Post::withTrashed()->with('postTags.tag')->latest()->get();
        return view('back.post.index',$data);
    }

    public function create()
    {
        Gate::authorize('app.post.create');
        $data['title'] = 'Create Post';
        $data['tags']  = Tag::orderBy('name')->get();
        return view('back.post.create',$data);
    }

    public function store(Request $request)
    {
        Gate::authorize('app.post.create');
        $this->validate($request,[
            'title' => 'required',
            'slug' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'photo' => 'required|mimes:jpg,jpeg,png,svg|max:1024',
        ]);
        //$slug = Str::slug($request->title,'-');
        $slug = $request->slug;
        $post = new Post();
        $post->user_id           = auth()->user()->id;
        $post->title             = $request->title;
        $post->slug              = $slug;
        $post->short_description = $request->short_description;
        $post->body              = $request->description;
        $post->meta_title     = $request->meta_title;
        $post->meta_key     = $request->meta_keywords;
        $post->meta_description  = $request->meta_description;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $file_name = uniqid().rand(000,9999).'.'.$file->getClientOriginalExtension();
            $file->move('uploads/post/',$file_name);
            $post->image = 'uploads/post/' . $file_name;
        }
        $post->save();

        if($request->tags && count($request->tags) > 0){
            $post_tags = [];
            foreach ($request->tags as $tag) {
                $post_tags[] = [
                    'post_id' => $post->id,
                    'tag_id' => $tag,
                ];
            }
            PostTag::insert($post_tags);
        }
        session()->flash('success','Created Successfully');
        return redirect()->route('post.index');
    }

    public function show($id)
    {
        Gate::authorize('app.post.index');
        $post = Post::findOrFail($id);
        $data['post']     = $post;
        $data['title'] = $post->title??'';
        return view('back.post.show',$data);
    }

    public function edit($id)
    {
        Gate::authorize('app.post.edit');
        $post = Post::with('postTags')->findOrFail($id);
        $data['title'] = 'Edit Post';
        $data['post']     = $post;
        $data['tags']  = Tag::orderBy('name')->get();
        $post_tags = PostTag::select('tag_id')->where('post_id',$post->id)->get();
        $post_tags_array = [];
        foreach($post_tags as $post_tag){
            array_push($post_tags_array,$post_tag->tag_id);
        }
        $data['post_tags'] = $post_tags_array;

        return view('back.post.edit',$data);
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('app.post.edit');
        $post = Post::findOrFail($id);
        $this->validate($request,[
            'title' => 'required',
            'slug' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'photo' => 'nullable|mimes:jpg,jpeg,png,svg|max:1024',
        ]);
        //$slug = Str::slug($request->title,'-');
        $slug = $request->slug;
        $post->user_id           = auth()->user()->id;
        $post->title             = $request->title;
        $post->slug              = $slug;
        $post->short_description = $request->short_description;
        $post->body              = $request->description;
        $post->meta_title     = $request->meta_title;
        $post->meta_key     = $request->meta_keywords;
        $post->meta_description  = $request->meta_description;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $file_name = uniqid().rand(000,9999).'.'.$file->getClientOriginalExtension();
            $file->move('uploads/post/',$file_name);
            if ($post->image != null){
                unlink($post->image);
            }
            $post->image = 'uploads/post/' . $file_name;
        }
        $post->save();

        if($request->tags && count($request->tags) > 0){
            PostTag::where('post_id', $post->id)->delete();
            $post_tags = [];
            foreach ($request->tags as $tag) {
                $post_tags[] = [
                    'post_id' => $post->id,
                    'tag_id' => $tag,
                ];
            }
            PostTag::insert($post_tags);
        }

        session()->flash('success','Updated Successfully');
        return redirect()->route('post.index');
    }

    public function trash($id)
    {
        Gate::authorize('app.post.destroy');
        $post = Post::findOrFail($id);
        $post->delete();
        session()->flash('Trashed Successfully','Success');
        return redirect()->back();
    }

    public function restore($id)
    {
        Gate::authorize('app.post.destroy');
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        session()->flash('Restore Successfully','Success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        Gate::authorize('app.post.destroy');
        $post = Post::withTrashed()->findOrFail($id);
        PostTag::where('post_id', $post->id)->delete();
        if ($post->image != null){
            unlink($post->image);
        }
        $post->forceDelete();
        session()->flash("Deleted Successfully","Success");
        return redirect()->back();
    }

}
