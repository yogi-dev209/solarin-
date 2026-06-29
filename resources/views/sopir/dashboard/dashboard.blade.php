@extends('layouts.sopir')

@section('title', 'Dashboard Sopir - SolarIn')
@section('page-greeting', 'Hallo, Selamat Datang')
@section('page-subtitle', 'Sudah Siap Untuk Pengajuan?')

@push('styles')
<style>
    .dashboard-sopir {
        padding-top: 18px;
    }

    .dashboard-title {
        font-size: 24px;
        font-weight: 900;
        margin: 0 0 42px 0;
        color: #111827;
    }

    /* BANNER PERINGATAN STNK/PAJAK */
    .warning-banner {
        background: #fee2e2;
        border: 2px solid #ef4444;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 34px;
        color: #991b1b;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
    }
    .warning-title {
        margin: 0 0 8px 0;
        font-size: 16px;
        font-weight: 900;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .warning-list {
        margin: 0;
        padding-left: 22px;
        font-size: 14px;
        line-height: 1.5;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 13px;
        margin-bottom: 50px;
    }

    .summary-card {
        border: 2px solid #111827;
        border-radius: 20px;
        background: #ffffff;
        min-height: 148px;
        overflow: hidden;
        transition: .2s;
    }

    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,.1);
    }

    .summary-card h3 {
        margin: 0;
        padding: 10px 12px;
        text-align: center;
        font-size: 24px;
        font-weight: 900;
        border-bottom: 1.5px solid #111827;
        color: #111827;
    }

    .summary-body {
        min-height: 96px;
        padding: 12px 16px 10px 16px;
        display: grid;
        grid-template-columns: 72px 1fr;
        align-items: center;
        gap: 10px;
    }

    .summary-icon {
        width: 66px;
        height: 58px;
        color: #08733f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 46px;
        font-weight: 900;
        line-height: 1;
    }

    .summary-number {
        font-size: 40px;
        font-weight: 400;
        color: #111827;
        text-align: center;
        line-height: 1;
    }

    .summary-desc {
        grid-column: 1 / 3;
        text-align: center;
        font-size: 12px;
        color: #111827;
        margin-top: 2px;
    }

    .bottom-section {
        border-top: 2px solid #9ca3af;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 265px;
        gap: 28px;
        padding-top: 28px;
    }

    .status-section {
        padding: 0 0 0 6px;
    }

    .section-title {
        text-align: center;
        font-size: 25px;
        font-weight: 900;
        margin: 0 0 40px 0;
        color: #111827;
    }

    .status-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .status-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 430px;
        background: #ffffff;
    }

    .status-table th {
        background: #d9d9d9;
        border: 1px solid #c9c9c9;
        padding: 16px 12px;
        font-size: 20px;
        font-weight: 400;
        text-align: center;
        color: #111827;
    }

    .status-table td {
        border: 1px solid #d9d9d9;
        padding: 10px 12px;
        font-size: 18px;
        text-align: center;
        color: #111827;
        border-bottom: 1px solid #f3f4f6;
    }

    .status-table tr:hover td {
        background: #f8fafc;
    }

    .date-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #e5e5e5;
        border-radius: 999px;
        padding: 4px 13px;
        min-width: 118px;
    }

    .notification-panel {
        border: 1.7px solid #111827;
        border-radius: 22px;
        background: #ffffff;
        overflow: hidden;
        align-self: start;
    }

    .notification-title {
        margin: 0;
        padding: 12px 14px;
        border-bottom: 1.5px solid #111827;
        text-align: center;
        font-size: 25px;
        font-weight: 900;
        color: #111827;
    }

    .notification-list {
        padding: 16px 14px 18px 18px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .notification-item {
        display: grid;
        grid-template-columns: 31px 1fr;
        gap: 10px;
        align-items: flex-start;
    }

    .notif-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #08733f;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 900;
        margin-top: 1px;
    }

    .notif-text {
        font-size: 13px;
        line-height: 1.35;
        color: #111827;
    }

    @media (max-width: 1000px) {
        .dashboard-title { margin-bottom: 28px; }
        .summary-grid { gap: 10px; margin-bottom: 36px; }
        .summary-card h3 { font-size: 21px; }
        .summary-number { font-size: 36px; }
        .bottom-section { grid-template-columns: 1fr; }
        .notification-panel { max-width: 100%; }
    }

    @media (max-width: 768px) {
        .dashboard-sopir { padding-top: 8px; }
        .dashboard-title { font-size: 21px; margin-bottom: 18px; }
        .summary-grid { grid-template-columns: 1fr; margin-bottom: 24px; }
        .summary-card { min-height: 125px; border-radius: 16px; }
        .summary-card h3 { font-size: 20px; padding: 9px; }
        .summary-body { min-height: 78px; grid-template-columns: 62px 1fr; }
        .summary-icon { width: 58px; height: 50px; font-size: 36px; }
        .summary-number { font-size: 32px; }
        .summary-desc { font-size: 11px; }
        .bottom-section { padding-top: 18px; gap: 20px; }
        .section-title, .notification-title { font-size: 20px; }
        .section-title { margin-bottom: 18px; }
        .status-table th, .status-table td { font-size: 15px; padding: 10px 8px; }
        .date-pill { min-width: 95px; padding: 3px 8px; }
        .notification-panel { border-radius: 16px; }
        .notification-list { gap: 14px; }
        .notif-text { font-size: 12px; }
    }
</style>
@endpush

@section('content')
<div class="dashboard-sopir">
    <h2 class="dashboard-title">Dashboard</h2>

    {{-- KOTAK PERINGATAN JIKA STNK / PAJAK MATI --}}
    @if($stnkExpired || $pajakExpired || $stnkNearExp || $pajakNearExp)
    <div class="warning-banner">
        <h4 class="warning-title"><span>⚠️</span> Peringatan Masa Berlaku Kendaraan</h4>
        <ul class="warning-list">
            @if($stnkExpired) <li>Masa berlaku <strong>STNK</strong> kendaraan Anda telah habis.</li> @endif
            @if($pajakExpired) <li>Masa berlaku <strong>Pajak</strong> kendaraan Anda telah habis.</li> @endif
            @if($stnkNearExp) <li>Masa berlaku <strong>STNK</strong> kendaraan Anda akan segera habis (kurang dari 30 hari).</li> @endif
            @if($pajakNearExp) <li>Masa berlaku <strong>Pajak</strong> kendaraan Anda akan segera habis (kurang dari 30 hari).</li> @endif
        </ul>
    </div>
    @endif

    <div class="summary-grid">
        <div class="summary-card">
            <h3>Pengajuan</h3>
            <div class="summary-body">
                <div class="summary-icon">▧</div>
                {{-- Mengambil jumlah pengajuan milik sopir yang sedang login --}}
                <div class="summary-number">{{ \App\Models\Submission::whereHas('vehicle', function($q){ $q->where('user_id', auth()->id()); })->count() }}</div>
                <div class="summary-desc">Total pengajuan dilakukan</div>
            </div>
        </div>

        <div class="summary-card">
            <h3>Revisi Dokumen</h3>
            <div class="summary-body">
                <div class="summary-icon">▤</div>
                <div class="summary-number">{{ $dokumenRevisi }}</div>
                <div class="summary-desc">Dokumen yang perlu diperbaiki</div>
            </div>
        </div>

        <div class="summary-card">
            <h3>Reset Barcode</h3>
            <div class="summary-body">
                <div class="summary-icon">↻</div>
                {{-- Mengambil jumlah reset barcode milik sopir yang sedang login --}}
                <div class="summary-number">{{ \App\Models\BarcodeResetRequest::whereHas('barcode.submission.vehicle', function($q){ $q->where('user_id', auth()->id()); })->count() }}</div>
                <div class="summary-desc">Total pengajuan reset</div>
            </div>
        </div>
    </div>

    <div class="bottom-section">
        <section class="status-section">
            <h3 class="section-title">Riwayat Aktivitas Pengajuan</h3>

            <div class="status-table-wrap">
                <table class="status-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kendaraan</th>
                            <th>Status Aktivitas</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($activityLogs as $log)
                            @php
                                // Menerjemahkan kode status dari database menjadi teks yang mudah dibaca
                                $actionLabels = [
                                    'pengajuan_dibuat'     => 'Pengajuan Dibuat',
                                    'dokumen_diupload'     => 'Dokumen Diupload',
                                    'dokumen_diverifikasi' => 'Dokumen Diverifikasi',
                                    'dokumen_direvisi'     => 'Dokumen Direvisi',
                                    'dokumen_ditolak'      => 'Dokumen Ditolak',
                                    'status_berubah'       => 'Status Berubah',
                                    'barcode_diterbitkan'  => 'Barcode Diterbitkan',
                                    'reset_diajukan'       => 'Reset Diajukan',
                                    'reset_disetujui'      => 'Reset Disetujui',
                                    'reset_ditolak'        => 'Reset Ditolak',
                                    'pengajuan_sanggah'    => 'Pengajuan Sanggah'
                                ];
                                $label = $actionLabels[$log->action] ?? ucwords(str_replace('_', ' ', $log->action));
                                $tgl = \Carbon\Carbon::parse($log->created_at)->format('d/m/Y');
                                $nopol = $vehicle->plate_number ?? '-';
                            @endphp
                            <tr>
                                <td><span class="date-pill">{{ $tgl }}</span></td>
                                <td>{{ $nopol }}</td>
                                <td>{{ $label }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="padding: 30px; color: #6b7280;">Belum ada aktivitas pengajuan tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="notification-panel">
            <h3 class="notification-title">Notifikasi Terbaru</h3>

            <div class="notification-list">
                @forelse($notifications as $notif)
                    @php
                        // Menentukan inisial huruf dari tipe notifikasi (P, R, D, B, N)
                        $iconNotif = match($notif->type) {
                            'pengajuan' => 'P', 'reset' => 'R', 'dokumen' => 'D', 'barcode' => 'B', default => 'N'
                        };
                    @endphp
                    <div class="notification-item">
                        <div class="notif-icon">{{ $iconNotif }}</div>
                        <div class="notif-text">
                            <strong>{{ $notif->title }}</strong><br>
                            {{ Str::limit($notif->message, 65) }}<br>
                            <span style="font-size: 11px; color: #6b7280; display: block; margin-top: 5px;">
                                {{ $notif->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #6b7280; font-size: 13px; padding: 20px 0;">Belum ada notifikasi.</div>
                @endforelse
            </div>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.Echo !== 'undefined') {
            console.log('Driver mencoba join presence channel...');
            window.Echo.join('chat-room')
                .here((users) => {
                    console.log('Driver: daftar user online:', users);
                })
                .joining((user) => {
                    console.log('Driver: user lain bergabung:', user);
                })
                .leaving((user) => {
                    console.log('Driver: user lain meninggalkan:', user);
                })
                .error((error) => {
                    console.error('Driver: error presence:', error);
                });
        } else {
            console.warn('Echo tidak tersedia di halaman driver.');
        }
    });
</script>
@endpush