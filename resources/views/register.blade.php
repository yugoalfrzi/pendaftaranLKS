<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrasi LKS - Sistem Manajemen LKS</title>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- web icon -->
    <link rel="icon" href="{{ asset('assets/Apps/vendors/images/favicon.ico') }}" type="image/png">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #e8f0fe 0%, #d4e4fc 100%);
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(#a0c4e8 0.8px, transparent 0.8px);
            background-size: 32px 32px;
            opacity: 0.25;
            pointer-events: none;
            z-index: 0;
        }

        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
            z-index: 1;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.12);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 440px;
            width: 100%;
        }

        .register-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 24px 44px -12px rgba(0, 0, 0, 0.16);
        }

        .register-form-container {
            padding: 1.8rem 1.75rem 2rem;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.2rem;
        }

        .logo-img {
            width: 56px;
            height: 56px;
            border-radius: 1rem;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
            background: #ffffff;
            padding: 4px;
            transition: transform 0.2s;
        }

        .logo-img:hover {
            transform: scale(1.02);
        }

        h2 {
            font-size: 1.4rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.3rem;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: -0.02em;
        }

        .subtitle {
            text-align: center;
            color: #5b6e8c;
            font-size: 0.8rem;
            margin-bottom: 1.4rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.75rem;
            color: #1e293b;
            margin-bottom: 0.3rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .input-group {
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .input-group-text {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-right: none;
            color: #2563eb;
            font-size: 0.9rem;
            padding: 0.55rem 0.85rem;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-left: none;
            padding: 0.55rem 0.85rem;
            font-size: 0.85rem;
            background: #ffffff;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: none;
            background: #ffffff;
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            border-radius: 1rem;
        }

        .password-input-group {
            position: relative;
        }

        .password-input-group .form-control {
            border-right: none;
        }

        .password-toggle {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: 10;
            border: 1px solid #e2e8f0;
            border-left: none;
            background: #ffffff;
            padding: 0 1rem;
            border-radius: 0 1rem 1rem 0;
            transition: all 0.2s;
        }

        .password-toggle:hover {
            background: #f8fafc;
        }

        .password-toggle i {
            font-size: 1.1rem;
            color: #94a3b8;
        }

        .password-toggle:hover i {
            color: #2563eb;
        }

        .btn-register {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            border-radius: 2rem;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            font-size: 0.88rem;
            color: white;
            transition: all 0.2s;
            width: 100%;
            cursor: pointer;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
        }

        .btn-register:disabled {
            opacity: 0.7;
            transform: none;
        }

        .alert-custom {
            border: none;
            border-radius: 1rem;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            margin-bottom: 1.2rem;
        }

        .alert-custom.alert-danger {
            background: #fee2e2;
            color: #b91c1c;
            border-left: 4px solid #b91c1c;
        }

        .alert-custom.alert-success {
            background: #e6f7e6;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            margin-left: 0.5rem;
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.82rem;
            color: #5b6e8c;
        }

        .login-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s;
        }

        .login-link a:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-form-container {
                padding: 1.25rem;
            }
            .logo-img {
                width: 46px;
                height: 46px;
            }
            h2 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-form-container">
                <!-- Logo -->
                <div class="logo-container">
                    <img src="{{ asset('assets/Apps/vendors/images/logo jawa barat.png') }}"
                         alt="Logo Jawa Barat" class="logo-img">
                    <img src="{{ asset('assets/Apps/vendors/images/lks2.jpg') }}"
                         alt="Logo e-LKS Jawa Barat" class="logo-img">
                </div>

                <h2>Registrasi LKS</h2>
                <p class="subtitle">Daftarkan Lembaga Kesejahteraan Sosial Anda</p>

                <!-- Alert placeholder -->
                <div id="registerAlert" class="alert-custom d-none" role="alert"></div>

                @if(session('pending'))
                <div class="alert-custom mb-3" style="background:#fff8e1;color:#856404;border-left:4px solid #ffc107;border-radius:1rem;padding:0.75rem 1rem;font-size:0.85rem;">
                    <i class="bi bi-clock-history me-2"></i>{{ session('pending') }}
                </div>
                @endif

                <form id="registerForm" action="{{ route('register') }}" method="POST">
                    @csrf

                    @if($errors->any())
                    <div class="alert-custom alert-danger mb-3">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Data Pengguna -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama LKS</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ old('name') }}" placeholder="Nama LKS Anda" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ old('email') }}" placeholder="nama@contoh.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="kabupaten_kota" class="form-label">Kabupaten / Kota</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <select class="form-control" id="kabupaten_kota" name="kabupaten_kota" required
                                    style="border-left: none;">
                                <option value="" disabled {{ old('kabupaten_kota') ? '' : 'selected' }}>-- Pilih Kabupaten/Kota --</option>
                                @php
                                $kabupatenKota = [
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
                                @endphp
                                @foreach($kabupatenKota as $kk)
                                    <option value="{{ $kk }}" {{ old('kabupaten_kota') === $kk ? 'selected' : '' }}>
                                        {{ $kk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="input-group password-input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Minimal 8 karakter" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <div class="input-group password-input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                   placeholder="Ulangi kata sandi" required>
                            <button type="button" class="password-toggle" id="togglePasswordConfirm">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn-register" id="registerButton">
                            <span id="registerText">Daftar</span>
                            <span id="registerSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </form>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>

                <!-- Divider -->
                <div class="d-flex align-items-center my-3">
                    <hr class="flex-1"><span class="px-2 text-muted small">atau</span><hr class="flex-1">
                </div>

                <!-- Google Register -->
                <a href="{{ route('auth.google') }}" class="btn w-100 d-flex align-items-center justify-content-center gap-2"
                   style="border:1.5px solid #e2e8f0;border-radius:2rem;padding:0.65rem 1rem;font-size:0.9rem;font-weight:600;color:#1e293b;background:#fff;transition:all 0.2s;"
                   onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                    <svg width="20" height="20" viewBox="0 0 48 48">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.36-8.16 2.36-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                        <path fill="none" d="M0 0h48v48H0z"/>
                    </svg>
                    Daftar dengan Google
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const registerForm  = document.getElementById('registerForm');
            const registerAlert = document.getElementById('registerAlert');
            const registerBtn   = document.getElementById('registerButton');
            const registerText  = document.getElementById('registerText');
            const registerSpinner = document.getElementById('registerSpinner');

            // Password toggle
            function setupToggle(toggleId, inputId) {
                const toggle = document.getElementById(toggleId);
                const input  = document.getElementById(inputId);
                if (!toggle || !input) return;
                toggle.addEventListener('click', function() {
                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    const icon = this.querySelector('i');
                    icon.classList.toggle('bi-eye', !isPassword);
                    icon.classList.toggle('bi-eye-slash', isPassword);
                });
            }
            setupToggle('togglePassword', 'password');
            setupToggle('togglePasswordConfirm', 'password_confirmation');

            // Form submit via AJAX
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();

                registerBtn.disabled = true;
                registerText.textContent = 'Mendaftar...';
                registerSpinner.classList.remove('d-none');

                fetch(registerForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                    body: new URLSearchParams(new FormData(registerForm)),
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success && data.status === 'pending') {
                        // Tampilkan pesan pending — jangan redirect
                        registerForm.style.display = 'none';
                        registerAlert.innerHTML = `<i class="bi bi-clock-history me-2"></i>${data.message}`;
                        registerAlert.className = 'alert-custom mb-3';
                        registerAlert.style.cssText = 'background:#fff8e1;color:#856404;border-left:4px solid #ffc107;border-radius:1rem;padding:1rem;font-size:0.9rem;';
                        registerAlert.classList.remove('d-none');
                    } else if (!data.success) {
                        registerAlert.innerHTML = `<i class="bi bi-exclamation-circle me-2"></i>${data.message || 'Terjadi kesalahan.'}`;
                        registerAlert.className = 'alert-custom alert-danger';
                        registerAlert.classList.remove('d-none');
                        registerBtn.disabled = false;
                        registerText.textContent = 'Daftar';
                        registerSpinner.classList.add('d-none');
                    }
                })
                .catch(() => {
                    registerAlert.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>Terjadi kesalahan. Silakan coba lagi.';
                    registerAlert.className = 'alert-custom alert-danger';
                    registerAlert.classList.remove('d-none');
                    registerBtn.disabled = false;
                    registerText.textContent = 'Daftar';
                    registerSpinner.classList.add('d-none');
                });
            });
        });
    </script>
</body>
</html>
