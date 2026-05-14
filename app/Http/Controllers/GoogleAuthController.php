<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    protected $kabupatenKota = [
        'Kabupaten Bandung', 'Kabupaten Bandung Barat', 'Kabupaten Bekasi',
        'Kabupaten Bogor', 'Kabupaten Ciamis', 'Kabupaten Cianjur',
        'Kabupaten Cirebon', 'Kabupaten Garut', 'Kabupaten Indramayu',
        'Kabupaten Karawang', 'Kabupaten Kuningan', 'Kabupaten Majalengka',
        'Kabupaten Pangandaran', 'Kabupaten Purwakarta', 'Kabupaten Subang',
        'Kabupaten Sukabumi', 'Kabupaten Sumedang', 'Kabupaten Tasikmalaya',
        'Kota Bandung', 'Kota Banjar', 'Kota Bekasi', 'Kota Bogor',
        'Kota Cimahi', 'Kota Cirebon', 'Kota Depok', 'Kota Sukabumi',
        'Kota Tasikmalaya',
    ];

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
            // Cek apakah user sudah ada
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
                        ->with('pending', 'Akun kamu sedang menunggu persetujuan admin.');
                }

                if ($needsApproval && $user->approval_status === 'rejected') {
                    return redirect()->route('login.show')
                        ->with('error', 'Akun kamu telah ditolak oleh admin.');
                }

                if ($needsApproval && $user->approval_status !== 'approved') {
                    return redirect()->route('login.show')
                        ->with('pending', 'Akun kamu sedang menunggu persetujuan admin.');
                }

                // Cek is_active
                if (!$user->is_active) {
                    return redirect()->route('login.show')
                        ->withErrors(['email' => 'Akun kamu telah dinonaktifkan. Hubungi admin.']);
                }

                Auth::login($user, true);
                return redirect()->intended('/dashboard');
            }

            // User baru — simpan data Google ke session, minta pilih kabupaten
            session([
                'google_register' => [
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                ]
            ]);

            return redirect()->route('auth.google.complete');

        } catch (\Exception $e) {
            Log::error('Error processing Google user: ' . $e->getMessage());
            return redirect()->route('login.show')
                ->with('error', 'Terjadi kesalahan saat memproses akun Google: ' . $e->getMessage());
        }
    }

    public function showCompleteForm()
    {
        // Pastikan ada data Google di session
        if (!session('google_register')) {
            return redirect()->route('login.show')
                ->with('error', 'Sesi Google tidak ditemukan. Silakan coba lagi.');
        }

        $googleData    = session('google_register');
        $kabupatenKota = $this->kabupatenKota;

        return view('auth.google-complete', compact('googleData', 'kabupatenKota'));
    }

    public function completeRegistration(Request $request)
    {
        if (!session('google_register')) {
            return redirect()->route('login.show')
                ->with('error', 'Sesi Google tidak ditemukan. Silakan coba lagi.');
        }

        $request->validate([
            'kabupaten_kota' => 'required|string|in:' . implode(',', $this->kabupatenKota),
        ], [
            'kabupaten_kota.required' => 'Kabupaten/Kota wajib dipilih.',
            'kabupaten_kota.in'       => 'Pilihan Kabupaten/Kota tidak valid.',
        ]);

        $googleData = session('google_register');

        // Cek lagi apakah email sudah terdaftar (race condition)
        $existing = User::where('email', $googleData['email'])->first();
        if ($existing) {
            session()->forget('google_register');
            return redirect()->route('login.show')
                ->with('error', 'Email sudah terdaftar. Silakan login.');
        }

        try {
            $newUser = User::create([
                'name'            => $googleData['name'],
                'email'           => $googleData['email'],
                'google_id'       => $googleData['google_id'],
                'avatar'          => $googleData['avatar'],
                'password'        => bcrypt(\Illuminate\Support\Str::random(32)),
                'role'            => 'user',
                'kabupaten_kota'  => $request->kabupaten_kota,
                'approval_status' => 'pending',
            ]);

            session()->forget('google_register');

            Log::info('New Google user registered: ' . $newUser->email . ' - ' . $request->kabupaten_kota);

            return redirect()->route('login.show')
                ->with('pending', 'Akun kamu sedang menunggu persetujuan admin. Kami akan mengirim email notifikasi setelah akun disetujui.');

        } catch (\Exception $e) {
            Log::error('Error completing Google registration: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
