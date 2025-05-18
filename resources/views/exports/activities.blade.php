<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Activity Log</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Activity Log (Posts)</h2>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Description</th>
                <th>Old Title</th>
                <th>New Title</th>
                <th>Old Content</th>
                <th>New Content</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            @php
            $props = $activity->properties;
            @endphp
            <tr>
                <td>{{ optional($activity->causer)->name ?? 'System' }}</td>
                <td>{{ $activity->description }}</td>
                <td>{{ $props['old']['title'] ?? '' }}</td>
                <td>{{ $props['new']['title'] ?? '' }}</td>
                <td>{{ $props['old']['content'] ?? '' }}</td>
                <td>{{ $props['new']['content'] ?? '' }}</td>
                <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>