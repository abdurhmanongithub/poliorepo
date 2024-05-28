<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $items = Role::paginate(10);
        return view('roles.index', compact('items'));
    }

    public function create()
    {
        $role = new Role();
        return view('roles.create', ['role' => $role]);
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        // Create role
        Role::create(['name' => $request->name]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        // Update role
        $role->update(['name' => $request->name]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }

    public function permissions(Request $request, Role $role)
    {
        $permissions = $role->permissions()->get();
        if ($request->ajax()) {
            return datatables()->of($permissions)->make(true);
        }
        // return redirect(route('roles.permissions.index',['role'=>$role->role]));
    }

    public function givePermission(Request $request, Role $role)
    {
        // if(!Auth::user()->can('role.permission.assign')){
        //     return abort(403);
        // }
        // foreach ($role->permissions()->get() as $permission) {
        //     $role->revokePermissionTo($permission);
        // }
        $request->validate(['permissions' => 'required']);
        $permissions = $request->get('permissions');
        foreach ($permissions as $permission) {
            $role->givePermissionTo(Permission::find($permission));
        }
        return redirect(route('roles.show', ['role' => $role->id]))->with('success', 'Permission Assigned successfully to the role');
    }

    public function revokePermission(Request $request, Role $role, Permission $permission)
    {
        // if(!Auth::user()->can('role.permission.assign')){
        //     return abort(403);
        // }
        if ($role->hasPermissionTo($permission->name)) {
            $role->revokePermissionTo($permission->name);
        }
        if ($request->ajax()) {
            return response()->json(array('msg' => 'revoked successfully'), 200);
        }
        return redirect(route('roles.show', ['role' => $role->id]))->with('success', 'Permission Revoked successfully to the role');
    }

    public function giveAllPermission(Role $role)
    {
        // if(!Auth::user()->can('role.permission.assign')){
        //     return abort(403);
        // }
        $role->syncPermissions(Permission::all());
        return redirect()->back()->with('success', 'all permission given');
    }
    public function removeAllPermission(Role $role)
    {
        // if(!Auth::user()->can('role.permission.assign')){
        //     return abort(403);
        // }
        foreach ($role->permissions()->get() as $permission) {
            $role->revokePermissionTo($permission);
        }
        return redirect()->back()->with('success', 'all permission removed');
    }
    public function show(Role $role)
    {
        $permissions = $role->permissions()->get();
        $freePermissions = DB::table('permissions')->whereNotIn('id', $role->permissions()->pluck('id'))->get();
        // dd($freePermissions);
        // dd($permissions);
        return view('roles.show', compact('role', 'permissions', 'freePermissions'));

    }
}
