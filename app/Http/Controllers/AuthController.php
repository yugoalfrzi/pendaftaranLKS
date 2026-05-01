<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Cek user dulu sebelum attempt
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Admin & super_admin tidak perlu approval
            $needsApproval = !in_array($user->role, ['admin', 'super_admin']);

            if ($needsApproval && $user->approval_status === 'pending') {
                $msg = 'Akun kamu sedang menunggu persetujuan admin.';
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $msg, 'status' => 'pending'], 403);
                }
                return back()->with('pending', $msg)->onlyInput('email');
            }

            if ($needsApproval && $user->approval_status === 'rejected') {
                $msg = 'Akun kamu telah ditolak oleh admin. Hubungi admin untuk informasi lebih lanjut.';
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $msg], 403);
                }
                return back()->withErrors(['email' => $msg])->onlyInput('email');
            }
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'  => true,
                    'redirect' => route('dashboard'),
                    'is_admin' => in_array($user->role, ['admin', 'super_admin']),
                    'role'     => $user->role ?? 'user',
                    'message'  => 'Login berhasil',
                ]);
            }

            return redirect()->intended('/dashboard')->with('alert', 'Login berhasil');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Email atau password salah'], 422);
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->onlyInput('email');
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
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:8|confirmed',
            'kabupaten_kota'  => 'required|string|max:100',
        ], [
            'name.required'           => 'Nama lengkap wajib diisi',
            'email.required'          => 'Email wajib diisi',
            'email.email'             => 'Format email tidak valid',
            'email.unique'            => 'Email sudah terdaftar',
            'password.required'       => 'Password wajib diisi',
            'password.min'            => 'Password minimal 8 karakter',
            'password.confirmed'      => 'Konfirmasi password tidak cocok',
            'kabupaten_kota.required' => 'Kabupaten/Kota wajib dipilih',
        ]);

        try {
            User::create([
                'name'            => $request->name,
                'email'           => $request->email,
                'password'        => bcrypt($request->password),
                'role'            => 'user',
                'kabupaten_kota'  => $request->kabupaten_kota,
                'approval_status' => 'pending',
            ]);

            $msg = 'Akun kamu sedang menunggu persetujuan admin.';

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'status' => 'pending', 'message' => $msg]);
            }

            return redirect()->route('login.show')->with('pending', $msg);

        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat registrasi.'], 500);
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])->withInput();
        }
    }

    // ===== SUPER ADMIN: Approve / Reject user =====

    public function approveUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['approval_status' => 'approved', 'rejection_reason' => null]);

        try {
            $user->notify(new \App\Notifications\UserApprovedNotification());
        } catch (\Exception $e) {
            Log::error('Email approve gagal: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', "Akun {$user->name} berhasil disetujui dan notifikasi email telah dikirim.");
    }

    public function rejectUser(Request $request, $id)
    {
        $request->validate(['reason' => 'nullable|string|max:500']);

        $user = User::findOrFail($id);
        $user->update([
            'approval_status'  => 'rejected',
            'rejection_reason' => $request->reason,
        ]);

        try {
            $user->notify(new \App\Notifications\UserRejectedNotification($request->reason ?? ''));
        } catch (\Exception $e) {
            Log::error('Email reject gagal: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', "Akun {$user->name} telah ditolak dan notifikasi email telah dikirim.");
    }
}
