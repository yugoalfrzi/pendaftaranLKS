<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen LKS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- web icon -->
    <link rel="icon" href="{{ asset('assets/Apps/vendors/images/favicon.ico') }}" type="image/png">

    <style>
        body {
            min-height: 100px;
            background-color: #f0f4ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            height: 100vh;
        }
        .login-right {
            background-color: rgba(255,255,255,0.93);
            padding: 3.5rem 2.5rem 3rem 2.5rem;
            border-radius: 1.2rem;
            box-shadow: 0 8px 32px 0 rgba(80,110,225,0.18), 0 1.5px 6px rgba(32,40,150,.06);
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: fadeInCard 0.7s cubic-bezier(.77,0,.175,1) 0s;
        }
        @keyframes fadeInCard {
            from { opacity: 0; transform: translateY(40px); }
            to   { opacity: 1; transform: translateY(0);    }
        }
        .login-form-container {
            max-width: 410px;
            margin: 0 auto;
            width: 100%;
        }
        .form-control:focus {
            border-color: #2453a7;
            box-shadow: 0 0 0 0.21rem rgba(36, 83, 167, 0.18);
        }
        .btn-primary {
            background: linear-gradient(90deg, #2468fa 0%, #3fc1fd 100%);
            border: none;
            font-weight: 600;
            letter-spacing: 0.03em;
            font-size: 1.13rem;
            transition: box-shadow .2s,transform .1s,background .2s;
            box-shadow: 0 4px 8px 0 rgba(36,104,250,0.06);
        }
        .btn-primary:hover,
        .btn-primary:focus {
            background: linear-gradient(90deg, #3574f1 0%, #38b7f2 100%);
            transform: translateY(-1px) scale(1.03);
            box-shadow: 0 6px 14px 0 rgba(36,104,250,0.13);
        }
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 26px;
            gap: 16px;
        }
        .logo-jabar {
            width: 90px;
            min-width: 70px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 14px 0 rgba(0,0,0,.13);
            border: 4px solid #f8faff;
            background: #fff;
        }
        .logo-lks {
            width: 90px;
            min-width: 70px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 14px 0 rgba(0,0,0,.13);
            border: 4px solid #f8faff;
            background: #fff;
        }
        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 22px;
            font-size: 0.98rem;
        }
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
        h2 {
            font-size: 2.1rem;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-align: center;
            margin-bottom: 10px;
            color: #123870;
            text-shadow: 0 2px 8px rgba(70,130,220,.06);
        }
        .text-muted {
            text-align: center;
            margin-bottom: 30px;
            color: #4c6282!important;
        }
        .form-label {
            font-weight: 500;
            font-size: 1.01rem;
            color: #153968;
            letter-spacing: 0.1px;
        }
        .input-group-text {
            background: #e8f0fe;
            border: none;
            color: #2453a7;
            font-size: 1.07rem;
        }
        .input-group {
            box-shadow: 0 1.5px 6px rgba(150,180,251,.04);
            border-radius: 7px;
            margin-bottom: 4px;
        }
        .form-check-label {
            color: #405176;
            font-size: .98rem;
        }
        .form-control {
            background: #f9fbfe;
            border-radius: 7px;
        }
        .form-control:disabled, .form-control[readonly] {
            background: #e9ecef;
        }
        .d-grid {
            margin-top: 12px;
        }
        .btn-lg {
            padding-top: .7rem;
            padding-bottom: .7rem;
            font-size: 1.09rem;
        }
        .text-center > a {
            color: #346eec;
            font-weight: 500;
            transition: color .2s;
        }
        .text-center > a:hover {
            color: #1947ae;
            text-decoration: underline;
        }
        .password-input-group {
            position: relative;
        }

        .password-input-group .form-control {
            padding-right: 50px;
            border-radius: 7px;
        }

        .password-input-group .password-toggle {
            position: absolute;
            right: 2px;
            top: 2px;
            bottom: 2px;
            z-index: 5;
            border: none;
            background: transparent;
            padding: 0 12px;
            border-radius: 0 7px 7px 0;
            transition: all 0.2s ease;
        }

        .password-input-group .password-toggle:hover {
            background-color: #e9ecef;
        }

        .password-input-group .password-toggle:focus {
            box-shadow: none;
            background-color: #dee2e6;
        }

        .password-input-group .password-toggle i {
            font-size: 1.1rem;
            color: #6c757d;
            transition: color 0.2s ease;
        }

        .password-input-group .password-toggle:hover i {
            color: #495057;
        }

        /* Ensure the input group maintains its style */
        .input-group {
            box-shadow: 0 1.5px 6px rgba(150,180,251,.04);
            border-radius: 7px;
            margin-bottom: 4px;
        }

        /* Fix for focus state */
        .password-input-group:focus-within .form-control {
            border-color: #2453a7;
            box-shadow: 0 0 0 0.21rem rgba(36, 83, 167, 0.18);
        }
    </style>
</head>
<body>
    <div class="container-fluid login-container">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 login-right">
                <div class="login-form-container">
                    <div class="logo-container">
                        <img src="{{ asset('assets/Apps/vendors/images/logo jawa barat.png') }}" 
                        alt="Logo Jawa Barat" class="logo-jabar">
                        <img src="{{ asset('assets/Apps/vendors/images/lks2.jpg') }}" alt="Logo e-LKS Jawa Barat" class="logo-lks">
                    </div>
                    <h2>Masuk ke Akun Anda</h2>
                    <p class="text-muted">Silakan masukkan kredensial Anda untuk melanjutkan</p>
                    
                    <!-- Alert placeholder untuk pesan error -->
                    <div id="loginAlert" class="alert alert-danger d-none" role="alert"></div>
                    
                    <form id="loginForm" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="nama@contoh.com" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <div class="input-group password-input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata sandi" required>
                                <button type="button" class="btn btn-outline-secondary password-toggle" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                            <label class="form-check-label" for="rememberMe">Ingat saya</label>
                        </div>
                        
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-lg" id="loginButton">
                                <span id="loginText">Masuk</span>
                                <span id="loginSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const loginAlert = document.getElementById('loginAlert');
            const loginButton = document.getElementById('loginButton');
            const loginText = document.getElementById('loginText');
            const loginSpinner = document.getElementById('loginSpinner');

            // ===== PASSWORD TOGGLE FUNCTIONALITY =====
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    // Toggle the type attribute
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle the icon
                    const icon = this.querySelector('i');
                    if (type === 'password') {
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                        this.setAttribute('aria-label', 'Tampilkan kata sandi');
                    } else {
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                        this.setAttribute('aria-label', 'Sembunyikan kata sandi');
                    }
                });

                // Optional: Add keyboard support
                togglePassword.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            }

            // ===== LOGIN FORM HANDLING (existing code) =====
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Ambil nilai dari form
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const rememberMe = document.getElementById('rememberMe').checked;

                // Validasi sederhana
                if (!email || !password) {
                    showAlert('Email dan kata sandi harus diisi!', 'danger');
                    return;
                }

                // Tampilkan loading state
                loginButton.disabled = true;
                loginText.textContent = 'Memproses...';
                loginSpinner.classList.remove('d-none');

                // Kirim data login ke server
                fetch(loginForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: new URLSearchParams(new FormData(loginForm))
                })
                .then(async response => {
                    if (response.status === 419) {
                        showAlert('Sesi kedaluwarsa atau CSRF token tidak valid. Muat ulang halaman dan coba lagi.', 'danger');
                        loginButton.disabled = false;
                        loginText.textContent = 'Masuk';
                        loginSpinner.classList.add('d-none');
                        throw new Error('CSRF token mismatch');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showAlert('Login berhasil!', 'success');

                        // Redirect ke dashboard setelah 2 detik
                        setTimeout(() => {
                            window.location.href = data.redirect || '/dashboard.dashboard';
                        }, 2000);
                    } else {
                        showAlert(data.message || 'Email atau kata sandi salah!', 'danger');
                        loginButton.disabled = false;
                        loginText.textContent = 'Masuk';
                        loginSpinner.classList.add('d-none');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan. Silakan coba lagi.', 'danger');
                    loginButton.disabled = false;
                    loginText.textContent = 'Masuk';
                    loginSpinner.classList.add('d-none');
                });
            });

            function showAlert(message, type) {
                loginAlert.textContent = message;
                loginAlert.className = `alert alert-${type}`;
                loginAlert.classList.remove('d-none');

                // Sembunyikan alert setelah 5 detik
                setTimeout(() => {
                    loginAlert.classList.add('d-none');
                }, 5000);
            }
        });
    </script>
</body>
</html>