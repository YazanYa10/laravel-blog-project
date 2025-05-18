<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->take(3)->get();
        $categories = Category::whereNotNull('image')->get();
        return view('site.home',compact('posts', 'categories'));
    }
}
