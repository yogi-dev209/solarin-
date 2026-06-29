@extends('layouts.admin')

@section('title', 'Dashboard Admin - SolarIn')
@section('page-greeting', 'Selamat Datang, Admin')
@section('page-subtitle', 'Kelola dan Pantau Pengajuan Barcode Solar Subsidi')

@push('styles')
<style>
    /* ===== BASE ===== */
    .dashboard-stat-wrap {
        max-width: 860px;
        margin: 32px auto 30px auto;
    }

    /* grid stat atas */
    .dashboard-stat-top {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 36px;
        margin-bottom: 32px;
    }

    /* grid stat bawah */
    .dashboard-stat-bottom {
        display: grid;
        grid-template-columns: repeat(2, 240px);
        justify-content: center;
        gap: 60px;
    }

    /* ===== KARTU STAT ===== */
    .dashboard-card {
        height: 144px;
        border: 2px solid #d1d5db;
        border-radius: 20px;
        background: #ffffff;
        padding: 18px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        position: relative;
        overflow: hidden;
    }

    .dashboard-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: transparent;
        transition: background 0.2s;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        border-color: #9ca3af;
    }

    .dashboard-card.active {
        border-color: #165bd8;
        background: #f5f9ff;
        box-shadow: 0 6px 16px rgba(22,91,216,0.15);
    }

    .dashboard-card.active::before {
        background: #165bd8;
    }

    .dashboard-card-title {
        text-align: center;
        font-size: 18px;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 10px;
        color: #1f2937;
    }

    .dashboard-card-body {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 18px;
    }

    .dashboard-icon {
        font-size: 44px;
        color: #2563eb;
        line-height: 1;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.05));
    }

    .dashboard-number {
        font-size: 38px;
        font-weight: 900;
        line-height: 1;
        color: #111827;
        letter-spacing: -0.5px;
    }

    /* ===== LAYOUT BAWAH ===== */
    .dashboard-bottom {
        display: grid;
        grid-template-columns: 1fr 260px;
        gap: 20px;
        border-top: 2px solid #e5e7eb;
        padding-top: 24px;
        margin-top: 20px;
    }

    .latest-box {
        border-right: 2px solid #e5e7eb;
        padding-right: 20px;
    }

    .latest-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .latest-header h2,
    .activity-box h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #1f2937;
    }

    .latest-header button {
        border: none;
        background: none;
        color: #2563eb;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        padding: 4px 12px;
        border-radius: 8px;
        transition: background 0.15s;
    }

    .latest-header button:hover {
        background: #eff6ff;
    }

    /* ===== TABEL ===== */
    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .dashboard-table th {
        background: #f3f4f6;
        font-weight: 600;
        color: #374151;
        padding: 10px 8px;
        text-align: center;
        border-bottom: 2px solid #e5e7eb;
    }

    .dashboard-table td {
        padding: 10px 8px;
        border-bottom: 1px solid #f3f4f6;
        color: #4b5563;
        cursor: pointer;
        transition: background 0.15s;
    }

    .dashboard-table tbody tr:hover td {
        background: #f9fafb;
    }

    .date-pill {
        background: #f3f4f6;
        border-radius: 20px;
        padding: 3px 12px;
        font-size: 13px;
        display: inline-block;
        font-weight: 500;
    }

    .status-green {
        color: #059669;
        font-weight: 600;
    }

    .status-red {
        color: #dc2626;
        font-weight: 600;
    }

    .status-dark {
        color: #1f2937;
        font-weight: 600;
    }

    /* ===== AKTIVITAS ===== */
    .activity-box {
        padding-left: 4px;
    }

    .activity-list {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        cursor: pointer;
        padding: 8px 10px;
        border-radius: 10px;
        transition: background 0.2s, transform 0.2s;
        border: 1px solid transparent;
    }

    .activity-item:hover {
        background: #f0f7ff;
        border-color: #dbeafe;
        transform: translateX(4px);
    }

    .activity-icon {
        width: 36px;
        font-size: 28px;
        color: #2563eb;
        line-height: 1.2;
        text-align: center;
        flex-shrink: 0;
    }

    .activity-text {
        font-size: 13px;
        line-height: 1.4;
        color: #374151;
    }

    .activity-text strong {
        display: block;
        font-weight: 700;
        color: #111827;
        margin-bottom: 2px;
    }

    /* ===== MINI FILTER ===== */
    .mini-filter {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin: 16px 0 20px;
    }

    .mini-filter strong {
        font-size: 14px;
        color: #4b5563;
    }

    .mini-filter button {
        border: 1.5px solid #d1d5db;
        background: #ffffff;
        border-radius: 24px;
        padding: 5px 14px;
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        transition: all 0.15s;
    }

    .mini-filter button:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }

    .mini-filter button.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        font-weight: 600;
    }

    /* ===== MODAL ===== */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 200;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(2px);
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-box {
        width: 420px;
        max-width: 92%;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.25);
        animation: modalIn 0.25s ease;
    }

    @keyframes modalIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 16px 0;
        color: #111827;
    }

    .modal-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f3f4f6;
        padding: 10px 0;
        font-size: 14px;
        color: #4b5563;
    }

    .modal-row strong {
        color: #111827;
        font-weight: 600;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #374151;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn:hover {
        background: #f9fafb;
    }

    .btn-primary {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    .btn-primary:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
    }

    .btn-outline {
        background: transparent;
        border-color: #d1d5db;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
        .dashboard-stat-wrap {
            max-width: 100%;
            margin: 20px 0 24px;
        }

        .dashboard-stat-top {
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .dashboard-stat-bottom {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            justify-content: stretch;
        }

        .dashboard-card {
            height: 120px;
            padding: 14px 12px;
            border-radius: 16px;
        }

        .dashboard-card-title {
            font-size: 15px;
        }

        .dashboard-number {
            font-size: 28px;
        }

        .dashboard-icon {
            font-size: 32px;
        }
    }

    @media (max-width: 768px) {
        .dashboard-stat-top {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .dashboard-stat-bottom {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .dashboard-bottom {
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .latest-box {
            border-right: none;
            padding-right: 0;
        }

        .dashboard-table {
            font-size: 13px;
        }

        .date-pill {
            padding: 2px 8px;
            font-size: 12px;
        }

        .latest-header h2,
        .activity-box h2 {
            font-size: 18px;
        }

        .modal-box {
            padding: 18px;
        }

        .activity-item:hover {
            transform: none;
        }
    }

    @media (max-width: 480px) {
        .dashboard-card {
            height: 106px;
        }
    }
</style>
@endpush

@section('content')
<div>
    <div class="dashboard-stat-wrap">
        <div class="dashboard-stat-top">
            <div class="dashboard-card active" onclick="filterStatus('all', this)">
                <div class="dashboard-card-title">Total Pengajuan</div>
                <div class="dashboard-card-body">
                    <div class="dashboard-icon">📝</div>
                    <div class="dashboard-number">{{ $totalPengajuan }}</div>
                </div>
            </div>

            <div class="dashboard-card" onclick="filterStatus('Menunggu Verifikasi', this)">
                <div class="dashboard-card-title">Menunggu<br>Verifikasi</div>
                <div class="dashboard-card-body">
                    <div class="dashboard-icon">👥</div>
                    <div class="dashboard-number">{{ $pengajuanMenunggu }}</div>
                </div>
            </div>

            <div class="dashboard-card" onclick="filterStatus('Dalam Proses', this)">
                <div class="dashboard-card-title">Dalam Proses</div>
                <div class="dashboard-card-body">
                    <div class="dashboard-icon">📈</div>
                    <div class="dashboard-number">{{ $pengajuanDiproses }}</div>
                </div>
            </div>
        </div>

        <div class="dashboard-stat-bottom">
            <div class="dashboard-card" onclick="filterStatus('Disetujui', this)">
                <div class="dashboard-card-title">Disetujui</div>
                <div class="dashboard-card-body">
                    <div class="dashboard-icon">📄</div>
                    <div class="dashboard-number">{{ $pengajuanSelesai }}</div>
                </div>
            </div>

            <div class="dashboard-card" onclick="filterStatus('Ditolak', this)">
                <div class="dashboard-card-title">Ditolak</div>
                <div class="dashboard-card-body">
                    <div class="dashboard-icon">📋</div>
                    <div class="dashboard-number">{{ $pengajuanDitolak }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="mini-filter">
        <strong>Filter cepat:</strong>
        <button class="filter-btn active" onclick="filterStatus('all')">Semua</button>
        <button class="filter-btn" onclick="filterStatus('Menunggu Verifikasi')">Menunggu</button>
        <button class="filter-btn" onclick="filterStatus('Dalam Proses')">Proses</button>
        <button class="filter-btn" onclick="filterStatus('Disetujui')">Disetujui</button>
        <button class="filter-btn" onclick="filterStatus('Ditolak')">Ditolak</button>
    </div>

    <div class="dashboard-bottom">
        <div class="latest-box">
            <div class="latest-header">
                <h2>Pengajuan Terbaru</h2>
                <button onclick="showAllRows()">Lihat Semua</button>
            </div>

            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>No. Polisi</th>
                        <th>No. Pintu</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status Pengajuan</th>
                    </tr>
                </thead>
                <tbody id="pengajuanTable">
                    @forelse ($recentPengajuan as $index => $pengajuan)
                    @php
                    $statusLabel = '';
                    $statusClass = '';
                    $dataStatus = '';

                    switch($pengajuan->status) {
                    case 'menunggu_verifikasi':
                    $statusLabel = 'Menunggu Verifikasi';
                    $statusClass = 'status-dark';
                    $dataStatus = 'Menunggu Verifikasi';
                    break;
                    case 'diproses':
                    case 'menunggu_upload_barcode':
                    case 'menunggu_penerbitan':
                    $statusLabel = 'Dalam Proses';
                    $statusClass = 'status-dark';
                    $dataStatus = 'Dalam Proses';
                    break;
                    case 'disetujui':
                    case 'barcode_terbit':
                    $statusLabel = 'Disetujui';
                    $statusClass = 'status-green';
                    $dataStatus = 'Disetujui';
                    break;
                    case 'ditolak':
                    $statusLabel = 'Ditolak';
                    $statusClass = 'status-red';
                    $dataStatus = 'Ditolak';
                    break;
                    default:
                    $statusLabel = ucwords(str_replace('_', ' ', $pengajuan->status));
                    $statusClass = 'status-dark';
                    $dataStatus = 'Lainnya';
                    }

                    $nopol = $pengajuan->vehicle->plate_number ?? '-';
                    $nopintu = $pengajuan->vehicle->door_number ?? '-';
                    $tgl = \Carbon\Carbon::parse($pengajuan->submission_date)->format('d/m/Y');
                    @endphp

                    <tr data-status="{{ $dataStatus }}" {{ $index >= 4 ? 'class=extra-row style=display:none' : '' }} onclick="openDetail('{{ $nopol }}', '{{ $nopintu }}', '{{ $tgl }}', '{{ $statusLabel }}')">
                        <td>{{ $nopol }}</td>
                        <td>{{ $nopintu }}</td>
                        <td><span class="date-pill">{{ $tgl }}</span></td>
                        <td><span class="{{ $statusClass }}">{{ $statusLabel }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 30px; color: #6b7280;">Belum ada pengajuan masuk ke sistem.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="activity-box">
            <h2>Aktivitas Terbaru</h2>

            <div class="activity-list">
                @forelse($recentActivity as $activity)
                @php
                $icon = '📋';
                switch($activity->action) {
                case 'pengajuan_dibuat': $icon = '📝'; break;
                case 'status_berubah': $icon = '🔄'; break;
                case 'dokumen_diupload': $icon = '📤'; break;
                case 'dokumen_diverifikasi': $icon = '✅'; break;
                case 'dokumen_direvisi': $icon = '⚠️'; break;
                case 'dokumen_ditolak': $icon = '❌'; break;
                case 'barcode_diterbitkan': $icon = '🎫'; break;
                case 'reset_diajukan': $icon = '🔁'; break;
                case 'reset_disetujui': $icon = '✔️'; break;
                case 'reset_ditolak': $icon = '✖️'; break;
                }
                $doorNumber = $activity->submission?->vehicle?->door_number ?? 'Sistem';
                $actionLabel = ucwords(str_replace('_', ' ', $activity->action));
                @endphp
                <div class="activity-item" onclick="openActivity('{{ $doorNumber }}', '{{ $actionLabel }}', '{{ addslashes($activity->description) }}')">
                    <div class="activity-icon">{{ $icon }}</div>
                    <div class="activity-text">
                        <strong>{{ $doorNumber }}</strong>
                        {{ Str::limit($activity->description, 35) }}
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 20px; color: #6b7280;">Belum ada aktivitas tercatat.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Modals tidak berubah --}}
<div class="modal-overlay" id="detailModal">
    <div class="modal-box">
        <h3 class="modal-title">Detail Pengajuan</h3>
        <div class="modal-row"><span>No. Polisi</span><strong id="modalPolisi">-</strong></div>
        <div class="modal-row"><span>No. Pintu</span><strong id="modalPintu">-</strong></div>
        <div class="modal-row"><span>Tanggal</span><strong id="modalTanggal">-</strong></div>
        <div class="modal-row"><span>Status</span><strong id="modalStatus">-</strong></div>
        <div style="margin-top:12px; font-size:13px; color:#6b7280;">Preview ringkasan pengajuan.</div>
        <div class="modal-actions">
            <button class="btn btn-outline" onclick="closeModal()">Tutup</button>
            <a href="{{ url('/admin/data-pengajuan') }}" class="btn btn-primary">Buka Data Pengajuan</a>
        </div>
    </div>
</div>

<div class="modal-overlay" id="activityModal">
    <div class="modal-box">
        <h3 class="modal-title">Aktivitas Terbaru</h3>
        <div class="modal-row"><span>No. Pintu</span><strong id="activityPintu">-</strong></div>
        <div class="modal-row"><span>Status Aktivitas</span><strong id="activityStatus">-</strong></div>
        <p id="activityDesc" style="font-size:14px; line-height:1.5; margin-top:12px; color:#374151;"></p>
        <div class="modal-actions">
            <button class="btn btn-outline" onclick="closeActivity()">Tutup</button>
            <a href="{{ url('/admin/monitoring-pengajuan') }}" class="btn btn-primary">Lihat Monitoring</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterStatus(status, card = null) {
        const rows = document.querySelectorAll('#pengajuanTable tr');
        const cards = document.querySelectorAll('.dashboard-card');
        const buttons = document.querySelectorAll('.filter-btn');

        rows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;
            const rowStatus = row.getAttribute('data-status');
            row.style.display = (status === 'all' || rowStatus === status) ? '' : 'none';
        });

        cards.forEach(item => item.classList.remove('active'));
        buttons.forEach(btn => btn.classList.remove('active'));

        if (card) {
            card.classList.add('active');
        }

        buttons.forEach(btn => {
            if (
                (status === 'all' && btn.innerText === 'Semua') ||
                (status !== 'all' && status.toLowerCase().includes(btn.innerText.toLowerCase()))
            ) {
                btn.classList.add('active');
            }
        });
    }

    function showAllRows() {
        document.querySelectorAll('#pengajuanTable tr').forEach(row => {
            row.style.display = '';
        });
        document.querySelectorAll('.dashboard-card').forEach(card => card.classList.remove('active'));
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelector('.filter-btn').classList.add('active');
    }

    function openDetail(polisi, pintu, tanggal, status) {
        document.getElementById('modalPolisi').innerText = polisi;
        document.getElementById('modalPintu').innerText = pintu;
        document.getElementById('modalTanggal').innerText = tanggal;
        document.getElementById('modalStatus').innerText = status;
        document.getElementById('detailModal').classList.add('show');
    }

    function closeModal() {
        document.getElementById('detailModal').classList.remove('show');
    }

    function openActivity(pintu, status, desc) {
        document.getElementById('activityPintu').innerText = pintu;
        document.getElementById('activityStatus').innerText = status;
        document.getElementById('activityDesc').innerText = desc;
        document.getElementById('activityModal').classList.add('show');
    }

    function closeActivity() {
        document.getElementById('activityModal').classList.remove('show');
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
            closeActivity();
        }
    });
</script>
@endpush