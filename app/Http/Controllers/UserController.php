<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $items = User::paginate(10);
        return view('users.index', compact('items'));
    }

    public function create()
    {
        $roles = Role::all();
        $user = new User();

        return view('users.create', compact('roles', 'user'));
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'roles' => 'required|array',
            'phone' => [
                'required',
                'regex:/^09[0-9]{8}$/'
            ],
        ]);
        // Create user
        $pass = 12345678;
        $user = User::create(array_merge($request->only('full_name', 'email', 'phone'), ['password' => Hash::make($pass)]));

        // Assign roles
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'roles' => 'required|array',
        ]);

        // Update user
        $user->update($request->only('name', 'email', 'password'));

        // Sync roles
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
