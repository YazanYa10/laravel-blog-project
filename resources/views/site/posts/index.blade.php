@extends('site.layouts.master')

@section('title', 'All Posts')

@section('content')
    <div class="container text-center">
        <h1>All Posts</h1>
        <p class="lead">Browse all posts available on the blog:</p>

        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit($post->content, 30) }}</p>
                            <a href="{{ route('site.post.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
