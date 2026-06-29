<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SolarIn</title>
    <style>
        /* (semua style tetap sama seperti yang Anda berikan) */
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #0b2f66;
            color: #111827;
        }

        .login-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 52% 48%;
            background: linear-gradient(90deg, rgba(0, 42, 101, .92) 0%, rgba(0, 65, 145, .82) 45%, rgba(255, 255, 255, .96) 45%, rgba(255, 255, 255, .98) 100%), url('https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
        }

        .hero {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            color: #ffffff;
            overflow: hidden;
        }

        .hero::before {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            top: -130px;
            left: -100px;
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 520px;
            height: 180px;
            background: rgba(255, 255, 255, .08);
            transform: rotate(-18deg);
            bottom: 80px;
            right: -120px;
            border-radius: 40px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 520px;
            width: 100%;
        }

        .brand-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 34px;
        }

        .logo-mark {
            width: 54px;
            height: 68px;
            background: #ffffff;
            border-radius: 60% 60% 60% 8%;
            transform: rotate(-45deg);
            position: relative;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .22);
        }

        .logo-mark::after {
            content: "";
            position: absolute;
            right: 6px;
            bottom: 9px;
            width: 22px;
            height: 38px;
            background: #f6b51e;
            border-radius: 60% 60% 60% 8%;
        }

        .brand-text h1 {
            margin: 0;
            font-size: 46px;
            letter-spacing: 3px;
            font-weight: 900;
        }

        .brand-text p {
            margin: 3px 0 0 0;
            font-size: 13px;
            font-weight: 700;
            opacity: .95;
        }

        .hero-title {
            margin: 0 0 14px 0;
            font-size: 36px;
            line-height: 1.15;
            font-weight: 900;
        }

        .hero-desc {
            margin: 0;
            font-size: 16px;
            line-height: 1.6;
            max-width: 440px;
            opacity: .95;
        }

        .hero-info {
            display: flex;
            gap: 14px;
            margin-top: 30px;
        }

        .info-card {
            width: 145px;
            min-height: 86px;
            border: 1px solid rgba(255, 255, 255, .35);
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(4px);
            border-radius: 12px;
            padding: 13px;
        }

        .info-card strong {
            display: block;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .info-card span {
            font-size: 12px;
            line-height: 1.3;
        }

        .login-side {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 42px 58px;
            position: relative;
        }

        .help-link {
            position: absolute;
            top: 28px;
            right: 42px;
            color: #0b5fc4;
            font-weight: 800;
            font-size: 14px;
            cursor: pointer;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            margin: 0 auto;
            background: rgba(255, 255, 255, .96);
            border: 1px solid #d9e2ef;
            border-radius: 18px;
            padding: 32px 30px;
            box-shadow: 0 22px 60px rgba(15, 23, 42, .18);
        }

        .login-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .small-logo {
            width: 48px;
            height: 60px;
            margin: 0 auto 12px auto;
            background: #1d65d8;
            border-radius: 60% 60% 60% 8%;
            transform: rotate(-45deg);
            position: relative;
        }

        .small-logo::after {
            content: "";
            position: absolute;
            right: 5px;
            bottom: 8px;
            width: 18px;
            height: 30px;
            background: #f6b51e;
            border-radius: 60% 60% 60% 8%;
        }

        .login-header h2 {
            margin: 0 0 6px 0;
            font-size: 30px;
            font-weight: 900;
            color: #0f172a;
        }

        .login-header p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.4;
            font-weight: 600;
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

        .form-group {
            margin-bottom: 17px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 8px;
            color: #1f2937;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #64748b;
        }

        .input-control {
            width: 100%;
            height: 48px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            padding: 0 44px 0 42px;
            font-size: 14px;
            outline: none;
            background: #ffffff;
        }

        .input-control:focus {
            border-color: #1d65d8;
            box-shadow: 0 0 0 4px rgba(29, 101, 216, .13);
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 16px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 6px 0 22px 0;
            font-size: 13px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #475569;
        }

        .forgot {
            color: #0b5fc4;
            font-weight: 800;
            cursor: pointer;
        }

        .btn-login,
        .btn-sso {
            width: 100%;
            height: 48px;
            border-radius: 9px;
            font-weight: 900;
            font-size: 15px;
            cursor: pointer;
            transition: .2s;
        }

        .btn-login {
            border: none;
            background: #1d65d8;
            color: #ffffff;
            box-shadow: 0 10px 20px rgba(29, 101, 216, .24);
        }

        .btn-login:hover {
            background: #1457c1;
            transform: translateY(-1px);
        }

        .separator {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #64748b;
            font-size: 13px;
            margin: 19px 0;
        }

        .separator::before,
        .separator::after {
            content: "";
            height: 1px;
            background: #d6deeb;
            flex: 1;
        }

        .btn-sso {
            background: #ffffff;
            border: 2px solid #9dbcf5;
            color: #1d65d8;
        }

        .btn-sso:hover {
            background: #f4f8ff;
        }

        .footer-login {
            text-align: center;
            margin-top: 18px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.7;
        }

        .footer-login a {
            color: #0b5fc4;
            text-decoration: none;
            font-weight: 800;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 99;
            align-items: center;
            justify-content: center;
            padding: 18px;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-box {
            width: 390px;
            max-width: 100%;
            background: #ffffff;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .25);
        }

        .modal-box h3 {
            margin: 0 0 8px 0;
            font-size: 20px;
        }

        .modal-box p {
            margin: 0;
            color: #475569;
            line-height: 1.5;
            font-size: 14px;
        }

        .modal-actions {
            margin-top: 18px;
            display: flex;
            justify-content: flex-end;
        }

        .modal-actions button {
            border: none;
            background: #1d65d8;
            color: #ffffff;
            border-radius: 8px;
            padding: 9px 15px;
            font-weight: 800;
            cursor: pointer;
        }

        @media (max-width: 900px) {
            body {
                background: linear-gradient(rgba(0, 42, 101, .86), rgba(0, 42, 101, .86)), url('https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&w=900&q=70');
                background-size: cover;
                background-position: center;
            }

            .login-page {
                display: block;
                min-height: 100vh;
                background: transparent;
                padding: 18px 14px 24px 14px;
            }

            .hero {
                padding: 20px 6px 16px 6px;
                min-height: auto;
                display: block;
                text-align: center;
            }

            .hero::before,
            .hero::after,
            .hero-title,
            .hero-desc,
            .hero-info {
                display: none;
            }

            .brand-row {
                justify-content: center;
                margin-bottom: 0;
            }

            .logo-mark {
                width: 42px;
                height: 54px;
            }

            .logo-mark::after {
                width: 17px;
                height: 29px;
                right: 5px;
                bottom: 7px;
            }

            .brand-text h1 {
                font-size: 32px;
            }

            .brand-text p {
                font-size: 11px;
                max-width: 230px;
            }

            .login-side {
                padding: 12px 0 0 0;
                display: block;
            }

            .help-link {
                position: static;
                color: #ffffff;
                text-align: right;
                margin: 0 4px 10px 0;
                font-size: 13px;
            }

            .login-card {
                max-width: 430px;
                padding: 23px 18px 20px 18px;
                border-radius: 16px;
            }

            .login-header {
                margin-bottom: 20px;
            }

            .small-logo {
                width: 40px;
                height: 50px;
                margin-bottom: 10px;
            }

            .small-logo::after {
                width: 15px;
                height: 26px;
            }

            .login-header h2 {
                font-size: 25px;
            }

            .login-header p {
                font-size: 13px;
            }

            .form-group {
                margin-bottom: 14px;
            }

            .input-control {
                height: 45px;
                font-size: 13px;
            }

            .form-row {
                font-size: 12px;
            }

            .btn-login,
            .btn-sso {
                height: 45px;
                font-size: 14px;
            }

            .footer-login {
                color: rgba(255, 255, 255, .9);
                margin-top: 14px;
            }

            .footer-login a {
                color: #ffffff;
            }
        }

        @media (max-width: 420px) {
            .login-page {
                padding: 14px 12px 18px 12px;
            }

            .brand-text h1 {
                font-size: 28px;
            }

            .brand-text p {
                font-size: 10px;
            }

            .login-card {
                padding: 20px 15px;
            }

            .form-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 9px;
            }
        }
    </style>
</head>

<body>
    <div class="login-page">
        <section class="hero">
            <div class="hero-content">
                <div class="brand-row">
                    <div class="logo-mark"></div>
                    <div class="brand-text">
                        <h1>SOLARIN</h1>
                        <p>Sistem Pengelolaan & Monitoring<br>Pengajuan Barcode Solar Subsidi</p>
                    </div>
                </div>
                <h2 class="hero-title">Kelola Pengajuan Barcode Solar Subsidi Lebih Mudah</h2>
                <p class="hero-desc">
                    Admin dapat memantau pengajuan sopir, melakukan verifikasi dokumen,
                    mengelola barcode, reset barcode, notifikasi, dan komunikasi melalui room chat.
                </p>
            </div>
        </section>

        <section class="login-side">
            <div class="help-link" onclick="openModal('Bantuan Login', 'Hubungi administrator sistem apabila akun admin tidak dapat digunakan atau lupa kata sandi.')">
                ⓘ Butuh bantuan?
            </div>

            <div class="login-card">
                <div class="login-header">
                    <div class="small-logo"></div>
                    <h2>Login Admin</h2>
                    <p>Masuk untuk melanjutkan ke sistem SOLARIN</p>
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
                    <input type="hidden" name="login_type" value="admin">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrap">
                            <span class="input-icon">👤</span>
                            <input id="email" type="email" class="input-control" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon">🔒</span>
                            <input id="password" type="password" class="input-control" name="password" placeholder="Masukkan password" required>
                            <button type="button" class="toggle-password" onclick="togglePassword()">👁</button>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="remember">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Ingat saya</span>
                        </label>

                        <span class="forgot" onclick="openModal('Lupa Password', 'Fitur lupa password digunakan untuk membantu admin melakukan pemulihan akun melalui email yang terdaftar.')">
                            Lupa password?
                        </span>
                    </div>

                    <button type="submit" class="btn-login">
                        🔒 Login
                    </button>
                </form>
            </div>

            <div class="footer-login">
                © 2026 SOLARIN. All rights reserved.<br>
                <a href="#">Kebijakan Privasi</a> · <a href="#">Syarat & Ketentuan</a>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <div id="infoModal" class="modal-overlay">
        <div class="modal-box">
            <h3 id="modalTitle">Informasi</h3>
            <p id="modalText">Konten informasi.</p>
            <div class="modal-actions">
                <button type="button" onclick="closeModal()">Mengerti</button>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            password.type = password.type === 'password' ? 'text' : 'password';
        }

        function openModal(title, text) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalText').innerText = text;
            document.getElementById('infoModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('infoModal').classList.remove('show');
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>

</html>