@extends('layouts.master')
@section('title')
    All User
@endsection
@section('content')
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">User Management</h3>
                @can('createUser')
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">+ Add New User</a>
                @endcan
                <form method="GET" class="form-inline">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control form-control-sm mr-2" placeholder="Search Users...">
                    <button type="submit" class="btn btn-primary btn-sm mr-2">Search</button>
                    <select name="role" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                        <option value="">All Roles</option>
                        @foreach ($roles as $r)
                            <option value="{{ $r->name }}" {{ request('role') == $r->name ? 'selected' : '' }}>
                                {{ $r->name }}
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
                <table class="table table-bordered m-0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Name</th>
                            <th width="10%">Email</th>
                            <th width="15%">Role</th>
                            <th width="5%">Created</th>
                            <th width="30%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    {{ $user->roles->pluck('name')->join('|| ') }}
                                </td>
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if ($user->id != 1 or auth()->user()->id == 1)
                                        @can('editUser')
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        @endcan
                                        @if (auth()->user()->id != $user->id)
                                            @can('archivingUser')
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        onclick="confirmArchiving(this)">
                                                        <i class="fas fa-archive"></i> Archiving
                                                    </button>
                                                </form>
                                            @endcan
                                        @endif


                                        @can('setPasswordUser')
                                            <a href="{{ route('users.password.edit', $user->id) }}"
                                                class="btn btn-secondary btn-sm">
                                                <i class="fas fa-key"></i> Set Password
                                            </a>
                                        @endcan
                                    @else
                                        <strong class="text-danger">Owner</strong>
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No users found.</td>
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
        function confirmArchiving(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won’t be able to undo this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FFC300',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, archiving it!',
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
