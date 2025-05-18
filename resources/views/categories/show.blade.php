@extends('layouts.master')
@section('title')
    Category View Page
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10">

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">{{ $category->name }}</h3>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Back</a>
                    </div>
                    @if ($category->image)
                        <div class="mb-3 text-center">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image"
                                class="img-thumbnail shadow" style="max-height: 300px;">
                        </div>
                    @endif
                    <div class="card-body">
                        <p class="text-muted">Created at: {{ $category->created_at->format('F j, Y') }}</p>
                        <p><strong>ID:</strong> {{ $category->id }}</p>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Posts in this Category</h5>
                    </div>
                    <div class="card-body p-0">
                        @if ($category->posts->count())
                            <table class="table table-striped table-bordered m-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="10%">#</th>
                                        <th width="30%">Title</th>
                                        <th width="50%">Content</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category->posts as $index => $post)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $post->title }}</td>
                                            <td>{{ Str::limit($post->content, 60) }}</td>
                                            <td>
                                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-3 text-center">
                                <em>No posts found in this category.</em>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
