<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Pendaftaran - SI LASKAR</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('assets/Apps/vendors/images/silaskar.jpeg') }}" type="image/jpeg">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e8f0fe 0%, #d4e4fc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(#a0c4e8 0.8px, transparent 0.8px);
            background-size: 32px 32px;
            opacity: 0.25;
            pointer-events: none;
        }
        .card {
            background: rgba(255,255,255,0.95);
            border-radius: 1.5rem;
            border: none;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.12);
            max-width: 440px;
            width: 100%;
            position: relative;
            z-index: 1;
        }
        .card-body { padding: 2rem; }
        .logo-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.2rem;
        }
        .logo-img {
            width: 52px; height: 52px;
            border-radius: 1rem;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0,0,0,0.07);
            padding: 4px;
            background: #fff;
        }
        h2 {
            font-size: 1.35rem;
            font-weight: 700;
            text-align: center;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin-bottom: 0.3rem;
        }
        .subtitle { text-align: center; color: #5b6e8c; font-size: 0.82rem; margin-bottom: 1.5rem; }
        .google-info {
            background: #f8fafc;
            border-radius: 1rem;
            padding: 0.85rem 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: 1px solid #e2e8f0;
        }
        .google-avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .google-avatar-placeholder {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: #2563eb;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }
        .form-label {
            font-weight: 600;
            font-size: 0.75rem;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.6rem 0.85rem;
            font-size: 0.85rem;
        }
        .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }
        .btn-complete {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            border-radius: 2rem;
            padding: 0.65rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: white;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-complete:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37,99,235,0.25);
        }
        .back-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.82rem;
            color: #5b6e8c;
        }
        .back-link a { color: #2563eb; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-body">
            {{-- Logo --}}
            <div class="logo-container">
                <img src="{{ asset('assets/Apps/vendors/images/logo jawa barat.png') }}" alt="Logo Jabar" class="logo-img">
                <img src="{{ asset('assets/Apps/vendors/images/silaskar.jpeg') }}" alt="SI LASKAR" class="logo-img">
            </div>

            <h2>Lengkapi Pendaftaran</h2>
            <p class="subtitle">Satu langkah lagi untuk menyelesaikan pendaftaran</p>

            @if(session('error'))
            <div class="alert alert-danger rounded-3 py-2 px-3 mb-3" style="font-size:0.85rem">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger rounded-3 py-2 px-3 mb-3" style="font-size:0.85rem">
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Info akun Google --}}
            <div class="google-info">
                @if($googleData['avatar'])
                    <img src="{{ $googleData['avatar'] }}" alt="Avatar" class="google-avatar">
                @else
                    <div class="google-avatar-placeholder">
                        {{ strtoupper(substr($googleData['name'], 0, 1)) }}
                    </div>
                @endif
                <div>
                    <div class="fw-semibold" style="font-size:0.9rem">{{ $googleData['name'] }}</div>
                    <div class="text-muted" style="font-size:0.8rem">{{ $googleData['email'] }}</div>
                </div>
                <i class="bi bi-google ms-auto text-primary"></i>
            </div>

            <form action="{{ route('auth.google.complete.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="kabupaten_kota" class="form-label">
                        Kabupaten / Kota <span class="text-danger">*</span>
                    </label>
                    <select name="kabupaten_kota" id="kabupaten_kota" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Kabupaten/Kota --</option>
                        @foreach($kabupatenKota as $kk)
                            <option value="{{ $kk }}" {{ old('kabupaten_kota') === $kk ? 'selected' : '' }}>
                                {{ $kk }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text mt-1">
                        <i class="bi bi-info-circle me-1"></i>
                        Pilih kabupaten/kota sesuai lokasi LKS Anda. Data akan diteruskan ke admin setempat.
                    </div>
                </div>

                <button type="submit" class="btn-complete">
                    <i class="bi bi-check-circle me-2"></i>Selesaikan Pendaftaran
                </button>
            </form>

            <div class="back-link">
                <a href="{{ route('login.show') }}"><i class="bi bi-arrow-left me-1"></i>Kembali ke Login</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
