@extends('layouts.master')
@section('title')
    Audit Logs
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Audit Logs</h3>
                        <form method="GET"class="mb-4 mt-3">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by name, role,user, or description"
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="description" class="form-control">
                                        <option value="">-- Filter by Action --</option>
                                        <option value="User created"
                                            {{ request('description') == 'User created' ? 'selected' : '' }}>User Created
                                        </option>
                                        <option value="User roles updated"
                                            {{ request('description') == 'User roles updated' ? 'selected' : '' }}>
                                            User Roles Updated
                                        </option>
                                        <option value="User name updated"
                                            {{ request('description') == 'User name updated' ? 'selected' : '' }}>
                                            User Name Updated
                                        </option>
                                        <option value="User archived"
                                            {{ request('description') == 'User archived' ? 'selected' : '' }}>
                                            User Archived
                                        </option>
                                        <option value="User restored"
                                            {{ request('description') == 'User restored' ? 'selected' : '' }}>
                                            User Restored
                                        </option>
                                        <option value="User permanently deleted"
                                            {{ request('description') == 'User permanently deleted' ? 'selected' : '' }}>
                                            User Permanently Deleted
                                        </option>
                                        <option value="User password updated"
                                            {{ request('description') == 'User password updated' ? 'selected' : '' }}>
                                            User Password Updated
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
                                        <td>{!! formatAuditLog($log) !!}</td>
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
