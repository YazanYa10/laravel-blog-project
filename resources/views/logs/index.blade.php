@extends('layouts.master')
@section('title')
    Posts Logs
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Posts Logs</h3>
                        <form method="GET" action="{{ route('logs.posts') }}" class="mb-4 mt-3">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by title, content,user, or description"
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="description" class="form-control">
                                        <option value="">-- Filter by Action --</option>
                                        <option value="Post created"
                                            {{ request('description') == 'Post created' ? 'selected' : '' }}>Post created
                                        </option>
                                        <option value="Post updated"
                                            {{ request('description') == 'Post updated' ? 'selected' : '' }}>Post updated
                                        </option>
                                        <option value="Post deleted"
                                            {{ request('description') == 'Post deleted' ? 'selected' : '' }}>Post deleted
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
                        <a href="{{ route('logs.posts.export.excel') }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </a>

                        <a href="{{ route('export.pdf') }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i>
                            Export to PDF
                        </a>

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
                                        <td>
                                            @if ($log->description === 'Post created' || $log->description === 'Post deleted')
                                                <strong>Title:</strong> {{ $log->properties['title'] ?? '-' }}<br>
                                                <strong>Content:</strong> {{ $log->properties['content'] ?? '-' }}
                                            @elseif($log->description === 'Post updated')
                                                <strong>Old:</strong><br>
                                                Title: {{ $log->properties['old']['title'] ?? '-' }}<br>
                                                Content: {{ $log->properties['old']['content'] ?? '-' }}<br>
                                                <strong>New:</strong><br>
                                                Title: {{ $log->properties['new']['title'] ?? '-' }}<br>
                                                Content: {{ $log->properties['new']['content'] ?? '-' }}
                                            @else
                                                <em>No details available</em>
                                            @endif
                                        </td>
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
