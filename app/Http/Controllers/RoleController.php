<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $items = Role::paginate(100);
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
}
