@extends('site.layouts.master')

@section('title', 'Category: ' . $category->name)

@section('content')
    <div class="container text-center my-5">
        <h1>Category: {{ $category->name }}</h1>
        <p class="lead">Posts under the "{{ ucfirst($category->name) }}" category:</p>

        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit(strip_tags($post->content), 30) }}</p>
                            <a href="{{ route('site.post.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>

    </div>
@endsection
