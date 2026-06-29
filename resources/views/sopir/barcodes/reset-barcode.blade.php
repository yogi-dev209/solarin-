@extends('layouts.sopir')

@section('title', 'Reset Barcode - SolarIn')
@section('page-greeting', 'Hallo, Selamat Datang')
@section('page-subtitle', 'Ajukan reset jika barcode hilang atau rusak.')

@push('styles')
<style>
    .reset-page {
        padding-top: 18px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 900;
        margin: 0 0 36px 0;
        color: #111827;
    }

    .top-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.08fr) minmax(360px, .92fr);
        gap: 34px;
        align-items: center;
        margin-bottom: 24px;
    }

    .progress-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 28px 22px;
        min-height: 230px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1.8px solid #111827;
    }

    .reset-progress {
        width: 100%;
        max-width: 540px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        position: relative;
    }

    .reset-progress::before {
        content: "";
        position: absolute;
        left: 12%;
        right: 12%;
        top: 39px;
        height: 3px;
        background: #e5e7eb;
        z-index: 0;
    }

    .step {
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .step-icon {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #9ca3af;
        margin: 0 auto 8px auto;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        font-weight: 900;
        box-shadow: 0 0 0 8px #ffffff;
        border: 2px solid #e5e7eb;
    }

    .step.active .step-icon {
        background: #08733f;
        color: #ffffff;
        border-color: #08733f;
    }

    .step-number {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #e5e7eb;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 7px auto;
        font-size: 11px;
        font-weight: 900;
    }

    .step.active .step-number {
        background: #08733f;
        color: #ffffff;
    }

    .step-label {
        font-size: 13px;
        font-weight: 900;
        color: #6b7280;
    }

    .step.active .step-label {
        color: #08733f;
    }

    .barcode-info-box {
        border: 1.8px solid #111827;
        border-radius: 22px;
        background: #ffffff;
        min-height: 230px;
        padding: 22px 24px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 18px;
    }

    .info-row {
        display: grid;
        grid-template-columns: 165px 10px 1fr;
        gap: 4px;
        font-size: 20px;
        line-height: 1.3;
        color: #111827;
    }

    .info-row span {
        font-weight: 400;
    }

    .info-row strong {
        font-weight: 800;
    }

    .reason-box {
        border: 1.8px solid #111827;
        border-radius: 22px;
        background: #ffffff;
        overflow: hidden;
        margin-top: 20px;
    }

    .reason-title {
        width: fit-content;
        min-width: 290px;
        padding: 12px 18px;
        border-bottom: 1.5px solid #111827;
        font-size: 23px;
        font-weight: 900;
        color: #111827;
    }

    .reason-area {
        width: 100%;
        min-height: 125px;
        border: none;
        outline: none;
        resize: vertical;
        padding: 16px 18px;
        font-size: 15px;
        line-height: 1.5;
        font-family: Arial, sans-serif;
        color: #111827;
    }

    .reason-area:disabled {
        background: #f8fafc;
        cursor: not-allowed;
    }

    .bottom-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        margin-top: 15px;
        padding: 0 58px 0 34px;
    }

    .agree-box {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 21px;
        color: #111827;
        cursor: pointer;
    }

    .agree-box input {
        width: 26px;
        height: 26px;
        accent-color: #08733f;
        cursor: pointer;
    }

    .agree-box input:disabled {
        cursor: not-allowed;
    }

    .submit-btn {
        width: 124px;
        height: 58px;
        border: 3px solid #111827;
        background: #ffffff;
        color: #111827;
        font-size: 15px;
        font-weight: 900;
        cursor: pointer;
        transition: .18s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .submit-btn:hover:not(:disabled) {
        background: #08733f;
        border-color: #08733f;
        color: #ffffff;
    }

    .submit-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .alert-box {
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 18px;
        font-size: 14px;
        font-weight: 700;
        border: 1.5px solid;
    }

    .alert-danger {
        background: #fef2f2;
        border-color: #f87171;
        color: #991b1b;
    }

    .alert-success {
        background: #dcfce7;
        border-color: #4ade80;
        color: #166534;
    }

    @media (max-width: 1000px) {
        .top-layout {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .bottom-row {
            padding: 0;
        }
    }

    @media (max-width: 768px) {
        .reset-page {
            padding-top: 8px;
        }

        .step-icon {
            width: 44px;
            height: 44px;
            font-size: 17px;
        }

        .info-row {
            grid-template-columns: 130px 10px 1fr;
            font-size: 15px;
        }

        .reason-title {
            width: 100%;
            font-size: 18px;
        }

        .bottom-row {
            flex-direction: column;
            align-items: stretch;
        }

        .submit-btn {
            width: 100%;
            height: 52px;
        }
    }
</style>
@endpush

@section('content')

@php
$step = 1; // Default: 1. Pengajuan
if ($alreadyRequested) {
$step = 2; // Menunggu verifikasi admin
if ($activeReset && $activeReset->status == 'disetujui') {
$step = 3; // Menunggu diupload ulang
}
}
@endphp

<div class="reset-page">
    <h2 class="page-title">Ajukan Reset</h2>

    @if (session('success'))
    <div class="alert-box alert-success">✓ {{ session('success') }}</div>
    @endif
    @if ($errors->any())
    <div class="alert-box alert-danger">
        <strong>Gagal:</strong>
        <ul style="margin: 5px 0 0 15px; padding: 0;">
            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
    @endif

    <div class="top-layout">
        <section class="progress-card">
            <div class="reset-progress">
                <div class="step {{ $step >= 1 ? 'active' : '' }}">
                    <div class="step-icon">▤</div>
                    <div class="step-number">1</div>
                    <div class="step-label">Pengajuan</div>
                </div>
                <div class="step {{ $step >= 2 ? 'active' : '' }}">
                    <div class="step-icon">♙</div>
                    <div class="step-number">2</div>
                    <div class="step-label">Verifikasi</div>
                </div>
                <div class="step {{ $step >= 3 ? 'active' : '' }}">
                    <div class="step-icon">↻</div>
                    <div class="step-number">3</div>
                    <div class="step-label">Reset Barcode</div>
                </div>
                <div class="step {{ $step >= 4 ? 'active' : '' }}">
                    <div class="step-icon">✓</div>
                    <div class="step-number">4</div>
                    <div class="step-label">Selesai</div>
                </div>
            </div>
        </section>

        <section class="barcode-info-box">
            <div class="info-row">
                <span>Nama Pemilik</span><span>:</span>
                <strong>{{ $barcode->submission->vehicle->user->name }}</strong>
            </div>
            <div class="info-row">
                <span>No. Polisi</span><span>:</span>
                <strong>{{ $barcode->submission->vehicle->plate_number }}</strong>
            </div>
            <div class="info-row">
                <span>No. Pintu</span><span>:</span>
                <strong>{{ $barcode->submission->vehicle->door_number }}</strong>
            </div>
            <div class="info-row">
                <span>Status Barcode</span><span>:</span>
                <strong>{{ $alreadyRequested ? 'Menunggu Reset' : 'Aktif' }}</strong>
            </div>
        </section>
    </div>

    <form action="{{ route('sopir.reset-barcode.store') }}" method="POST" id="resetForm">
        @csrf
        <section class="reason-box">
            <div class="reason-title">Alasan Pengajuan Reset</div>
            <textarea
                name="reason"
                id="reasonInput"
                class="reason-area"
                placeholder="Contoh: Kertas barcode robek / hilang..."
                {{ $alreadyRequested ? 'disabled' : 'required' }}>{{ old('reason', $activeReset->reason ?? '') }}</textarea>
        </section>

        <div class="bottom-row">
            <label class="agree-box">
                <input type="checkbox" name="confirmed" id="agreeCheck" value="1" {{ $alreadyRequested ? 'disabled checked' : 'required' }}>
                <span>Saya menyatakan alasan yang saya berikan benar.</span>
            </label>

            <button type="submit" class="submit-btn" id="btnSubmit" {{ $alreadyRequested ? 'disabled' : '' }}>
                {{ $alreadyRequested ? 'Diproses' : 'Kirim' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('resetForm').addEventListener('submit', function(e) {
        if (!document.getElementById('agreeCheck').checked) {
            e.preventDefault();
            alert('Centang pernyataan kebenaran data terlebih dahulu.');
            return false;
        }

        document.getElementById('btnSubmit').innerText = 'Mengirim...';
        document.getElementById('btnSubmit').style.pointerEvents = 'none';
    });
</script>
@endpush