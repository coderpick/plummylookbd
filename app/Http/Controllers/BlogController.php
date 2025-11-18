<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostTag;
use App\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $data['title'] = 'Blogs';
        $data['posts'] = Post::with('postTags')->latest()->paginate(9);
        $data['tags'] = Tag::latest()->get();
        return view('front.blog_index', $data);
    }

    public function show($slug)
    {
        $post = Post::with('postTags','user')->where('slug', $slug)->firstOrFail();
        $data['post'] = $post;
        $data['keyword'] = $post->meta_key;
        $data['description'] = $post->meta_description;
        $data['title'] = $post->meta_title??$post->title;
        $data['tags'] = Tag::latest()->get();
        $data['recent_posts'] = Post::with('postTags')->latest()->limit(5)->get();
        return view('front.blog_show', $data);
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $data['title'] = $tag->name;
        $postIds = PostTag::where('tag_id', $tag->id)->pluck('post_id')->toArray();
        if (!empty($postIds)) {
            $data['posts'] = Post::with('postTags')->whereIn('id', $postIds)->paginate(9);
        } else {
            $data['posts'] = Post::with('postTags')->where('id', 0)->paginate(9);
        }
        $data['tags'] = Tag::latest()->get();
        return view('front.blog_index', $data);
    }
}
