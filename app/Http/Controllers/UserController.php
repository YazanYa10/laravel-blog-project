<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:users', ['only' => ['index']]);
        $this->middleware('permission:createUser', ['only' => ['create', 'store']]);
        $this->middleware('permission:editUser', ['only' => ['edit', 'update']]);
        $this->middleware('permission:archivingUser', ['only' => ['destroy']]);
        $this->middleware('permission:setPasswordUser', ['only' => ['editPassword', 'updatePassword']]);
        $this->middleware('permission:archivedUsers', ['only' => ['archived']]);
        $this->middleware('permission:restoreUser', ['only' => ['restore']]);
        $this->middleware('permission:forceDeleteUser', ['only' => ['forceDelete']]);
    }
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $role = $request->input('role');
        $query = User::query();
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }
        if ($role) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }
        $roles = Role::all();
        $users = $query->paginate($perPage);
        return view('users.index', compact('users', 'perPage', 'search', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create',compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->syncRoles($request->roles);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'name' => $user->name,
                'role' => $user->getRoleNames() ?? 'None'
            ])
            ->log('User created');
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    { 
        $roles = Role::all();
        $user = User::find($id);
        if($user->id ==1 && auth()->user()->id != 1){
            abort(403);
        }
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UserRequest $request,User $user)
    {
        $oldRoles = $user->roles->pluck('name')->toArray();
        $oldname = $user->name;
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $user->syncRoles($request->roles);
        $newRoles = $user->roles->pluck('name')->toArray();
        if ($oldRoles !== $newRoles) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties([
                    'name' => $user->name,
                    'old_roles' => $oldRoles,
                    'new_roles' => $newRoles
                ])
                ->log('User roles updated');
        }else{
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties([
                    'old_name' => $oldname,
                    'new_name' => $user->name,
                    'role' => $oldRoles,
                ])
                ->log('User name updated');
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'name' => $user->name,
                'role' => $user->getRoleNames()->toArray()
            ])
            ->log('User archived');
        return redirect()->route('users.archived')->with('success', 'User archived successfully.');
    }

    public function archived(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $query = User::query()->onlyTrashed();
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }
        $users = $query->paginate($perPage);
        return view('users.archived', compact('users', 'perPage', 'search'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'name' => $user->name,
                'role' => $user->getRoleNames()->toArray()
            ])
            ->log('User restored');
        return redirect()->route('users.index')->with('success', 'User restored successfully.');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account permanently.');
        }
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'name' => $user->name,
                'role' => $user->getRoleNames()->toArray()
            ])
            ->log('User permanently deleted');
        $user->forceDelete();
        
        return redirect()->route('users.archived')->with('success', 'User deleted permanently.');
    }

    public function editPassword($id)
    {
        $user = User::find($id);
        if($user->id == 1 && auth()->user()->id != 1){
            abort(403);
        }
        return view('users.set-password', compact('user'));
    }

    public function updatePassword(Request $request,$id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'password' => 'Your password has been changed.',
            ])
            ->log('User password updated');
        return redirect()->route('users.index')->with('success', 'Password has been updated successfully.');
    }

    public function allWithStatus()
    {
        $users = User::withTrashed()->paginate(10);
        return view('users.all_with_status', compact('users'));
    }
}
