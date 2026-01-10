<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($slug)
    { 
        $page = Page::where('slug', $slug)->where('status', 1)->first();
        if(!$page) abort(404);
        return view('front.page.index', compact('page'));
    }
}
