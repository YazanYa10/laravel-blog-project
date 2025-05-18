<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
class CategoryController extends Controller
{
    public function show($name)
    {
        $category = Category::where('name', $name)->firstOrFail();
        $posts = Post::where('category_id', $category->id)->paginate(3); // 6 posts per page
        return view('site.category', compact('category', 'posts'));
    }
}
