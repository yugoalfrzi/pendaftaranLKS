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

            // Cek akun dinonaktifkan
            if (!$user->is_active) {
                $msg = 'Akun kamu telah dinonaktifkan. Hubungi admin untuk informasi lebih lanjut.';
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

    public function manageAccounts(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');
        $role   = $request->get('role', 'all');

        $query = User::where('role', '!=', 'super_admin')
            ->where('approval_status', 'approved');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('kabupaten_kota', 'like', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'    => User::where('role', '!=', 'super_admin')->where('approval_status', 'approved')->count(),
            'active'   => User::where('role', '!=', 'super_admin')->where('approval_status', 'approved')->where('is_active', true)->count(),
            'inactive' => User::where('role', '!=', 'super_admin')->where('approval_status', 'approved')->where('is_active', false)->count(),
        ];

        return view('superadmin.manage-accounts', compact('users', 'stats'));
    }

    public function toggleActive(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Jangan bisa nonaktifkan super_admin
        if ($user->role === 'super_admin') {
            return redirect()->back()->with('error', 'Tidak dapat mengubah status akun Super Admin.');
        }

        $user->update(['is_active' => !$user->is_active]);

        // Jika dinonaktifkan, logout semua session user tersebut
        if (!$user->is_active) {
            // Hapus semua session user ini dari database
            \DB::table('sessions')->where('user_id', $user->id)->delete();
        }

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }

    public function approveUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['approval_status' => 'approved', 'rejection_reason' => null]);

        $mailer = config('mail.default');
        $nonInboxMailers = ['log', 'array'];

        try {
            $user->notify(new \App\Notifications\UserApprovedNotification());
        } catch (\Exception $e) {
            Log::error('Email approve gagal: ' . $e->getMessage());
            return redirect()->back()->with(
                'success',
                "Akun {$user->name} berhasil disetujui. Email notifikasi gagal dikirim: periksa MAIL_* di server (SMTP/Resend/Postmark, dll.)."
            );
        }

        $msg = "Akun {$user->name} berhasil disetujui.";
        if (in_array($mailer, $nonInboxMailers, true)) {
            $msg .= " Email tidak sampai ke Gmail karena MAIL_MAILER={$mailer} (hanya ke log/array). Di Railway, set MAIL_MAILER=smtp (atau resend/postmark) beserta kredensial dan MAIL_FROM_ADDRESS.";
        } else {
            $msg .= ' Notifikasi email telah dikirim.';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function rejectUser(Request $request, $id)
    {
        $request->validate(['reason' => 'nullable|string|max:500']);

        $user = User::findOrFail($id);
        $user->update([
            'approval_status'  => 'rejected',
            'rejection_reason' => $request->reason,
        ]);

        $mailer = config('mail.default');
        $nonInboxMailers = ['log', 'array'];

        try {
            $user->notify(new \App\Notifications\UserRejectedNotification($request->reason ?? ''));
        } catch (\Exception $e) {
            Log::error('Email reject gagal: ' . $e->getMessage());
            return redirect()->back()->with(
                'success',
                "Akun {$user->name} telah ditolak. Email notifikasi gagal dikirim: periksa konfigurasi mail di server."
            );
        }

        $msg = "Akun {$user->name} telah ditolak.";
        if (in_array($mailer, $nonInboxMailers, true)) {
            $msg .= " Email tidak sampai ke inbox karena MAIL_MAILER={$mailer}. Atur pengirim email nyata di Railway (MAIL_MAILER + kredensial).";
        } else {
            $msg .= ' Notifikasi email telah dikirim.';
        }

        return redirect()->back()->with('success', $msg);
    }
}