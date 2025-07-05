<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index() {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:user,admin']);
        $user->update(['role' => $request->role]);
        return redirect()->route('admin.users.index')->with('success', 'Role updated.');
    }

    public function toggleBlock(User $user)
    {
        $user->update(['blocked' => !$user->blocked]);
        return redirect()->route('admin.users.index')->with('success', 'User status updated.');
    }
}
