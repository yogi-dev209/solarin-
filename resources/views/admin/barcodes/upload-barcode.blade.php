@extends('layouts.admin')

@section('title', 'Upload Barcode - SolarIn')
@section('page-greeting', 'Selamat Datang, Admin')
@section('page-subtitle', 'Upload hasil barcode yang telah diterbitkan untuk sopir')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .barcode-page {
        padding-top: 18px;
    }

    .barcode-title {
        font-size: 23px;
        font-weight: 800;
        margin: 0 0 18px 0;
    }

    .barcode-layout {
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

    .barcode-toolbar {
        display: grid;
        grid-template-columns: 1fr 120px;
        gap: 10px;
        margin-bottom: 12px;
    }

    .barcode-search {
        height: 39px;
        border: 1.4px solid #111827;
        border-radius: 8px;
        padding: 0 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .barcode-search span {
        font-size: 14px;
        color: #003b78;
    }

    .barcode-search input {
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

    .status-waiting {
        background: #fef3c7;
        color: #92400e;
    }

    .status-uploaded {
        background: #dcfce7;
        color: #15803d;
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

    .upload-section {
        border: 1.5px solid #111827;
        border-radius: 10px;
        padding: 14px;
        margin-top: 12px;
    }

    .upload-section h4 {
        margin: 0 0 12px 0;
        font-size: 15px;
        font-weight: 900;
    }

    .upload-area {
        border: 2px dashed #9ca3af;
        border-radius: 12px;
        padding: 22px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: .18s;
        position: relative;
    }

    .upload-area:hover,
    .upload-area.dragover {
        border-color: #003b78;
        background: #eef5ff;
    }

    .upload-icon {
        font-size: 40px;
        margin-bottom: 8px;
    }

    .upload-area strong {
        display: block;
        font-size: 15px;
        margin-bottom: 4px;
    }

    .upload-area span {
        font-size: 12px;
        color: #64748b;
    }

    .file-name {
        margin-top: 10px;
        font-size: 13px;
        font-weight: 800;
        color: #003b78;
        display: none;
    }

    .barcode-preview-wrap {
        margin-top: 14px;
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 14px;
        align-items: stretch;
    }

    .barcode-preview {
        min-height: 180px;
        border: 1.5px solid #111827;
        border-radius: 10px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .barcode-placeholder {
        width: 120px;
        height: 120px;
        background: linear-gradient(90deg, #111 10px, transparent 10px) 0 0 / 24px 24px, linear-gradient(#111 10px, transparent 10px) 0 0 / 24px 24px, #ffffff;
        border: 8px solid #111;
        opacity: .28;
    }

    .barcode-preview img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: none;
    }

    .preview-info {
        border: 1.3px solid #d1d5db;
        border-radius: 10px;
        padding: 12px;
        background: #ffffff;
    }

    .preview-info h4 {
        margin: 0 0 10px 0;
        font-size: 14px;
        font-weight: 900;
    }

    .preview-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        border-bottom: 1px solid #e5e7eb;
        padding: 8px 0;
        font-size: 13px;
    }

    .preview-row span {
        color: #64748b;
    }

    .preview-row strong {
        text-align: right;
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

    .btn-upload {
        background: #003b78;
    }

    .btn-upload:hover:not(:disabled) {
        background: #002855;
    }

    .btn-notify {
        background: #16a34a;
    }

    .btn-notify:hover:not(:disabled) {
        background: #108238;
    }

    .history-box {
        margin-top: 14px;
        border: 1.3px solid #d1d5db;
        border-radius: 10px;
        padding: 12px;
        background: #f8fafc;
    }

    .history-box h4 {
        margin: 0 0 10px 0;
        font-size: 14px;
        font-weight: 900;
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

    .history-item span {
        color: #64748b;
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
        width: 460px;
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
        .barcode-layout {
            grid-template-columns: 1fr;
        }

        .submission-list {
            max-height: none;
        }
    }

    @media (max-width: 768px) {
        .barcode-page {
            padding-top: 8px;
        }

        .barcode-toolbar,
        .submission-meta,
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

<div class="barcode-page">
    <h2 class="barcode-title">Upload Barcode</h2>

    <div class="barcode-layout">
        <div class="panel">
            <div class="panel-header">
                <h3>Daftar Pengajuan (Siap Upload)</h3>
                <span id="selectedCounter">{{ $submissions->count() }} Data</span>
            </div>

            <div class="panel-body">
                <div class="barcode-toolbar">
                    <div class="barcode-search">
                        <span>⌕</span>
                        <input type="text" id="searchInput" placeholder="Cari sopir / no polisi..." onkeyup="searchBarcode()">
                    </div>

                    <select class="filter-select" id="statusFilter" onchange="searchBarcode()">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Upload">Menunggu Upload</option>
                        <option value="Barcode Terupload">Barcode Terupload</option>
                    </select>
                </div>

                <div class="submission-list" id="submissionList">
                    @forelse ($submissions as $index => $sub)
                    @php
                    $isUploaded = $sub->status === 'barcode_terbit';
                    $statusUI = $isUploaded ? 'Barcode Terupload' : 'Menunggu Upload';
                    $statusClass = $isUploaded ? 'status-uploaded' : 'status-waiting';

                    $driverName = $sub->vehicle && $sub->vehicle->user ? $sub->vehicle->user->name : '-';
                    $plateNum = $sub->vehicle ? $sub->vehicle->plate_number : '-';
                    $doorNum = $sub->vehicle ? $sub->vehicle->door_number : '-';
                    $area = $sub->vehicle && $sub->vehicle->user ? $sub->vehicle->user->operational_area : '-';
                    $phone = $sub->vehicle && $sub->vehicle->user ? $sub->vehicle->user->phone : '-';
                    $vehicleType = $sub->vehicle ? $sub->vehicle->vehicle_type : '-';
                    $dateStr = \Carbon\Carbon::parse($sub->submission_date)->format('d/m/Y');

                    $barcodeUrl = $sub->barcode && $sub->barcode->barcode_file ? asset('storage/' . $sub->barcode->barcode_file) : '';

                    $searchKeyword = strtolower("$driverName $plateNum $doorNum $statusUI");
                    @endphp

                    <div
                        class="submission-card {{ $index === 0 ? 'active' : '' }}"
                        data-search="{{ $searchKeyword }}"
                        data-status="{{ $statusUI }}"
                        onclick="selectSubmission(this, 
                                '{{ $sub->id }}', 
                                '{{ $sub->submission_code }}', 
                                '{{ $driverName }}', 
                                '{{ $plateNum }}', 
                                '{{ $doorNum }}', 
                                '{{ $dateStr }}', 
                                '{{ $statusUI }}', 
                                '{{ $phone }}', 
                                '{{ $vehicleType }}', 
                                '{{ $area }}',
                                '{{ $barcodeUrl }}'
                            )">
                        <div class="submission-top">
                            <div class="police-number">{{ $plateNum }}</div>
                            <div class="door-badge">{{ $doorNum }}</div>
                        </div>

                        <div class="submission-meta">
                            <span>Sopir: <strong>{{ $driverName }}</strong></span>
                            <span>Tanggal: <strong>{{ $dateStr }}</strong></span>
                            <span>Area: <strong>{{ $area }}</strong></span>
                            <span>ID: <strong>{{ $sub->submission_code }}</strong></span>
                        </div>

                        <span class="status-pill {{ $statusClass }}">{{ $statusUI }}</span>
                    </div>
                    @empty
                    <div class="empty-state">Tidak ada data yang menunggu upload barcode.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h3>Form Upload Hasil Barcode</h3>
                <span id="currentStatus" class="status-pill status-waiting">Pilih Data</span>
            </div>

            <div class="panel-body" id="formPanelBody" style="display:none;">
                <div class="detail-grid">
                    <div class="detail-box"><span>ID Pengajuan</span><strong id="detailId">-</strong></div>
                    <div class="detail-box"><span>Nama Sopir</span><strong id="detailDriver">-</strong></div>
                    <div class="detail-box"><span>No Polisi</span><strong id="detailPolice">-</strong></div>
                    <div class="detail-box"><span>No. Pintu</span><strong id="detailDoor">-</strong></div>
                    <div class="detail-box"><span>No HP</span><strong id="detailPhone">-</strong></div>
                    <div class="detail-box"><span>Jenis Kendaraan</span><strong id="detailVehicle">-</strong></div>
                </div>

                <div class="upload-section">
                    <h4>Upload File Barcode</h4>

                    <input type="file" id="barcodeFile" accept="image/jpeg,image/png,image/jpg" style="display:none;" onchange="handleFile(this.files[0])">

                    <div class="upload-area" id="uploadArea" onclick="document.getElementById('barcodeFile').click()">
                        <div class="upload-icon">▦</div>
                        <strong>Klik atau tarik file barcode ke sini</strong>
                        <span>Format disarankan: PNG, JPG, JPEG (Max 5MB)</span>
                        <div class="file-name" id="fileName"></div>
                    </div>

                    <div class="barcode-preview-wrap">
                        <div class="barcode-preview">
                            <div class="barcode-placeholder" id="barcodePlaceholder"></div>
                            <img id="barcodePreview" alt="Preview Barcode">
                        </div>

                        <div class="preview-info">
                            <h4>Informasi Upload</h4>

                            <div class="preview-row">
                                <span>Status Sistem</span>
                                <strong id="uploadStatus">Belum ada file</strong>
                            </div>

                            <div class="preview-row">
                                <span>Nama File</span>
                                <strong id="uploadFileName">-</strong>
                            </div>

                            <div class="preview-row">
                                <span>Notifikasi Sopir</span>
                                <strong id="notifyStatus">Belum dikirim</strong>
                            </div>
                        </div>
                    </div>

                    <textarea id="uploadNote" class="note-area" placeholder="Catatan tambahan (Opsional). Contoh: Barcode sudah bisa digunakan."></textarea>

                    <div class="action-row">
                        <button class="action-btn btn-upload" id="btnUpload" onclick="confirmUpload()">Upload & Simpan Barcode</button>
                        <button class="action-btn btn-notify" id="btnNotify" onclick="sendNotification()">Kirim Notifikasi Sopir</button>
                    </div>
                </div>
            </div>

            <div id="emptyPanelIndicator" class="empty-state">
                Silakan pilih pengajuan di panel sebelah kiri.
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <h3 class="modal-title">Konfirmasi Upload Barcode</h3>
        <p class="modal-text">
            Pastikan file gambar barcode sudah benar dan sesuai dengan plat nomor kendaraan yang dipilih.
        </p>

        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeConfirm()">Batal</button>
            <button class="btn-primary" id="btnExecuteUpload" onclick="runUpload()">Ya, Upload Sekarang</button>
        </div>
    </div>
</div>

<div class="toast" id="toastBox">Berhasil.</div>
@endsection

@push('scripts')
<script>
    let currentSubmissionId = null;
    let uploadedFile = null;
    let isBarcodeUploaded = false; // Flag untuk memastikan notifikasi hanya bisa dikirim setelah upload sukses

    document.addEventListener('DOMContentLoaded', function() {
        const firstCard = document.querySelector('.submission-card');
        if (firstCard) firstCard.click();
    });

    function selectSubmission(card, dbId, displayId, driver, police, door, date, status, phone, vehicle, area, barcodeUrl) {
        document.querySelectorAll('.submission-card').forEach(item => item.classList.remove('active'));
        card.classList.add('active');

        document.getElementById('emptyPanelIndicator').style.display = 'none';
        document.getElementById('formPanelBody').style.display = 'block';

        currentSubmissionId = dbId;

        // Isi Detail Text
        document.getElementById('detailId').innerText = displayId;
        document.getElementById('detailDriver').innerText = driver;
        document.getElementById('detailPolice').innerText = police;
        document.getElementById('detailDoor').innerText = door;
        document.getElementById('detailPhone').innerText = phone;
        document.getElementById('detailVehicle').innerText = vehicle;

        setStatusUI(status);
        resetUploadPreview();

        // Jika data dari database sudah memiliki gambar barcode, langsung tampilkan
        if (barcodeUrl) {
            isBarcodeUploaded = true;
            document.getElementById('uploadStatus').innerText = 'Tersimpan di server';
            document.getElementById('uploadFileName').innerText = 'barcode_lama.png';
            document.getElementById('notifyStatus').innerText = 'Siap dikirim';

            const preview = document.getElementById('barcodePreview');
            const placeholder = document.getElementById('barcodePlaceholder');
            preview.src = barcodeUrl;
            preview.style.display = 'block';
            placeholder.style.display = 'none';

            // Ubah teks tombol menjadi Update
            document.getElementById('btnUpload').innerText = "Update Barcode Baru";
        }
    }

    function setStatusUI(status) {
        const currentStatus = document.getElementById('currentStatus');
        currentStatus.innerText = status;
        currentStatus.className = 'status-pill';

        if (status === 'Barcode Terupload') {
            currentStatus.classList.add('status-uploaded');
        } else {
            currentStatus.classList.add('status-waiting');
        }
    }

    function searchBarcode() {
        const keyword = document.getElementById('searchInput').value.trim().toLowerCase();
        const status = document.getElementById('statusFilter').value;
        const cards = document.querySelectorAll('.submission-card');
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

    function handleFile(file) {
        if (!file) return;

        // Validasi ekstensi
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            showToast('Gagal: Format wajib berupa gambar JPG/PNG.');
            return;
        }

        // Validasi ukuran (Max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            showToast('Gagal: Ukuran gambar maksimal 5MB.');
            return;
        }

        uploadedFile = file;

        document.getElementById('fileName').style.display = 'block';
        document.getElementById('fileName').innerText = file.name;
        document.getElementById('uploadStatus').innerText = 'Siap diupload ke server';
        document.getElementById('uploadFileName').innerText = file.name;

        const preview = document.getElementById('barcodePreview');
        const placeholder = document.getElementById('barcodePlaceholder');

        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        placeholder.style.display = 'none';

        document.getElementById('btnUpload').innerText = "Upload & Simpan Barcode";
    }

    function resetUploadPreview() {
        uploadedFile = null;
        isBarcodeUploaded = false;

        document.getElementById('barcodeFile').value = '';
        document.getElementById('fileName').style.display = 'none';
        document.getElementById('uploadStatus').innerText = 'Belum ada file';
        document.getElementById('uploadFileName').innerText = '-';
        document.getElementById('notifyStatus').innerText = 'Belum dikirim';
        document.getElementById('uploadNote').value = '';

        document.getElementById('barcodePreview').style.display = 'none';
        document.getElementById('barcodePreview').src = '';
        document.getElementById('barcodePlaceholder').style.display = 'block';

        document.getElementById('btnUpload').innerText = "Upload & Simpan Barcode";
    }

    function confirmUpload() {
        if (!uploadedFile) {
            showToast('Pilih atau tarik file gambar barcode terlebih dahulu.');
            return;
        }
        document.getElementById('confirmModal').classList.add('show');
    }

    function closeConfirm() {
        document.getElementById('confirmModal').classList.remove('show');
    }

    // Eksekusi AJAX Fetch ke Laravel Controller
    function runUpload() {
        const btnExe = document.getElementById('btnExecuteUpload');
        btnExe.innerText = 'Mengupload...';
        btnExe.disabled = true;

        let formData = new FormData();
        formData.append('barcode_file', uploadedFile);
        formData.append('note', document.getElementById('uploadNote').value);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        fetch(`/admin/upload-barcode/${currentSubmissionId}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    isBarcodeUploaded = true;
                    setStatusUI('Barcode Terupload');

                    // Ubah status di list kiri (kartu aktif)
                    const activeCard = document.querySelector('.submission-card.active');
                    if (activeCard) {
                        activeCard.setAttribute('data-status', 'Barcode Terupload');
                        activeCard.querySelector('.status-pill').innerText = 'Barcode Terupload';
                        activeCard.querySelector('.status-pill').className = 'status-pill status-uploaded';
                    }

                    document.getElementById('uploadStatus').innerText = 'Sukses tersimpan di server';
                    document.getElementById('notifyStatus').innerText = 'Siap dikirim ke sopir';

                    showToast(data.message);
                    closeConfirm();
                } else {
                    showToast('Gagal mengupload barcode.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan jaringan.');
            })
            .finally(() => {
                btnExe.innerText = 'Ya, Upload Sekarang';
                btnExe.disabled = false;
            });
    }

    function sendNotification() {
        if (!isBarcodeUploaded) {
            showToast('Anda harus mengupload dan menyimpan barcode terlebih dahulu sebelum mengirim notifikasi.');
            return;
        }

        const btnNotif = document.getElementById('btnNotify');
        btnNotif.innerText = 'Mengirim...';
        btnNotif.disabled = true;

        fetch(`/admin/upload-barcode/${currentSubmissionId}/notify`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('notifyStatus').innerText = 'Berhasil Terkirim';
                    showToast(data.message);
                } else {
                    showToast('Gagal mengirim notifikasi.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan jaringan saat mengirim notifikasi.');
            })
            .finally(() => {
                btnNotif.innerText = 'Kirim Notifikasi Sopir';
                btnNotif.disabled = false;
            });
    }

    // Drag and Drop Logics
    const uploadArea = document.getElementById('uploadArea');
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    uploadArea.addEventListener('dragleave', function() {
        uploadArea.classList.remove('dragover');
    });
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        handleFile(e.dataTransfer.files[0]);
    });

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