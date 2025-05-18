@extends('layouts.master')
@section('title')
    Home
@endsection
@section('content')
    <div class="container-fluid mt-3">

        {{-- Dashboard Stats --}}
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $postsCount }}</h3>
                        <p>Total Posts</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $categoriesCount }}</h3>
                        <p>Total Categories</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Latest Posts --}}
        <div class="card mt-4">
            @auth
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Latest Posts</h3>
                    @can('createPost')
                        <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm">+ Create New Post</a>
                    @endcan
                </div>
            @endauth
            <div class="card-body p-0">
                @if ($latestPosts->count())
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestPosts as $index => $post)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @can('showPost')
                                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-info">
                                                View
                                            </a>
                                        @endcan

                                        @can('editPost')
                                            @can('update', $post)
                                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
                                            @endcan
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
@endsection
