<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect by role
            if ($user->role === 'admin') {
                return redirect()->route('dashboard.admin');
            } elseif ($user->role === 'vendor') {
                return redirect()->route('dashboard.vendor');
            } else {
                return redirect()->route('dashboard.customer');
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials. Please try again.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
