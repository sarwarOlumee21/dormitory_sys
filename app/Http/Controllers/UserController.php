<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function userRegister()
    {
        return view('users.userRegister');
    }
    public function userStore(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:admin,manager,staff,user',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'number' => 'required|string|max:255',
            ]);
        $user = User::create([
            'code' => $validatedData['code'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'number' => $validatedData['number'],
        ]);
        if (!$user) {
            return redirect()->back()->with('error', 'Failed to register user. Please try again.');
        }

        return redirect()->route('users.userRegister')->with('success', 'User registered successfully.');
    }

    public function userList()
    {
        $users = User::all();
        return view('users.userList', compact('users'));
    }
    public function userEdit($id)
    {
        $user = User::findOrFail($id);
        return view('users.userEdit', compact('user'));
    }
    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'code' => 'required|string|max:255|unique:users,code,' . $user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,manager,staff',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'number' => 'required|string|max:255',
        ]);
        $user->update([
            'code' => $validatedData['code'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'username' => $validatedData['username'],
            'password' => isset($validatedData['password']) ? Hash::make($validatedData['password']) : $user->password,
            'number' => $validatedData['number'],
        ]);
        return redirect()->route('users.userList')->with('success', 'User updated successfully.');
    }
}
