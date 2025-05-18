<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(6); // 6 posts per page
        return view('site.posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $comments = $post->comments()->latest()->get();
        return view('site.posts.show', compact('post', 'comments'));
    }
}
