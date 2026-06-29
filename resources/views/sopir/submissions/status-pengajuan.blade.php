@extends('layouts.sopir')

@section('title', 'Status Pengajuan - SolarIn')
@section('page-greeting', 'Hallo, Selamat Datang')
@section('page-subtitle', 'Pantau progres dokumenmu di sini.')

@push('styles')
<style>
    .status-page {
        padding-top: 18px;
        min-height: 100vh;
    }

    .page-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 14px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 900;
        margin: 0;
        color: #111827;
    }

    .title-line {
        border-bottom: 2px solid #9ca3af;
        margin-bottom: 24px;
    }

    .search-box {
        width: 430px;
        max-width: 100%;
        height: 43px;
        border: 1.7px solid #111827;
        border-radius: 11px;
        background: #ffffff;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 13px;
        transition: all 0.3s ease;
    }

    .search-icon {
        font-size: 25px;
        font-weight: 900;
        color: #08733f;
        line-height: 1;
    }

    .search-box input {
        border: none;
        outline: none;
        width: 100%;
        min-width: 0;
        font-size: 13px;
        color: #111827;
        background: transparent;
    }

    .search-box input::placeholder {
        color: #94a3b8;
    }

    .clear-btn {
        width: 24px;
        height: 24px;
        border: none;
        background: #f1f5f9;
        color: #111827;
        border-radius: 50%;
        font-size: 28px;
        line-height: 1;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .clear-btn:hover {
        background: #e5e7eb;
    }

    .tab-row {
        display: flex;
        align-items: center;
        gap: 28px;
        border-bottom: 2px solid #9ca3af;
        margin-bottom: 18px;
        overflow-x: auto;
        white-space: nowrap;
    }

    .tab-btn {
        border: none;
        background: transparent;
        padding: 0 0 10px 0;
        font-size: 18px;
        font-weight: 400;
        color: #111827;
        cursor: pointer;
        position: relative;
    }

    .tab-btn.active {
        font-weight: 900;
    }

    .tab-btn.active::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 100%;
        height: 4px;
        background: #111827;
        border-radius: 999px;
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .status-table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        min-width: 620px;
        transition: all 0.3s ease;
    }

    .status-table th {
        background: #d9d9d9;
        border: 1px solid #c9c9c9;
        padding: 14px 9px;
        font-size: 14px;
        font-weight: 700;
        text-align: left;
        color: #111827;
    }

    .status-table td {
        border: 1px solid #d9d9d9;
        padding: 14px 9px;
        font-size: 14px;
        line-height: 1.35;
        color: #111827;
        vertical-align: middle;
    }

    .date-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #e5e5e5;
        border-radius: 999px;
        padding: 4px 9px;
        min-width: 92px;
        font-weight: 700;
    }

    .empty-row {
        display: none;
        padding: 24px;
        border: 1px solid #d9d9d9;
        background: #ffffff;
        text-align: center;
        font-size: 15px;
        font-weight: 800;
        color: #64748b;
    }

    .empty-row.show {
        display: block;
    }

    /* STATUS WARNA WARNI (TIDAK ADA REVISI) */
    .badge-status {
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 900;
    }

    .status-menunggu {
        background: #fef08a;
        color: #854d0e;
        border: 1px solid #fde047;
    }

    .status-proses {
        background: #bae6fd;
        color: #0369a1;
        border: 1px solid #7dd3fc;
    }

    .status-setuju {
        background: #bbf7d0;
        color: #166534;
        border: 1px solid #86efac;
    }

    .status-tolak {
        background: #fecaca;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    /* DARK MODE */
    body.dark-mode {
        background-color: #0f172a !important;
        color: #e5e7eb !important;
    }

    body.dark-mode .page-title,
    body.dark-mode .tab-btn {
        color: #f8fafc !important;
    }

    body.dark-mode .search-box {
        background: #1e293b !important;
        border-color: #334155 !important;
    }

    body.dark-mode .search-box input {
        color: #f8fafc !important;
    }

    body.dark-mode .clear-btn {
        background: #334155 !important;
        color: #e5e7eb !important;
    }

    body.dark-mode .tab-btn.active::after {
        background: #38bdf8 !important;
    }

    body.dark-mode .status-table {
        background: #1e293b !important;
    }

    body.dark-mode .status-table th {
        background: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    body.dark-mode .status-table td {
        border-color: #334155 !important;
        color: #e5e7eb !important;
    }

    body.dark-mode .date-pill {
        background: #334155 !important;
        color: #f8fafc !important;
    }

    body.dark-mode .empty-row {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }

    @media (max-width: 900px) {
        .tab-row {
            gap: 34px;
        }
    }

    @media (max-width: 768px) {
        .page-head {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .page-title {
            font-size: 20px;
        }

        .search-box {
            width: 100%;
            height: 41px;
        }

        .title-line {
            margin-bottom: 18px;
        }
    }
</style>
@endpush

@section('content')

@php
$user = auth()->user();
$lang = $user->language ?? 'id';
@endphp

<div class="status-page">
    @if (session('success'))
    <div style="background: #dcfce7; border: 1.5px solid #4ade80; color: #166534; padding: 12px 16px; border-radius: 12px; margin-bottom: 15px; font-weight: 700; font-size: 14px;">
        ✓ {{ session('success') }}
    </div>
    @endif

    <div class="page-head">
        <h2 class="page-title">{{ $lang == 'en' ? 'Submission Status' : 'Status Pengajuan' }}</h2>

        <div class="search-box">
            <span class="search-icon">⌕</span>
            <input type="text" id="searchInput" placeholder="{{ $lang == 'en' ? 'Search ID / vehicle / status...' : 'Cari ID / kendaraan / status...' }}" onkeyup="filterData()">
            <button type="button" class="clear-btn" onclick="clearSearch()">×</button>
        </div>
    </div>

    <div class="title-line"></div>

    <div class="tab-row">
        <button class="tab-btn active" data-status="Semua" onclick="setTab(this, 'Semua')">{{ $lang == 'en' ? 'All' : 'Semua' }}</button>
        <button class="tab-btn" data-status="Menunggu" onclick="setTab(this, 'Menunggu')">{{ $lang == 'en' ? 'Waiting' : 'Menunggu' }}</button>
        <button class="tab-btn" data-status="Diproses" onclick="setTab(this, 'Diproses')">{{ $lang == 'en' ? 'Processing' : 'Diproses' }}</button>
        <button class="tab-btn" data-status="Disetujui" onclick="setTab(this, 'Disetujui')">{{ $lang == 'en' ? 'Approved' : 'Disetujui' }}</button>
        <button class="tab-btn" data-status="Ditolak" onclick="setTab(this, 'Ditolak')">{{ $lang == 'en' ? 'Rejected' : 'Ditolak' }}</button>
    </div>

    <div class="table-wrap">
        <table class="status-table">
            <thead>
                <tr>
                    <th>{{ $lang == 'en' ? 'Submission ID' : 'ID Pengajuan' }}</th>
                    <th>{{ $lang == 'en' ? 'Date' : 'Tanggal' }}</th>
                    <th>{{ $lang == 'en' ? 'Vehicle' : 'Kendaraan' }}</th>
                    <th>Status</th>
                    <th>{{ $lang == 'en' ? 'Admin Note' : 'Catatan Admin' }}</th>
                </tr>
            </thead>

            <tbody id="statusTableBody">
                @forelse ($submissions as $sub)
                @php
                // Mapping Status Database ke UI (Tampilan)
                $statusUI = 'Menunggu';
                $badgeClass = 'status-menunggu';

                if (in_array($sub->status, ['diproses', 'proses_pembuatan_barcode'])) {
                $statusUI = 'Diproses';
                $badgeClass = 'status-proses';
                } elseif ($sub->status == 'barcode_terbit' || $sub->status == 'disetujui') {
                $statusUI = 'Disetujui';
                $badgeClass = 'status-setuju';
                } elseif ($sub->status == 'ditolak') {
                $statusUI = 'Ditolak';
                $badgeClass = 'status-tolak';
                }

                if ($lang == 'en') {
                $statusUI = match($statusUI) {
                'Menunggu' => 'Waiting',
                'Diproses' => 'Processing',
                'Disetujui' => 'Approved',
                'Ditolak' => 'Rejected',
                default => $statusUI
                };
                }

                $dateStr = \Carbon\Carbon::parse($sub->submission_date)->format('d/m/Y');

                $searchKeyword = strtolower($sub->submission_code . " " . $dateStr . " " . $sub->vehicle->plate_number . " " . $statusUI . " " . ($sub->rejection_reason ?? ''));
                @endphp

                <tr data-status="{{ $statusUI }}" data-search="{{ $searchKeyword }}">
                    <td style="font-weight: 900; color: #08733f;">{{ $sub->submission_code }}</td>
                    <td><span class="date-pill">{{ $dateStr }}</span></td>
                    <td style="font-weight: 700;">{{ $sub->vehicle->plate_number }}</td>
                    <td><span class="badge-status {{ $badgeClass }}">{{ $statusUI }}</span></td>
                    <td style="font-size: 13px; font-style: italic;">
                        {{ $sub->rejection_reason ?? ($lang == 'en' ? 'No notes.' : 'Tidak ada catatan.') }}
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="empty-row {{ $submissions->isEmpty() ? 'show' : '' }}" id="emptyRow">
        {{ $lang == 'en' ? 'No submission data found.' : 'Data pengajuan tidak ditemukan.' }}
    </div>
</div>
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
    let activeStatus = 'Semua';

    function setTab(button, statusID) {
        let mappingStatus = statusID;

        if (lang === 'en') {
            if (statusID === 'Menunggu') mappingStatus = 'Waiting';
            if (statusID === 'Diproses') mappingStatus = 'Processing';
            if (statusID === 'Disetujui') mappingStatus = 'Approved';
            if (statusID === 'Ditolak') mappingStatus = 'Rejected';
        }

        activeStatus = mappingStatus;

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        button.classList.add('active');
        filterData();
    }

    function filterData() {
        const keyword = document.getElementById('searchInput').value.trim().toLowerCase();
        const rows = document.querySelectorAll('#statusTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            const searchText = row.getAttribute('data-search');

            const matchStatus = (activeStatus === 'Semua' || activeStatus === 'All') || (rowStatus === activeStatus);
            const matchKeyword = keyword === '' || searchText.includes(keyword);

            if (matchStatus && matchKeyword) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const emptyEl = document.getElementById('emptyRow');
        if (visibleCount === 0) {
            emptyEl.classList.add('show');
        } else {
            emptyEl.classList.remove('show');
        }
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        filterData();
    }
</script>
@endpush