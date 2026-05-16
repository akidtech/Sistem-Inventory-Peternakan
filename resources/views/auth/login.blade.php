<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SiTernak - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        .bg-glass {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 16px;
            padding: 35px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .input-group-text {
            cursor: pointer;
        }

        .btn-primary {
            background-color: #2E7D32;
            border-color: #2E7D32;
        }

        .btn-primary:hover {
            background-color: #388E3C;
            border-color: #388E3C;
        }

        .lupa-password {
            color: #2E7D32;
        }

        .lupa-password:hover {
            color: #388E3C;
            text-decoration: underline;
        }

        .logo-sub {
            font-size: 28px;
            font-weight: 700;
            color: #2E7D32;
        }

        .demo-box {
            background: #f1f8e9;
            border-left: 3px solid #2E7D32;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="bg-glass">

                    {{-- Logo --}}
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo-mini.png') }}" alt="Sumber Makmur"
                            style="height: 100px; width: auto; object-fit: contain; margin-bottom: 8px;">
                        <div class="logo-sub">LOGIN</div>
                    </div>

                    {{-- Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger py-2">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email"
                                value="{{ old('email') }}" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password">
                                <span class="input-group-text" id="togglePassword">
                                    <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted small" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#" class="text-decoration-none small lupa-password">Lupa Password?</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </button>
                        </div>

                    </form>

                    {{-- Demo akun --}}
                    <div class="demo-box">
                        <strong>Demo Akun:</strong><br>
                        👑 Admin: <code>admin@gmail.com</code> / <code>admin123</code><br>
                        👨‍🌾 Peternak: <code>budi@gmail.com</code> / <code>budi123</code>
                    </div>

                </div>

                <p class="text-center text-white mt-3 small">
                    © {{ date('Y') }} <strong>SiTernak</strong> — Sistem Manajemen Ternak
                </p>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>
