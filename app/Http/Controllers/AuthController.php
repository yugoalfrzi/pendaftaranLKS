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
            if ($user && isset($user->role)) {
                // admin or super_admin are considered as admin
                $isAdmin = in_array($user->role, ['admin', 'super_admin']);
            }

            // If request is AJAX/JSON, return JSON including role info
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('dashboard'),
                    'is_admin' => $isAdmin,
                    'role' => $user->role ?? 'user',
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

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'nama_lks' => 'required|string|max:255',
            'alamat_lks' => 'required|string',
            'nomor_kontak' => 'required|string|max:20',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'nama_lks.required' => 'Nama LKS wajib diisi',
            'alamat_lks.required' => 'Alamat LKS wajib diisi',
            'nomor_kontak.required' => 'Nomor kontak wajib diisi',
        ]);

        try {
            \DB::beginTransaction();

            // Create user with role 'user' (LKS)
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'user',
            ]);

            // Create LKS record with all required fields
            \App\Models\lks::create([
                'user_id' => $user->id,
                'nama_lks' => $request->nama_lks,
                'alamat_lks' => $request->alamat_lks,
                'nomor_kontak' => $request->nomor_kontak,
                'tanda_pendaftaran' => 'Baru',
                'tanggal_masuk_dokumen' => now(),
                'tanggal_persyaratan' => now(),
                'status_permohonan' => 'Menunggu',
                'pendaftaran_lengkap' => false,
            ]);

            \DB::commit();

            // Return JSON response for AJAX - redirect to login
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('login.show'),
                    'message' => 'Registrasi berhasil! Silakan login dengan akun Anda.'
                ], 200);
            }

            return redirect()->route('login.show')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Registration error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return JSON error for AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat registrasi: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'
            ])->withInput();
        }
    }
}
