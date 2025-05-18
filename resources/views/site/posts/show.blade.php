@extends('site.layouts.master')

@section('title', $post->title)

@section('content')
    <div class="container my-5">


        {{-- Post Card --}}
        <div class="card shadow-lg border-0 mb-5">

            {{-- Post Image --}}
            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top img-fluid" alt="{{ $post->title }}"
                    style="height: 200px; object-fit: cover;">
            @endif

            {{-- Title Section with Background --}}
            <div class="bg-light p-4 text-center rounded-bottom">
                <h1 class="card-title mb-2">{{ $post->title }}</h1>
                <p class="text-muted mb-0">{{ $post->created_at->format('F d, Y') }}</p>
            </div>

            {{-- Post Content --}}
            <div class="card-body mt-4">
                <div class="text-start" style="line-height: 1.8;">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="mb-4 d-flex justify-content-start gap-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>

            @auth('site')
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentModal">Add Comment</button>
            @else
                <a href="{{ route('site.login') }}" class="btn btn-primary">Add Comment</a>
            @endauth
        </div>

        {{-- Comments Section --}}
        <div class="mt-5">
            <h4 class="mb-3">Comments ({{ $comments->count() }})</h4>

            @forelse ($comments as $comment)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{ $comment->user->name }}
                            <small class="text-muted">- {{ $comment->created_at->diffForHumans() }}</small>
                        </h6>
                        <p class="card-text">{{ $comment->content }}</p>
                    </div>
                </div>
            @empty
                <p class="text-muted">No comments yet. Be the first to comment!</p>
            @endforelse
        </div>

    </div>

    {{-- Modal for Adding Comment --}}
    @auth('site')
        <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('site.comment.store', $post->id) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentModalLabel">Add Comment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <textarea name="content" class="form-control" rows="4" placeholder="Write your comment here..." required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit Comment</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endauth

@endsection
