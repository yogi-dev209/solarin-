<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sopir - SolarIn</title>
    <style>
        /* (semua style tetap sama seperti yang Anda berikan) */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        .login-wrapper {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 45% 55%;
            background: #ffffff;
        }

        .brand-side {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(1, 87, 43, .96), rgba(11, 122, 62, .84)), url('https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center bottom;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            color: #ffffff;
        }

        .brand-side::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 20%, rgba(255, 255, 255, .16), transparent 24%), linear-gradient(155deg, transparent 0 35%, rgba(255, 255, 255, .08) 36% 46%, transparent 47% 100%);
        }

        .brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 430px;
            transform: translateY(-12px);
        }

        .brand-drop {
            width: 118px;
            height: 118px;
            margin: 0 auto 24px auto;
            position: relative;
        }

        .drop-shape {
            width: 92px;
            height: 112px;
            border: 5px solid #ffffff;
            border-radius: 60% 60% 60% 8%;
            transform: rotate(45deg);
            margin: 0 auto;
            position: relative;
        }

        .drop-shape::after {
            content: "";
            position: absolute;
            width: 42px;
            height: 58px;
            right: 5px;
            bottom: 4px;
            background: #fbbf24;
            border-radius: 60% 60% 60% 8%;
        }

        .brand-title {
            font-size: 58px;
            line-height: 1;
            font-weight: 900;
            letter-spacing: 3px;
            margin: 0 0 15px 0;
        }

        .brand-subtitle {
            font-size: 19px;
            line-height: 1.35;
            font-weight: 700;
            margin: 0 auto;
            max-width: 390px;
        }

        .brand-line {
            width: 78px;
            height: 4px;
            background: #fbbf24;
            border-radius: 999px;
            margin: 18px auto;
        }

        .brand-company {
            font-size: 18px;
            font-weight: 800;
            margin-top: 4px;
        }

        .form-side {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #ffffff;
            position: relative;
        }

        .help-link {
            position: absolute;
            top: 28px;
            right: 34px;
            color: #0f8a49;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .form-center {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 52px 38px 24px 38px;
        }

        .login-card {
            width: 100%;
            max-width: 560px;
            border: 1.5px solid #e5e7eb;
            border-radius: 16px;
            padding: 34px 34px 28px 34px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .08);
            background: #ffffff;
        }

        .card-head {
            text-align: center;
            margin-bottom: 28px;
        }

        .card-head h1 {
            margin: 0 0 10px 0;
            font-size: 32px;
            font-weight: 900;
            color: #052e16;
        }

        .card-head p {
            margin: 0;
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
        }

        .small-logo {
            margin: 20px auto 0 auto;
            width: 92px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .small-drop {
            width: 54px;
            height: 64px;
            border-radius: 60% 60% 60% 8%;
            transform: rotate(45deg);
            background: #138a47;
            position: relative;
        }

        .small-drop::after {
            content: "";
            position: absolute;
            right: 4px;
            bottom: 4px;
            width: 22px;
            height: 34px;
            background: #fbbf24;
            border-radius: 60% 60% 60% 8%;
        }

        .small-logo strong {
            font-size: 28px;
            letter-spacing: 1px;
            color: #138a47;
            font-weight: 900;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 900;
            margin-bottom: 8px;
            color: #111827;
        }

        .input-wrap {
            height: 46px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 0 13px;
            background: #ffffff;
            transition: .18s;
        }

        .input-wrap:focus-within {
            border-color: #138a47;
            box-shadow: 0 0 0 3px rgba(19, 138, 71, .12);
        }

        .input-icon {
            color: #64748b;
            font-size: 16px;
            width: 18px;
            text-align: center;
        }

        .input-wrap input {
            border: none;
            outline: none;
            width: 100%;
            min-width: 0;
            font-size: 14px;
            color: #111827;
        }

        .eye-btn {
            border: none;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            font-size: 15px;
            padding: 0;
        }

        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin: 3px 0 24px 0;
            font-size: 13px;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-weight: 600;
            cursor: pointer;
        }

        .remember input {
            width: 16px;
            height: 16px;
            accent-color: #138a47;
        }

        .forgot-link {
            color: #138a47;
            text-decoration: none;
            font-weight: 900;
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 8px;
            background: #138a47;
            color: #ffffff;
            font-size: 14px;
            font-weight: 900;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            box-shadow: 0 10px 24px rgba(19, 138, 71, .24);
            transition: .18s;
        }

        .login-btn:hover {
            background: #0f7a3f;
            transform: translateY(-1px);
        }

        .login-note {
            margin-top: 16px;
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
            color: #166534;
            border-radius: 9px;
            padding: 10px 12px;
            font-size: 12px;
            line-height: 1.45;
            font-weight: 700;
        }

        .alert {
            padding: 11px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
        }

        .footer {
            padding: 18px 24px 24px 24px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }

        .footer strong {
            color: #64748b;
        }

        .footer-links {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            gap: 18px;
        }

        .footer-links a {
            color: #138a47;
            text-decoration: none;
            font-weight: 800;
        }

        .toast {
            display: none;
            position: fixed;
            right: 24px;
            bottom: 24px;
            background: #138a47;
            color: #ffffff;
            padding: 13px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 800;
            z-index: 20;
            box-shadow: 0 14px 35px rgba(0, 0, 0, .22);
        }

        .toast.show {
            display: block;
        }

        @media (max-width: 900px) {
            .login-wrapper {
                grid-template-columns: 1fr;
            }

            .brand-side {
                min-height: 280px;
                padding: 36px 22px;
            }

            .brand-content {
                transform: none;
            }

            .brand-drop {
                width: 76px;
                height: 76px;
                margin-bottom: 16px;
            }

            .drop-shape {
                width: 60px;
                height: 74px;
                border-width: 4px;
            }

            .drop-shape::after {
                width: 26px;
                height: 38px;
            }

            .brand-title {
                font-size: 42px;
            }

            .brand-subtitle {
                font-size: 15px;
            }

            .brand-company {
                font-size: 15px;
            }

            .form-side {
                min-height: auto;
            }

            .help-link {
                top: 16px;
                right: 18px;
            }

            .form-center {
                padding: 32px 18px 18px 18px;
            }

            .login-card {
                max-width: 100%;
            }
        }

        @media (max-width: 520px) {
            body {
                background: #ffffff;
            }

            .brand-side {
                min-height: 230px;
            }

            .brand-title {
                font-size: 34px;
                letter-spacing: 2px;
            }

            .brand-subtitle {
                font-size: 13px;
            }

            .brand-line {
                margin: 12px auto;
            }

            .login-card {
                border: none;
                box-shadow: none;
                padding: 18px 4px 10px 4px;
            }

            .card-head h1 {
                font-size: 26px;
            }

            .small-logo strong {
                font-size: 24px;
            }

            .login-options {
                align-items: flex-start;
                flex-direction: column;
                gap: 10px;
            }

            .footer-links {
                flex-direction: column;
                gap: 6px;
            }

            .toast {
                left: 14px;
                right: 14px;
                bottom: 14px;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <section class="brand-side">
            <div class="brand-content">
                <div class="brand-drop">
                    <div class="drop-shape"></div>
                </div>
                <h1 class="brand-title">SOLARIN</h1>
                <p class="brand-subtitle">
                    Sistem Pengelolaan & Monitoring Pengajuan Barcode Solar Subsidi
                </p>
                <div class="brand-line"></div>
                <div class="brand-company">PT XYZ Transportasi</div>
            </div>
        </section>

        <section class="form-side">
            <div class="help-link" onclick="showHelp(event)">ⓘ Butuh bantuan?</div>

            <div class="form-center">
                <div class="login-card">

                    <div class="card-head">
                        <h1>Login Sopir</h1>
                        <p>Masuk untuk melanjutkan ke sistem SOLARIN</p>
                        <div class="small-logo">
                            <div class="small-drop"></div>
                            <strong>SOLARIN</strong>
                        </div>
                    </div>

                    {{-- TAMPILKAN PESAN ERROR DARI SESSION --}}
                    @if (session('error'))
                    <div class="alert alert-error">
                        ⚠️ {{ session('error') }}
                    </div>
                    @endif
                    {{-- Tampilkan error validasi --}}
                    @if ($errors->any())
                    <div class="alert alert-error">
                        {{ $errors->first() }}
                    </div>
                    @endif

                    {{-- Tampilkan pesan sukses logout jika ada --}}
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input type="hidden" name="login_type" value="sopir">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-wrap">
                                <span class="input-icon">♙</span>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" autocomplete="email" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-wrap">
                                <span class="input-icon">▣</span>
                                <input type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
                                <button type="button" class="eye-btn" onclick="togglePassword()">◉</button>
                            </div>
                        </div>

                        <div class="login-options">
                            <label class="remember">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                Ingat saya
                            </label>

                            <span class="forgot-link" onclick="forgotPassword(event)">Lupa password?</span>
                        </div>

                        <button type="submit" class="login-btn">
                            ▣ Login
                        </button>
                        <div style="text-align:center; margin-top:16px; font-size:13px;">
                            Belum punya akun? <a href="{{ route('register') }}" style="color:#138a47; font-weight:900; text-decoration:none;">Daftar di sini</a>
                        </div>

                        <div class="login-note">
                            <strong>Info:</strong> Gunakan email dan password yang terdaftar di sistem.
                        </div>
                    </form>
                </div>
            </div>

            <footer class="footer">
                <strong>© 2026 SOLARIN.</strong> All rights reserved.
                <div class="footer-links">
                    <a href="#">Kebijakan Privasi</a>
                    <a href="#">Syarat & Ketentuan</a>
                </div>
            </footer>
        </section>
    </div>

    <div class="toast" id="toastBox">Berhasil.</div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            password.type = password.type === 'password' ? 'text' : 'password';
        }

        function forgotPassword(event) {
            event.preventDefault();
            showToast('Fitur lupa password akan segera hadir. Hubungi admin jika mengalami kendala.');
        }

        function showHelp(event) {
            event.preventDefault();
            showToast('Silakan hubungi admin operasional untuk bantuan akun sopir.');
        }

        function showToast(message) {
            const toast = document.getElementById('toastBox');
            toast.innerText = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 2200);
        }
    </script>
</body>

</html>