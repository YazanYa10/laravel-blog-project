<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
class PostController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:posts', ['only' => ['index']]);
        $this->middleware('permission:createPost', ['only' => ['create', 'store']]);
        $this->middleware('permission:editPost', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deletePost', ['only' => ['destroy']]);
        $this->middleware('permission:showPost', ['only' => ['show']]);
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $category = $request->input('category');
        $query = Post::query();
        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        }
        if ($category) {
            $query->where('category_id', $category);
        }
        $posts = $query->paginate($perPage);
        $categories = Category::all();
        return view('posts.index', compact('posts', 'perPage', 'search', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create',compact('categories'));
    }

    public function store(PostRequest  $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }
        $post =  Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'user_id' => auth()->id(),
            'slug' => Str::slug($request->title),
        ]);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($post)
            ->withProperties([
                'title' => $post->title,
                'content' => $post->content
            ])
            ->log('Post created');

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show($id)
    {
        $post = Post::where('id', $id)->first();
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::where('id', $id)->first();
        $this->authorize('update', $post);
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::where('id', $id)->first();
        $this->authorize('update', $post);
        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
        }
        activity()
            ->causedBy(auth()->user())
            ->performedOn($post)
            ->withProperties([
                'old' => [
                    'title' => $post->title,
                    'content' => $post->content
                ],
                'new' => [
                    'title' => $request->title,
                    'content' => $request->content
                ]
            ])
            ->log('Post updated');
        /*
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);*/
        
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
        $post->image = $imagePath;
        $post->slug = Str::slug($request->title);
        $post->save(); // This is what Spatie listens to
        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();
        $this->authorize('delete', $post);
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($post)
            ->withProperties([
                'title' => $post->title,
                'content' => $post->content
            ])
            ->log('Post deleted');
            
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    
}
