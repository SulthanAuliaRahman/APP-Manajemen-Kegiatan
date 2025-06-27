<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function manageUser()
    {
        $users = User::paginate(5);
        return view('manageUser', compact('users'));
    }

    public function buatUser()
    {
        return view('manageUser'); // Reuse manageUser view for the create button
    }

    public function getUser($userId)
    {
        $user = User::find($userId);
        return response()->json($user);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:mahasiswa,dosen,himpunan,admin'
        ]);

        User::create([
            'user_id' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return response()->json(['success' => true, 'message' => 'User created successfully']);
    }

    public function updateUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId . ',user_id',
            'role' => 'required|in:mahasiswa,dosen,himpunan,admin'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password
        ]);

        return response()->json(['success' => true, 'message' => 'User updated successfully']);
    }

    public function approveKegiatan()
    {
        return redirect()->route('manageApprovals')->with('success', 'Redirected to manage approvals.');
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }
}
