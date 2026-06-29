@extends('layouts.admin')

@section('title', 'Notifikasi - SolarIn')
@section('page-greeting', 'Halo, Selamat Datang')
@section('page-subtitle', 'Lihat pemberitahuan aktivitas pengajuan dan barcode')

@push('styles')
<style>
    .notif-page {
        padding-top: 18px;
    }

    .notif-title {
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
        background: #fff;
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
        font-weight: 900;
    }

    .panel {
        border: 1.5px solid #d1d5db;
        border-radius: 10px;
        background: #fff;
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

    .notif-toolbar {
        display: grid;
        grid-template-columns: 1fr 145px 145px;
        gap: 10px;
        margin-bottom: 14px;
    }

    .notif-search {
        height: 40px;
        border: 1.4px solid #111827;
        border-radius: 8px;
        padding: 0 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .notif-search span {
        color: #003b78;
        font-weight: 900;
    }

    .notif-search input {
        border: none;
        outline: none;
        width: 100%;
        font-size: 13px;
    }

    .filter-select {
        height: 40px;
        border: 1.4px solid #111827;
        border-radius: 8px;
        padding: 0 9px;
        background: white;
        font-size: 13px;
        outline: none;
    }

    .notif-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-height: 600px;
        overflow-y: auto;
        padding-right: 4px;
    }

    .notif-item {
        border: 1.4px solid #d1d5db;
        border-radius: 10px;
        padding: 13px;
        display: grid;
        grid-template-columns: 42px 1fr auto;
        gap: 12px;
        align-items: start;
        cursor: pointer;
        background: #fff;
        transition: .18s;
    }

    .notif-item:hover {
        background: #eef5ff;
        border-color: #003b78;
    }

    .notif-item.unread {
        border-left: 6px solid #003b78;
        background: #f8fbff;
    }

    .notif-icon {
        width: 39px;
        height: 39px;
        border-radius: 50%;
        background: #eef5ff;
        color: #003b78;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
    }

    .notif-content h4 {
        margin: 0 0 5px 0;
        font-size: 15px;
        font-weight: 900;
    }

    .notif-content p {
        margin: 0;
        font-size: 13px;
        color: #475569;
        line-height: 1.45;
    }

    .notif-meta {
        text-align: right;
        font-size: 12px;
        color: #64748b;
        white-space: nowrap;
    }

    .badge {
        display: inline-flex;
        padding: 4px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 900;
        margin-top: 8px;
    }

    .badge-info {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-success {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-warning {
        background: #fef3c7;
        color: #92400e;
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
        height: 38px;
        padding: 0 13px;
        background: #fff;
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
        color: white;
        border-color: #003b78;
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

    .detail-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        border-bottom: 1px solid #e5e7eb;
        padding: 9px 0;
        font-size: 13px;
    }

    .detail-row span {
        color: #64748b;
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

    @media (max-width: 768px) {
        .notif-page {
            padding-top: 8px;
        }

        .notif-title {
            font-size: 20px;
            margin-bottom: 14px;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .notif-toolbar {
            grid-template-columns: 1fr;
        }

        .notif-item {
            grid-template-columns: 38px 1fr;
        }

        .notif-meta {
            grid-column: 1 / 3;
            text-align: left;
        }

        .action-row {
            flex-direction: column;
        }

        .btn {
            width: 100%;
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
<div class="notif-page">
    <h2 class="notif-title">Pemberitahuan</h2>

    <div class="summary-grid">
        <div class="summary-card">
            <div><span>Total Notifikasi</span><strong id="totalNotif">{{ $totalNotif }}</strong></div>
            <div class="summary-icon">N</div>
        </div>

        <div class="summary-card">
            <div><span>Belum Dibaca</span><strong id="unreadCountDisplay">{{ $unreadCount }}</strong></div>
            <div class="summary-icon">!</div>
        </div>

        <div class="summary-card">
            <div><span>Pengajuan</span><strong>{{ $pengajuanCount }}</strong></div>
            <div class="summary-icon">P</div>
        </div>

        <div class="summary-card">
            <div><span>Reset Barcode</span><strong>{{ $resetCount }}</strong></div>
            <div class="summary-icon">R</div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Daftar Notifikasi</h3>
            <a href="{{ url('/admin/kirim-notifikasi') }}" class="btn btn-primary">Kirim Notifikasi Baru</a>
        </div>

        <div class="panel-body">
            <div class="notif-toolbar">
                <div class="notif-search">
                    <span>⌕</span>
                    <input type="text" id="searchInput" placeholder="Cari notifikasi..." onkeyup="filterNotif()">
                </div>

                <select class="filter-select" id="typeFilter" onchange="filterNotif()">
                    <option value="">Semua Tipe</option>
                    <option value="pengajuan">Pengajuan</option>
                    <option value="dokumen">Dokumen</option>
                    <option value="barcode">Barcode</option>
                    <option value="reset">Reset</option>
                </select>

                <select class="filter-select" id="readFilter" onchange="filterNotif()">
                    <option value="">Semua Status</option>
                    <option value="unread">Belum Dibaca</option>
                    <option value="read">Sudah Dibaca</option>
                </select>
            </div>

            <div class="notif-list" id="notifList">
                @forelse ($notifications as $notif)
                @php
                $isRead = $notif->is_read ? 'read' : 'unread';

                $icon = match($notif->type) {
                'pengajuan' => 'P', 'reset' => 'R', 'dokumen' => 'D', 'barcode' => 'B', default => 'N'
                };

                $badgeClass = match($notif->type) {
                'pengajuan' => 'badge-info', 'reset' => 'badge-warning', 'dokumen' => 'badge-success', 'barcode' => 'badge-success', default => 'badge-info'
                };
                @endphp

                <div class="notif-item {{ $isRead }}"
                    data-type="{{ $notif->type }}"
                    data-read="{{ $isRead }}"
                    data-search="{{ strtolower($notif->title . ' ' . $notif->message) }}"
                    data-id="{{ $notif->id }}"
                    data-title="{{ $notif->title }}"
                    data-message="{{ $notif->message }}"
                    data-notiftype="{{ ucfirst($notif->type) }}"
                    data-time="{{ $notif->created_at->format('d/m/Y H:i') }}"
                    onclick="openNotif(this)">

                    <div class="notif-icon">{{ $icon }}</div>

                    <div class="notif-content">
                        <h4>{{ $notif->title }}</h4>
                        <p>{{ $notif->message }}</p>
                        <span class="badge {{ $badgeClass }}">{{ ucfirst($notif->type) }}</span>
                    </div>

                    <div class="notif-meta">
                        {{ $notif->created_at->format('H:i') }}<br>
                        <span class="read-status-text">{{ $isRead === 'unread' ? 'Belum dibaca' : 'Sudah dibaca' }}</span>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 40px; color: #64748b; font-weight: 700; font-size:15px;">
                    Belum ada notifikasi untuk Anda.
                </div>
                @endforelse
            </div>

            <div class="action-row">
                <button class="btn" onclick="markAllReadUI()">Tandai Semua Dibaca</button>
                <button class="btn btn-primary" onclick="window.location.reload()">Refresh Halaman</button>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="notifModal">
    <div class="modal-box">
        <h3 class="modal-title" id="modalTitle">Detail Notifikasi</h3>
        <p style="font-size: 14px; line-height: 1.5; color: #475569; margin-bottom: 20px;" id="modalMessage">-</p>

        <div class="detail-row"><span>Kategori Tipe</span><strong id="modalType">-</strong></div>
        <div class="detail-row"><span>Waktu Masuk</span><strong id="modalTime">-</strong></div>

        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeNotif()">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function openNotif(item) {
        const id = item.dataset.id;

        document.getElementById('modalTitle').innerText = item.dataset.title;
        document.getElementById('modalMessage').innerText = item.dataset.message;
        document.getElementById('modalType').innerText = item.dataset.notiftype;
        document.getElementById('modalTime').innerText = item.dataset.time;
        document.getElementById('notifModal').classList.add('show');

        if (!item.classList.contains('unread')) return;

        item.classList.remove('unread');
        item.setAttribute('data-read', 'read');
        const metaText = item.querySelector('.read-status-text');
        if (metaText) metaText.innerText = 'Sudah dibaca';

        try {
            const response = await fetch(`/admin/notifications/${id}/read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            const data = await response.json();

            if (data.success) {
                const unreadDisplay = document.getElementById('unreadCountDisplay');
                unreadDisplay.innerText = Math.max(0, parseInt(unreadDisplay.innerText) - 1);
            }
        } catch (error) {
            console.error('Gagal menandai notifikasi sebagai dibaca.');
        }
    }

    function closeNotif() {
        document.getElementById('notifModal').classList.remove('show');
    }

    function filterNotif() {
        const keyword = document.getElementById('searchInput').value.trim().toLowerCase();
        const type = document.getElementById('typeFilter').value.toLowerCase();
        const read = document.getElementById('readFilter').value;

        document.querySelectorAll('.notif-item').forEach(item => {
            const search = item.getAttribute('data-search');
            const itemType = item.getAttribute('data-type').toLowerCase();
            const itemRead = item.getAttribute('data-read');

            const matchKeyword = keyword === '' || search.includes(keyword);
            const matchType = type === '' || itemType === type;
            const matchRead = read === '' || itemRead === read;

            item.style.display = matchKeyword && matchType && matchRead ? '' : 'none';
        });
    }

    async function markAllReadUI() {
        try {
            const response = await fetch('/admin/notifications/read-all', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            const data = await response.json();
            if (!data.success) return;
        } catch (error) {
            return;
        }

        document.querySelectorAll('.notif-item').forEach(item => {
            item.classList.remove('unread');
            item.setAttribute('data-read', 'read');
            const metaText = item.querySelector('.read-status-text');
            if (metaText) metaText.innerText = 'Sudah dibaca';
        });

        const badge = document.getElementById('notifBadgeCounter');
        if (badge) badge.style.display = 'none';

        document.getElementById('unreadCountDisplay').innerText = '0';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') closeNotif();
    });
</script>
@endpush