<?php

namespace App\Http\Controllers;

use App\BlogCategory;
use App\Post;
use App\Tag;

class BlogController extends Controller
{
    public function index()
    {
        $data['title'] = 'Blogs';
        $data['posts'] = Post::select('id', 'user_id', 'blog_category_id', 'title', 'slug', 'short_description', 'image', 'deleted_at', 'created_at')->with('blogCategory')->latest()->paginate(9);

        $data['blogCategories'] = BlogCategory::orderBy('name', 'ASC')->get();

        return view('front.blog_index', $data);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $data['post'] = $post;
        $data['keyword'] = $post->meta_key;
        $data['description'] = $post->meta_description;
        $data['title'] = $post->meta_title ?? $post->title;
        $data['blogCategories'] = BlogCategory::orderBy('name', 'ASC')->get();
        $data['recent_posts'] = Post::with('tags')->latest()->limit(5)->get();

        return view('front.blog_show', $data);
    }

    public function categoryPost($categorySlug)
    {
        $category = BlogCategory::where('slug', $categorySlug)->firstOrFail();
        $data['title'] = $category->name;
        $data['posts'] = Post::select('id', 'user_id', 'blog_category_id', 'title', 'slug', 'short_description', 'image', 'deleted_at', 'created_at')
            ->where('blog_category_id', $category->id)
            ->with('blogCategory')->latest()->paginate(9);
        $data['blogCategories'] = BlogCategory::orderBy('name', 'ASC')->get();

        return view('front.blog_index', $data);
    }

    public function tagPost($tagSlug)
    {
        $tag = Tag::where('slug', $tagSlug)->firstOrFail();
        $data['title'] = $tag->name;
        $data['posts'] = $tag->posts()->with('blogCategory')->latest()->paginate(9);
        $data['blogCategories'] = BlogCategory::orderBy('name', 'ASC')->get();

        return view('front.blog_tags', $data);
    }
}
