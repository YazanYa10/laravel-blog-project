@extends('site.layouts.master')

@section('title', 'Home')

@section('content')

    <!-- Welcome Section -->
    <!-- Welcome Section with Slideshow -->
    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4 fw-bold">Welcome to MyBlog!</h1>
            <p class="fs-5">Explore categories and find your inspiration.</p>

            @if ($categories->count())
                <div id="categoryCarousel" class="carousel slide mt-4" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-inner">
                        @foreach ($categories as $index => $category)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $category->image) }}" class="d-block w-100 rounded"
                                    alt="{{ $category->name }}" style="height: 300px; object-fit: cover;">
                                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                                    <h5 class="text-white">{{ $category->name }}</h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#categoryCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#categoryCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            @else
                <p class="text-muted mt-4">No category images to display yet.</p>
            @endif
            <div class="text-center mt-3">
                <button class="btn btn-outline-primary me-2" data-bs-target="#categoryCarousel" data-bs-slide="prev">
                    &laquo; Previous
                </button>
                <button class="btn btn-outline-primary" data-bs-target="#categoryCarousel" data-bs-slide="next">
                    Next &raquo;
                </button>
            </div>

        </div>
    </div>


    <!-- Latest Posts Section -->
    <div class="container my-5" id="posts">
        <h2 class="text-center mb-4">Latest Posts</h2>

        <div class="row">
            @forelse ($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit($post->content, 50) }}</p>
                            <a href="{{ route('site.post.show', $post->slug) }}"
                                class="btn btn-outline-primary mt-auto">Read More</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No posts available yet.</p>
            @endforelse
        </div>
    </div>

@endsection
