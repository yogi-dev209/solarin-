<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sopir - SolarIn</title>
    <style>
        /* ====== STYLE SAMA DENGAN LOGIN ====== */
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

        .register-wrapper {
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

        .register-card {
            width: 100%;
            max-width: 620px;
            border: 1.5px solid #e5e7eb;
            border-radius: 16px;
            padding: 34px 34px 28px 34px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .08);
            background: #ffffff;
        }

        .card-head {
            text-align: center;
            margin-bottom: 22px;
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
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 900;
            margin-bottom: 6px;
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

        .input-wrap input,
        .input-wrap select {
            border: none;
            outline: none;
            width: 100%;
            min-width: 0;
            font-size: 14px;
            color: #111827;
            background: transparent;
        }

        .input-wrap select {
            height: 100%;
            cursor: pointer;
        }

        .eye-btn {
            border: none;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            font-size: 15px;
            padding: 0;
        }

        .row-dua {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .register-btn {
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
            margin-top: 6px;
        }

        .register-btn:hover {
            background: #0f7a3f;
            transform: translateY(-1px);
        }

        .login-link {
            margin-top: 18px;
            text-align: center;
            font-size: 13px;
            color: #475569;
        }

        .login-link a {
            color: #138a47;
            font-weight: 900;
            text-decoration: none;
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

        @media (max-width: 900px) {
            .register-wrapper {
                grid-template-columns: 1fr;
            }

            .brand-side {
                min-height: 220px;
                padding: 30px 20px;
            }

            .brand-content {
                transform: none;
            }

            .brand-drop {
                width: 76px;
                height: 76px;
                margin-bottom: 12px;
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
                font-size: 36px;
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
                padding: 28px 16px 12px 16px;
            }

            .register-card {
                max-width: 100%;
                border: none;
                box-shadow: none;
                padding: 16px 4px 10px 4px;
            }

            .row-dua {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }

        @media (max-width: 520px) {
            body {
                background: #ffffff;
            }

            .brand-side {
                min-height: 180px;
            }

            .brand-title {
                font-size: 28px;
            }

            .card-head h1 {
                font-size: 24px;
            }

            .small-logo strong {
                font-size: 22px;
            }

            .footer-links {
                flex-direction: column;
                gap: 6px;
            }
        }
    </style>
</head>

<body>
    <div class="register-wrapper">
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
                <div class="register-card">
                    <div class="card-head">
                        <h1>Daftar Akun Sopir</h1>
                        <p>Isi data berikut untuk mendaftar sebagai sopir</p>
                        <div class="small-logo">
                            <div class="small-drop"></div>
                            <strong>SOLARIN</strong>
                        </div>
                    </div>

                    {{-- Tampilkan error validasi --}}
                    @if ($errors->any())
                    <div class="alert alert-error">
                        <ul style="margin:0;padding-left:16px;">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- ===== DATA USER ===== --}}
                        <h4 style="margin:10px 0 12px 0; font-size:15px; color:#0f172a;">Data Diri</h4>

                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <div class="input-wrap">
                                <span class="input-icon">👤</span>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" required autofocus>
                            </div>
                        </div>

                        <div class="row-dua">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-wrap">
                                    <span class="input-icon">@</span>
                                    <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Username" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-wrap">
                                    <span class="input-icon">✉</span>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <div class="input-wrap">
                                <span class="input-icon">📱</span>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="0812xxxxxx" required>
                            </div>
                        </div>

                        <div class="row-dua">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-wrap">
                                    <span class="input-icon">🔒</span>
                                    <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                                    <button type="button" class="eye-btn" onclick="togglePassword('password')">◉</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <div class="input-wrap">
                                    <span class="input-icon">🔒</span>
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                                    <button type="button" class="eye-btn" onclick="togglePassword('password_confirmation')">◉</button>
                                </div>
                            </div>
                        </div>

                        <div class="row-dua">
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <div class="input-wrap">
                                    <span class="input-icon">🏠</span>
                                    <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Alamat lengkap">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="operational_area">Wilayah Operasional</label>
                                <div class="input-wrap">
                                    <span class="input-icon">📍</span>
                                    <input type="text" id="operational_area" name="operational_area" value="{{ old('operational_area') }}" placeholder="Contoh: Surabaya">
                                </div>
                            </div>
                        </div>

                        {{-- ===== DATA KENDARAAN ===== --}}
                        <h4 style="margin:20px 0 12px 0; font-size:15px; color:#0f172a;">Data Kendaraan</h4>

                        <div class="form-group">
                            <label for="plate_number">Nomor Polisi (Plat)</label>
                            <div class="input-wrap">
                                <span class="input-icon">🚛</span>
                                <input type="text" id="plate_number" name="plate_number" value="{{ old('plate_number') }}" placeholder="Contoh: L 1234 AB" required>
                            </div>
                        </div>

                        <div class="row-dua">
                            <div class="form-group">
                                <label for="door_number">Nomor Pintu (Bodi)</label>
                                <div class="input-wrap">
                                    <span class="input-icon">🚪</span>
                                    <input type="text" id="door_number" name="door_number" value="{{ old('door_number') }}" placeholder="Nomor pintu kendaraan" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="vehicle_type">Tipe Kendaraan</label>
                                <div class="input-wrap">
                                    <span class="input-icon">🚚</span>
                                    <input type="text" id="vehicle_type" name="vehicle_type" value="{{ old('vehicle_type') }}" placeholder="Contoh: Tronton, CDE, dll" required>
                                </div>
                            </div>
                        </div>

                        <div class="row-dua">
                            <div class="form-group">
                                <label for="fuel_type">Jenis BBM</label>
                                <div class="input-wrap">
                                    <span class="input-icon">⛽</span>
                                    <select id="fuel_type" name="fuel_type">
                                        <option value="">Pilih</option>
                                        <option value="Solar" {{ old('fuel_type')=='Solar' ? 'selected' : '' }}>Solar</option>
                                        <option value="Pertalite" {{ old('fuel_type')=='Pertalite' ? 'selected' : '' }}>Pertalite</option>
                                        <option value="Pertamax" {{ old('fuel_type')=='Pertamax' ? 'selected' : '' }}>Pertamax</option>
                                        <option value="Dex" {{ old('fuel_type')=='Dex' ? 'selected' : '' }}>Dex</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="wheels_count">Jumlah Roda</label>
                                <div class="input-wrap">
                                    <span class="input-icon">⚙️</span>
                                    <input type="number" id="wheels_count" name="wheels_count" value="{{ old('wheels_count') }}" placeholder="Contoh: 6" min="2">
                                </div>
                            </div>
                        </div>

                        <div class="row-dua">
                            <div class="form-group">
                                <label for="tax_expired">Masa Berlaku Pajak</label>
                                <div class="input-wrap">
                                    <span class="input-icon">📅</span>
                                    <input type="date" id="tax_expired" name="tax_expired" value="{{ old('tax_expired') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="stnk_expired">Masa Berlaku STNK</label>
                                <div class="input-wrap">
                                    <span class="input-icon">📅</span>
                                    <input type="date" id="stnk_expired" name="stnk_expired" value="{{ old('stnk_expired') }}">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="register-btn">
                            ➜ Daftar Sekarang
                        </button>

                        <div class="login-link">
                            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
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

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function showHelp(event) {
            event.preventDefault();
            alert('Jika mengalami kesulitan, hubungi admin operasional.');
        }
    </script>
</body>

</html>