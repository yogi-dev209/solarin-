@extends('layouts.admin')

@section('title', 'Monitoring Pengajuan - SolarIn')
@section('page-greeting', 'Selamat Datang, Admin')
@section('page-subtitle', 'Pantau perkembangan status pengajuan barcode solar subsidi')

@push('styles')
<style>
    .monitor-page {
        padding-top: 18px;
        min-height: 100vh;
    }

    .monitor-title {
        font-size: 23px;
        font-weight: 800;
        margin: 0 0 18px 0;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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
        font-size: 18px;
        font-weight: 900;
    }

    .monitor-layout {
        display: grid;
        grid-template-columns: 44% 56%;
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

    .monitor-toolbar {
        display: grid;
        grid-template-columns: 1fr 150px;
        gap: 10px;
        margin-bottom: 12px;
    }

    .monitor-search {
        height: 39px;
        border: 1.4px solid #111827;
        border-radius: 8px;
        padding: 0 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .monitor-search span {
        font-size: 14px;
        color: #003b78;
        font-weight: 900;
    }

    .monitor-search input {
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

    .monitor-list {
        display: flex;
        flex-direction: column;
        gap: 9px;
        max-height: 545px;
        overflow-y: auto;
        padding-right: 3px;
    }

    .monitor-card {
        border: 1.4px solid #d1d5db;
        border-radius: 10px;
        padding: 11px;
        cursor: pointer;
        background: #ffffff;
        transition: .18s;
    }

    .monitor-card:hover,
    .monitor-card.active {
        border-color: #003b78;
        background: #eef5ff;
    }

    .monitor-card-top {
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

    .monitor-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        font-size: 12px;
        color: #475569;
    }

    /* STATUS PILL */
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

    .status-process {
        background: #dbeafe;
        color: #1d4ed8;
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

    /* PROGRESS TRACKER */
    .progress-box {
        border: 1.5px solid #111827;
        border-radius: 10px;
        padding: 13px;
        margin-bottom: 14px;
    }

    .progress-head {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
    }

    .progress-head h4 {
        margin: 0;
        font-size: 15px;
        font-weight: 900;
    }

    .progress-percent {
        font-size: 14px;
        font-weight: 900;
        color: #003b78;
    }

    .progress-track {
        height: 12px;
        background: #e5e7eb;
        border-radius: 999px;
        overflow: hidden;
        border: 1px solid #d1d5db;
    }

    .progress-fill {
        height: 100%;
        width: 0%;
        background: #003b78;
        transition: width 0.4s ease;
    }

    .step-list {
        margin-top: 15px;
        display: grid;
        gap: 10px;
    }

    .step-item {
        display: grid;
        grid-template-columns: 34px 1fr;
        gap: 9px;
        align-items: flex-start;
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 9px;
        background: #ffffff;
        opacity: 0.5;
        transition: 0.3s;
    }

    .step-item.current {
        opacity: 1;
        border-color: #003b78;
        background: #eef5ff;
    }

    .step-item.done {
        opacity: 1;
    }

    .step-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid #9ca3af;
        background: #ffffff;
        color: #111827;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 900;
    }

    .step-item.done .step-circle {
        background: #15803d;
        border-color: #15803d;
        color: #fff;
    }

    .step-item.current .step-circle {
        border-color: #003b78;
        color: #003b78;
    }

    .step-content strong {
        display: block;
        font-size: 13px;
        margin-bottom: 3px;
    }

    .step-content span {
        font-size: 12px;
        color: #64748b;
        line-height: 1.4;
    }

    .readonly-info {
        margin-top: 12px;
        padding: 11px 12px;
        border-radius: 9px;
        background: #eef5ff;
        border: 1.3px solid #bfdbfe;
        color: #1d4ed8;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.45;
    }

    .action-row {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 14px;
    }

    .btn {
        border: 1px solid #111827;
        border-radius: 8px;
        min-height: 38px;
        padding: 0 13px;
        background: #ffffff;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        color: #111827;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary {
        background: #003b78;
        color: #ffffff;
        border-color: #003b78;
    }

    /* MODAL */
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

    .history-box {
        border: 1.3px solid #d1d5db;
        border-radius: 10px;
        padding: 12px;
        background: #f8fafc;
        margin-top: 14px;
    }

    .history-item {
        display: grid;
        grid-template-columns: 23px 1fr;
        gap: 8px;
        margin-bottom: 10px;
        font-size: 12px;
    }

    .history-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #003b78;
        margin-top: 2px;
    }

    .history-item strong {
        display: block;
        font-size: 12px;
        margin-bottom: 2px;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #64748b;
        font-weight: 700;
    }

    @media (max-width: 900px) {
        .monitor-layout {
            grid-template-columns: 1fr;
        }

        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .monitor-page {
            padding-top: 8px;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .monitor-toolbar {
            grid-template-columns: 1fr;
        }

        .monitor-meta,
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .action-row,
        .modal-actions {
            flex-direction: column;
        }

        .btn,
        .modal-actions button {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

@php
// Menghitung statistik langsung dari database (semua data pengajuan)
$totalCount = \App\Models\Submission::count();
$processCount = \App\Models\Submission::whereIn('status', ['diproses', 'disetujui', 'menunggu_upload_barcode', 'menunggu_penerbitan'])->count();
$barcodeCount = \App\Models\Submission::where('status', 'barcode_terbit')->count();
$rejectedCount = \App\Models\Submission::where('status', 'ditolak')->count();
@endphp

<div class="monitor-page">
    <h2 class="monitor-title">Monitoring Pengajuan</h2>

    <!-- SUMMARY CARDS (Dinamis dari Database) -->
    <div class="summary-grid">
        <div class="summary-card">
            <div>
                <span>Total Pengajuan</span>
                <strong>{{ $totalCount }}</strong>
            </div>
            <div class="summary-icon">T</div>
        </div>

        <div class="summary-card">
            <div>
                <span>Dalam Proses</span>
                <strong>{{ $processCount }}</strong>
            </div>
            <div class="summary-icon">P</div>
        </div>

        <div class="summary-card">
            <div>
                <span>Barcode Tersedia</span>
                <strong>{{ $barcodeCount }}</strong>
            </div>
            <div class="summary-icon">B</div>
        </div>

        <div class="summary-card">
            <div>
                <span>Ditolak</span>
                <strong>{{ $rejectedCount }}</strong>
            </div>
            <div class="summary-icon">R</div>
        </div>
    </div>

    <div class="monitor-layout">
        <!-- PANEL KIRI: LIST MONITORING -->
        <div class="panel">
            <div class="panel-header">
                <h3>Daftar Pengajuan Aktif</h3>
                <span id="selectedCounter">{{ $submissions->count() }} Data</span>
            </div>

            <div class="panel-body">
                <div class="monitor-toolbar">
                    <div class="monitor-search">
                        <span>⌕</span>
                        <input type="text" id="searchInput" placeholder="Cari sopir / no polisi..." onkeyup="searchMonitoring()">
                    </div>

                    <select class="filter-select" id="statusFilter" onchange="searchMonitoring()">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                        <option value="Proses Validasi">Proses Validasi</option>
                        <option value="Menunggu Barcode">Menunggu Barcode</option>
                    </select>
                </div>

                <div class="monitor-list" id="monitorList">
                    @forelse ($submissions as $index => $sub)
                    @php
                    // Mapping Status untuk Progress & UI
                    $progress = 25;
                    $step = 2;
                    $statusUI = 'Menunggu Verifikasi';
                    $statusClass = 'status-waiting';
                    $note = 'Pengajuan sedang menunggu verifikasi dokumen oleh admin.';

                    if ($sub->status === 'diproses') {
                    $progress = 50; $step = 3;
                    $statusUI = 'Proses Validasi'; $statusClass = 'status-process';
                    $note = 'Pengajuan masuk ke tahap validasi/proses lanjutan.';
                    } elseif (in_array($sub->status, ['disetujui', 'menunggu_upload_barcode', 'menunggu_penerbitan'])) {
                    $progress = 75; $step = 4;
                    $statusUI = 'Menunggu Barcode'; $statusClass = 'status-process';
                    $note = 'Pengajuan telah disetujui, sedang menunggu barcode diterbitkan.';
                    }

                    // Jaga-jaga jika ada relasi yang null
                    $driverName = $sub->vehicle && $sub->vehicle->user ? $sub->vehicle->user->name : '-';
                    $policeNum = $sub->vehicle ? $sub->vehicle->plate_number : '-';
                    $doorNum = $sub->vehicle ? $sub->vehicle->door_number : '-';
                    $area = $sub->vehicle && $sub->vehicle->user ? $sub->vehicle->user->operational_area : '-';
                    $phone = $sub->vehicle && $sub->vehicle->user ? $sub->vehicle->user->phone : '-';
                    $vehicleType = $sub->vehicle ? $sub->vehicle->vehicle_type : '-';
                    $dateStr = \Carbon\Carbon::parse($sub->submission_date)->format('d/m/Y');

                    $searchKeyword = strtolower("$driverName $policeNum $doorNum $statusUI");
                    @endphp

                    <div
                        class="monitor-card {{ $index === 0 ? 'active' : '' }}"
                        data-search="{{ $searchKeyword }}"
                        data-status="{{ $statusUI }}"
                        onclick="selectMonitoring(this, 
                                '{{ $sub->submission_code }}', 
                                '{{ $driverName }}', 
                                '{{ $policeNum }}', 
                                '{{ $doorNum }}', 
                                '{{ $dateStr }}', 
                                '{{ $statusUI }}', 
                                '{{ $statusClass }}',
                                {{ $progress }}, 
                                {{ $step }}, 
                                '{{ $phone }}', 
                                '{{ $area ?? '-' }}', 
                                '{{ $vehicleType ?? '-' }}', 
                                '{{ $note }}')">

                        <div class="monitor-card-top">
                            <div class="police-number">{{ $policeNum }}</div>
                            <div class="door-badge">{{ $doorNum }}</div>
                        </div>

                        <div class="monitor-meta">
                            <span>Sopir: <strong>{{ $driverName }}</strong></span>
                            <span>Tanggal: <strong>{{ $dateStr }}</strong></span>
                            <span>Area: <strong>{{ $area ?? '-' }}</strong></span>
                            <span>Progress: <strong>{{ $progress }}%</strong></span>
                        </div>

                        <span class="status-pill {{ $statusClass }}">{{ $statusUI }}</span>
                    </div>
                    @empty
                    <div class="empty-state">Tidak ada pengajuan aktif yang perlu dimonitoring saat ini.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- PANEL KANAN: DETAIL MONITORING -->
        <div class="panel">
            <div class="panel-header">
                <h3>Detail Progress Pengajuan</h3>
                <span id="currentStatus" class="status-pill status-waiting">Pilih Data</span>
            </div>

            <div class="panel-body" id="detailPanelBody" style="display:none;">
                <div class="detail-grid">
                    <div class="detail-box"><span>ID Pengajuan</span><strong id="detailId">-</strong></div>
                    <div class="detail-box"><span>Nama Sopir</span><strong id="detailDriver">-</strong></div>
                    <div class="detail-box"><span>No Polisi</span><strong id="detailPolice">-</strong></div>
                    <div class="detail-box"><span>No. Pintu</span><strong id="detailDoor">-</strong></div>
                    <div class="detail-box"><span>No HP</span><strong id="detailPhone">-</strong></div>
                    <div class="detail-box"><span>Jenis Kendaraan</span><strong id="detailVehicle">-</strong></div>
                </div>

                <div class="progress-box">
                    <div class="progress-head">
                        <h4>Progress Pengajuan</h4>
                        <span class="progress-percent" id="progressText">0%</span>
                    </div>

                    <div class="progress-track">
                        <div class="progress-fill" id="progressFill"></div>
                    </div>

                    <div class="step-list">
                        <div class="step-item" id="step5">
                            <div class="step-circle">✓</div>
                            <div class="step-content">
                                <strong>Barcode Tersedia</strong>
                                <span>Barcode sudah terbit dan dapat digunakan oleh sopir.</span>
                            </div>
                        </div>

                        <div class="step-item" id="step4">
                            <div class="step-circle">4</div>
                            <div class="step-content">
                                <strong>Menunggu Barcode Terbit</strong>
                                <span>Pengajuan disetujui, admin sedang menyiapkan file barcode.</span>
                            </div>
                        </div>

                        <div class="step-item" id="step3">
                            <div class="step-circle">3</div>
                            <div class="step-content">
                                <strong>Proses Validasi</strong>
                                <span>Pengajuan sedang diproses dan diverifikasi lebih lanjut.</span>
                            </div>
                        </div>

                        <div class="step-item" id="step2">
                            <div class="step-circle">2</div>
                            <div class="step-content">
                                <strong>Verifikasi Dokumen</strong>
                                <span>Admin mengecek kelengkapan foto kendaraan, STNK, dan Pajak.</span>
                            </div>
                        </div>

                        <div class="step-item done" id="step1">
                            <div class="step-circle">✓</div>
                            <div class="step-content">
                                <strong>Pengajuan Dikirim</strong>
                                <span>Sopir berhasil mengirim data kendaraan dan dokumen.</span>
                            </div>
                        </div>
                    </div>

                    <div class="readonly-info">
                        Halaman ini bersifat *Read-Only* (hanya untuk pantauan). Perubahan status dilakukan melalui menu Verifikasi Dokumen atau Upload Barcode.
                    </div>
                </div>

                <div class="action-row">
                    <button class="btn" onclick="openHistoryModal()">Lihat Detail Riwayat</button>
                    <a href="{{ route('admin.submissions') }}" class="btn btn-primary">Ke Tabel Data Pengajuan</a>
                </div>
            </div>

            <div id="emptyPanelIndicator" class="empty-state">
                Silakan pilih data pengajuan di panel sebelah kiri.
            </div>
        </div>
    </div>
</div>

<!-- MODAL RIWAYAT -->
<div class="modal-overlay" id="historyModal">
    <div class="modal-box">
        <h3 class="modal-title">Detail Riwayat Monitoring</h3>
        <p class="modal-text">Riwayat ini menampilkan status terkini yang tercatat pada sistem aplikasi.</p>

        <div class="history-box">
            <div class="history-item">
                <div class="history-dot"></div>
                <div>
                    <strong>Pengajuan Diterima</strong>
                    <span id="modalHistorySubmit">Sopir mengirim data pada DD/MM/YYYY.</span>
                </div>
            </div>
            <div class="history-item">
                <div class="history-dot"></div>
                <div>
                    <strong>Status Saat Ini</strong>
                    <span id="modalCurrentStatus">-</span>
                </div>
            </div>
            <div class="history-item">
                <div class="history-dot"></div>
                <div>
                    <strong>Keterangan</strong>
                    <span id="modalCurrentNote">-</span>
                </div>
            </div>
        </div>

        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeHistoryModal()">Tutup</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const firstCard = document.querySelector('.monitor-card');
        if (firstCard) firstCard.click();
    });

    function selectMonitoring(card, id, driver, police, door, date, statusUI, statusClass, progress, step, phone, area, vehicle, note) {
        document.querySelectorAll('.monitor-card').forEach(item => item.classList.remove('active'));
        card.classList.add('active');

        document.getElementById('emptyPanelIndicator').style.display = 'none';
        document.getElementById('detailPanelBody').style.display = 'block';

        // Teks Detail
        document.getElementById('detailId').innerText = id;
        document.getElementById('detailDriver').innerText = driver;
        document.getElementById('detailPolice').innerText = police;
        document.getElementById('detailDoor').innerText = door;
        document.getElementById('detailPhone').innerText = phone;
        document.getElementById('detailVehicle').innerText = vehicle;

        // Progress Bar
        document.getElementById('progressText').innerText = progress + '%';
        document.getElementById('progressFill').style.width = progress + '%';

        // Status Pill
        const currentStatus = document.getElementById('currentStatus');
        currentStatus.innerText = statusUI;
        currentStatus.className = 'status-pill ' + statusClass;

        // Step Tracker Logic
        for (let i = 1; i <= 5; i++) {
            const item = document.getElementById('step' + i);
            item.classList.remove('done', 'current');

            if (i < step) {
                item.classList.add('done');
            } else if (i === step) {
                item.classList.add('current');
            }
        }

        // Teks Modal Riwayat
        document.getElementById('modalHistorySubmit').innerText = 'Sopir mengirim data dan dokumen pada ' + date + '.';
        document.getElementById('modalCurrentStatus').innerText = statusUI;
        document.getElementById('modalCurrentNote').innerText = note;
    }

    function searchMonitoring() {
        const keyword = document.getElementById('searchInput').value.trim().toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const cards = document.querySelectorAll('.monitor-card');
        let count = 0;

        cards.forEach(card => {
            const searchText = card.getAttribute('data-search');
            const cardStatus = card.getAttribute('data-status');

            const matchKeyword = keyword === '' || searchText.includes(keyword);
            const matchStatus = statusFilter === '' || cardStatus === statusFilter;

            const visible = matchKeyword && matchStatus;
            card.style.display = visible ? '' : 'none';

            if (visible) count++;
        });

        document.getElementById('selectedCounter').innerText = count + ' Data';
    }

    function openHistoryModal() {
        document.getElementById('historyModal').classList.add('show');
    }

    function closeHistoryModal() {
        document.getElementById('historyModal').classList.remove('show');
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') closeHistoryModal();
    });
</script>
@endpush