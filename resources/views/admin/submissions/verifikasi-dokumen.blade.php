@extends('layouts.admin')

@section('title', 'Verifikasi Dokumen - SolarIn')
@section('page-greeting', 'Selamat Datang, Admin')
@section('page-subtitle', 'Periksa kelengkapan dokumen pengajuan barcode solar subsidi')

@push('styles')
<style>
    .verify-page {
        padding-top: 18px;
    }

    .verify-title {
        font-size: 23px;
        font-weight: 800;
        margin: 0 0 18px 0;
    }

    .verify-layout {
        display: grid;
        grid-template-columns: 42% 58%;
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

    .verify-toolbar {
        display: grid;
        grid-template-columns: 1fr 115px;
        gap: 10px;
        margin-bottom: 12px;
    }

    .verify-search {
        height: 39px;
        border: 1.4px solid #111827;
        border-radius: 8px;
        padding: 0 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .verify-search span {
        font-size: 14px;
        color: #003b78;
    }

    .verify-search input {
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
    }

    .submission-list {
        display: flex;
        flex-direction: column;
        gap: 9px;
        max-height: 560px;
        overflow-y: auto;
        padding-right: 3px;
    }

    .submission-card {
        border: 1.4px solid #d1d5db;
        border-radius: 10px;
        padding: 11px;
        cursor: pointer;
        background: #ffffff;
        transition: .18s;
    }

    .submission-card:hover,
    .submission-card.active {
        border-color: #003b78;
        background: #eef5ff;
    }

    .submission-top {
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

    .submission-meta {
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

    /* HANYA ADA 3 STATUS SEKARANG */
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

    .document-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 15px;
    }

    .document-card {
        border: 1.5px solid #111827;
        border-radius: 10px;
        overflow: hidden;
        background: #ffffff;
    }

    .document-preview {
        height: 128px;
        background-color: #e2e8f0;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        font-size: 24px;
        font-weight: 900;
        position: relative;
    }

    .document-label {
        padding: 9px 10px;
        border-top: 1.3px solid #111827;
    }

    .document-label strong {
        display: block;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .document-label span {
        font-size: 11px;
        color: #15803d;
        font-weight: 800;
    }

    .document-actions {
        display: grid;
        grid-template-columns: 1fr;
        gap: 6px;
        padding: 0 10px 10px 10px;
    }

    .small-btn {
        height: 32px;
        border: 1px solid #111827;
        border-radius: 8px;
        background: #ffffff;
        color: #111827;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
    }

    .small-btn:hover {
        background: #f1f5f9;
    }

    .verification-box {
        border: 1.5px solid #111827;
        border-radius: 10px;
        padding: 13px;
        margin-top: 12px;
    }

    .verification-box h4 {
        margin: 0 0 10px 0;
        font-size: 15px;
        font-weight: 900;
    }

    .check-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 9px;
        margin-bottom: 12px;
    }

    .check-item {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 9px;
        display: flex;
        gap: 8px;
        align-items: center;
        font-size: 13px;
        font-weight: 700;
    }

    .check-item input {
        width: 16px;
        height: 16px;
    }

    .note-area {
        width: 100%;
        min-height: 76px;
        border: 1.3px solid #9ca3af;
        border-radius: 8px;
        padding: 10px;
        font-size: 13px;
        resize: vertical;
        outline: none;
    }

    .action-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
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

    .action-btn:hover {
        opacity: .9;
    }

    .approve {
        background: #16a34a;
    }

    .reject {
        background: #dc2626;
    }

    /* MODALS */
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
        width: 480px;
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

    .preview-modal-img {
        height: 350px;
        border: 1px solid #111827;
        border-radius: 10px;
        background-color: #e2e8f0;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        font-size: 24px;
        font-weight: 900;
        margin-top: 12px;
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

    /* State Kosong */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #64748b;
        font-weight: 700;
    }

    @media (max-width: 900px) {
        .verify-layout {
            grid-template-columns: 1fr;
        }

        .submission-list {
            max-height: none;
        }
    }

    @media (max-width: 768px) {
        .verify-page {
            padding-top: 8px;
        }

        .verify-toolbar {
            grid-template-columns: 1fr;
        }

        .detail-grid,
        .document-grid,
        .check-grid,
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

<div class="verify-page">
    <h2 class="verify-title">Verifikasi Dokumen</h2>

    @if(session('success'))
    <div style="background: #dcfce7; border: 1.5px solid #16a34a; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 15px; font-weight: 700; font-size: 14px;">
        ✓ {{ session('success') }}
    </div>
    @endif

    <div class="verify-layout">
        <div class="panel">
            <div class="panel-header">
                <h3>Daftar Pengajuan</h3>
                <span id="selectedCounter">{{ $submissions->count() }} Data</span>
            </div>

            <div class="panel-body">
                <div class="verify-toolbar">
                    <div class="verify-search">
                        <span>⌕</span>
                        <input type="text" id="searchInput" placeholder="Cari sopir / no polisi..." onkeyup="searchSubmission()">
                    </div>

                    <select class="filter-select" id="statusFilter" onchange="filterStatus()">
                        <option value="">Semua</option>
                        <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                        <option value="diproses">Disetujui/Diproses</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>

                <div class="submission-list" id="submissionList">
                    @forelse ($submissions as $index => $sub)
                    @php
                    $statusUI = match($sub->status) {
                    'menunggu_verifikasi' => 'Menunggu',
                    'ditolak' => 'Ditolak',
                    default => 'Disetujui'
                    };

                    $statusClass = match($sub->status) {
                    'menunggu_verifikasi' => 'status-waiting',
                    'ditolak' => 'status-rejected',
                    default => 'status-approved'
                    };

                    // Cek dokumen
                    $fotoKendaraan = $sub->documents->where('document_type', 'foto_kendaraan')->first();
                    $fotoStnk = $sub->documents->where('document_type', 'stnk_pajak')->first();

                    // Buat URL Gambar (Jika belum ada foto, biarkan kosong)
                    $urlKendaraan = $fotoKendaraan ? asset('storage/' . $fotoKendaraan->file) : '';
                    $urlStnk = $fotoStnk ? asset('storage/' . $fotoStnk->file) : '';

                    // Handle error jika relasi vehicle/user ada yang terhapus
                    $userName = $sub->vehicle && $sub->vehicle->user ? $sub->vehicle->user->name : 'Sopir Terhapus';
                    $plateNum = $sub->vehicle ? $sub->vehicle->plate_number : '-';
                    $doorNum = $sub->vehicle ? $sub->vehicle->door_number : '-';
                    $phoneNum = $sub->vehicle && $sub->vehicle->user ? $sub->vehicle->user->phone : '-';
                    $vehicleType = $sub->vehicle ? $sub->vehicle->vehicle_type : '-';
                    @endphp

                    <div
                        class="submission-card {{ $index === 0 ? 'active' : '' }}"
                        data-search="{{ strtolower($userName.' '.$plateNum.' '.$doorNum.' '.$statusUI) }}"
                        data-status="{{ $sub->status }}"
                        onclick="selectSubmission(this, 
                                '{{ $sub->id }}', 
                                '{{ $sub->submission_code }}', 
                                '{{ $userName }}', 
                                '{{ $plateNum }}', 
                                '{{ $doorNum }}', 
                                '{{ \Carbon\Carbon::parse($sub->submission_date)->format('d/m/Y') }}', 
                                '{{ $statusUI }}', 
                                '{{ $phoneNum }}', 
                                '{{ $vehicleType }}', 
                                '{{ $urlKendaraan }}', 
                                '{{ $urlStnk }}'
                            )">
                        <div class="submission-top">
                            <div class="police-number">{{ $plateNum }}</div>
                            <div class="door-badge">{{ $doorNum }}</div>
                        </div>

                        <div class="submission-meta">
                            <span>Sopir: <strong>{{ $userName }}</strong></span>
                            <span>Tanggal: <strong>{{ \Carbon\Carbon::parse($sub->submission_date)->format('d/m/Y') }}</strong></span>
                            <span style="grid-column: 1 / 3;">ID: <strong>{{ $sub->submission_code }}</strong></span>
                        </div>

                        <span class="status-pill {{ $statusClass }}">{{ $statusUI }}</span>
                    </div>
                    @empty
                    <div class="empty-state">Belum ada data pengajuan.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h3>Detail dan Pemeriksaan Dokumen</h3>
                <span id="currentStatus" class="status-pill status-waiting">Pilih Data</span>
            </div>

            <div class="panel-body" id="detailPanelBody" style="display: none;">
                <div class="detail-grid">
                    <div class="detail-box">
                        <span>ID Pengajuan</span>
                        <strong id="detailId">-</strong>
                    </div>
                    <div class="detail-box">
                        <span>Nama Sopir</span>
                        <strong id="detailDriver">-</strong>
                    </div>
                    <div class="detail-box">
                        <span>No Polisi</span>
                        <strong id="detailPolice">-</strong>
                    </div>
                    <div class="detail-box">
                        <span>No. Pintu</span>
                        <strong id="detailDoor">-</strong>
                    </div>
                    <div class="detail-box">
                        <span>No HP</span>
                        <strong id="detailPhone">-</strong>
                    </div>
                    <div class="detail-box">
                        <span>Jenis Kendaraan</span>
                        <strong id="detailVehicle">-</strong>
                    </div>
                </div>

                <div class="document-grid">
                    <div class="document-card">
                        <div class="document-preview" id="thumbKendaraan">Foto Kosong</div>
                        <div class="document-label">
                            <strong>Foto Kendaraan</strong>
                        </div>
                        <div class="document-actions">
                            <button type="button" class="small-btn" onclick="openPreview('Foto Kendaraan')">Lihat Penuh</button>
                        </div>
                    </div>

                    <div class="document-card">
                        <div class="document-preview" id="thumbStnk">Foto Kosong</div>
                        <div class="document-label">
                            <strong>STNK & Pajak</strong>
                        </div>
                        <div class="document-actions">
                            <button type="button" class="small-btn" onclick="openPreview('STNK Kendaraan')">Lihat Penuh</button>
                        </div>
                    </div>
                </div>

                <div class="verification-box" id="verificationBox">
                    <h4>Pemeriksaan Admin</h4>

                    <div class="check-grid">
                        <label class="check-item"><input type="checkbox" id="checkVehicle"> Foto kendaraan sesuai</label>
                        <label class="check-item"><input type="checkbox" id="checkStnk"> STNK & Pajak valid</label>
                        <label class="check-item"><input type="checkbox" id="checkData"> Data sopir sesuai</label>
                        <label class="check-item"><input type="checkbox" id="checkClear"> Gambar terbaca jelas</label>
                    </div>

                    <textarea id="adminNote" class="note-area" placeholder="Catatan opsional jika disetujui / Wajib diisi jika ditolak..."></textarea>

                    <div class="action-row">
                        <button class="action-btn approve" onclick="confirmAction('approve')">Setujui & Proses</button>
                        <button class="action-btn reject" onclick="confirmAction('reject')">Tolak Pengajuan</button>
                    </div>
                </div>
            </div>

            <div id="emptyPanelIndicator" class="empty-state">
                Silakan pilih data pengajuan di sebelah kiri.
            </div>
        </div>
    </div>
</div>

<form id="processForm" method="POST" action="">
    @csrf
    <input type="hidden" name="action" id="formAction">
    <input type="hidden" name="admin_note" id="formAdminNote">
</form>

<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <h3 class="modal-title" id="confirmTitle">Konfirmasi</h3>
        <p class="modal-text" id="confirmText">Apakah kamu yakin?</p>

        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeConfirm()">Batal</button>
            <button type="button" class="btn-primary" onclick="runAction()">Ya, Lanjutkan</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="previewModal">
    <div class="modal-box" style="width: 700px;">
        <h3 class="modal-title" id="previewTitle">Preview Dokumen</h3>
        <div class="preview-modal-img" id="previewImage">Pilih Gambar</div>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closePreview()">Tutup</button>
        </div>
    </div>
</div>

<div class="toast" id="toastBox">Berhasil.</div>
@endsection

@push('scripts')
<script>
    let selectedAction = '';
    let docKendaraanUrl = '';
    let docStnkUrl = '';

    // Auto-select item pertama jika ada
    document.addEventListener('DOMContentLoaded', function() {
        const firstCard = document.querySelector('.submission-card');
        if (firstCard) firstCard.click();
    });

    function selectSubmission(card, dbId, displayId, driver, police, door, date, status, phone, vehicle, urlKendaraan, urlStnk) {
        document.querySelectorAll('.submission-card').forEach(item => item.classList.remove('active'));
        card.classList.add('active');

        // Tampilkan panel detail
        document.getElementById('emptyPanelIndicator').style.display = 'none';
        document.getElementById('detailPanelBody').style.display = 'block';

        // Isi Teks
        document.getElementById('detailId').innerText = displayId;
        document.getElementById('detailDriver').innerText = driver;
        document.getElementById('detailPolice').innerText = police;
        document.getElementById('detailDoor').innerText = door;
        document.getElementById('detailPhone').innerText = phone;
        document.getElementById('detailVehicle').innerText = vehicle;

        // Setel Status Pill
        const currentStatus = document.getElementById('currentStatus');
        currentStatus.innerText = status;
        currentStatus.className = 'status-pill';

        // Menyembunyikan form aksi jika pengajuan sudah selesai (Disetujui/Ditolak)
        const verifBox = document.getElementById('verificationBox');
        if (status === 'Menunggu') {
            currentStatus.classList.add('status-waiting');
            verifBox.style.display = 'block';
        } else if (status === 'Ditolak') {
            currentStatus.classList.add('status-rejected');
            verifBox.style.display = 'none';
        } else {
            currentStatus.classList.add('status-approved');
            verifBox.style.display = 'none';
        }

        // Setel Gambar
        docKendaraanUrl = urlKendaraan;
        docStnkUrl = urlStnk;

        setThumbnail('thumbKendaraan', urlKendaraan);
        setThumbnail('thumbStnk', urlStnk);

        // Reset form
        document.getElementById('adminNote').value = '';
        ['checkVehicle', 'checkStnk', 'checkClear', 'checkData'].forEach(id => {
            document.getElementById(id).checked = false;
        });

        // Set action form Laravel
        document.getElementById('processForm').action = `/admin/verifikasi-dokumen/${dbId}`;
    }

    function setThumbnail(elementId, url) {
        const el = document.getElementById(elementId);
        if (url) {
            el.style.backgroundImage = `url('${url}')`;
            el.innerText = '';
        } else {
            el.style.backgroundImage = 'none';
            el.innerText = 'Foto Tidak Tersedia';
        }
    }

    function searchSubmission() {
        const keyword = document.getElementById('searchInput').value.trim().toLowerCase();
        const cards = document.querySelectorAll('.submission-card');
        let count = 0;

        cards.forEach(card => {
            const searchText = card.getAttribute('data-search');
            const status = document.getElementById('statusFilter').value;
            const matchKeyword = keyword === '' || searchText.includes(keyword);
            const matchStatus = status === '' || card.getAttribute('data-status').includes(status);

            const visible = matchKeyword && matchStatus;
            card.style.display = visible ? '' : 'none';

            if (visible) count++;
        });

        document.getElementById('selectedCounter').innerText = count + ' Data';
    }

    function filterStatus() {
        searchSubmission();
    }

    function openPreview(type) {
        document.getElementById('previewTitle').innerText = 'Preview ' + type;
        const previewImage = document.getElementById('previewImage');

        let targetUrl = type === 'Foto Kendaraan' ? docKendaraanUrl : docStnkUrl;

        if (targetUrl) {
            previewImage.style.backgroundImage = `url('${targetUrl}')`;
            previewImage.innerText = '';
        } else {
            previewImage.style.backgroundImage = 'none';
            previewImage.innerText = 'File Tidak Ditemukan';
        }

        document.getElementById('previewModal').classList.add('show');
    }

    function closePreview() {
        document.getElementById('previewModal').classList.remove('show');
    }

    function confirmAction(action) {
        selectedAction = action;
        const note = document.getElementById('adminNote').value.trim();

        if (action === 'reject' && note === '') {
            showToast('Catatan wajib diisi jika ingin menolak pengajuan.');
            return;
        }

        if (action === 'approve') {
            const required = ['checkVehicle', 'checkStnk', 'checkClear', 'checkData'];
            const allChecked = required.every(id => document.getElementById(id).checked);

            if (!allChecked) {
                showToast('Centang semua checklist pemeriksaan sebelum menyetujui dokumen.');
                return;
            }

            document.getElementById('confirmTitle').innerText = 'Setujui Pengajuan';
            document.getElementById('confirmText').innerText = 'Apakah Anda yakin ingin menyetujui dokumen ini? Pengajuan akan dilanjutkan ke tahap pembuatan barcode.';
        }

        if (action === 'reject') {
            document.getElementById('confirmTitle').innerText = 'Tolak Pengajuan';
            document.getElementById('confirmText').innerText = 'Pengajuan akan dibatalkan/ditolak. Pastikan alasan penolakan sudah jelas.';
        }

        document.getElementById('confirmModal').classList.add('show');
    }

    function closeConfirm() {
        document.getElementById('confirmModal').classList.remove('show');
    }

    // Eksekusi Submit Form Laravel
    function runAction() {
        document.getElementById('formAction').value = selectedAction;
        document.getElementById('formAdminNote').value = document.getElementById('adminNote').value;

        // Submit form
        document.getElementById('processForm').submit();

        closeConfirm();
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