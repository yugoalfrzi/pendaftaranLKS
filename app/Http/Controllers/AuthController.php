<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $isAdmin = false;
            if ($user) {
                if (property_exists($user, 'is_admin')) {
                    $isAdmin = (bool) $user->is_admin;
                } elseif (isset($user->role)) {
                    $isAdmin = ($user->role === 'admin');
                }
            }

            // If request is AJAX/JSON, return JSON including role info
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('dashboard'),
                    'is_admin' => $isAdmin,
                    'message' => 'Login berhasil'
                ]);
            }

            // standard redirect (include a flash alert)
            return redirect()->intended('/dashboard')->with('alert', 'Login berhasil');
        }

        // Invalid credentials - respond appropriately for AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 422);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('alert', 'Anda telah logout');
    }
}
