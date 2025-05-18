<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permissions', ['only' => ['index']]);
        $this->middleware('permission:createPermission', ['only' => ['create', 'store']]);
        $this->middleware('permission:editPermission', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deletePermission', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);  // Default is 10
        $search = $request->input('search');
        $role_id = $request->input('role');
        $roles = Role::all();
        $query = Permission::query();
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($role_id) {
            $query->whereHas('roles', function ($q) use ($role_id) {
                $q->where('id', $role_id);
            });
        }
        $permissions = $query->paginate($perPage);
        return view('permissions.index', compact('permissions', 'perPage', 'search','roles'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $role = Role::where('name', 'superadmin')->first();
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);
        Permission::create(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);
        $permission->update(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted.');
    }
}
