@extends('layouts.master')
@section('title')
    Show Post Page
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">{{ $post->title }}</h3>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">Published on: {{ $post->created_at->format('F j, Y') }}</p>
                        <hr>
                        <p>{{ $post->content }}</p>
                    </div>
                    @if ($post->image)
                        <div class="card mb-4 border-primary">
                            <div class="card-body text-center p-3">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Featured Image"
                                    class="img-fluid img-thumbnail" style="max-height: 350px; object-fit: contain;">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
