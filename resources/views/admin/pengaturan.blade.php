@php
    // Menangkap bahasa dari admin yang sedang login
    $lang = auth()->check() ? (auth()->user()->language ?? 'id') : 'id';
@endphp

@extends('layouts.admin')

@section('title', $lang == 'en' ? 'Admin Settings - SolarIn' : 'Pengaturan Admin - SolarIn')
@section('page-greeting', $lang == 'en' ? 'Welcome, Admin' : 'Selamat Datang, Admin')
@section('page-subtitle', $lang == 'en' ? 'Manage account information, security, and system preferences' : 'Kelola informasi akun, keamanan, dan preferensi sistem')

@push('styles')
<style>
    :root {
        --border-color: #d1d5db;
        --border-radius: 10px;
        --blue-800: #003b78;
        --blue-50: #eef5ff;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-600: #64748b;
        --gray-800: #1f2937;
    }

    .settings-page {
        padding-top: 18px;
    }

    .settings-title {
        font-size: 23px;
        font-weight: 800;
        margin: 0 0 18px 0;
    }

    .settings-layout {
        display: grid;
        grid-template-columns: 265px 1fr;
        gap: 16px;
        align-items: start;
    }

    .panel {
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        background: #ffffff;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .panel-header {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color);
        background: var(--gray-100);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .panel-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
        color: var(--gray-800);
    }

    .panel-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .panel-body {
        padding: 16px;
    }

    .profile-box {
        text-align: center;
        padding: 24px 14px;
        border-bottom: 1px solid var(--border-color);
        background: #ffffff;
    }

    .profile-photo-wrap {
        position: relative;
        width: 96px;
        height: 96px;
        margin: 0 auto 14px auto;
    }

    .profile-photo {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: var(--blue-800);
        color: #ffffff;
        border: 4px solid var(--blue-50);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
        font-weight: 900;
        overflow: hidden;
        position: relative;
    }

    .profile-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-photo .initial {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
        font-weight: 900;
        background: var(--blue-800);
        color: #fff;
    }

    .photo-edit-btn {
        position: absolute;
        right: -4px;
        bottom: 4px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid #ffffff;
        background: var(--blue-800);
        color: #ffffff;
        font-size: 14px;
        font-weight: 900;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }

    .photo-edit-btn.disabled {
        opacity: .45;
        cursor: not-allowed;
    }

    .profile-box h3 {
        margin: 0 0 4px 0;
        font-size: 18px;
        font-weight: 900;
        color: var(--gray-800);
    }

    .profile-box p {
        margin: 0;
        font-size: 12px;
        color: var(--gray-600);
        line-height: 1.45;
    }

    .settings-menu {
        padding: 10px;
        display: grid;
        gap: 8px;
    }

    .settings-tab {
        width: 100%;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        background: #ffffff;
        padding: 12px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        text-align: left;
        transition: .18s;
        font-family: inherit;
    }

    .settings-tab:hover,
    .settings-tab.active {
        background: var(--blue-50);
        border-color: var(--blue-800);
    }

    .tab-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: var(--blue-50);
        color: var(--blue-800);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 900;
        flex-shrink: 0;
    }

    .settings-tab.active .tab-icon {
        background: var(--blue-800);
        color: #ffffff;
    }

    .tab-text strong {
        display: block;
        font-size: 13px;
        font-weight: 900;
        color: var(--gray-800);
    }

    .tab-text span {
        display: block;
        font-size: 11px;
        color: var(--gray-600);
        margin-top: 2px;
    }

    .settings-section {
        display: none;
    }

    .settings-section.active {
        display: block;
    }

    .section-title {
        margin: 0 0 6px 0;
        font-size: 18px;
        font-weight: 900;
        color: var(--gray-800);
    }

    .section-desc {
        margin: 0 0 18px 0;
        font-size: 13px;
        color: var(--gray-600);
        line-height: 1.6;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .form-group {
        margin-bottom: 6px;
    }

    .form-group.full {
        grid-column: 1 / 3;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 6px;
        color: var(--gray-800);
    }

    .form-control,
    select {
        width: 100%;
        height: 42px;
        border: 1px solid #9ca3af;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 13px;
        outline: none;
        background: #ffffff;
        transition: border-color 0.2s;
    }

    .form-control:focus,
    select:focus {
        border-color: var(--blue-800);
        box-shadow: 0 0 0 2px rgba(0,59,120,0.1);
    }

    .form-control:disabled,
    select:disabled {
        background: var(--gray-50);
        color: var(--gray-600);
        cursor: not-allowed;
        border-color: var(--border-color);
    }

    .readonly-note {
        padding: 12px 14px;
        border-radius: var(--border-radius);
        background: var(--blue-50);
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.5;
        margin-bottom: 18px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 18px;
    }

    .info-card {
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 14px;
        background: #ffffff;
    }

    .info-card span {
        display: block;
        font-size: 11px;
        color: var(--gray-600);
        margin-bottom: 4px;
    }

    .info-card strong {
        font-size: 15px;
        font-weight: 900;
        color: var(--gray-800);
    }

    .security-info {
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 14px;
        background: var(--gray-50);
        margin-bottom: 18px;
    }

    .security-info h4 {
        margin: 0 0 6px 0;
        font-size: 15px;
        font-weight: 900;
    }

    .security-info p {
        margin: 0;
        font-size: 13px;
        color: #475569;
        line-height: 1.6;
    }

    .theme-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 18px;
    }

    .theme-card {
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 14px;
        cursor: pointer;
        transition: .2s;
        background: #ffffff;
        position: relative;
    }

    .theme-card:hover,
    .theme-card.active {
        border-color: var(--blue-800);
        background: var(--blue-50);
    }

    .theme-card input {
        position: absolute;
        top: 14px;
        right: 14px;
    }

    .theme-preview {
        height: 100px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .theme-preview.light {
        background: linear-gradient(90deg, #003b78 0 28%, #ffffff 28% 100%);
    }

    .theme-preview.dark {
        background: linear-gradient(90deg, #0f172a 0 28%, #1e293b 28% 100%);
    }

    .theme-card strong {
        display: block;
        font-size: 14px;
        font-weight: 900;
        color: var(--gray-800);
    }

    .theme-card span {
        display: block;
        font-size: 12px;
        color: var(--gray-600);
        margin-top: 4px;
        line-height: 1.4;
    }

    .language-box {
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 16px;
        background: #ffffff;
    }

    .language-box h4 {
        margin: 0 0 8px 0;
        font-size: 15px;
        font-weight: 900;
    }

    .language-box p {
        margin: 0 0 14px 0;
        font-size: 13px;
        color: var(--gray-600);
        line-height: 1.5;
    }

    .action-row {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        border: 1px solid var(--gray-800);
        border-radius: 8px;
        min-height: 40px;
        padding: 0 18px;
        background: #ffffff;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        color: var(--gray-800);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: 0.2s;
        font-family: inherit;
    }

    .btn:hover {
        background: var(--gray-100);
    }

    .btn-primary {
        background: var(--blue-800);
        color: #ffffff;
        border-color: var(--blue-800);
    }

    .btn-primary:hover {
        background: #002752;
    }

    .btn-green {
        background: #16a34a;
        color: #ffffff;
        border-color: #16a34a;
    }

    .btn-green:hover {
        background: #15803d;
    }

    .btn:disabled {
        opacity: .45;
        cursor: not-allowed;
    }

    .toast {
        display: none;
        position: fixed;
        right: 24px;
        bottom: 24px;
        background: var(--blue-800);
        color: white;
        padding: 14px 20px;
        border-radius: var(--border-radius);
        font-size: 13px;
        font-weight: 800;
        z-index: 300;
        box-shadow: 0 14px 35px rgba(0, 0, 0, .22);
        transition: 0.2s;
    }

    .toast.show {
        display: block;
    }

    body.demo-dark {
        background: #0f172a;
    }

    body.demo-dark .panel,
    body.demo-dark .profile-box,
    body.demo-dark .settings-tab,
    body.demo-dark .info-card,
    body.demo-dark .theme-card,
    body.demo-dark .language-box {
        background: #1e293b;
        color: #f8fafc;
        border-color: #334155;
    }

    body.demo-dark .panel-header {
        background: #0f172a;
        color: #f8fafc;
        border-color: #334155;
    }

    body.demo-dark .tab-text strong,
    body.demo-dark .theme-card strong,
    body.demo-dark .section-title,
    body.demo-dark .info-card strong {
        color: #f8fafc;
    }

    body.demo-dark .form-control,
    body.demo-dark select {
        background: #0f172a;
        color: #f8fafc;
        border-color: #475569;
    }

    body.demo-dark .form-control:disabled,
    body.demo-dark select:disabled {
        background: #111827;
        color: #94a3b8;
    }

    body.demo-dark .security-info,
    body.demo-dark .readonly-note {
        background: #0f172a;
        border-color: #334155;
    }

    @media (max-width: 900px) {
        .settings-layout {
            grid-template-columns: 1fr;
        }
        .settings-menu {
            grid-template-columns: repeat(3, 1fr);
        }
        .info-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 640px) {
        .settings-page {
            padding-top: 8px;
        }
        .settings-title {
            font-size: 20px;
            margin-bottom: 14px;
        }
        .panel-header {
            align-items: flex-start;
            flex-direction: column;
        }
        .panel-actions {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        .settings-menu {
            grid-template-columns: 1fr;
        }
        .form-grid,
        .theme-grid {
            grid-template-columns: 1fr;
        }
        .form-group.full {
            grid-column: auto;
        }
        .info-grid {
            grid-template-columns: 1fr;
        }
        .action-row {
            flex-direction: column;
        }
        .btn {
            width: 100%;
        }
        .toast {
            left: 14px;
            right: 14px;
            bottom: 14px;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="settings-page">
    <h2 class="settings-title">{{ $lang == 'en' ? 'Admin Settings' : 'Pengaturan Admin' }}</h2>

    <div class="settings-layout">

        {{-- PANEL KIRI --}}
        <div class="panel">
            <div class="profile-box">
                <input type="file" id="photoInput" accept="image/*" style="display:none;" onchange="previewPhoto(this.files[0])">

                <div class="profile-photo-wrap">
                    <div class="profile-photo">
                        @if($admin->photo)
                            <img id="profileImage" src="{{ asset('storage/'.$admin->photo) }}" alt="{{ $lang == 'en' ? 'Admin Profile Photo' : 'Foto Profil Admin' }}">
                            <span class="initial" id="profileInitial" style="display:none;">{{ strtoupper(substr($admin->name,0,1)) }}</span>
                        @else
                            <img id="profileImage" src="" alt="{{ $lang == 'en' ? 'Admin Profile Photo' : 'Foto Profil Admin' }}" style="display:none;">
                            <span class="initial" id="profileInitial">{{ strtoupper(substr($admin->name,0,1)) }}</span>
                        @endif
                    </div>
                    <button class="photo-edit-btn disabled" id="photoButton" onclick="choosePhoto()" title="{{ $lang == 'en' ? 'Change profile photo' : 'Ganti foto profil' }}">📷</button>
                </div>

                <h3 id="summaryName">{{ $admin->name }}</h3>
                <p id="summaryEmail">{{ $admin->email }}</p>
                <p id="summaryRole">{{ ucfirst($admin->role) }}</p>
            </div>

            <div class="settings-menu">
                <button class="settings-tab active" onclick="openSection('profile', this)">
                    <span class="tab-icon">P</span>
                    <span class="tab-text"><strong>{{ $lang == 'en' ? 'Account Profile' : 'Profil Akun' }}</strong><span>{{ $lang == 'en' ? 'Admin identity' : 'Identitas admin' }}</span></span>
                </button>
                <button class="settings-tab" onclick="openSection('security', this)">
                    <span class="tab-icon">K</span>
                    <span class="tab-text"><strong>{{ $lang == 'en' ? 'Security' : 'Keamanan' }}</strong><span>{{ $lang == 'en' ? 'Change password' : 'Ubah kata sandi' }}</span></span>
                </button>
                <button class="settings-tab" onclick="openSection('system', this)">
                    <span class="tab-icon">S</span>
                    <span class="tab-text"><strong>{{ $lang == 'en' ? 'System Settings' : 'Pengaturan Sistem' }}</strong><span>{{ $lang == 'en' ? 'Theme and language' : 'Tema dan bahasa' }}</span></span>
                </button>
            </div>
        </div>

        {{-- PANEL KANAN --}}
        <div class="panel">
            <div class="panel-header">
                <h3 id="panelTitle">{{ $lang == 'en' ? 'Account Profile' : 'Profil Akun' }}</h3>
                <div class="panel-actions">
                    <button type="button" class="btn btn-primary" onclick="enableEdit()">{{ $lang == 'en' ? 'Edit Changes' : 'Edit Perubahan' }}</button>
                    <button type="button" class="btn btn-green" onclick="saveChanges()" id="saveButton" disabled>{{ $lang == 'en' ? 'Save Changes' : 'Simpan Perubahan' }}</button>
                </div>
            </div>

            <div class="panel-body">
                <div class="readonly-note" id="editInfo">
                    {!! $lang == 'en' ? 'Read-only mode is active. Click <strong>Edit Changes</strong> to modify profile, password, theme, or language.' : 'Mode baca aktif. Klik tombol <strong>Edit Perubahan</strong> untuk mengubah profil, password, tema, atau bahasa.' !!}
                </div>

                {{-- SECTION: PROFIL --}}
                <div class="settings-section active" id="section-profile">
                    <h3 class="section-title">{{ $lang == 'en' ? 'Account Profile' : 'Profil Akun' }}</h3>
                    <p class="section-desc">{{ $lang == 'en' ? 'Manage admin identity: name, contact, address, email, and profile photo.' : 'Kelola identitas admin: nama, kontak, alamat, email, dan foto profil.' }}</p>

                    <div class="info-grid">
                        <div class="info-card"><span>{{ $lang == 'en' ? 'Role Access' : 'Hak Akses' }}</span><strong>{{ ucfirst($admin->role) }}</strong></div>
                        <div class="info-card"><span>{{ $lang == 'en' ? 'Last Updated' : 'Terakhir Diperbarui' }}</span><strong>{{ $admin->updated_at ? $admin->updated_at->format('d/m/Y') : '-' }}</strong></div>
                        <div class="info-card"><span>{{ $lang == 'en' ? 'Joined Since' : 'Bergabung Sejak' }}</span><strong>{{ $admin->created_at->format('d/m/Y') }}</strong></div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>{{ $lang == 'en' ? 'Admin Name' : 'Nama Admin' }}</label>
                            <input type="text" id="adminName" class="form-control editable" value="{{ $admin->name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>{{ $lang == 'en' ? 'Phone Number' : 'Nomor Telepon' }}</label>
                            <input type="text" id="adminPhone" class="form-control editable" value="{{ $admin->phone ?? '' }}" placeholder="{{ $lang == 'en' ? 'Not filled' : 'Belum diisi' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>{{ $lang == 'en' ? 'Address' : 'Alamat' }}</label>
                            <input type="text" id="adminAddress" class="form-control editable" value="{{ $admin->address ?? '' }}" placeholder="{{ $lang == 'en' ? 'Not filled' : 'Belum diisi' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>{{ $lang == 'en' ? 'Role' : 'Peran' }}</label>
                            <input type="text" id="adminRole" class="form-control" value="{{ ucfirst($admin->role) }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>{{ $lang == 'en' ? 'Email Address' : 'Alamat Email' }}</label>
                            <input type="email" id="adminEmail" class="form-control editable" value="{{ $admin->email }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>{{ $lang == 'en' ? 'Join Date' : 'Tanggal Bergabung' }}</label>
                            <input type="text" id="joinDate" class="form-control" value="{{ $admin->created_at->format('d F Y') }}" disabled>
                        </div>
                    </div>
                </div>

                {{-- SECTION: KEAMANAN --}}
                <div class="settings-section" id="section-security">
                    <h3 class="section-title">{{ $lang == 'en' ? 'Security' : 'Keamanan' }}</h3>
                    <p class="section-desc">{{ $lang == 'en' ? 'Update your password regularly to maintain account security.' : 'Perbarui kata sandi secara berkala untuk menjaga keamanan akun.' }}</p>

                    <div class="security-info">
                        <h4>{{ $lang == 'en' ? 'Password Requirements' : 'Persyaratan Kata Sandi' }}</h4>
                        <p>{{ $lang == 'en' ? 'Minimum 6 characters. Use a combination of letters, numbers, and symbols for stronger security.' : 'Minimal 6 karakter. Gunakan kombinasi huruf, angka, dan simbol agar lebih kuat.' }}</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group full">
                            <label>{{ $lang == 'en' ? 'Current Password' : 'Password Saat Ini' }}</label>
                            <input type="password" id="currentPassword" class="form-control editable" placeholder="{{ $lang == 'en' ? 'Enter current password' : 'Masukkan password saat ini' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>{{ $lang == 'en' ? 'New Password' : 'Password Baru' }}</label>
                            <input type="password" id="newPassword" class="form-control editable" placeholder="{{ $lang == 'en' ? 'Minimum 6 characters' : 'Minimal 6 karakter' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>{{ $lang == 'en' ? 'Confirm New Password' : 'Konfirmasi Password Baru' }}</label>
                            <input type="password" id="confirmPassword" class="form-control editable" placeholder="{{ $lang == 'en' ? 'Repeat new password' : 'Ulangi password baru' }}" disabled>
                        </div>
                    </div>
                </div>

                {{-- SECTION: SISTEM --}}
                <div class="settings-section" id="section-system">
                    <h3 class="section-title">{{ $lang == 'en' ? 'System Settings' : 'Pengaturan Sistem' }}</h3>
                    <p class="section-desc">{{ $lang == 'en' ? 'Set display (light/dark mode) and interface language.' : 'Atur tampilan (mode terang/gelap) dan bahasa antarmuka.' }}</p>

                    <div class="theme-grid">
                        <label class="theme-card active" id="themeLightCard" onclick="selectTheme('light')">
                            <input type="radio" name="theme" id="themeLight" class="editable" value="light" checked disabled>
                            <div class="theme-preview light"></div>
                            <strong>Light Mode</strong>
                            <span>{{ $lang == 'en' ? 'Light display, suitable for well-lit rooms.' : 'Tampilan terang, cocok untuk ruangan cukup cahaya.' }}</span>
                        </label>

                        <label class="theme-card" id="themeDarkCard" onclick="selectTheme('dark')">
                            <input type="radio" name="theme" id="themeDark" class="editable" value="dark" disabled>
                            <div class="theme-preview dark"></div>
                            <strong>Dark Mode</strong>
                            <span>{{ $lang == 'en' ? 'Dark display, more comfortable for the eyes at night.' : 'Tampilan gelap, lebih nyaman di mata saat malam.' }}</span>
                        </label>
                    </div>

                    <div class="language-box">
                        <h4>{{ $lang == 'en' ? 'System Language' : 'Bahasa Sistem' }}</h4>
                        <p>{{ $lang == 'en' ? 'Select the language to be used throughout the admin panel.' : 'Pilih bahasa yang akan digunakan di seluruh panel admin.' }}</p>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Language' : 'Bahasa' }}</label>
                                <select id="languageSelect" class="editable" disabled>
                                    <option value="id" {{ $admin->language == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                    <option value="en" {{ $admin->language == 'en' ? 'selected' : '' }}>English</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Language Preview' : 'Contoh Tampilan Bahasa' }}</label>
                                <input type="text" id="languagePreview" class="form-control" value="{{ $admin->language == 'en' ? 'System uses English' : 'Sistem menggunakan Bahasa Indonesia' }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-row">
                    <a href="{{ url('/admin/manajemen-user') }}" class="btn">{{ $lang == 'en' ? 'To User Management' : 'Ke Manajemen User' }}</a>
                    <button type="button" class="btn btn-green" onclick="saveChanges()" id="bottomSaveButton" disabled>{{ $lang == 'en' ? 'Save Changes' : 'Simpan Perubahan' }}</button>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="toast" id="toastBox">Berhasil.</div>
@endsection

@push('scripts')
<script>
    let editMode = false;
    const currentLang = '{{ $lang }}'; // Menangkap bahasa ke dalam variabel JavaScript

    // TAB NAVIGATION
    function openSection(section, button) {
        document.querySelectorAll('.settings-section').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.settings-tab').forEach(el => el.classList.remove('active'));

        document.getElementById('section-' + section).classList.add('active');
        button.classList.add('active');

        const titles = {
            profile: currentLang === 'en' ? 'Account Profile' : 'Profil Akun',
            security: currentLang === 'en' ? 'Security' : 'Keamanan',
            system: currentLang === 'en' ? 'System Settings' : 'Pengaturan Sistem'
        };
        document.getElementById('panelTitle').innerText = titles[section];
    }

    // EDIT MODE
    function enableEdit() {
        editMode = true;

        document.querySelectorAll('.editable').forEach(el => el.disabled = false);
        document.getElementById('saveButton').disabled = false;
        document.getElementById('bottomSaveButton').disabled = false;
        document.getElementById('photoButton').classList.remove('disabled');
        
        document.getElementById('editInfo').innerHTML = currentLang === 'en' 
            ? 'Edit mode active. Please change the necessary data, then click <strong>Save Changes</strong>.'
            : 'Mode edit aktif. Silakan ubah data yang diperlukan, lalu klik <strong>Simpan Perubahan</strong>.';

        showToast(currentLang === 'en' ? 'Edit mode active.' : 'Mode edit perubahan aktif.');
    }

    function disableEdit() {
        editMode = false;

        document.querySelectorAll('.editable').forEach(el => el.disabled = true);
        document.getElementById('saveButton').disabled = true;
        document.getElementById('bottomSaveButton').disabled = true;
        document.getElementById('photoButton').classList.add('disabled');
        
        document.getElementById('editInfo').innerHTML = currentLang === 'en'
            ? 'Read-only mode is active. Click <strong>Edit Changes</strong> to modify profile, password, theme, or language.'
            : 'Mode baca aktif. Klik tombol <strong>Edit Perubahan</strong> untuk mengubah profil, password, tema, atau bahasa.';
    }

    // FOTO PROFIL
    function choosePhoto() {
        if (!editMode) {
            showToast(currentLang === 'en' ? 'Click Edit Changes first to change profile photo.' : 'Klik Edit Perubahan terlebih dahulu untuk mengganti foto profil.');
            return;
        }
        document.getElementById('photoInput').click();
    }

    function previewPhoto(file) {
        if (!file) return;
        const image = document.getElementById('profileImage');
        const initial = document.getElementById('profileInitial');
        const reader = new FileReader();
        reader.onload = function(e) {
            image.src = e.target.result;
            image.style.display = 'block';
            initial.style.display = 'none';
        };
        reader.readAsDataURL(file);
        showToast(currentLang === 'en' ? 'Profile photo selected.' : 'Foto profil berhasil dipilih.');
    }

    // TEMA
    function selectTheme(theme) {
        if (!editMode) {
            showToast(currentLang === 'en' ? 'Click Edit Changes first.' : 'Klik Edit Perubahan terlebih dahulu.');
            return;
        }

        document.querySelectorAll('.theme-card').forEach(card => card.classList.remove('active'));

        if (theme === 'dark') {
            document.getElementById('themeDarkCard').classList.add('active');
            document.getElementById('themeDark').checked = true;
            document.body.classList.add('demo-dark');
            showToast(currentLang === 'en' ? 'Dark mode selected.' : 'Dark mode dipilih.');
        } else {
            document.getElementById('themeLightCard').classList.add('active');
            document.getElementById('themeLight').checked = true;
            document.body.classList.remove('demo-dark');
            showToast(currentLang === 'en' ? 'Light mode selected.' : 'Light mode dipilih.');
        }
    }

    document.getElementById('languageSelect').addEventListener('change', function() {
        const preview = document.getElementById('languagePreview');
        preview.value = this.value === 'en' ? 'System uses English' : 'Sistem menggunakan Bahasa Indonesia';
        showToast(this.value === 'en' ? 'English selected.' : 'Bahasa Indonesia dipilih.');
    });

    // SIMPAN PERUBAHAN
    async function saveChanges() {
        if (!editMode) {
            showToast(currentLang === 'en' ? 'Click Edit Changes first.' : 'Klik Edit Perubahan terlebih dahulu.');
            return;
        }

        const name = document.getElementById('adminName').value.trim();
        const email = document.getElementById('adminEmail').value.trim();
        const phone = document.getElementById('adminPhone').value.trim();
        const address = document.getElementById('adminAddress').value.trim();

        if (!name || !email) {
            showToast(currentLang === 'en' ? 'Name and email cannot be empty.' : 'Nama dan email tidak boleh kosong.');
            return;
        }

        // Password update
        const currentPassword = document.getElementById('currentPassword').value.trim();
        const newPassword = document.getElementById('newPassword').value.trim();
        const confirmPassword = document.getElementById('confirmPassword').value.trim();

        const passwordFilled = currentPassword || newPassword || confirmPassword;

        if (passwordFilled) {
            if (!currentPassword || !newPassword || !confirmPassword) {
                showToast(currentLang === 'en' ? 'Please fill all password fields.' : 'Lengkapi semua kolom password.');
                return;
            }
            if (newPassword.length < 6) {
                showToast(currentLang === 'en' ? 'New password must be at least 6 characters.' : 'Password baru minimal 6 karakter.');
                return;
            }
            if (newPassword !== confirmPassword) {
                showToast(currentLang === 'en' ? 'Password confirmation does not match.' : 'Konfirmasi password tidak sama.');
                return;
            }

            try {
                const passwordRes = await fetch('/admin/profile/password', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        current_password: currentPassword,
                        new_password: newPassword,
                        confirm_password: confirmPassword
                    })
                });

                const passwordData = await passwordRes.json();
                if (!passwordData.success) {
                    showToast(passwordData.message || (currentLang === 'en' ? 'Failed to change password.' : 'Gagal mengubah password.'));
                    return;
                }

                document.getElementById('currentPassword').value = "";
                document.getElementById('newPassword').value = "";
                document.getElementById('confirmPassword').value = "";
            } catch (e) {
                console.error(e);
                showToast(currentLang === 'en' ? 'Failed to change password.' : 'Gagal mengubah password.');
                return;
            }
        }

        // Profil + foto
        const formData = new FormData();
        formData.append('_method', 'PATCH');
        formData.append('name', name);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('address', address);

        const photo = document.getElementById('photoInput').files[0];
        if (photo) {
            formData.append('photo', photo);
        }

        try {
            const profileRes = await fetch('/admin/profile', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const profileData = await profileRes.json();
            if (!profileData.success) {
                showToast(profileData.message || (currentLang === 'en' ? 'Failed to save profile.' : 'Gagal menyimpan profil.'));
                return;
            }
        } catch (e) {
            console.error(e);
            showToast(currentLang === 'en' ? 'Failed to connect to server.' : 'Gagal terhubung ke server.');
            return;
        }

        // Preferensi (tema & bahasa)
        const themeRadio = document.querySelector('input[name="theme"]:checked');
        const theme = themeRadio ? themeRadio.value : 'light';
        const language = document.getElementById('languageSelect').value;

        try {
            const prefRes = await fetch('/admin/profile/preferences', {
                method: 'PATCH', // Pastikan Route web.php Anda tetap menggunakan Route::patch()
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    theme: theme,
                    language: language
                })
            });

            const prefData = await prefRes.json();
            if (!prefData.success) {
                showToast((currentLang === 'en' ? 'Failed to save preferences: ' : 'Gagal menyimpan preferensi: ') + (prefData.message || ''));
                return;
            }
        } catch (e) {
            console.error(e);
            showToast(currentLang === 'en' ? 'Failed to save preferences.' : 'Gagal menyimpan preferensi.');
            return;
        }

        // Cek jika bahasa diubah, reload halaman agar teks baru dirender
        if (language !== currentLang) {
            showToast(currentLang === 'en' ? 'Language preference saved. Reloading...' : 'Preferensi bahasa berhasil disimpan. Memuat ulang...');
            setTimeout(() => {
                window.location.reload();
            }, 1200);
            return; 
        }

        // Update tampilan secara manual jika bahasa tidak diganti
        document.getElementById('summaryName').innerText = name;
        document.getElementById('summaryEmail').innerText = email;
        const initial = document.getElementById('profileInitial');
        initial.innerText = name.charAt(0).toUpperCase();
        if (!photo) {
            const img = document.getElementById('profileImage');
            img.style.display = 'none';
            initial.style.display = 'flex';
        }

        disableEdit();
        showToast(currentLang === 'en' ? 'Changes saved successfully.' : 'Perubahan berhasil disimpan.');
    }

    function showToast(message) {
        const toast = document.getElementById('toastBox');
        toast.innerText = message;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2200);
    }

    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const theme = '{{ $admin->theme ?? "light" }}';
        
        if (theme === 'dark') {
            document.getElementById('themeDarkCard').classList.add('active');
            document.getElementById('themeDark').checked = true;
            document.body.classList.add('demo-dark');
        } else {
            document.getElementById('themeLightCard').classList.add('active');
            document.getElementById('themeLight').checked = true;
        }

        document.getElementById('languageSelect').value = currentLang;
        document.getElementById('languagePreview').value = currentLang === 'en' ? 'System uses English' : 'Sistem menggunakan Bahasa Indonesia';
    });
</script>
@endpush