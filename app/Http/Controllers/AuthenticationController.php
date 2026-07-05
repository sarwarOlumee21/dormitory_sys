<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);

        $loginValue = $request->input('login', $request->input('email'));

        $emailCredentials = [
            'email' => $loginValue,
            'password' => $request->password,
        ];

        $usernameCredentials = [
            'username' => $loginValue,
            'password' => $request->password,
        ];

        if (auth()->attempt($emailCredentials) || auth()->attempt($usernameCredentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'You are logged in successfully.');
        }

        return back()->withErrors([
            'login' => 'ایمیل، نام کاربری یا رمز عبور اشتباه است.',
        ])->onlyInput('login');
    }
}
