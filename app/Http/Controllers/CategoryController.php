<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CategoryRequest;
class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:categories', ['only' => ['index']]);
        $this->middleware('permission:createCategory', ['only' => ['create','store']]);
        $this->middleware('permission:editCategory', ['only' => ['edit','update']]);
        $this->middleware('permission:deleteCategory', ['only' => ['destroy']]);
        $this->middleware('permission:showCategory', ['only' => ['show']]);
    }
    
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $query = Category::query();
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        $categories = $query->paginate($perPage);
        return view('categories.index', compact('categories', 'perPage', 'search'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }
        Category::create([
            'name' => $request->name,
            'image' => $imagePath,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request,Category $category)
    {
        $imagePath = $category->image;
        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
        }
        $category->update([
            'name' => $request->name,
            'image' => $imagePath,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        foreach ($category->posts as $post) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $post->delete();
        }
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
