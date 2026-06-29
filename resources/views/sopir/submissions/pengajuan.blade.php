@extends('layouts.sopir')

@section('title', 'Pengajuan Dokumen - SolarIn')
@section('page-greeting', 'Hallo, Selamat Datang')
@section('page-subtitle', 'Sudah Siap Untuk Pengajuan?')

@push('styles')
<style>
    .pengajuan-page {
        padding-top: 18px;
    }

    .page-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
        border-bottom: 2px solid #9ca3af;
        padding-bottom: 14px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 900;
        margin: 0;
        color: #111827;
    }

    .page-sub {
        margin: 5px 0 0 0;
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
    }

    .status-pill {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #86efac;
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 900;
        white-space: nowrap;
    }

    .driver-card {
        border: 1.8px solid #111827;
        border-radius: 18px;
        background: #ffffff;
        padding: 18px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .driver-card-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .driver-card-title h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 900;
        color: #111827;
    }

    .driver-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .info-box {
        border: 1.3px solid #d1d5db;
        border-radius: 12px;
        padding: 12px 13px;
        background: #f8fafc;
        min-height: 70px;
        transition: all 0.3s ease;
    }

    .info-box span {
        display: block;
        font-size: 12px;
        color: #64748b;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .info-box strong {
        display: block;
        font-size: 16px;
        color: #111827;
        font-weight: 900;
    }

    .main-upload-card {
        border: 1.8px solid #111827;
        border-radius: 22px;
        background: #ffffff;
        overflow: hidden;
        display: grid;
        grid-template-columns: 42% 58%;
        min-height: 330px;
        transition: all 0.3s ease;
    }

    .guide-box {
        border-right: 1.8px solid #111827;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }

    .guide-title {
        padding: 15px 18px;
        border-bottom: 1.8px solid #111827;
        font-size: 20px;
        font-weight: 900;
        color: #111827;
        background: #ffffff;
        text-align: center;
    }

    .guide-content {
        padding: 18px;
        display: grid;
        gap: 14px;
        flex: 1;
    }

    .guide-preview {
        border: 1.3px dashed #08733f;
        border-radius: 16px;
        background: #ecfdf5;
        min-height: 135px;
        padding: 14px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .guide-mini {
        border: 1px solid #86efac;
        border-radius: 12px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 7px;
        text-align: center;
        padding: 10px;
    }

    .guide-mini-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: #08733f;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
        font-weight: 900;
    }

    .guide-mini strong {
        font-size: 12px;
        color: #111827;
    }

    .guide-list {
        display: grid;
        gap: 9px;
        font-size: 13px;
        color: #111827;
        font-weight: 700;
        line-height: 1.45;
    }

    .guide-list div {
        display: grid;
        grid-template-columns: 22px 1fr;
        gap: 8px;
        align-items: start;
    }

    .check {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #08733f;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 900;
        margin-top: 1px;
    }

    .upload-box {
        padding: 22px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 18px;
    }

    .upload-title {
        margin: 0;
        font-size: 20px;
        font-weight: 900;
        color: #111827;
    }

    .upload-subtitle {
        margin: 4px 0 0 0;
        font-size: 13px;
        color: #64748b;
        font-weight: 700;
    }

    .upload-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .upload-item {
        border: 1.5px solid #d1d5db;
        border-radius: 16px;
        background: #ffffff;
        padding: 14px;
        min-height: 205px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.3s ease;
    }

    .upload-card {
        min-height: 120px;
        border: 2px dashed #94a3b8;
        border-radius: 14px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: .18s;
        overflow: hidden;
        position: relative;
    }

    .upload-card:hover {
        border-color: #08733f;
        background: #f0fdf4;
    }

    .upload-card.has-file {
        border-style: solid;
        border-color: #08733f;
        background: #ecfdf5;
    }

    .plus-icon {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: #08733f;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        font-weight: 500;
        line-height: 1;
    }

    .preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
        position: absolute;
        inset: 0;
    }

    .upload-card.has-file .preview-img {
        display: block;
    }

    .upload-card.has-file .plus-icon {
        display: none;
    }

    .upload-label {
        margin-top: 12px;
        font-size: 14px;
        font-weight: 900;
        color: #111827;
        text-align: center;
    }

    .upload-note {
        margin-top: 4px;
        font-size: 11px;
        color: #64748b;
        text-align: center;
        line-height: 1.35;
    }

    .file-name {
        display: none;
        margin-top: 8px;
        font-size: 11px;
        font-weight: 900;
        color: #08733f;
        text-align: center;
        word-break: break-word;
    }

    .file-name.show {
        display: block;
    }

    .submit-row {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        border-top: 1px solid #e5e7eb;
        padding-top: 16px;
    }

    .btn-secondary,
    .submit-btn {
        height: 46px;
        border-radius: 10px;
        padding: 0 22px;
        font-size: 14px;
        font-weight: 900;
        cursor: pointer;
        transition: .18s;
    }

    .btn-secondary {
        border: 1.5px solid #111827;
        background: #ffffff;
        color: #111827;
    }

    .submit-btn {
        border: 1.5px solid #08733f;
        background: #08733f;
        color: #ffffff;
        min-width: 150px;
    }

    .submit-btn:hover {
        background: #065f36;
        border-color: #065f36;
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

    /* CSS ERROR & WARNING BOX */
    .alert-box {
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 18px;
        font-size: 14px;
        font-weight: 700;
        line-height: 1.5;
    }

    .alert-danger {
        background: #fef2f2;
        border: 1.5px solid #f87171;
        color: #991b1b;
    }

    .alert-warning {
        background: #fffbeb;
        border: 1.5px solid #fcd34d;
        color: #92400e;
    }

    /* DARK MODE */
    body.dark-mode {
        background-color: #0f172a !important;
        color: #e5e7eb !important;
    }

    body.dark-mode .page-title,
    body.dark-mode .driver-card-title h3,
    body.dark-mode .info-box strong,
    body.dark-mode .guide-title,
    body.dark-mode .upload-title,
    body.dark-mode .upload-label,
    body.dark-mode .guide-list {
        color: #f8fafc !important;
    }

    body.dark-mode .page-sub,
    body.dark-mode .info-box span,
    body.dark-mode .upload-subtitle {
        color: #94a3b8 !important;
    }

    body.dark-mode .driver-card,
    body.dark-mode .main-upload-card {
        background: #1e293b !important;
        border-color: #334155 !important;
    }

    body.dark-mode .info-box,
    body.dark-mode .guide-box,
    body.dark-mode .upload-item {
        background: #0f172a !important;
        border-color: #334155 !important;
    }

    body.dark-mode .guide-title {
        background: #1e293b !important;
        border-bottom-color: #334155 !important;
    }

    body.dark-mode .upload-card {
        background: #1e293b !important;
        border-color: #475569 !important;
    }

    body.dark-mode .upload-card:hover {
        border-color: #38bdf8 !important;
    }

    body.dark-mode .btn-secondary {
        background: #1e293b !important;
        border-color: #475569 !important;
        color: #f8fafc !important;
    }

    @media (max-width: 1000px) {
        .driver-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .main-upload-card {
            grid-template-columns: 1fr;
        }

        .guide-box {
            border-right: none;
            border-bottom: 1.8px solid #111827;
        }
    }

    @media (max-width: 768px) {
        .pengajuan-page {
            padding-top: 8px;
        }

        .page-head {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .page-title {
            font-size: 20px;
        }

        .driver-grid {
            grid-template-columns: 1fr;
        }

        .driver-card {
            border-radius: 16px;
            padding: 14px;
        }

        .driver-card-title {
            flex-direction: column;
            align-items: flex-start;
        }

        .main-upload-card {
            border-radius: 16px;
        }

        .guide-title,
        .upload-title {
            font-size: 18px;
        }

        .guide-preview {
            grid-template-columns: 1fr;
        }

        .upload-box {
            padding: 16px;
        }

        .upload-grid {
            grid-template-columns: 1fr;
        }

        .submit-row {
            flex-direction: column;
        }

        .btn-secondary,
        .submit-btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

@php
$user = auth()->user();
$lang = $user->language ?? 'id';
@endphp

<div class="pengajuan-page">
    <div class="page-head">
        <div>
            <h2 class="page-title">{{ $lang == 'en' ? 'Document Submission' : 'Pengajuan dan Upload Dokumen' }}</h2>
            <p class="page-sub">{{ $lang == 'en' ? 'Complete vehicle photos, tax, and STNK documents.' : 'Lengkapi foto kendaraan serta dokumen pajak dan STNK.' }}</p>
        </div>

        <div class="status-pill">{{ $lang == 'en' ? 'Status: Ready to Submit' : 'Status: Siap Diajukan' }}</div>
    </div>

    <!-- NOTIFIKASI ERROR (JIKA ADA GAGAL UPLOAD) -->
    @if ($errors->any())
    <div class="alert-box alert-danger">
        <strong>{{ $lang == 'en' ? 'Submission Failed:' : 'Pengajuan Gagal:' }}</strong>
        <ul style="margin: 5px 0 0 15px; padding: 0;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- JIKA SOPIR BELUM PUNYA KENDARAAN, TAMPILKAN PERINGATAN -->
    @if (!$vehicle)
    <div class="alert-box alert-warning">
        {{ $lang == 'en' 
                ? 'You have not filled in the vehicle data (Plate Number / Door Number). Please fill it in first on the Profile page to make a submission.' 
                : 'Anda belum mengisi data kendaraan (No. Polisi / No. Pintu). Silakan lengkapi terlebih dahulu di halaman Profil untuk melakukan pengajuan.' }}
        <br><br>
        <a href="{{ route('sopir.profil') }}" style="color: #92400e; font-weight: 900; text-decoration: underline;">
            {{ $lang == 'en' ? 'Go to Profile Settings' : 'Menuju Pengaturan Profil' }}
        </a>
    </div>
    @else
    <section class="driver-card">
        <div class="driver-card-title">
            <h3>{{ $lang == 'en' ? 'Driver & Vehicle Data' : 'Data Sopir dan Kendaraan' }}</h3>
            <span class="status-pill">Sopir {{ $user->name }}</span>
        </div>

        <div class="driver-grid">
            <div class="info-box">
                <span>{{ $lang == 'en' ? 'Name' : 'Nama' }}</span>
                <strong>{{ $user->name }}</strong>
            </div>

            <div class="info-box">
                <span>{{ $lang == 'en' ? 'Plate Number' : 'No. Polisi' }}</span>
                <strong>{{ $vehicle->plate_number }}</strong>
            </div>

            <div class="info-box">
                <span>{{ $lang == 'en' ? 'Door Number' : 'No. Pintu' }}</span>
                <strong>{{ $vehicle->door_number }}</strong>
            </div>

            <div class="info-box">
                <span>{{ $lang == 'en' ? 'Operational' : 'Operasional' }}</span>
                <strong>{{ $user->operational_area ?? '-' }}</strong>
            </div>

            <div class="info-box">
                <span>{{ $lang == 'en' ? 'Tax Expiry' : 'Masa Aktif Pajak' }}</span>
                <strong>{{ $vehicle->tax_expired ? \Carbon\Carbon::parse($vehicle->tax_expired)->format('d/m/Y') : '-' }}</strong>
            </div>

            <div class="info-box">
                <span>{{ $lang == 'en' ? 'STNK Expiry' : 'Masa Aktif STNK' }}</span>
                <strong>{{ $vehicle->stnk_expired ? \Carbon\Carbon::parse($vehicle->stnk_expired)->format('d/m/Y') : '-' }}</strong>
            </div>
        </div>
    </section>

    <!-- FORM ASLI PENGIRIMAN DATA -->
    <form id="pengajuanForm" action="{{ route('sopir.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

        <section class="main-upload-card">
            <div class="guide-box">
                <div class="guide-title">{{ $lang == 'en' ? 'Photo Guide' : 'Panduan Foto' }}</div>

                <div class="guide-content">
                    <div class="guide-preview">
                        <div class="guide-mini">
                            <div class="guide-mini-icon">▤</div>
                            <strong>Pajak & STNK</strong>
                        </div>

                        <div class="guide-mini">
                            <div class="guide-mini-icon">▰</div>
                            <strong>Foto Kendaraan</strong>
                        </div>
                    </div>

                    <div class="guide-list">
                        <div>
                            <span class="check">✓</span>
                            <span>{{ $lang == 'en' ? 'Ensure the vehicle plate number is clearly visible.' : 'Pastikan nomor polisi pada kendaraan terlihat jelas.' }}</span>
                        </div>

                        <div>
                            <span class="check">✓</span>
                            <span>{{ $lang == 'en' ? 'Tax and STNK photos must not be blurry or cropped.' : 'Foto pajak dan STNK tidak buram dan tidak terpotong.' }}</span>
                        </div>

                        <div>
                            <span class="check">✓</span>
                            <span>{{ $lang == 'en' ? 'Use sufficient lighting so documents can be verified easily.' : 'Gunakan pencahayaan yang cukup agar dokumen mudah diverifikasi.' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="upload-box">
                <div>
                    <h3 class="upload-title">{{ $lang == 'en' ? 'Upload Documents' : 'Upload Dokumen Pengajuan' }}</h3>
                    <p class="upload-subtitle">{{ $lang == 'en' ? 'Click the upload area to select a photo from your device (Max 5MB).' : 'Klik area upload untuk memilih foto dari perangkat (Maks 5MB).' }}</p>
                </div>

                <div class="upload-grid">
                    <!-- UPLOAD FOTO KENDARAAN -->
                    <div class="upload-item">
                        <label for="fotoKendaraan" class="upload-card" id="kendaraanUploadCard">
                            <span class="plus-icon">+</span>
                            <img src="" alt="Preview Kendaraan" class="preview-img" id="kendaraanPreview">
                        </label>

                        <div class="upload-label">{{ $lang == 'en' ? 'Vehicle Photo' : 'Foto Kendaraan' }}</div>
                        <div class="upload-note">{{ $lang == 'en' ? 'Front/side view, plate visible.' : 'Tampak depan/samping, nomor polisi terlihat.' }}</div>
                        <div class="file-name" id="kendaraanFileName"></div>

                        <input type="file" name="foto_kendaraan" id="fotoKendaraan" accept="image/jpeg,image/png,image/jpg" hidden onchange="handleUpload(this, 'kendaraanFileName', 'kendaraanPreview', 'kendaraanUploadCard')">
                    </div>

                    <!-- UPLOAD FOTO STNK & PAJAK -->
                    <div class="upload-item">
                        <label for="fotoStnk" class="upload-card" id="stnkUploadCard">
                            <span class="plus-icon">+</span>
                            <img src="" alt="Preview STNK" class="preview-img" id="stnkPreview">
                        </label>

                        <div class="upload-label">{{ $lang == 'en' ? 'STNK & Tax Photo' : 'Foto Pajak & STNK' }}</div>
                        <div class="upload-note">{{ $lang == 'en' ? 'Ensure text and expiry are readable.' : 'Pastikan tulisan dan masa aktif terbaca jelas.' }}</div>
                        <div class="file-name" id="stnkFileName"></div>

                        <input type="file" name="stnk_pajak" id="fotoStnk" accept="image/jpeg,image/png,image/jpg" hidden onchange="handleUpload(this, 'stnkFileName', 'stnkPreview', 'stnkUploadCard')">
                    </div>
                </div>

                <div class="submit-row">
                    <button type="button" class="btn-secondary" onclick="resetUpload()">{{ $lang == 'en' ? 'Cancel' : 'Batal' }}</button>
                    <button type="button" class="submit-btn" id="btnSubmitForm" onclick="submitPengajuan()">{{ $lang == 'en' ? 'Submit Application' : 'Kirim Pengajuan' }}</button>
                </div>
            </div>
        </section>
    </form>
    @endif
</div>

<div class="toast" id="toastBox">Berhasil.</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const initialTheme = "{{ $user->theme ?? 'light' }}";
        if (initialTheme === 'dark') {
            document.body.classList.add('dark-mode');
        }
    });

    const lang = "{{ $lang }}";

    function handleUpload(input, fileNameId, previewId, cardId) {
        const fileName = document.getElementById(fileNameId);
        const preview = document.getElementById(previewId);
        const card = document.getElementById(cardId);

        if (!input.files || !input.files[0]) {
            resetSpecificUpload(fileName, preview, card);
            return;
        }

        const file = input.files[0];

        // Validasi Ukuran 5MB di JS
        if (file.size > 5 * 1024 * 1024) {
            showToast(lang === 'en' ? 'File too large! Max 5MB.' : 'File terlalu besar! Maksimal 5MB.');
            input.value = '';
            resetSpecificUpload(fileName, preview, card);
            return;
        }

        fileName.innerText = file.name;
        fileName.classList.add('show');

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            card.classList.add('has-file');
        };
        reader.readAsDataURL(file);
    }

    function resetSpecificUpload(fileName, preview, card) {
        fileName.innerText = '';
        fileName.classList.remove('show');
        preview.src = '';
        card.classList.remove('has-file');
    }

    function resetUpload() {
        document.getElementById('fotoKendaraan').value = '';
        document.getElementById('fotoStnk').value = '';

        resetSpecificUpload(document.getElementById('kendaraanFileName'), document.getElementById('kendaraanPreview'), document.getElementById('kendaraanUploadCard'));
        resetSpecificUpload(document.getElementById('stnkFileName'), document.getElementById('stnkPreview'), document.getElementById('stnkUploadCard'));

        showToast(lang === 'en' ? 'Upload cancelled.' : 'Upload dibatalkan.');
    }

    function submitPengajuan() {
        const fotoKendaraan = document.getElementById('fotoKendaraan');
        const fotoStnk = document.getElementById('fotoStnk');

        if (!fotoKendaraan.files[0] || !fotoStnk.files[0]) {
            showToast(lang === 'en' ? 'Please upload both photos first.' : 'Upload foto kendaraan dan foto pajak & STNK terlebih dahulu.');
            return;
        }

        document.getElementById('btnSubmitForm').innerText = lang === 'en' ? 'Submitting...' : 'Mengirim...';

        // Submit Asli
        document.getElementById('pengajuanForm').submit();
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