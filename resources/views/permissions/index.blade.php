@extends('layouts.master')
@section('title')
    Permissions
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">

                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">All Permissions</h3>
                        @can('createPermission')
                            <a href="{{ route('permissions.create') }}" class="btn btn-primary">Create New Permission</a>
                        @endcan
                        <form method="GET" class="form-inline">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control form-control-sm mr-2" placeholder="Search Permissions...">
                            <button type="submit" class="btn btn-primary btn-sm mr-2">Search</button>
                            <select name="role" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                                <option value="">All Roles</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->id }}" {{ request('role') == $r->id ? 'selected' : '' }}>
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
                        <table class="table table-striped table-bordered m-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="30%">Name</th>
                                    <th width="30%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permissions as $permission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            @can('editPermission')
                                                <a href="{{ route('permissions.edit', $permission->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                            @endcan

                                            @can('deletePermission')
                                                <form action="{{ route('permissions.destroy', $permission->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete(this)">Delete</button>
                                                </form>
                                            @endcan

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No permissions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        {{ $permissions->appends(request()->query())->links() }}
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
