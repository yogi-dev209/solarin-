@extends('layouts.admin')

@section('title', 'Reset Barcode - SolarIn')
@section('page-greeting', 'Selamat Datang, Admin')
@section('page-subtitle', 'Kelola permintaan reset barcode dari sopir')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .reset-page {
        padding-top: 18px;
    }

    .reset-title {
        font-size: 23px;
        font-weight: 800;
        margin: 0 0 18px 0;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    .summary-card {
        border: 1.5px solid #111827;
        border-radius: 10px;
        padding: 13px;
        background: #ffffff;
        min-height: 82px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .summary-card span {
        font-size: 12px;
        color: #475569;
        font-weight: 700;
    }

    .summary-card strong {
        display: block;
        font-size: 27px;
        font-weight: 900;
        margin-top: 4px;
    }

    .summary-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #eef5ff;
        color: #003b78;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        font-weight: 900;
    }

    .reset-layout {
        display: grid;
        grid-template-columns: 45% 55%;
        gap: 16px;
        align-items: start;
    }

    .panel {
        border: 1.5px solid #d1d5db;
        border-radius: 10px;
        background: #ffffff;
        overflow: hidden;
    }

    .panel-header {
        padding: 13px 15px;
        border-bottom: 1px solid #d1d5db;
        background: #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .panel-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
    }

    .panel-body {
        padding: 14px;
    }

    .reset-toolbar {
        display: grid;
        grid-template-columns: 1fr 140px;
        gap: 10px;
        margin-bottom: 12px;
    }

    .reset-search {
        height: 39px;
        border: 1.4px solid #111827;
        border-radius: 8px;
        padding: 0 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .reset-search span {
        font-size: 14px;
        color: #003b78;
    }

    .reset-search input {
        border: none;
        outline: none;
        width: 100%;
        font-size: 13px;
    }

    .filter-select {
        height: 39px;
        border: 1.4px solid #111827;
        border-radius: 8px;
        padding: 0 9px;
        font-size: 13px;
        background: white;
        outline: none;
    }

    .reset-list {
        display: flex;
        flex-direction: column;
        gap: 9px;
        max-height: 545px;
        overflow-y: auto;
        padding-right: 3px;
    }

    .reset-card {
        border: 1.4px solid #d1d5db;
        border-radius: 10px;
        padding: 11px;
        cursor: pointer;
        background: #ffffff;
        transition: .18s;
    }

    .reset-card:hover,
    .reset-card.active {
        border-color: #003b78;
        background: #eef5ff;
    }

    .reset-card-top {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        align-items: center;
        margin-bottom: 7px;
    }

    .police-number {
        font-size: 16px;
        font-weight: 900;
    }

    .door-badge {
        background: #003b78;
        color: white;
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
    }

    .reset-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        font-size: 12px;
        color: #475569;
    }

    .status-pill {
        display: inline-flex;
        padding: 4px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        margin-top: 8px;
    }

    .status-waiting {
        background: #fef3c7;
        color: #92400e;
    }

    .status-approved {
        background: #dcfce7;
        color: #15803d;
    }

    .status-rejected {
        background: #fee2e2;
        color: #b91c1c;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 14px;
    }

    .detail-box {
        border: 1.3px solid #d1d5db;
        border-radius: 9px;
        padding: 10px;
        background: #ffffff;
    }

    .detail-box span {
        display: block;
        font-size: 11px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .detail-box strong {
        font-size: 14px;
        color: #111827;
    }

    .reason-box {
        border: 1.5px solid #111827;
        border-radius: 10px;
        padding: 13px;
        margin-bottom: 14px;
    }

    .reason-box h4 {
        margin: 0 0 9px 0;
        font-size: 15px;
        font-weight: 900;
    }

    .reason-content {
        border: 1px solid #d1d5db;
        border-radius: 9px;
        background: #f8fafc;
        padding: 12px;
        font-size: 13px;
        line-height: 1.5;
        color: #334155;
    }

    .barcode-preview-wrap {
        margin-top: 14px;
        display: grid;
        grid-template-columns: 170px 1fr;
        gap: 14px;
        align-items: stretch;
    }

    .barcode-preview {
        min-height: 170px;
        border: 1.5px solid #111827;
        border-radius: 10px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .barcode-placeholder {
        width: 112px;
        height: 112px;
        background: linear-gradient(90deg, #111 9px, transparent 9px) 0 0 / 23px 23px, linear-gradient(#111 9px, transparent 9px) 0 0 / 23px 23px, #ffffff;
        border: 7px solid #111;
        opacity: .28;
    }

    .barcode-preview img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: none;
    }

    .barcode-info {
        border: 1.3px solid #d1d5db;
        border-radius: 10px;
        padding: 12px;
        background: #ffffff;
    }

    .barcode-info h4 {
        margin: 0 0 10px 0;
        font-size: 14px;
        font-weight: 900;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        border-bottom: 1px solid #e5e7eb;
        padding: 8px 0;
        font-size: 13px;
    }

    .info-row span {
        color: #64748b;
    }

    .info-row strong {
        text-align: right;
    }

    .note-area {
        width: 100%;
        min-height: 82px;
        border: 1.3px solid #9ca3af;
        border-radius: 8px;
        padding: 10px;
        font-size: 13px;
        resize: vertical;
        outline: none;
        margin-top: 12px;
    }

    .action-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 9px;
        margin-top: 12px;
    }

    .action-btn {
        height: 42px;
        border: none;
        border-radius: 9px;
        color: white;
        font-size: 13px;
        font-weight: 900;
        cursor: pointer;
        transition: .18s;
    }

    .action-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .action-btn:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 9px 18px rgba(15, 23, 42, .16);
    }

    .btn-green {
        background: #16a34a;
    }

    .btn-red {
        background: #dc2626;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        z-index: 200;
        align-items: center;
        justify-content: center;
        padding: 18px;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-box {
        width: 470px;
        max-width: 100%;
        background: white;
        border-radius: 14px;
        border: 2px solid #111827;
        padding: 20px;
        box-shadow: 0 24px 60px rgba(0, 0, 0, .25);
    }

    .modal-title {
        margin: 0 0 10px 0;
        font-size: 21px;
        font-weight: 900;
    }

    .modal-text {
        font-size: 14px;
        line-height: 1.5;
        color: #475569;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 18px;
    }

    .modal-actions button {
        border: 1px solid #111827;
        border-radius: 8px;
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
    }

    .btn-cancel {
        background: white;
        color: #111827;
    }

    .btn-primary {
        background: #003b78;
        color: white;
        border-color: #003b78 !important;
    }

    .toast {
        display: none;
        position: fixed;
        right: 24px;
        bottom: 24px;
        background: #003b78;
        color: #ffffff;
        padding: 13px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        z-index: 300;
    }

    .toast.show {
        display: block;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #64748b;
        font-weight: 700;
    }

    @media (max-width: 900px) {
        .reset-layout {
            grid-template-columns: 1fr;
        }

        .reset-list {
            max-height: none;
        }
    }

    @media (max-width: 768px) {
        .reset-page {
            padding-top: 8px;
        }

        .summary-grid,
        .reset-toolbar,
        .reset-meta,
        .detail-grid,
        .barcode-preview-wrap,
        .action-row {
            grid-template-columns: 1fr;
        }

        .modal-actions {
            flex-direction: column;
        }

        .modal-actions button {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
@php
$totalCount = $resets->count();
$approvedCount = $resets->where('status', 'disetujui')->count();
$pendingCount = $resets->where('status', 'menunggu')->count();
@endphp

<div class="reset-page">
    <h2 class="reset-title">Reset Barcode</h2>

    <div class="summary-grid">
        <div class="summary-card">
            <div>
                <span>Total Permintaan Reset</span>
                <strong>{{ $totalCount }}</strong>
            </div>
            <div class="summary-icon">R</div>
        </div>

        <div class="summary-card">
            <div>
                <span>Sudah Direset</span>
                <strong>{{ $approvedCount }}</strong>
            </div>
            <div class="summary-icon">✓</div>
        </div>

        <div class="summary-card">
            <div>
                <span>Belum Direset</span>
                <strong>{{ $pendingCount }}</strong>
            </div>
            <div class="summary-icon">!</div>
        </div>
    </div>

    <div class="reset-layout">
        <div class="panel">
            <div class="panel-header">
                <h3>Daftar Permintaan Reset</h3>
                <span id="selectedCounter">{{ $totalCount }} Data</span>
            </div>

            <div class="panel-body">
                <div class="reset-toolbar">
                    <div class="reset-search">
                        <span>⌕</span>
                        <input type="text" id="searchInput" placeholder="Cari sopir / no polisi..." onkeyup="searchReset()">
                    </div>

                    <select class="filter-select" id="statusFilter" onchange="searchReset()">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Validasi">Menunggu Validasi</option>
                        <option value="Reset Disetujui">Reset Disetujui</option>
                        <option value="Reset Ditolak">Reset Ditolak</option>
                    </select>
                </div>

                <div class="reset-list" id="resetList">
                    @forelse ($resets as $index => $reset)
                    @php
                    $statusUI = match($reset->status) {
                    'disetujui' => 'Reset Disetujui',
                    'ditolak' => 'Reset Ditolak',
                    default => 'Menunggu Validasi'
                    };

                    $statusClass = match($reset->status) {
                    'disetujui' => 'status-approved',
                    'ditolak' => 'status-rejected',
                    default => 'status-waiting'
                    };

                    $driverName = $reset->barcode->submission->vehicle->user->name ?? '-';
                    $policeNum = $reset->barcode->submission->vehicle->plate_number ?? '-';
                    $doorNum = $reset->barcode->submission->vehicle->door_number ?? '-';
                    $phone = $reset->barcode->submission->vehicle->user->phone ?? '-';
                    $area = $reset->barcode->submission->vehicle->user->operational_area ?? '-';
                    $dateStr = \Carbon\Carbon::parse($reset->created_at)->format('d/m/Y');
                    $reasonStr = $reset->reason ?? 'Permintaan reset barcode diajukan oleh sopir.';

                    $barcodeUrl = $reset->barcode && $reset->barcode->barcode_file ? asset('storage/' . $reset->barcode->barcode_file) : '';

                    $searchKeyword = strtolower("$driverName $policeNum $doorNum $statusUI $area");
                    @endphp

                    <div
                        class="reset-card {{ $index === 0 ? 'active' : '' }}"
                        data-search="{{ $searchKeyword }}"
                        data-status="{{ $statusUI }}"
                        onclick="selectReset(this, 
                                '{{ $reset->id }}', 
                                '{{ $driverName }}', 
                                '{{ $policeNum }}', 
                                '{{ $doorNum }}', 
                                '{{ $dateStr }}', 
                                '{{ $statusUI }}', 
                                '{{ $phone }}', 
                                '{{ $area }}', 
                                '{{ addslashes($reasonStr) }}',
                                '{{ $barcodeUrl }}'
                            )">
                        <div class="reset-card-top">
                            <div class="police-number">{{ $policeNum }}</div>
                            <div class="door-badge">{{ $doorNum }}</div>
                        </div>

                        <div class="reset-meta">
                            <span>Sopir: <strong>{{ $driverName }}</strong></span>
                            <span>Tanggal: <strong>{{ $dateStr }}</strong></span>
                            <span>Area: <strong>{{ $area }}</strong></span>
                        </div>

                        <span class="status-pill {{ $statusClass }}">{{ $statusUI }}</span>
                    </div>
                    @empty
                    <div class="empty-state">Tidak ada data permintaan reset.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h3>Detail Reset Barcode</h3>
                <span id="currentStatus" class="status-pill status-waiting">Pilih Data</span>
            </div>

            <div class="panel-body" id="detailPanelBody" style="display:none;">
                <div class="detail-grid">
                    <div class="detail-box"><span>ID Reset</span><strong id="detailId">-</strong></div>
                    <div class="detail-box"><span>Nama Sopir</span><strong id="detailDriver">-</strong></div>
                    <div class="detail-box"><span>No Polisi</span><strong id="detailPolice">-</strong></div>
                    <div class="detail-box"><span>No. Pintu</span><strong id="detailDoor">-</strong></div>
                    <div class="detail-box"><span>No HP</span><strong id="detailPhone">-</strong></div>
                    <div class="detail-box"><span>Area Operasional</span><strong id="detailArea">-</strong></div>
                </div>

                <div class="reason-box">
                    <h4>Alasan Permintaan Reset</h4>
                    <div class="reason-content" id="detailReason">
                        -
                    </div>

                    <div class="barcode-preview-wrap">
                        <div class="barcode-preview">
                            <div class="barcode-placeholder" id="barcodePlaceholder"></div>
                            <img id="barcodePreviewImg" alt="Barcode Lama" style="display:none;">
                        </div>

                        <div class="barcode-info">
                            <h4>Informasi Barcode</h4>

                            <div class="info-row">
                                <span>Status Barcode Lama</span>
                                <strong id="oldBarcodeStatus">Aktif</strong>
                            </div>

                            <div class="info-row">
                                <span>Status Reset</span>
                                <strong id="resetInfoStatus">Menunggu Validasi</strong>
                            </div>

                            <div class="info-row">
                                <span>Barcode Baru</span>
                                <strong id="newBarcodeStatus">Belum diterbitkan</strong>
                            </div>
                        </div>
                    </div>

                    <div id="actionContainer">
                        <textarea id="adminNote" class="note-area" placeholder="Catatan admin (Wajib diisi jika menolak reset)..."></textarea>

                        <div class="action-row">
                            <button class="action-btn btn-green" onclick="confirmAction('approve')">Setujui Reset</button>
                            <button class="action-btn btn-red" onclick="confirmAction('reject')">Tolak Reset</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="emptyPanelIndicator" class="empty-state">
                Silakan pilih data permintaan reset di panel kiri.
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <h3 class="modal-title" id="confirmTitle">Konfirmasi</h3>
        <p class="modal-text" id="confirmText">
            Pastikan data permintaan reset sudah sesuai sebelum diproses.
        </p>

        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeConfirm()">Batal</button>
            <button class="btn-primary" id="btnExecuteAction" onclick="runAction()">Ya, Proses</button>
        </div>
    </div>
</div>

<div class="toast" id="toastBox">Berhasil.</div>
@endsection

@push('scripts')
<script>
    let currentResetId = null;
    let selectedAction = '';

    document.addEventListener('DOMContentLoaded', function() {
        const firstCard = document.querySelector('.reset-card');
        if (firstCard) firstCard.click();
    });

    function selectReset(card, dbId, driver, police, door, date, status, phone, area, reason, barcodeUrl) {
        document.querySelectorAll('.reset-card').forEach(item => item.classList.remove('active'));
        card.classList.add('active');

        document.getElementById('emptyPanelIndicator').style.display = 'none';
        document.getElementById('detailPanelBody').style.display = 'block';

        currentResetId = dbId;

        // Isi Teks
        document.getElementById('detailId').innerText = 'RST-' + dbId.padStart(3, '0');
        document.getElementById('detailDriver').innerText = driver;
        document.getElementById('detailPolice').innerText = police;
        document.getElementById('detailDoor').innerText = door;
        document.getElementById('detailPhone').innerText = phone;
        document.getElementById('detailArea').innerText = area;
        document.getElementById('detailReason').innerText = reason;

        // Setel Gambar Barcode Lama
        const previewImg = document.getElementById('barcodePreviewImg');
        const placeholder = document.getElementById('barcodePlaceholder');
        if (barcodeUrl) {
            previewImg.src = barcodeUrl;
            previewImg.style.display = 'block';
            placeholder.style.display = 'none';
        } else {
            previewImg.style.display = 'none';
            placeholder.style.display = 'block';
        }

        setStatus(status);
        document.getElementById('adminNote').value = '';

        // Sembunyikan form aksi jika sudah diproses
        if (status === 'Menunggu Validasi') {
            document.getElementById('actionContainer').style.display = 'block';
        } else {
            document.getElementById('actionContainer').style.display = 'none';
        }
    }

    function setStatus(status) {
        const currentStatus = document.getElementById('currentStatus');
        currentStatus.innerText = status;
        currentStatus.className = 'status-pill';

        if (status === 'Reset Disetujui') {
            currentStatus.classList.add('status-approved');
            document.getElementById('newBarcodeStatus').innerText = 'Menunggu Diupload';
            document.getElementById('oldBarcodeStatus').innerText = 'Nonaktif (QR Inactive)';
        } else if (status === 'Reset Ditolak') {
            currentStatus.classList.add('status-rejected');
            document.getElementById('newBarcodeStatus').innerText = 'Tidak Diterbitkan';
            document.getElementById('oldBarcodeStatus').innerText = 'Tetap Aktif';
        } else {
            currentStatus.classList.add('status-waiting');
            document.getElementById('newBarcodeStatus').innerText = 'Belum diterbitkan';
            document.getElementById('oldBarcodeStatus').innerText = 'Menunggu Keputusan';
        }

        document.getElementById('resetInfoStatus').innerText = status;
    }

    function searchReset() {
        const keyword = document.getElementById('searchInput').value.trim().toLowerCase();
        const status = document.getElementById('statusFilter').value;
        const cards = document.querySelectorAll('.reset-card');
        let count = 0;

        cards.forEach(card => {
            const searchText = card.getAttribute('data-search');
            const cardStatus = card.getAttribute('data-status');

            const matchKeyword = keyword === '' || searchText.includes(keyword);
            const matchStatus = status === '' || cardStatus === status;

            const visible = matchKeyword && matchStatus;
            card.style.display = visible ? '' : 'none';

            if (visible) count++;
        });

        document.getElementById('selectedCounter').innerText = count + ' Data';
    }

    function confirmAction(action) {
        selectedAction = action;
        const note = document.getElementById('adminNote').value.trim();

        if (action === 'reject' && note === '') {
            showToast('Catatan wajib diisi saat menolak reset barcode.');
            return;
        }

        if (action === 'approve') {
            document.getElementById('confirmTitle').innerText = 'Setujui Reset Barcode';
            document.getElementById('confirmText').innerText = 'Permintaan reset akan disetujui. Barcode lama akan dinonaktifkan dan pengajuan akan pindah ke menu Upload Barcode agar Anda bisa mengunggah barcode baru.';
        } else {
            document.getElementById('confirmTitle').innerText = 'Tolak Reset Barcode';
            document.getElementById('confirmText').innerText = 'Permintaan reset akan ditolak. Alasan penolakan akan dikirimkan kepada sopir.';
        }

        document.getElementById('confirmModal').classList.add('show');
    }

    function closeConfirm() {
        document.getElementById('confirmModal').classList.remove('show');
    }

    // Eksekusi AJAX Fetch ke Laravel
    function runAction() {
        const btnExe = document.getElementById('btnExecuteAction');
        btnExe.innerText = 'Memproses...';
        btnExe.disabled = true;

        const note = document.getElementById('adminNote').value.trim();
        const url = selectedAction === 'approve' ?
            `/admin/reset-barcode/${currentResetId}/approve` :
            `/admin/reset-barcode/${currentResetId}/reject`;

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    admin_note: note
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const finalStatus = selectedAction === 'approve' ? 'Reset Disetujui' : 'Reset Ditolak';
                    setStatus(finalStatus);
                    document.getElementById('actionContainer').style.display = 'none';

                    // Update UI di list kiri (kartu aktif)
                    const activeCard = document.querySelector('.reset-card.active');
                    if (activeCard) {
                        activeCard.setAttribute('data-status', finalStatus);
                        activeCard.querySelector('.status-pill').innerText = finalStatus;
                        activeCard.querySelector('.status-pill').className = 'status-pill ' + (selectedAction === 'approve' ? 'status-approved' : 'status-rejected');
                    }

                    showToast(data.message);
                    closeConfirm();
                } else {
                    showToast(data.message || 'Gagal memproses data.');
                }
            })
            .catch(error => {
                console.error(error);
                showToast('Terjadi kesalahan jaringan.');
            })
            .finally(() => {
                btnExe.innerText = 'Ya, Proses';
                btnExe.disabled = false;
            });
    }

    function showToast(message) {
        const toast = document.getElementById('toastBox');
        toast.innerText = message;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2500);
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') closeConfirm();
    });
</script>
@endpush