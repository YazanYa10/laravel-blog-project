@extends('layouts.master')
@section('title')
    Roles Logs
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Roles Logs</h3>
                        <form method="GET"class="mb-4 mt-3">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by role, permissions, or description"
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="description" class="form-control">
                                        <option value="">-- Filter by Action --</option>
                                        <option value="Role created"
                                            {{ request('description') == 'Role created' ? 'selected' : '' }}>Role Created
                                        </option>
                                        <option value="Role permissions updated"
                                            {{ request('description') == 'Role permissions updated' ? 'selected' : '' }}>
                                            Role Permissions Updated
                                        </option>
                                        <option value="Role name updated"
                                            {{ request('description') == 'Role name updated' ? 'selected' : '' }}>
                                            Role Name Updated
                                        </option>
                                        <option value="Role deleted"
                                            {{ request('description') == 'Role deleted' ? 'selected' : '' }}>
                                            Role deleted
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="user_id" class="form-control">
                                        <option value="">-- Filter by User --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-striped table-bordered m-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>User</th>
                                    <th>Details</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $log)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $log->description }}</td>
                                        <td>{{ $log->causer->name ?? 'System/Unknown' }}</td>
                                        <td>{!! formatRoleLog($log) !!}</td>

                                        <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No logs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="p-3">
                            {{ $logs->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
