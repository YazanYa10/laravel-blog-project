@extends('layouts.master')
@section('title')
    Archived Users Page
@endsection
@section('content')
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Archived Users</h3>
                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to Active Users
                </a>
                <form method="GET" class="form-inline">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control form-control-sm mr-2" placeholder="Search  Archived Users...">
                    <button type="submit" class="btn btn-primary btn-sm mr-2">Search</button>
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
                <table class="table table-bordered m-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->deleted_at->diffForHumans() }}</td>
                                <td>
                                    @can('restoreUser')
                                        <form action="{{ route('users.restore', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn btn-sm btn-success" title="Restore user"
                                                onclick="confirmRestore(this)">
                                                <i class="fas fa-undo"></i> Restore
                                            </button>
                                        </form>
                                    @endcan

                                    @can('forceDeleteUser')
                                        <form action="{{ route('users.forceDelete', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" title="Delete permanently"
                                                onclick="confirmDelete(this)">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    @endcan

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No archived users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-center">
                {{ $users->appends(request()->query())->links() }}
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
    <script>
        function confirmRestore(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won’t be able to undo this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#49ff33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, restore it!',
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
@endsection
