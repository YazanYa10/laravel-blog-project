@extends('layouts.master') {{-- Use your AdminLTE main layout --}}
@section('title')
    Posts
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">All Posts</h3>
                        @can('createPost')
                            <a href="{{ route('posts.create') }}" class="btn btn-primary">Create New Post</a>
                        @endcan
                        <form method="GET" class="form-inline">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control form-control-sm mr-2" placeholder="Search posts...">
                            <button type="submit" class="btn btn-primary btn-sm mr-2">Search</button>
                            <select name="category" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="mr-2">Show</label>
                            <select name="perPage" class="form-control form-control-sm" onchange="this.form.submit()">
                                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </form>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-bordered m-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="20%">Image</th>
                                    <th width="10%">Title</th>
                                    <th width="20%">Content</th>
                                    <th width="10%">Category</th>
                                    <th width="10%">Author</th>
                                    <th width="40%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $post)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            @if ($post->image)
                                                <img src="{{ asset('storage/' . $post->image) }}" alt="Featured Image"
                                                    class="img-thumbnail"
                                                    style="width: 80px; height: 60px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ Str::limit($post->content, 60) }}</td>
                                        <td>{{ $post->category->name ?? 'Uncategorized' }}</td>
                                        <td>{{ $post->user->name ?? 'Unknown' }}</td>
                                        <td>
                                            @can('showPost')
                                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            @endcan

                                            @can('editPost')
                                                @can('update', $post)
                                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">
                                                        Edit
                                                    </a>
                                                @endcan
                                            @endcan

                                            @can('deletePost')
                                                @can('delete', $post)
                                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="confirmDelete(this)">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endcan

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No posts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        {{ $posts->appends(request()->query())->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won’t be able to undo this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true, // 🔄 This shows the spinner!
                preConfirm: () => {
                    return new Promise((resolve) => {
                        setTimeout(() => {
                            button.closest('form').submit();
                            resolve(); // resolve to close modal if needed
                        }, 500); // optional delay
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        }
    </script>
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
