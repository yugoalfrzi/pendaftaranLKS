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
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 560px;
            width: 100%;
        }

        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 50px -15px rgba(0, 0, 0, 0.2);
        }

        .register-form-container {
            padding: 2.2rem 2rem 2.5rem 2rem;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            gap: 1.2rem;
            margin-bottom: 1.8rem;
        }

        .logo-img {
            width: 70px;
            height: 70px;
            border-radius: 1.5rem;
            object-fit: cover;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            background: #ffffff;
            padding: 6px;
            transition: transform 0.2s;
        }

        .logo-img:hover {
            transform: scale(1.02);
        }

        h2 {
            font-size: 1.7rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: -0.02em;
        }

        .subtitle {
            text-align: center;
            color: #5b6e8c;
            font-size: 0.85rem;
            margin-bottom: 1.8rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            color: #1e293b;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .input-group {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .input-group-text {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-right: none;
            color: #2563eb;
            font-size: 1rem;
            padding: 0.7rem 1rem;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-left: none;
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
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
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
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
            margin-top: 1.5rem;
            font-size: 0.85rem;
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
                padding: 1.5rem;
            }
            .logo-img {
                width: 60px;
                height: 60px;
            }
            h2 {
                font-size: 1.4rem;
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

                <form id="registerForm" action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Data Pengguna -->

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="nama@contoh.com" required>
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

                    <!-- Data LKS -->
                    <hr class="my-4">

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
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const registerForm = document.getElementById('registerForm');
            const registerAlert = document.getElementById('registerAlert');
            const registerButton = document.getElementById('registerButton');
            const registerText = document.getElementById('registerText');
            const registerSpinner = document.getElementById('registerSpinner');

            // ===== PASSWORD TOGGLE FUNCTIONALITY =====
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const passwordConfirmInput = document.getElementById('password_confirmation');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    const icon = this.querySelector('i');
                    if (type === 'password') {
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    } else {
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    }
                });
            }

            if (togglePasswordConfirm && passwordConfirmInput) {
                togglePasswordConfirm.addEventListener('click', function() {
                    const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordConfirmInput.setAttribute('type', type);

                    const icon = this.querySelector('i');
                    if (type === 'password') {
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    } else {
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    }
                });
            }

            // ===== REGISTER FORM HANDLING =====
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const password = document.getElementById('password').value;
                const passwordConfirm = document.getElementById('password_confirmation').value;

                if (password !== passwordConfirm) {
                    showAlert('Konfirmasi password tidak cocok!', 'danger');
                    return;
                }

                if (password.length < 8) {
                    showAlert('Password minimal 8 karakter!', 'danger');
                    return;
                }

                // Loading state
                registerButton.disabled = true;
                registerText.textContent = 'Memproses...';
                registerSpinner.classList.remove('d-none');

                fetch(registerForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: new URLSearchParams(new FormData(registerForm))
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        throw data;
                    }
                    return data;
                })
                .then(data => {
                    if (data.success) {
                        showAlert('Registrasi berhasil! Mengalihkan...', 'success');
                        setTimeout(() => {
                            window.location.href = data.redirect || '/dashboard';
                        }, 1500);
                    } else {
                        showAlert(data.message || 'Registrasi gagal!', 'danger');
                        registerButton.disabled = false;
                        registerText.textContent = 'Daftar';
                        registerSpinner.classList.add('d-none');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

                    if (error.errors) {
                        const firstError = Object.values(error.errors)[0];
                        errorMessage = Array.isArray(firstError) ? firstError[0] : firstError;
                    } else if (error.message) {
                        errorMessage = error.message;
                    }

                    showAlert(errorMessage, 'danger');
                    registerButton.disabled = false;
                    registerText.textContent = 'Daftar';
                    registerSpinner.classList.add('d-none');
                });
            });

            function showAlert(message, type) {
                registerAlert.textContent = message;
                registerAlert.className = `alert-custom alert-${type}`;
                registerAlert.classList.remove('d-none');

                setTimeout(() => {
                    registerAlert.classList.add('d-none');
                }, 5000);
            }
        });
    </script>
</body>
</html>
