<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:roles', ['only' => ['index']]);
        $this->middleware('permission:createRole', ['only' => ['create', 'store']]);
        $this->middleware('permission:editRole', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteRole', ['only' => ['destroy']]);
        $this->middleware('permission:showPermissions', ['only' => ['showPermissions']]);
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $query = Role::query();
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        $roles = $query->paginate($perPage);
        return view('roles.index', compact('roles', 'perPage'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($role)
            ->withProperties([
                'name' => $request->name,
                'permissions' => $request->permissions
            ])
            ->log('Role created');
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        if($role->id == 6 && auth()->user()->id != 1){
            abort(403);
        } 
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);
        $oldrole = $role->name;
        $oldPermissions = $role->permissions->pluck('name')->toArray();
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        $newPermissions = $role->permissions->pluck('name')->toArray();
        if ($oldPermissions !== $newPermissions) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($role)
                ->withProperties([
                    'name' => $role->name,
                    'old_permissions' => $oldPermissions,
                    'new_permissions' => $newPermissions
                ])
                ->log('Role permissions updated');
        }
        else
        {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($role)
                ->withProperties([
                    'old_name' => $oldrole,
                    'new_name' => $role->name,
                    'permissions' => $oldPermissions,
                ])
                ->log('Role name updated');
        }
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($role)
            ->withProperties([
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name')->toArray()
            ])
            ->log('Role deleted');

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted.');
    }

    public function showPermissions($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::whereIn('id', $role->permissions->pluck('id'))->paginate(5);
        return view('roles.show-permissions', compact('role', 'permissions'));
    }
}
