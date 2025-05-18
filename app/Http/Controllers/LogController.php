<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;
use App\Exports\PostLogsExport;
use Maatwebsite\Excel\Facades\Excel;
class LogController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:postsLogs', ['only' => ['logsPosts']]);
        $this->middleware('permission:usersLogs', ['only' => ['logsUsers']]);
        $this->middleware('permission:rolesLogs', ['only' => ['logsRoles']]);
    }
    public function logsPosts(Request $request)
    {
        $query = Activity::where('subject_type', \App\Models\Post::class);
        // Search by Description or Details
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('properties->title', 'like', "%{$search}%")
                    ->orWhere('properties->content', 'like', "%{$search}%")
                    ->orWhereHas('causer', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }
        // Filter by Description
        if ($request->filled('description')) {
            $description = $request->description;
            $query->where('description', $description);
        }
     

        if ($request->filled('user_id')) {
            $userId = $request->input('user_id');
            $query->where('causer_id', $userId);
        }
        $logs = $query->paginate(10);
        $users = \App\Models\User::all();
        return view('logs.index', compact('logs', 'users'));
        /*
        $logs = Activity::where('subject_type', 'App\\Models\\Post')->paginate(10);
        return view('logs.index', compact('logs'));
        */
    }

    public function logsUsers(Request $request)
    {
        $query = Activity::where('subject_type', \App\Models\User::class);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('description', 'like', "%{$search}%")
                    ->orWhere('properties->name', 'like', "%{$search}%")
                    ->orWhere('properties->role', 'like', "%{$search}%")
                    ->orWhere('properties->old_roles', 'like', "%{$search}%")
                    ->orWhere('properties->new_roles', 'like', "%{$search}%")
                    ->orWhereHas('causer', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
      
        }
        if ($request->filled('description')) {
            $description = $request->description;
            $query->where('description', $description);
        }
        if ($request->filled('user_id')) {
            $userId = $request->input('user_id');
            $query->where('causer_id', $userId);
        }
        $logs = $query->paginate(10);
        $users = \App\Models\User::all();
        return view('logs.logs-users', compact('logs','users'));
        /*
        $logs = Activity::where('subject_type', 'App\\Models\\User')->paginate(30);
        return view('logs.logs-users', compact('logs'));
        */
    }

    public function logsRoles(Request $request)
    {
        $query = Activity::where('subject_type', Role::class);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('description', 'like', "%{$search}%")
                    ->orWhere('properties->name', 'like', "%{$search}%")
                    ->orWhere('properties->permissions', 'like', "%{$search}%")
                    ->orWhere('properties->old_permissions', 'like', "%{$search}%")
                    ->orWhere('properties->new_permissions', 'like', "%{$search}%")
                    ->orWhere('properties->old_name', 'like', "%{$search}%")
                    ->orWhere('properties->new_name', 'like', "%{$search}%");
        }
        if ($request->filled('description')) {
            $description = $request->description;
            $query->where('description', $description);
        }
        if ($request->filled('user_id')) {
            $userId = $request->input('user_id');
            $query->where('causer_id', $userId);
        }
        $logs = $query->paginate(10);
        $users = \App\Models\User::all();
        return view('logs.roles', compact('logs', 'users'));
        /*
        $logs = Activity::where('subject_type', Role::class)->paginate(10);
        */
    }

    public function exportPostLogsExcel()
    {
        return Excel::download(new PostLogsExport, 'post_logs.xlsx');
    }
       
}
