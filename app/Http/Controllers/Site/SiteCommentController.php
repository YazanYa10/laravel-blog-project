<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class SiteCommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        Comment::create([
            'site_user_id' => auth('site')->id(),
            'content' => $request->content,
            'post_id' => $post->id,
        ]);
       
        session()->flash('success', 'Comment added successfully!');
        return redirect()->back();
    }
}
