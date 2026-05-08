<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            Log::error('Google OAuth redirect error: ' . $e->getMessage());
            return redirect()->route('login.show')
                ->with('error', 'Tidak dapat menghubungi Google. Periksa konfigurasi OAuth.');
        }
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::warning('Google OAuth invalid state, retrying stateless: ' . $e->getMessage());
            // Fallback ke stateless jika state tidak cocok (misal session hilang)
            try {
                $googleUser = Socialite::driver('google')->stateless()->user();
            } catch (\Exception $e2) {
                Log::error('Google OAuth stateless fallback failed: ' . $e2->getMessage());
                return redirect()->route('login.show')
                    ->with('error', 'Login Google gagal. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            Log::error('Google OAuth callback error: ' . $e->getMessage());
            return redirect()->route('login.show')
                ->with('error', 'Login Google gagal: ' . $e->getMessage());
        }

        try {
            // Cek apakah user sudah ada berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
                // Update google_id jika belum ada
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar'    => $googleUser->getAvatar(),
                    ]);
                }

                // Admin & super_admin tidak perlu approval
                $needsApproval = !in_array($user->role, ['admin', 'super_admin']);

                if ($needsApproval && $user->approval_status === 'pending') {
                    return redirect()->route('login.show')
                        ->with('pending', 'Akun kamu sedang menunggu persetujuan admin. Kami akan mengirim email setelah akun disetujui.');
                }

                if ($needsApproval && $user->approval_status === 'rejected') {
                    return redirect()->route('login.show')
                        ->with('error', 'Akun kamu telah ditolak oleh admin. Hubungi admin untuk informasi lebih lanjut.');
                }

                if ($needsApproval && $user->approval_status !== 'approved') {
                    return redirect()->route('login.show')
                        ->with('pending', 'Akun kamu sedang menunggu persetujuan admin.');
                }

                Auth::login($user, true);
                return redirect()->intended('/dashboard');
            }

            // Buat akun baru dari Google — status pending
            $newUser = User::create([
                'name'            => $googleUser->getName(),
                'email'           => $googleUser->getEmail(),
                'google_id'       => $googleUser->getId(),
                'avatar'          => $googleUser->getAvatar(),
                'password'        => bcrypt(\Illuminate\Support\Str::random(32)),
                'role'            => 'user',
                'approval_status' => 'pending',
            ]);

            Log::info('New Google user registered: ' . $newUser->email);

            return redirect()->route('login.show')
                ->with('pending', 'Akun kamu sedang menunggu persetujuan admin. Kami akan mengirim email notifikasi setelah akun disetujui.');

        } catch (\Exception $e) {
            Log::error('Error processing Google user: ' . $e->getMessage());
            return redirect()->route('login.show')
                ->with('error', 'Terjadi kesalahan saat memproses akun Google: ' . $e->getMessage());
        }
    }
}
