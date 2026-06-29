@extends('layouts.admin')

@section('title', 'Data Pengajuan - SolarIn')
@section('page-greeting', 'Selamat Datang, Admin')
@section('page-subtitle', 'Kelola dan Pantau Pengajuan Barcode Solar Subsidi')

@push('styles')
<style>
    .submission-page {
        padding-top: 22px;
    }

    .submission-title {
        font-size: 23px;
        font-weight: 800;
        margin: 0 0 24px 0;
    }

    .submission-toolbar {
        display: grid;
        grid-template-columns: 1fr 145px;
        gap: 12px;
        align-items: center;
        margin-bottom: 18px;
    }

    .submission-search {
        height: 46px;
        border: 1.5px solid #111827;
        border-radius: 8px;
        display: flex;
        align-items: center;
        padding: 0 12px;
        gap: 10px;
        background: #ffffff;
    }

    .submission-search .search-icon {
        font-size: 17px;
        color: #003b78;
        flex-shrink: 0;
    }

    .submission-search input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 15px;
        background: transparent;
        min-width: 0;
    }

    .submission-search button {
        border: none;
        background: transparent;
        font-size: 21px;
        cursor: pointer;
        color: #111827;
        width: 25px;
        height: 25px;
        line-height: 1;
    }

    .filter-button {
        height: 46px;
        border: 1.5px solid #111827;
        border-radius: 10px;
        background: #ffffff;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        cursor: pointer;
        color: #111827;
    }

    .filter-button .filter-icon {
        font-size: 18px;
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #d1d5db;
        border-radius: 2px;
    }

    .submission-table {
        width: 100%;
        min-width: 820px;
        border-collapse: collapse;
        font-size: 14px;
    }

    .submission-table th {
        background: #e7e7e7;
        font-size: 14px;
        font-weight: 600;
        text-align: center;
        border: 1px solid #d1d5db;
        padding: 12px 8px;
    }

    .submission-table td {
        text-align: center;
        border: 1px solid #d1d5db;
        padding: 11px 8px;
        background: #ffffff;
    }

    .submission-table tbody tr {
        cursor: pointer;
        transition: .18s;
    }

    .submission-table tbody tr:hover td {
        background: #eef5ff;
    }

    .date-pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 999px;
        background: #e5e5e5;
        color: #111827;
    }

    .status-waiting {
        color: #111827;
        font-weight: 500;
    }

    .status-rejected {
        color: #ff0000;
        font-weight: 600;
    }

    .status-verified {
        color: #00b050;
        font-weight: 600;
    }

    .status-objection {
        color: #ff7a00;
        font-weight: 600;
        line-height: 1.2;
    }

    .status-process {
        color: #1d4ed8;
        font-weight: 600;
    }

    .empty-row td {
        padding: 24px;
        color: #64748b;
        font-weight: 700;
        text-align: center;
    }

    .pagination-box {
        display: flex;
        justify-content: flex-end;
        margin-top: 32px;
    }

    .pagination-inner {
        display: flex;
        border: 2px solid #111827;
        border-radius: 2px;
        overflow: hidden;
    }

    .pagination-inner button {
        min-width: 44px;
        height: 46px;
        border: none;
        border-right: 2px solid #111827;
        background: #ffffff;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
    }

    .pagination-inner button:last-child {
        border-right: none;
        min-width: 58px;
    }

    .pagination-inner button.active {
        background: #eef5ff;
        color: #003b78;
    }

    .mobile-submission-list {
        display: none;
    }

    .mobile-submission-card {
        border: 1.5px solid #d1d5db;
        border-radius: 12px;
        background: #ffffff;
        padding: 13px;
        margin-bottom: 12px;
        box-shadow: 0 6px 16px rgba(15, 23, 42, .06);
        cursor: pointer;
    }

    .mobile-card-top {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 9px;
    }

    .mobile-card-police {
        font-weight: 800;
        font-size: 15px;
    }

    .mobile-card-door {
        background: #eef5ff;
        color: #003b78;
        border-radius: 999px;
        padding: 3px 9px;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .mobile-card-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 6px 0;
        border-top: 1px solid #eef2f7;
        font-size: 12px;
    }

    .mobile-card-row span:first-child {
        color: #64748b;
    }

    .mobile-card-row span:last-child {
        font-weight: 700;
        text-align: right;
    }

    /* MODALS */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .42);
        z-index: 200;
        align-items: center;
        justify-content: center;
        padding: 18px;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-box {
        width: 500px;
        max-width: 100%;
        background: #ffffff;
        border-radius: 14px;
        border: 2px solid #111827;
        padding: 20px;
        box-shadow: 0 24px 60px rgba(0, 0, 0, .25);
    }

    .modal-title {
        margin: 0 0 16px 0;
        font-size: 22px;
        font-weight: 800;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .form-group select {
        width: 100%;
        height: 39px;
        border: 1px solid #9ca3af;
        border-radius: 8px;
        padding: 8px 10px;
        font-size: 13px;
        outline: none;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        border-bottom: 1px solid #d1d5db;
        padding: 9px 0;
        font-size: 14px;
    }

    .detail-row span {
        color: #475569;
    }

    .detail-row strong {
        text-align: right;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 18px;
    }

    .modal-actions button,
    .modal-actions a {
        border: 1px solid #111827;
        border-radius: 8px;
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-cancel {
        background: #ffffff;
        color: #111827;
    }

    .btn-blue {
        background: #003b78;
        color: #ffffff;
        border-color: #003b78 !important;
    }

    .btn-red {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626 !important;
    }

    .btn-green {
        background: #16a34a;
        color: #ffffff;
        border-color: #16a34a !important;
    }

    @media (max-width: 768px) {
        .submission-page {
            padding-top: 8px;
        }

        .submission-toolbar {
            grid-template-columns: 1fr 42px;
            gap: 9px;
        }

        .filter-button {
            grid-column: 1 / 3;
            height: 41px;
            font-size: 14px;
        }

        .table-wrap {
            display: none;
        }

        .mobile-submission-list {
            display: block;
        }

        .pagination-box {
            justify-content: center;
        }

        .modal-actions {
            flex-direction: column;
        }

        .modal-actions button,
        .modal-actions a {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

@php
function submissionStatusClass($status) {
return match ($status) {
'Ditolak' => 'status-rejected',
'Terverifikasi' => 'status-verified',
'Pengajuan Sanggah' => 'status-objection',
'Dalam Proses' => 'status-process',
default => 'status-waiting',
};
}
@endphp

<div class="submission-page">
    <h2 class="submission-title">Data Pengajuan</h2>

    <div class="submission-toolbar">
        <div class="submission-search">
            <span class="search-icon">⌕</span>
            <input type="text" id="searchInput" placeholder="Cari no polisi, no pintu, status..." onkeyup="searchSubmission()">
            <button type="button" onclick="clearSearch()">×</button>
        </div>

        <button type="button" class="filter-button" onclick="openFilterModal()">
            <span class="filter-icon">▽</span>
            <span>Filter</span>
        </button>
    </div>

    <div class="table-wrap">
        <table class="submission-table">
            <thead>
                <tr>
                    <th>No Polisi</th>
                    <th>No. Pintu</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Dokumen</th>
                    <th>Tanggal Update</th>
                    <th>Status Pengajuan</th>
                </tr>
            </thead>

            <tbody id="submissionTableBody">
                @foreach ($submissions as $sub)
                @php
                // Mapping Status DB ke UI
                $statusUI = match($sub->status) {
                'ditolak' => 'Ditolak',
                'diproses' => 'Dalam Proses',
                'disetujui', 'barcode_terbit', 'menunggu_upload_barcode', 'menunggu_penerbitan' => 'Terverifikasi',
                'pengajuan_sanggah' => 'Pengajuan Sanggah',
                default => 'Menunggu Verifikasi',
                };

                // Cek kelengkapan dokumen
                $docStatus = 'Menunggu';
                if ($sub->status === 'ditolak') {
                $docStatus = 'Ditolak';
                } elseif (in_array($sub->status, ['diproses', 'disetujui', 'barcode_terbit', 'menunggu_upload_barcode', 'menunggu_penerbitan'])) {
                $docStatus = 'Disetujui';
                }

                $police = $sub->vehicle->plate_number;
                $door = $sub->vehicle->door_number;
                $date = \Carbon\Carbon::parse($sub->submission_date)->format('d/m/Y');
                $update = \Carbon\Carbon::parse($sub->updated_at)->format('d/m/Y');
                $searchStr = strtolower("$police $door $date $docStatus $update $statusUI");
                @endphp

                <tr class="submission-row"
                    data-document="{{ $docStatus }}"
                    data-status="{{ $statusUI }}"
                    data-search="{{ $searchStr }}"
                    onclick="openDetailModal('{{ $police }}','{{ $door }}','{{ $date }}','{{ $docStatus }}','{{ $update }}','{{ $statusUI }}')">

                    <td>{{ $police }}</td>
                    <td>{{ $door }}</td>
                    <td><span class="date-pill">{{ $date }}</span></td>
                    <td>{{ $docStatus }}</td>
                    <td><span class="date-pill">{{ $update }}</span></td>
                    <td>
                        <span class="{{ submissionStatusClass($statusUI) }}">
                            {!! $statusUI === 'Pengajuan Sanggah' ? 'Pengajuan<br>Sanggah' : $statusUI !!}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mobile-submission-list" id="mobileSubmissionList">
        @foreach ($submissions as $sub)
        @php
        $statusUI = match($sub->status) {
        'ditolak' => 'Ditolak',
        'diproses' => 'Dalam Proses',
        'disetujui', 'barcode_terbit', 'menunggu_upload_barcode', 'menunggu_penerbitan' => 'Terverifikasi',
        'pengajuan_sanggah' => 'Pengajuan Sanggah',
        default => 'Menunggu Verifikasi',
        };

        $docStatus = 'Menunggu';
        if ($sub->status === 'ditolak') $docStatus = 'Ditolak';
        elseif (in_array($sub->status, ['diproses', 'disetujui', 'barcode_terbit', 'menunggu_upload_barcode', 'menunggu_penerbitan'])) $docStatus = 'Disetujui';

        $police = $sub->vehicle->plate_number;
        $door = $sub->vehicle->door_number;
        $date = \Carbon\Carbon::parse($sub->submission_date)->format('d/m/Y');
        $update = \Carbon\Carbon::parse($sub->updated_at)->format('d/m/Y');
        $searchStr = strtolower("$police $door $date $docStatus $update $statusUI");
        @endphp

        <div class="mobile-submission-card submission-row"
            data-document="{{ $docStatus }}"
            data-status="{{ $statusUI }}"
            data-search="{{ $searchStr }}"
            onclick="openDetailModal('{{ $police }}','{{ $door }}','{{ $date }}','{{ $docStatus }}','{{ $update }}','{{ $statusUI }}')">

            <div class="mobile-card-top">
                <div class="mobile-card-police">{{ $police }}</div>
                <div class="mobile-card-door">{{ $door }}</div>
            </div>
            <div class="mobile-card-row"><span>Tanggal Pengajuan</span><span>{{ $date }}</span></div>
            <div class="mobile-card-row"><span>Dokumen</span><span>{{ $docStatus }}</span></div>
            <div class="mobile-card-row"><span>Tanggal Update</span><span>{{ $update }}</span></div>
            <div class="mobile-card-row"><span>Status</span><span class="{{ submissionStatusClass($statusUI) }}">{{ $statusUI }}</span></div>
        </div>
        @endforeach
    </div>

    <div id="emptyState" class="empty-row" style="display:none; text-align: center; padding: 24px; color: #64748b; font-weight: 700; border: 1px solid #d1d5db; background: #fff; margin-top: -1px;">
        Data pengajuan tidak ditemukan.
    </div>

    <div class="pagination-box" id="paginationBox">
        <div class="pagination-inner" id="paginationInner">
        </div>
    </div>
</div>

<div class="modal-overlay" id="filterModal">
    <div class="modal-box">
        <h3 class="modal-title">Filter Data Pengajuan</h3>

        <div class="form-group">
            <label>Status Pengajuan</label>
            <select id="filterStatus">
                <option value="">Semua Status</option>
                <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                <option value="Dalam Proses">Dalam Proses</option>
                <option value="Terverifikasi">Terverifikasi</option>
                <option value="Ditolak">Ditolak</option>
                <option value="Pengajuan Sanggah">Pengajuan Sanggah</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status Dokumen</label>
            <select id="filterDocument">
                <option value="">Semua Dokumen</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>

        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeFilterModal()">Batal</button>
            <button type="button" class="btn-red" onclick="resetFilter()">Reset</button>
            <button type="button" class="btn-blue" onclick="applyFilter()">Terapkan Filter</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="detailModal">
    <div class="modal-box">
        <h3 class="modal-title">Detail Pengajuan</h3>

        <div class="detail-row"><span>No Polisi</span><strong id="detailPolice">-</strong></div>
        <div class="detail-row"><span>No. Pintu</span><strong id="detailDoor">-</strong></div>
        <div class="detail-row"><span>Tanggal Pengajuan</span><strong id="detailDate">-</strong></div>
        <div class="detail-row"><span>Status Dokumen</span><strong id="detailDocument">-</strong></div>
        <div class="detail-row"><span>Tanggal Update</span><strong id="detailUpdate">-</strong></div>
        <div class="detail-row"><span>Status Pengajuan</span><strong id="detailStatus">-</strong></div>

        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeDetailModal()">Tutup</button>
            <a href="{{ route('admin.verifikasi') }}" class="btn-green">Verifikasi</a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let currentPage = 1;
    let itemsPerPage = 10; // Menampilkan 10 data per halaman
    let activeStatus = '';
    let activeDocument = '';
    let activeKeyword = '';

    // Ambil semua elemen tabel dan mobile
    const tableRows = Array.from(document.querySelectorAll('#submissionTableBody .submission-row'));
    const mobileRows = Array.from(document.querySelectorAll('#mobileSubmissionList .submission-row'));

    document.addEventListener('DOMContentLoaded', function() {
        renderData();
    });

    function renderData() {
        let filteredIndexes = []; // Menyimpan index data yang lolos filter

        // Karena data di tabel dan mobile urutannya sama persis, kita cukup looping salah satunya
        for (let i = 0; i < tableRows.length; i++) {
            const status = tableRows[i].getAttribute('data-status');
            const documentStatus = tableRows[i].getAttribute('data-document');
            const searchText = tableRows[i].getAttribute('data-search');

            const matchStatus = activeStatus === '' || status === activeStatus;
            const matchDocument = activeDocument === '' || documentStatus === activeDocument;
            const matchKeyword = activeKeyword === '' || searchText.includes(activeKeyword);

            if (matchStatus && matchDocument && matchKeyword) {
                filteredIndexes.push(i);
            }

            // Sembunyikan semua dulu
            tableRows[i].style.display = 'none';
            mobileRows[i].style.display = 'none';
        }

        // State Kosong
        document.getElementById('emptyState').style.display = filteredIndexes.length === 0 ? 'block' : 'none';
        document.getElementById('paginationBox').style.display = filteredIndexes.length === 0 ? 'none' : 'flex';

        // Hitung Pagination
        let totalPages = Math.ceil(filteredIndexes.length / itemsPerPage);
        if (currentPage > totalPages && totalPages > 0) currentPage = totalPages;

        let startIndex = (currentPage - 1) * itemsPerPage;
        let endIndex = startIndex + itemsPerPage;

        // Tampilkan data yang sesuai halaman aktif
        for (let j = startIndex; j < endIndex && j < filteredIndexes.length; j++) {
            let actualIndex = filteredIndexes[j];
            tableRows[actualIndex].style.display = '';
            mobileRows[actualIndex].style.display = '';
        }

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const paginationInner = document.getElementById('paginationInner');
        paginationInner.innerHTML = '';

        if (totalPages <= 1) return;

        for (let i = 1; i <= totalPages; i++) {
            let btn = document.createElement('button');
            btn.type = 'button';
            btn.innerText = i;
            if (i === currentPage) btn.classList.add('active');

            btn.onclick = function() {
                currentPage = i;
                renderData();
            };
            paginationInner.appendChild(btn);
        }
    }

    function searchSubmission() {
        activeKeyword = document.getElementById('searchInput').value.trim().toLowerCase();
        currentPage = 1;
        renderData();
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        activeKeyword = '';
        currentPage = 1;
        renderData();
    }

    function openFilterModal() {
        document.getElementById('filterModal').classList.add('show');
    }

    function closeFilterModal() {
        document.getElementById('filterModal').classList.remove('show');
    }

    function applyFilter() {
        activeStatus = document.getElementById('filterStatus').value;
        activeDocument = document.getElementById('filterDocument').value;
        currentPage = 1;
        renderData();
        closeFilterModal();
    }

    function resetFilter() {
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterDocument').value = '';
        document.getElementById('searchInput').value = '';
        activeStatus = '';
        activeDocument = '';
        activeKeyword = '';
        currentPage = 1;
        renderData();
        closeFilterModal();
    }

    function openDetailModal(police, door, date, documentStatus, update, status) {
        document.getElementById('detailPolice').innerText = police;
        document.getElementById('detailDoor').innerText = door;
        document.getElementById('detailDate').innerText = date;
        document.getElementById('detailDocument').innerText = documentStatus;
        document.getElementById('detailUpdate').innerText = update;
        document.getElementById('detailStatus').innerText = status;
        document.getElementById('detailModal').classList.add('show');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('show');
    }
</script>
@endpush