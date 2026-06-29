@extends('layouts.sopir')

@section('title', 'Pengaturan Sopir - SolarIn')
@section('page-greeting', 'Hallo, Selamat Datang')
@section('page-subtitle', 'Sudah Siap Untuk Pengajuan?')

@push('styles')
<style>
    /* CSS DASAR (MODE TERANG) */
    .settings-page {
        padding-top: 18px;
        min-height: 100vh;
    }

    .page-title {
        font-size: 24px;
        font-weight: 900;
        margin: 0 0 18px 0;
        color: #111827;
        transition: color 0.3s ease;
    }

    .settings-layout {
        display: grid;
        grid-template-columns: 315px minmax(0, 1fr);
        gap: 18px;
        align-items: start;
    }

    .side-panel,
    .content-panel {
        border: 1.8px solid #111827;
        border-radius: 18px;
        background: #ffffff;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .profile-summary {
        padding: 24px 18px 18px 18px;
        text-align: center;
        border-bottom: 1.5px solid #d1d5db;
        transition: border-color 0.3s ease;
    }

    .avatar-box {
        width: 112px;
        height: 112px;
        border-radius: 50%;
        background: #08733f;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 900;
        margin: 0 auto 14px auto;
        overflow: hidden;
        border: 4px solid #dcfce7;
    }

    .avatar-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }

    .avatar-box.has-image img {
        display: block;
    }

    .avatar-box.has-image span {
        display: none;
    }

    .profile-summary h3 {
        margin: 0 0 5px 0;
        font-size: 21px;
        font-weight: 900;
        color: #111827;
    }

    .profile-summary p {
        margin: 0;
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
    }

    .profile-badge {
        margin: 14px auto 0 auto;
        display: inline-flex;
        padding: 7px 13px;
        border-radius: 999px;
        background: #dcfce7;
        color: #15803d;
        font-size: 12px;
        font-weight: 900;
    }

    .upload-photo-btn {
        display: none;
        width: 100%;
        height: 38px;
        border: 1.5px solid #08733f;
        border-radius: 9px;
        background: #ffffff;
        color: #08733f;
        font-size: 12px;
        font-weight: 900;
        cursor: pointer;
        margin-top: 14px;
        align-items: center;
        justify-content: center;
    }

    .upload-photo-btn.show {
        display: flex;
    }

    .mini-info {
        padding: 15px 18px;
        border-bottom: 1.5px solid #d1d5db;
        display: grid;
        gap: 10px;
        transition: border-color 0.3s ease;
    }

    .mini-info-row {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        font-size: 13px;
    }

    .mini-info-row span {
        color: #64748b;
        font-weight: 800;
    }

    .mini-info-row strong {
        color: #111827;
        font-weight: 900;
        text-align: right;
    }

    .settings-tabs {
        padding: 12px;
        display: grid;
        gap: 8px;
    }

    .tab-btn {
        width: 100%;
        min-height: 45px;
        border: 1.4px solid #d1d5db;
        border-radius: 10px;
        background: #ffffff;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 12px;
        font-size: 13px;
        font-weight: 900;
        cursor: pointer;
        text-align: left;
        transition: all 0.2s ease;
    }

    .tab-btn:hover,
    .tab-btn.active {
        background: #ecfdf5;
        border-color: #08733f;
        color: #08733f;
    }

    .tab-icon {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 900;
        flex-shrink: 0;
    }

    .tab-btn.active .tab-icon {
        background: #08733f;
        color: #ffffff;
    }

    .content-header {
        padding: 18px 22px;
        border-bottom: 1.6px solid #111827;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        background: #ffffff;
        transition: all 0.3s ease;
    }

    .content-header h3 {
        margin: 0;
        font-size: 22px;
        font-weight: 900;
        color: #111827;
    }

    .content-header p {
        margin: 4px 0 0 0;
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
    }

    .header-actions {
        display: flex;
        gap: 9px;
        flex-shrink: 0;
    }

    .btn-edit,
    .btn-save {
        height: 40px;
        border-radius: 9px;
        padding: 0 15px;
        font-size: 13px;
        font-weight: 900;
        cursor: pointer;
    }

    .btn-edit {
        background: #ffffff;
        border: 1.5px solid #111827;
        color: #111827;
        transition: all 0.2s ease;
    }

    .btn-save {
        background: #08733f;
        border: 1.5px solid #08733f;
        color: #ffffff;
        opacity: .55;
        pointer-events: none;
    }

    .btn-save.active {
        opacity: 1;
        pointer-events: auto;
    }

    .content-body {
        padding: 22px;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .section-title {
        margin: 0 0 14px 0;
        font-size: 18px;
        font-weight: 900;
        color: #111827;
    }

    .section-subtitle {
        margin: -7px 0 16px 0;
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 26px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .form-group.full {
        grid-column: 1 / 3;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 900;
        color: #111827;
    }

    .form-control,
    .form-select,
    textarea {
        width: 100%;
        border: 1.4px solid #9ca3af;
        border-radius: 9px;
        padding: 11px 12px;
        font-size: 14px;
        color: #111827;
        background: #ffffff;
        outline: none;
        font-family: Arial, Helvetica, sans-serif;
        transition: all 0.3s ease;
    }

    textarea {
        min-height: 86px;
        resize: vertical;
    }

    .form-control:disabled,
    .form-select:disabled,
    textarea:disabled {
        background: #f8fafc;
        color: #475569;
        cursor: not-allowed;
    }

    .form-control:focus,
    .form-select:focus,
    textarea:focus {
        border-color: #08733f;
        box-shadow: 0 0 0 3px rgba(8, 115, 63, .13);
    }

    .info-note {
        border: 1px solid #bbf7d0;
        background: #f0fdf4;
        color: #166534;
        border-radius: 10px;
        padding: 12px 13px;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.45;
        margin-bottom: 18px;
    }

    .preference-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 18px;
    }

    .preference-card {
        border: 1.5px solid #d1d5db;
        border-radius: 14px;
        padding: 15px;
        background: #ffffff;
        cursor: pointer;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        transition: all 0.3s ease;
    }

    .preference-card.active {
        border-color: #08733f;
        background: #ecfdf5;
    }

    .preference-card input {
        margin-top: 3px;
        accent-color: #08733f;
    }

    .preference-card strong {
        display: block;
        font-size: 14px;
        font-weight: 900;
        margin-bottom: 4px;
        color: #111827;
    }

    .preference-card span {
        font-size: 12px;
        color: #64748b;
        font-weight: 700;
        line-height: 1.35;
    }

    .bottom-actions {
        border-top: 1px solid #d1d5db;
        margin-top: 10px;
        padding-top: 18px;
        display: flex;
        justify-content: flex-end;
        gap: 9px;
    }

    .toast {
        display: none;
        position: fixed;
        right: 24px;
        bottom: 24px;
        background: #08733f;
        color: #ffffff;
        padding: 13px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        z-index: 300;
        box-shadow: 0 14px 35px rgba(0, 0, 0, .22);
    }

    .toast.show {
        display: block;
    }

    /* ========================================================
       CSS DARK MODE GLOBAL (MEMAKSA BACKGROUND LUAR GELAP JUGA)
       ======================================================== */
    body.dark-mode {
        background-color: #0f172a !important;
        color: #e5e7eb !important;
    }

    body.dark-mode #app,
    body.dark-mode .main-content,
    body.dark-mode .content-wrapper {
        background-color: #0f172a !important;
    }

    body.dark-mode .page-title {
        color: #f8fafc !important;
    }

    body.dark-mode .side-panel,
    body.dark-mode .content-panel,
    body.dark-mode .content-header,
    body.dark-mode .profile-summary,
    body.dark-mode .tab-btn,
    body.dark-mode .preference-card {
        background: #1e293b !important;
        color: #e5e7eb !important;
        border-color: #334155 !important;
    }

    body.dark-mode .content-header h3,
    body.dark-mode .section-title,
    body.dark-mode .profile-summary h3,
    body.dark-mode .mini-info-row strong,
    body.dark-mode .preference-card strong,
    body.dark-mode .form-group label {
        color: #f8fafc !important;
    }

    body.dark-mode .form-control,
    body.dark-mode .form-select,
    body.dark-mode textarea {
        background: #0f172a !important;
        color: #f8fafc !important;
        border-color: #475569 !important;
    }

    body.dark-mode .form-control:disabled,
    body.dark-mode .form-select:disabled,
    body.dark-mode textarea:disabled {
        background: #111827 !important;
        color: #94a3b8 !important;
    }

    body.dark-mode .content-header,
    body.dark-mode .profile-summary,
    body.dark-mode .mini-info {
        border-bottom-color: #334155 !important;
    }

    body.dark-mode .tab-btn {
        background: #0f172a !important;
        border-color: #334155 !important;
    }

    body.dark-mode .tab-btn:hover,
    body.dark-mode .tab-btn.active {
        background: #334155 !important;
        border-color: #38bdf8 !important;
        color: #38bdf8 !important;
    }

    body.dark-mode .tab-btn.active .tab-icon {
        background: #38bdf8 !important;
        color: #0f172a !important;
    }

    body.dark-mode .tab-icon {
        background: #1e293b !important;
        color: #94a3b8 !important;
    }

    body.dark-mode .preference-card.active {
        border-color: #38bdf8 !important;
        background: #0f172a !important;
    }

    body.dark-mode .btn-edit {
        background: #1e293b !important;
        color: #f8fafc !important;
        border-color: #475569 !important;
    }

    @media (max-width: 1000px) {
        .settings-layout {
            grid-template-columns: 1fr;
        }

        .side-panel {
            max-width: 100%;
        }

        .settings-tabs {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .settings-page {
            padding-top: 8px;
        }

        .page-title {
            font-size: 20px;
        }

        .settings-tabs {
            grid-template-columns: 1fr;
        }

        .content-header {
            flex-direction: column;
            align-items: stretch;
            padding: 16px;
        }

        .header-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .btn-edit,
        .btn-save {
            width: 100%;
        }

        .form-grid,
        .preference-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: 1;
        }
    }
</style>
@endpush

@section('content')

@php
$user = auth()->user();
$vehicle = $user->vehicles->first();

// MENANGKAP PENGATURAN BAHASA DARI DATABASE
$lang = $user->language ?? 'id';
@endphp

<div class="settings-page">
    <!-- Judul Halaman Dinamis berdasarkan Bahasa -->
    <h2 class="page-title">{{ $lang == 'en' ? 'Driver Settings' : 'Pengaturan Sopir' }}</h2>

    <div class="settings-layout">
        <aside class="side-panel">
            <div class="profile-summary">
                <div class="avatar-box {{ $user->photo ? 'has-image' : '' }}" id="avatarBox">
                    <span id="avatarInitial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    <img id="avatarImage" src="{{ $user->photo ? asset('storage/' . $user->photo) : '' }}" alt="Foto Profil">
                </div>

                <h3 id="profileNameText">{{ $user->name }}</h3>
                <p id="profileEmailText">{{ $user->email }}</p>

                <div class="profile-badge">{{ $lang == 'en' ? 'Active Driver Account' : 'Akun Sopir Aktif' }}</div>

                <label for="photoInput" class="upload-photo-btn" id="uploadPhotoBtn">
                    {{ $lang == 'en' ? 'Change Profile Photo' : 'Ganti Foto Profil' }}
                </label>
            </div>

            <div class="mini-info">
                <div class="mini-info-row">
                    <span>{{ $lang == 'en' ? 'Door Number' : 'No. Pintu' }}</span>
                    <strong id="miniDoor">{{ $vehicle ? $vehicle->door_number : '-' }}</strong>
                </div>

                <div class="mini-info-row">
                    <span>{{ $lang == 'en' ? 'Plate Number' : 'No. Polisi' }}</span>
                    <strong id="miniPolice">{{ $vehicle ? $vehicle->plate_number : '-' }}</strong>
                </div>

                <div class="mini-info-row">
                    <span>{{ $lang == 'en' ? 'Operational' : 'Operasional' }}</span>
                    <strong id="miniArea">{{ $user->operational_area ?? '-' }}</strong>
                </div>

                <div class="mini-info-row">
                    <span>{{ $lang == 'en' ? 'Account Status' : 'Status Akun' }}</span>
                    <strong>{{ ucfirst($user->status) }}</strong>
                </div>
            </div>

            <div class="settings-tabs">
                <button class="tab-btn active" onclick="switchTab('profileTab', this)">
                    <span class="tab-icon">👤</span>
                    <span>{{ $lang == 'en' ? 'Account Profile' : 'Profil Akun' }}</span>
                </button>

                <button class="tab-btn" onclick="switchTab('securityTab', this)">
                    <span class="tab-icon">🔒</span>
                    <span>{{ $lang == 'en' ? 'Security' : 'Keamanan' }}</span>
                </button>

                <button class="tab-btn" onclick="switchTab('systemTab', this)">
                    <span class="tab-icon">⚙</span>
                    <span>{{ $lang == 'en' ? 'System Settings' : 'Pengaturan Sistem' }}</span>
                </button>
            </div>
        </aside>

        <!-- FORM UTAMA -->
        <section class="content-panel">
            <form id="profileForm" action="{{ route('sopir.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="file" name="photo" id="photoInput" accept="image/jpeg,image/png,image/jpg" hidden onchange="previewPhoto(this)">
                <input type="hidden" name="vehicle_id" value="{{ $vehicle ? $vehicle->id : '' }}">

                <div class="content-header">
                    <div>
                        <h3 id="panelTitle">{{ $lang == 'en' ? 'Account Profile' : 'Profil Akun' }}</h3>
                        <p id="panelSubtitle">{{ $lang == 'en' ? 'Manage your account, vehicle, and driver information.' : 'Kelola data akun, kendaraan, dan informasi sopir.' }}</p>
                    </div>

                    <div class="header-actions">
                        <button type="button" class="btn-edit" onclick="enableEdit()">{{ $lang == 'en' ? 'Edit Changes' : 'Edit Perubahan' }}</button>
                        <button type="button" class="btn-save" id="saveTopBtn" onclick="saveChanges()">{{ $lang == 'en' ? 'Save' : 'Simpan' }}</button>
                    </div>
                </div>

                <div class="content-body">
                    <!-- NOTIFIKASI ERROR / SUKSES -->
                    @if (session('success'))
                    <div class="info-note" style="border-color: #4ade80; background: #dcfce7; color: #166534;">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="info-note" style="border-color: #f87171; background: #fef2f2; color: #991b1b;">
                        <strong>{{ $lang == 'en' ? 'Failed to save changes:' : 'Gagal menyimpan perubahan:' }}</strong>
                        <ul style="margin: 6px 0 0 16px; padding: 0; font-weight: 700;">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="tab-content active" id="profileTab">
                        <h4 class="section-title">{{ $lang == 'en' ? 'Personal Data' : 'Data Pribadi' }}</h4>
                        <p class="section-subtitle">{{ $lang == 'en' ? 'Main driver information on the SolarIn system.' : 'Informasi utama akun sopir pada sistem SolarIn.' }}</p>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Full Name' : 'Nama Lengkap' }}</label>
                                <input type="text" name="name" id="driverName" class="form-control editable" value="{{ old('name', $user->name) }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" id="driverEmail" class="form-control editable" value="{{ old('email', $user->email) }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Phone Number' : 'No. HP' }}</label>
                                <input type="text" name="phone" id="driverPhone" class="form-control editable" value="{{ old('phone', $user->phone) }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Address / Domicile' : 'Alamat / Domisili' }}</label>
                                <input type="text" name="address" id="driverAddress" class="form-control editable" value="{{ old('address', $user->address) }}" disabled>
                            </div>
                        </div>

                        <h4 class="section-title">{{ $lang == 'en' ? 'Vehicle Data (Main)' : 'Data Kendaraan (Utama)' }}</h4>
                        <p class="section-subtitle">{{ $lang == 'en' ? 'Vehicle data used for submitting subsidized diesel barcode.' : 'Data kendaraan yang digunakan untuk pengajuan barcode solar subsidi.' }}</p>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Plate Number' : 'No. Polisi' }}</label>
                                <input type="text" name="plate_number" id="vehiclePolice" class="form-control editable" value="{{ old('plate_number', $vehicle?->plate_number) }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Door Number' : 'No. Pintu' }}</label>
                                <input type="text" name="door_number" id="vehicleDoor" class="form-control editable" value="{{ old('door_number', $vehicle?->door_number) }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Operational Area' : 'Area Operasional' }}</label>
                                <input type="text" name="operational_area" id="vehicleArea" class="form-control editable" value="{{ old('operational_area', $user->operational_area) }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Vehicle Type' : 'Jenis Kendaraan' }}</label>
                                <input type="text" name="vehicle_type" id="vehicleType" class="form-control editable" value="{{ old('vehicle_type', $vehicle?->vehicle_type) }}" disabled>
                            </div>

                            <!-- INI DIA KOLOM PAJAK DAN STNK YANG KEMBALI -->
                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Tax Expiry Date' : 'Masa Aktif Pajak' }}</label>
                                <input type="date" name="tax_expired" id="taxDate" class="form-control editable" value="{{ old('tax_expired', $vehicle?->tax_expired ? \Carbon\Carbon::parse($vehicle->tax_expired)->format('Y-m-d') : '') }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'STNK Expiry Date' : 'Masa Aktif STNK' }}</label>
                                <input type="date" name="stnk_expired" id="stnkDate" class="form-control editable" value="{{ old('stnk_expired', $vehicle?->stnk_expired ? \Carbon\Carbon::parse($vehicle->stnk_expired)->format('Y-m-d') : '') }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="securityTab">
                        <h4 class="section-title">{{ $lang == 'en' ? 'Account Security' : 'Keamanan Akun' }}</h4>
                        <p class="section-subtitle">{{ $lang == 'en' ? 'Use this section if you want to change your account password.' : 'Gunakan bagian ini jika sopir ingin mengganti password akun.' }}</p>

                        <div class="info-note">
                            {{ $lang == 'en' ? 'Fill in all password fields only if you want to make a password change. If you do not want to change the password, leave it blank.' : 'Isi semua kolom password hanya jika ingin melakukan perubahan password. Jika tidak ingin mengganti password, biarkan kosong.' }}
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Old Password' : 'Password Lama' }}</label>
                                <input type="password" name="old_password" id="oldPassword" class="form-control editable" placeholder="{{ $lang == 'en' ? 'Enter old password' : 'Masukkan password lama' }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'New Password' : 'Password Baru' }}</label>
                                <input type="password" name="password" id="newPassword" class="form-control editable" placeholder="{{ $lang == 'en' ? 'Enter new password' : 'Masukkan password baru' }}" disabled>
                            </div>

                            <div class="form-group full">
                                <label>{{ $lang == 'en' ? 'Confirm New Password' : 'Konfirmasi Password Baru' }}</label>
                                <input type="password" name="password_confirmation" id="confirmPassword" class="form-control editable" placeholder="{{ $lang == 'en' ? 'Repeat new password' : 'Ulangi password baru' }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="systemTab">
                        <h4 class="section-title">{{ $lang == 'en' ? 'System Settings' : 'Pengaturan Sistem' }}</h4>
                        <p class="section-subtitle">{{ $lang == 'en' ? 'Manage display preferences and application language.' : 'Kelola preferensi tampilan dan bahasa aplikasi.' }}</p>

                        <div class="preference-grid">
                            <label class="preference-card {{ $user->theme == 'light' ? 'active' : '' }}" id="lightThemeCard">
                                <input type="radio" name="theme" id="themeLight" value="light" {{ $user->theme == 'light' ? 'checked' : '' }} onchange="setThemePreference('light')" disabled class="editable">
                                <div>
                                    <strong>{{ $lang == 'en' ? 'Light Mode' : 'Mode Terang' }}</strong>
                                    <span>{{ $lang == 'en' ? 'Standard display with white background.' : 'Tampilan standar dengan latar putih.' }}</span>
                                </div>
                            </label>

                            <label class="preference-card {{ $user->theme == 'dark' ? 'active' : '' }}" id="darkThemeCard">
                                <input type="radio" name="theme" id="themeDark" value="dark" {{ $user->theme == 'dark' ? 'checked' : '' }} onchange="setThemePreference('dark')" disabled class="editable">
                                <div>
                                    <strong>{{ $lang == 'en' ? 'Dark Mode' : 'Mode Gelap' }}</strong>
                                    <span>{{ $lang == 'en' ? 'Display with dark colors (Night Mode).' : 'Tampilan dengan warna gelap (Night Mode).' }}</span>
                                </div>
                            </label>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Application Language' : 'Bahasa Aplikasi' }}</label>
                                <select name="language" id="languageSelect" class="form-select editable" disabled onchange="updateLanguagePreview()">
                                    <option value="id" {{ $user->language == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                    <option value="en" {{ $user->language == 'en' ? 'selected' : '' }}>English</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{ $lang == 'en' ? 'Language Preview' : 'Preview Bahasa' }}</label>
                                <input type="text" id="languagePreview" class="form-control" value="{{ $user->language == 'en' ? 'English is active' : 'Bahasa Indonesia aktif' }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="bottom-actions">
                        <button type="button" class="btn-edit" onclick="enableEdit()">{{ $lang == 'en' ? 'Edit Changes' : 'Edit Perubahan' }}</button>
                        <button type="button" class="btn-save" id="saveBottomBtn" onclick="saveChanges()">{{ $lang == 'en' ? 'Save Changes' : 'Simpan Perubahan' }}</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>

<div class="toast" id="toastBox">Berhasil.</div>
@endsection

@push('scripts')
<script>
    // Memastikan JS memaksa body menjadi gelap jika temanya dark
    document.addEventListener('DOMContentLoaded', function() {
        const initialTheme = "{{ $user->theme ?? 'light' }}";
        if (initialTheme === 'dark') {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });

    let editMode = false;
    const currentLang = "{{ $lang }}";

    function switchTab(tabId, button) {
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        document.getElementById(tabId).classList.add('active');
        button.classList.add('active');

        const panelTitle = document.getElementById('panelTitle');
        const panelSubtitle = document.getElementById('panelSubtitle');

        if (tabId === 'profileTab') {
            panelTitle.innerText = currentLang === 'en' ? 'Account Profile' : 'Profil Akun';
            panelSubtitle.innerText = currentLang === 'en' ? 'Manage your account, vehicle, and driver information.' : 'Kelola data akun, kendaraan, dan informasi sopir.';
        }
        if (tabId === 'securityTab') {
            panelTitle.innerText = currentLang === 'en' ? 'Security' : 'Keamanan';
            panelSubtitle.innerText = currentLang === 'en' ? 'Manage password and account security.' : 'Kelola password dan keamanan akun sopir.';
        }
        if (tabId === 'systemTab') {
            panelTitle.innerText = currentLang === 'en' ? 'System Settings' : 'Pengaturan Sistem';
            panelSubtitle.innerText = currentLang === 'en' ? 'Manage display preferences and language.' : 'Kelola preferensi tampilan dan bahasa aplikasi.';
        }
    }

    function enableEdit() {
        editMode = true;
        document.querySelectorAll('.editable').forEach(input => {
            input.disabled = false;
        });

        document.getElementById('saveTopBtn').classList.add('active');
        document.getElementById('saveBottomBtn').classList.add('active');
        document.getElementById('uploadPhotoBtn').classList.add('show');

        showToast(currentLang === 'en' ? 'Edit mode active. Please change your data.' : 'Mode edit aktif. Silakan ubah data Anda.');
    }

    function saveChanges() {
        if (!editMode) {
            showToast(currentLang === 'en' ? 'Click Edit Changes first.' : 'Klik Edit Perubahan terlebih dahulu.');
            return;
        }

        const name = document.getElementById('driverName').value.trim();
        const email = document.getElementById('driverEmail').value.trim();

        if (name === '' || email === '') {
            showToast(currentLang === 'en' ? 'Name and Email cannot be empty.' : 'Nama dan Email tidak boleh kosong.');
            return;
        }

        document.getElementById('saveTopBtn').innerText = currentLang === 'en' ? 'Saving...' : 'Menyimpan...';
        document.getElementById('saveBottomBtn').innerText = currentLang === 'en' ? 'Saving...' : 'Menyimpan...';

        document.getElementById('profileForm').submit();
    }

    function previewPhoto(input) {
        const file = input.files && input.files[0];
        if (!file) return;

        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            showToast(currentLang === 'en' ? 'Failed: Format must be image (JPG, PNG).' : 'Gagal: Format harus berupa gambar (JPG, PNG).');
            input.value = '';
            return;
        }

        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            showToast(currentLang === 'en' ? 'Failed: Size too large. Max 5MB.' : 'Gagal: Ukuran foto terlalu besar. Maksimal 5MB.');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const avatarBox = document.getElementById('avatarBox');
            const avatarImage = document.getElementById('avatarImage');

            avatarImage.src = e.target.result;
            avatarBox.classList.add('has-image');

            showToast(currentLang === 'en' ? 'Photo ready to upload. Don\'t forget to Save.' : 'Foto siap diupload. Jangan lupa Simpan Perubahan.');
        };
        reader.readAsDataURL(file);
    }

    function setThemePreference(theme) {
        const lightCard = document.getElementById('lightThemeCard');
        const darkCard = document.getElementById('darkThemeCard');

        lightCard.classList.remove('active');
        darkCard.classList.remove('active');

        if (theme === 'dark') {
            darkCard.classList.add('active');
            document.body.classList.add('dark-mode');
        } else {
            lightCard.classList.add('active');
            document.body.classList.remove('dark-mode');
        }
    }

    function updateLanguagePreview() {
        const language = document.getElementById('languageSelect').value;
        const preview = document.getElementById('languagePreview');

        if (language === 'en') {
            preview.value = 'English is active';
        } else {
            preview.value = 'Bahasa Indonesia aktif';
        }
    }

    function showToast(message) {
        const toast = document.getElementById('toastBox');
        toast.innerText = message;
        toast.classList.add('show');

        setTimeout(() => {
            toast.classList.remove('show');
        }, 2500);
    }
</script>
@endpush