@extends('layouts.admin')

@section('title', 'Manajemen User - SolarIn')
@section('page-greeting', 'Selamat Datang, Admin')
@section('page-subtitle', 'Kelola Akun Sopir')

@push('styles')
<style>
    .user-page {
        padding-top: 18px;
    }

    .page-title {
        font-size: 22px;
        font-weight: 900;
        margin-bottom: 18px;
    }

    /* Alert Error */
    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 16px;
        border: 1.5px solid #dc2626;
        font-weight: 800;
        font-size: 13px;
    }

    .alert-error ul {
        margin: 0;
        padding-left: 20px;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 22px;
    }

    .summary-card {
        border: 2px solid #111;
        border-radius: 16px;
        background: #fff;
        padding: 16px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .summary-title {
        font-size: 18px;
        font-weight: 900;
        text-align: center;
        margin-bottom: 12px;
    }

    .summary-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 24px;
    }

    .summary-icon {
        width: 52px;
        height: 52px;
        font-size: 38px;
        font-weight: 900;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .summary-card strong {
        font-size: 38px;
        font-weight: 900;
    }

    .user-list-section {
        background: #fff;
        border: 1.5px solid #d1d5db;
        border-radius: 12px;
        padding: 16px;
    }

    .user-list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }

    .user-list-actions {
        display: flex;
        gap: 8px;
    }

    .btn-outline {
        height: 34px;
        border-radius: 7px;
        padding: 0 13px;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        background: #fff;
        border: 1.4px solid #111;
    }

    .user-filter-row {
        display: grid;
        grid-template-columns: 1fr 170px;
        gap: 10px;
        margin-bottom: 10px;
    }

    .search-box {
        height: 38px;
        border: 1.4px solid #111;
        border-radius: 8px;
        padding: 0 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
    }

    .search-box input {
        border: none;
        outline: none;
        width: 100%;
        font-size: 12px;
    }

    .user-filter-row select {
        height: 38px;
        border: 1.4px solid #111;
        border-radius: 8px;
        padding: 0 9px;
        background: #fff;
        font-size: 12px;
    }

    .table-responsive {
        overflow-x: auto;
        border: 1px solid #cbd5e1;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 860px;
    }

    th {
        background: #e5e7eb;
        border: 1px solid #cbd5e1;
        padding: 10px 9px;
        font-size: 12px;
        font-weight: 900;
        text-align: center;
    }

    td {
        border: 1px solid #cbd5e1;
        padding: 9px;
        font-size: 12px;
        vertical-align: middle;
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .user-avatar {
        width: 31px;
        height: 31px;
        border-radius: 50%;
        background: #003b78;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 900;
        flex-shrink: 0;
    }

    .user-name {
        font-size: 12px;
        font-weight: 900;
    }

    .status-badge {
        display: inline-flex;
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 900;
    }

    .status-aktif {
        background: #dcfce7;
        color: #15803d;
    }

    .status-nonaktif {
        background: #f1f5f9;
        color: #64748b;
    }

    .table-action {
        display: flex;
        gap: 7px;
        justify-content: center;
    }

    .action-button {
        min-width: 76px;
        height: 32px;
        border-radius: 8px;
        border: none;
        font-size: 11px;
        font-weight: 900;
        cursor: pointer;
        padding: 0 10px;
        color: #fff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .action-button.edit {
        background: #003b78;
    }

    .action-button.delete {
        background: #dc2626;
    }

    .pagination-row {
        display: flex;
        justify-content: flex-end;
        margin-top: 14px;
    }

    .page-btn {
        width: 42px;
        height: 36px;
        border: 1.4px solid #111;
        background: #fff;
        font-size: 12px;
        font-weight: 900;
        cursor: pointer;
    }

    .page-btn.active {
        background: #eef5ff;
        color: #003b78;
    }

    .toast {
        display: none;
        position: fixed;
        right: 24px;
        bottom: 24px;
        background: #003b78;
        color: #fff;
        padding: 13px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        z-index: 300;
        box-shadow: 0 14px 35px rgba(0, 0, 0, .22);
    }

    .toast.show {
        display: block;
    }

    /* Modal edit */
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
        width: 620px;
        max-width: 100%;
        background: #fff;
        border-radius: 14px;
        border: 2px solid #111;
        padding: 20px;
        box-shadow: 0 24px 60px rgba(0, 0, 0, .25);
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-title {
        margin: 0 0 16px 0;
        font-size: 21px;
        font-weight: 900;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 13px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .form-group.full {
        grid-column: 1/3;
    }

    .form-group label {
        font-size: 12px;
        font-weight: 900;
    }

    .form-control {
        width: 100%;
        border: 1.4px solid #9ca3af;
        border-radius: 8px;
        padding: 10px;
        font-size: 13px;
        outline: none;
        background: #fff;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 9px;
        margin-top: 18px;
    }

    .btn-cancel {
        border: 1.5px solid #111;
        border-radius: 8px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 900;
        cursor: pointer;
        background: #fff;
        color: #111;
    }

    .btn-primary {
        border: 1.5px solid #003b78;
        border-radius: 8px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 900;
        cursor: pointer;
        background: #003b78;
        color: #fff;
    }

    @media (max-width:768px) {
        .summary-grid {
            grid-template-columns: 1fr;
        }

        .user-filter-row {
            grid-template-columns: 1fr;
        }

        .user-list-header {
            flex-direction: column;
            gap: 10px;
        }

        .user-list-actions {
            width: 100%;
        }

        .btn-outline {
            width: 100%;
        }

        .table-action {
            flex-wrap: wrap;
        }

        .toast {
            left: 14px;
            right: 14px;
            bottom: 14px;
            text-align: center;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: 1;
        }

        .modal-actions {
            flex-direction: column;
        }

        .btn-cancel,
        .btn-primary {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
@php
if (!isset($users) || !$users) {
$users = collect([]);
}
$total = $users->total();
$aktif = $users->where('status', 'aktif')->count();
$nonaktif = $users->where('status', 'nonaktif')->count();
@endphp

<div class="user-page">
    <h2 class="page-title">Manajemen User</h2>

    {{-- Penampil Error Validasi --}}
    @if ($errors->any())
    <div class="alert-error">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-title">Total Sopir</div>
            <div class="summary-content">
                <div class="summary-icon">👤</div>
                <strong>{{ $total }}</strong>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-title">Aktif</div>
            <div class="summary-content">
                <div class="summary-icon">✅</div>
                <strong>{{ $aktif }}</strong>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-title">Nonaktif</div>
            <div class="summary-content">
                <div class="summary-icon">⛔</div>
                <strong>{{ $nonaktif }}</strong>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-title">Dihapus</div>
            <div class="summary-content">
                <div class="summary-icon">🗑</div>
                <strong>0</strong>
            </div>
        </div>
    </div>

    <div class="user-list-section">
        <div class="user-list-header">
            <h3>Daftar Akun Sopir</h3>
            <div class="user-list-actions">
                <button class="btn-outline" onclick="exportUser()">Export</button>
            </div>
        </div>

        <div class="user-filter-row">
            <div class="search-box">
                <span>⌕</span>
                <input type="text" id="searchInput" placeholder="Cari nama, email, HP..." onkeyup="searchUser()">
            </div>
            <select id="statusFilter" onchange="filterStatus()">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Status</th>
                        <th>Login Terakhir</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @forelse ($users as $user)
                    <tr
                        data-id="{{ $user->id }}"
                        data-name="{{ $user->name }}"
                        data-username="{{ $user->username }}"
                        data-email="{{ $user->email }}"
                        data-phone="{{ $user->phone }}"
                        data-status="{{ $user->status }}"
                        data-operational="{{ $user->operational_area }}"
                        data-address="{{ $user->address }}"
                        data-search="{{ strtolower($user->name . ' ' . $user->email . ' ' . $user->phone . ' ' . $user->status) }}">
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <div class="user-name">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            <span class="status-badge status-{{ $user->status }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>{{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') : '-' }}</td>
                        <td>
                            <div class="table-action">
                                <button class="action-button edit" onclick="openEditModal(this)">Edit</button>
                                <form action="{{ route('admin.sopir.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus sopir ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-button delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:20px;">Belum ada sopir terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-row">
            {{ $users->links() }}
        </div>
    </div>
</div>

<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <h3 class="modal-title">Edit Sopir</h3>
        <form id="editForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" id="editName" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="editUsername" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="editEmail" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="phone" id="editPhone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Area Operasional</label>
                    <input type="text" name="operational_area" id="editArea" class="form-control">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="editStatus" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                <div class="form-group full">
                    <label>Alamat</label>
                    <input type="text" name="address" id="editAddress" class="form-control">
                </div>
                <div class="form-group full">
                    <label>Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" id="editPassword" class="form-control" placeholder="Kosongkan jika tidak diubah">
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<div class="toast" id="toastBox">Berhasil.</div>
@endsection

@push('scripts')
<script>
    function searchUser() {
        const keyword = document.getElementById('searchInput').value.trim().toLowerCase();
        const status = document.getElementById('statusFilter').value;
        const rows = document.querySelectorAll('#userTableBody tr');

        rows.forEach(row => {
            const rowStatus = row.dataset.status || '';
            const searchText = row.dataset.search || '';
            const matchKeyword = keyword === '' || searchText.includes(keyword);
            const matchStatus = status === '' || rowStatus === status;
            row.style.display = (matchKeyword && matchStatus) ? '' : 'none';
        });
    }

    function filterStatus() {
        searchUser();
    }

    function openEditModal(button) {
        const row = button.closest('tr');
        const id = row.dataset.id;
        const name = row.dataset.name || '';
        const username = row.dataset.username || '';
        const email = row.dataset.email || '';
        const phone = row.dataset.phone || '';
        const status = row.dataset.status || 'aktif';
        const area = row.dataset.operational || '';
        const address = row.dataset.address || '';

        document.getElementById('editName').value = name;
        document.getElementById('editUsername').value = username;
        document.getElementById('editEmail').value = email;
        document.getElementById('editPhone').value = phone;
        document.getElementById('editStatus').value = status;
        document.getElementById('editArea').value = area;
        document.getElementById('editAddress').value = address;
        document.getElementById('editPassword').value = '';

        const form = document.getElementById('editForm');
        // Pastikan prefix URL rute admin sudah sesuai dengan web.php Anda
        form.action = "{{ url('admin/sopir') }}/" + id;

        document.getElementById('editModal').classList.add('show');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('show');
    }

    function exportUser() {
        showToast('Export data sopir (demo).');
    }

    function showToast(message) {
        const toast = document.getElementById('toastBox');
        toast.innerText = message;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2200);
    }

    document.addEventListener('DOMContentLoaded', searchUser);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditModal();
        }
    });
</script>
@endpush