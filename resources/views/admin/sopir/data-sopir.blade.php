@extends('layouts.admin')

@section('title', 'Data Sopir - SolarIn')
@section('page-greeting', 'Selamat Datang, Admin')
@section('page-subtitle', 'Kelola dan Pantau Pengajuan Barcode Solar Subsidi')

@push('styles')
<style>
    /* Reset & Variabel Warna */
    :root {
        --primary: #003b78;
        --primary-hover: #002855;
        --text-dark: #111827;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --bg-hover: #f1f5f9;
        --radius-md: 8px;
        --radius-lg: 12px;
    }

    .driver-page,
    .driver-page * {
        box-sizing: border-box;
    }

    .driver-page {
        width: 100%;
        padding-top: 10px;
        color: var(--text-dark);
    }

    /* Toolbar Layout */
    .driver-toolbar {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        align-items: center;
        flex-wrap: wrap;
    }

    .driver-search {
        flex: 1;
        min-width: 250px;
        height: 44px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        padding: 0 14px;
        background: #ffffff;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: all 0.2s;
    }

    .driver-search:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 59, 120, 0.1);
    }

    .driver-search .search-icon {
        font-size: 18px;
        color: var(--text-muted);
        flex-shrink: 0;
    }

    .driver-search input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 14px;
        background: transparent;
        padding: 0 10px;
        color: var(--text-dark);
        width: 100%;
    }

    .driver-search button {
        border: none;
        background: transparent;
        font-size: 20px;
        cursor: pointer;
        color: var(--text-muted);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .driver-search button:hover {
        background: var(--bg-hover);
        color: var(--text-dark);
    }

    .filter-button {
        height: 44px;
        padding: 0 16px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        background: #ffffff;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: var(--text-dark);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: 0.2s;
    }

    .filter-button:hover {
        background: var(--bg-hover);
    }

    .add-button {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-md);
        background: var(--primary);
        color: #ffffff;
        border: none;
        font-size: 24px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px rgba(0, 59, 120, 0.2);
        transition: 0.2s;
        flex-shrink: 0;
    }

    .add-button:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
    }

    /* Table Styling */
    .table-wrap {
        width: 100%;
        overflow-x: auto;
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .driver-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
        font-size: 14px;
    }

    .driver-table th {
        background: var(--bg-light);
        color: var(--text-muted);
        font-size: 13px;
        font-weight: 600;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color);
    }

    .driver-table td {
        text-align: left;
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-dark);
    }

    .driver-table tbody tr {
        transition: 0.15s;
    }

    .driver-table tbody tr:hover td {
        background: var(--bg-hover);
    }

    .driver-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .door-badge {
        background: #e0f2fe;
        color: #0369a1;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
    }

    .empty-row td {
        padding: 40px 20px;
        color: var(--text-muted);
        font-weight: 500;
        text-align: center;
    }

    .pagination-box {
        display: flex;
        justify-content: flex-end;
        margin-top: 24px;
    }

    /* Mobile Version */
    .mobile-driver-list {
        display: none;
    }

    .mobile-driver-card {
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        background: #ffffff;
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .mobile-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--bg-hover);
    }

    .mobile-card-name {
        font-weight: 700;
        font-size: 16px;
        color: var(--text-dark);
    }

    .mobile-card-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        font-size: 13px;
    }

    .mobile-card-row span:first-child {
        color: var(--text-muted);
    }

    .mobile-card-row span:last-child {
        font-weight: 500;
        text-align: right;
    }

    /* Modal Styling */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 1050;
        /* Diperbesar agar di atas navbar admin */
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.2s ease-out;
    }

    .modal-overlay.show {
        display: flex;
        opacity: 1;
    }

    .modal-box {
        width: 480px;
        max-width: 100%;
        background: #ffffff;
        border-radius: var(--radius-lg);
        padding: 24px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        transform: translateY(20px);
        transition: transform 0.2s ease-out;
    }

    .modal-overlay.show .modal-box {
        transform: translateY(0);
    }

    .modal-box.large {
        width: 640px;
    }

    .modal-title {
        margin: 0 0 20px 0;
        font-size: 20px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .modal-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text-dark);
    }

    .form-group input,
    .form-group select {
        width: 100%;
        height: 42px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 0 12px;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 59, 120, 0.1);
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
    }

    .modal-actions button {
        border-radius: var(--radius-md);
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-cancel {
        background: #ffffff;
        color: var(--text-dark);
        border: 1px solid var(--border-color);
    }

    .btn-cancel:hover {
        background: var(--bg-hover);
    }

    .btn-blue {
        background: var(--primary);
        color: #ffffff;
        border: none;
    }

    .btn-blue:hover {
        background: var(--primary-hover);
    }

    /* Toast */
    .toast {
        display: none;
        position: fixed;
        right: 24px;
        bottom: 24px;
        background: var(--text-dark);
        color: #ffffff;
        padding: 14px 24px;
        border-radius: var(--radius-md);
        font-size: 14px;
        font-weight: 500;
        z-index: 2000;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.3s;
    }

    .toast.show {
        display: block;
        transform: translateY(0);
        opacity: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .driver-toolbar {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
        }

        .driver-search {
            grid-column: 1 / -1;
        }

        .filter-button {
            width: 100%;
            justify-content: center;
        }

        .table-wrap {
            display: none;
        }

        .mobile-driver-list {
            display: block;
        }

        .modal-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .modal-actions {
            flex-direction: column;
        }

        .modal-actions button {
            width: 100%;
        }

        .toast {
            left: 16px;
            right: 16px;
            bottom: 16px;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="driver-page">

    <div class="driver-toolbar">
        <div class="driver-search">
            <span class="search-icon">⌕</span>
            <input type="text" id="searchInput" placeholder="Cari nama sopir, no pintu, area..." onkeyup="searchDriver()">
            <button type="button" onclick="clearSearch()" title="Bersihkan Pencarian">×</button>
        </div>

        <button type="button" class="filter-button" onclick="openFilterModal()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filter
        </button>

        <button type="button" class="add-button" onclick="openAddModal()" title="Tambah Sopir">+</button>
    </div>

    <div class="table-wrap">
        <table class="driver-table">
            <thead>
                <tr>
                    <th>Nama Sopir</th>
                    <th>No. Pintu</th>
                    <th>No. HP</th>
                    <th>Area Operasional</th>
                    <th>Lokasi Terakhir</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="driverTableBody">
                @forelse ($sopirs as $sopir)
                @php
                $vehicle = $sopir->vehicles->first();
                $location = $sopir->last_latitude && $sopir->last_longitude
                ? $sopir->last_latitude . ', ' . $sopir->last_longitude
                : '-';
                @endphp
                <tr
                    data-area="{{ $sopir->operational_area ?? '-' }}"
                    data-status="{{ $sopir->status }}"
                    data-search="{{ strtolower($sopir->name . ' ' . ($vehicle->door_number ?? '') . ' ' . $sopir->phone . ' ' . ($sopir->operational_area ?? '') . ' ' . $sopir->status) }}">
                    <td style="font-weight: 500;">{{ $sopir->name }}</td>
                    <td><span class="door-badge">{{ $vehicle->door_number ?? '-' }}</span></td>
                    <td>{{ $sopir->phone ?? '-' }}</td>
                    <td>{{ $sopir->operational_area ?? '-' }}</td>
                    <td>{{ $location }}</td>
                    <td>
                        <span class="status-badge {{ $sopir->status === 'aktif' ? 'status-active' : 'status-inactive' }}">
                            {{ ucfirst($sopir->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr id="emptyTableRow" class="empty-row">
                    <td colspan="6">Belum ada data sopir.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mobile-driver-list" id="mobileDriverList">
        @forelse ($sopirs as $sopir)
        @php
        $vehicle = $sopir->vehicles->first();
        $location = $sopir->last_latitude && $sopir->last_longitude
        ? $sopir->last_latitude . ', ' . $sopir->last_longitude
        : '-';
        @endphp
        <div class="mobile-driver-card"
            data-area="{{ $sopir->operational_area ?? '-' }}"
            data-status="{{ $sopir->status }}"
            data-search="{{ strtolower($sopir->name . ' ' . ($vehicle->door_number ?? '') . ' ' . $sopir->phone . ' ' . ($sopir->operational_area ?? '') . ' ' . $sopir->status) }}">
            <div class="mobile-card-top">
                <div class="mobile-card-name">{{ $sopir->name }}</div>
                <div class="door-badge">{{ $vehicle->door_number ?? '-' }}</div>
            </div>
            <div class="mobile-card-row"><span>No. HP</span><span>{{ $sopir->phone ?? '-' }}</span></div>
            <div class="mobile-card-row"><span>Area</span><span>{{ $sopir->operational_area ?? '-' }}</span></div>
            <div class="mobile-card-row"><span>Lokasi</span><span>{{ $location }}</span></div>
            <div class="mobile-card-row">
                <span>Status</span>
                <span class="status-badge {{ $sopir->status === 'aktif' ? 'status-active' : 'status-inactive' }}">{{ ucfirst($sopir->status) }}</span>
            </div>
        </div>
        @empty
        <div id="emptyMobileRow" class="mobile-driver-card" style="text-align:center; font-weight:600; color:var(--text-muted); padding: 32px 16px;">
            Belum ada data sopir.
        </div>
        @endforelse
    </div>

    <div class="pagination-box">
        {{ $sopirs->links() }}
    </div>

    <div class="modal-overlay" id="addModal">
        <div class="modal-box large">
            <h3 class="modal-title">Tambah Sopir Baru</h3>

            <form id="addSopirForm" action="{{ route('admin.sopir.store') }}" method="POST">
                @csrf
                <div class="modal-grid">
                    <div class="form-group">
                        <label>Nama Sopir</label>
                        <input type="text" name="name" placeholder="Contoh: Arif Santoso" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Contoh: arifsantoso" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="arif@solarin.test" required>
                    </div>
                    <div class="form-group">
                        <label>No. HP</label>
                        <input type="text" name="phone" placeholder="08123456789" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="form-group">
                        <label>Area Operasional</label>
                        <input type="text" name="operational_area" placeholder="Contoh: Gresik">
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label>Alamat</label>
                        <input type="text" name="address" placeholder="Alamat lengkap sopir">
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeAddModal()">Batal</button>
                    <button type="submit" class="btn-blue">Simpan Sopir</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="filterModal">
        <div class="modal-box">
            <h3 class="modal-title">Filter Data Sopir</h3>
            <div class="form-group">
                <label>Area Operasional</label>
                <select id="filterArea">
                    <option value="">Semua Area</option>
                    @foreach ($sopirs->pluck('operational_area')->unique()->filter() as $area)
                    <option value="{{ $area }}">{{ $area }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Status Akun</label>
                <select id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeFilterModal()">Batal</button>
                <button type="button" class="btn-blue" onclick="applyFilter()">Terapkan Filter</button>
            </div>
        </div>
    </div>

    <div class="toast" id="toastBox">Berhasil.</div>

</div> @endsection @push('scripts')
<script>
    let activeArea = '';
    let activeStatus = '';
    let activeKeyword = '';

    function allItems() {
        return [
            ...document.querySelectorAll('#driverTableBody tr[data-area]'),
            ...document.querySelectorAll('#mobileDriverList .mobile-driver-card[data-area]')
        ];
    }

    function renderData() {
        let tableVisible = 0;
        let mobileVisible = 0;

        allItems().forEach(item => {
            const area = item.getAttribute('data-area') || '';
            const status = item.getAttribute('data-status') || '';
            const searchText = item.getAttribute('data-search') || '';

            const matchArea = activeArea === '' || area === activeArea;
            const matchStatus = activeStatus === '' || status === activeStatus;
            const matchKeyword = activeKeyword === '' || searchText.includes(activeKeyword);

            const visible = matchArea && matchStatus && matchKeyword;
            item.style.display = visible ? '' : 'none';

            if (visible && item.tagName === 'TR') tableVisible++;
            if (visible && item.classList.contains('mobile-driver-card')) mobileVisible++;
        });

        const emptyTable = document.getElementById('emptyTableRow');
        const emptyMobile = document.getElementById('emptyMobileRow');

        if (emptyTable) emptyTable.style.display = tableVisible === 0 ? '' : 'none';
        if (emptyMobile) emptyMobile.style.display = mobileVisible === 0 ? '' : 'none';
    }

    function searchDriver() {
        activeKeyword = document.getElementById('searchInput').value.trim().toLowerCase();
        renderData();
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        activeKeyword = '';
        renderData();
    }

    function openAddModal() {
        const modal = document.getElementById('addModal');
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('show'), 10);
    }

    function closeAddModal() {
        const modal = document.getElementById('addModal');
        modal.classList.remove('show');
        setTimeout(() => modal.style.display = 'none', 200);
    }

    function openFilterModal() {
        const modal = document.getElementById('filterModal');
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('show'), 10);
    }

    function closeFilterModal() {
        const modal = document.getElementById('filterModal');
        modal.classList.remove('show');
        setTimeout(() => modal.style.display = 'none', 200);
    }

    function applyFilter() {
        activeArea = document.getElementById('filterArea').value;
        activeStatus = document.getElementById('filterStatus').value;
        renderData();
        closeFilterModal();
        showToast('Filter berhasil diterapkan.');
    }

    function showToast(message) {
        const toast = document.getElementById('toastBox');
        toast.innerText = message;
        toast.classList.remove('show');
        void toast.offsetWidth;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2500);
    }

    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('show');
                setTimeout(() => this.style.display = 'none', 200);
            }
        });
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.show').forEach(el => {
                el.classList.remove('show');
                setTimeout(() => el.style.display = 'none', 200);
            });
        }
    });

    document.addEventListener('DOMContentLoaded', renderData);
</script>
@endpush