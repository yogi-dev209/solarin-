<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sopir - SolarIn')</title>

    <style>
        /* ===== STYLE DASAR ===== */
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
            background: #ffffff;
            color: #111827;
            font-size: 13px;
        }

        .app-wrapper {
            display: flex;
            min-height: 100vh;
            background: #ffffff;
        }

        .sidebar {
            width: 165px;
            background: #08733f;
            color: #ffffff;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
        }

        .brand {
            height: 78px;
            display: flex;
            align-items: center;
            padding: 14px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
            letter-spacing: .5px;
            font-size: 15px;
        }

        .brand-icon {
            width: 22px;
            height: 28px;
            border-radius: 50% 50% 50% 0;
            background: linear-gradient(135deg, #22c55e 40%, #f5b21b 40%);
            transform: rotate(-20deg);
            display: inline-block;
        }

        .sidebar-menu {
            padding: 10px 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 12px 16px;
            color: #ffffff;
            text-decoration: none;
            font-size: 12px;
            border-left: 4px solid transparent;
            opacity: .95;
        }

        .menu-item:hover,
        .menu-item.active {
            background: #15a05d;
            border-left-color: #ffffff;
        }

        .menu-icon {
            width: 16px;
            text-align: center;
            font-size: 13px;
        }

        .logout-menu {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 8px;
        }

        .main {
            margin-left: 165px;
            width: calc(100% - 165px);
            min-height: 100vh;
            background: #ffffff;
        }

        .topbar {
            height: 72px;
            padding: 12px 24px 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #9ca3af;
            background: #ffffff;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .hamburger {
            width: 31px;
            height: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
        }

        .hamburger span {
            height: 2px;
            background: #111827;
            display: block;
        }

        .page-heading h1 {
            margin: 0 0 2px 0;
            font-size: 16px;
            font-weight: 700;
        }

        .page-heading p {
            margin: 0;
            font-size: 12px;
            color: #111827;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notif {
            position: relative;
            font-size: 23px;
            line-height: 1;
            cursor: pointer;
        }

        .notif-badge {
            position: absolute;
            top: -6px;
            right: -5px;
            min-width: 18px;
            height: 18px;
            background: #e11d48;
            color: white;
            border-radius: 50%;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 7px;
            border-left: 1px solid #111827;
            padding-left: 10px;
            font-weight: 700;
        }

        .user-avatar {
            width: 31px;
            height: 31px;
            border-radius: 50%;
            background: #111827;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            text-transform: uppercase;
        }

        .content {
            padding: 18px 24px 28px 24px;
        }

        /* ===== MODAL NOTIFIKASI ===== */
        .notif-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 200;
            align-items: center;
            justify-content: center;
            padding: 18px;
        }

        .notif-modal-overlay.show {
            display: flex;
        }

        .notif-modal-box {
            width: 470px;
            max-width: 100%;
            background: white;
            border-radius: 14px;
            border: 2px solid #111827;
            padding: 20px;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 24px 60px rgba(0, 0, 0, .25);
        }

        .notif-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }

        .notif-modal-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
        }

        .notif-modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6b7280;
        }

        .notif-modal-list {
            overflow-y: auto;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding-right: 4px;
        }

        .notif-item-sopir {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px;
            background: #fff;
            transition: .15s;
        }

        .notif-item-sopir.unread {
            border-left: 4px solid #08733f;
            background: #f0fdf4;
        }

        .notif-item-sopir .notif-title {
            font-weight: 700;
            font-size: 14px;
            margin: 0 0 4px 0;
        }

        .notif-item-sopir .notif-msg {
            font-size: 13px;
            color: #374151;
            margin: 0 0 6px 0;
        }

        .notif-item-sopir .notif-meta {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #6b7280;
        }

        .notif-item-sopir .notif-meta .badge-type {
            background: #e5e7eb;
            padding: 1px 8px;
            border-radius: 12px;
        }

        .notif-empty {
            text-align: center;
            color: #6b7280;
            padding: 30px 0;
        }

        .notif-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 14px;
            border-top: 1px solid #e5e7eb;
            padding-top: 14px;
        }

        .btn-notif {
            border: 1px solid #111827;
            border-radius: 6px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            background: white;
            color: #111827;
        }

        .btn-notif-primary {
            background: #08733f;
            color: white;
            border-color: #08733f;
        }

        /* ===== TOAST ===== */
        .toast-notif {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #08733f;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .2);
            z-index: 300;
            display: none;
            max-width: 360px;
        }

        .toast-notif.show {
            display: block;
        }

        /* ===== RESPONSIVE ===== */
        .mobile-overlay {
            display: none;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 145px;
            }

            .main {
                margin-left: 145px;
                width: calc(100% - 145px);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 220px;
                transform: translateX(-100%);
                transition: .25s ease;
                z-index: 100;
                box-shadow: 8px 0 24px rgba(0, 0, 0, .25);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .mobile-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .35);
                z-index: 90;
            }

            .mobile-overlay.show {
                display: block;
            }

            .main {
                margin-left: 0;
                width: 100%;
            }

            .topbar {
                height: auto;
                min-height: 66px;
                padding: 10px 14px;
                gap: 10px;
            }

            .topbar-left {
                gap: 10px;
            }

            .hamburger {
                width: 28px;
                height: 20px;
            }

            .page-heading h1 {
                font-size: 14px;
                max-width: 190px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .page-heading p {
                font-size: 11px;
            }

            .topbar-right {
                gap: 8px;
            }

            .notif {
                font-size: 19px;
            }

            .user-box {
                padding-left: 7px;
                gap: 5px;
                font-size: 11px;
            }

            .user-avatar {
                width: 27px;
                height: 27px;
                font-size: 14px;
            }

            .content {
                padding: 14px;
            }

            .notif-modal-box {
                width: 100%;
                margin: 10px;
                max-height: 90vh;
            }

            .toast-notif {
                left: 14px;
                right: 14px;
                bottom: 14px;
            }
        }
    </style>

    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="app-wrapper">
        <div class="mobile-overlay" id="mobileOverlay" onclick="toggleSidebar()"></div>
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <div class="brand-logo">
                    <span class="brand-icon"></span>
                    <span>SOLARIN</span>
                </div>
            </div>

            <nav class="sidebar-menu">
                @php
                $menus = [
                ['label' => 'Dashboard', 'icon' => '⌂', 'url' => url('/sopir/dashboard'), 'active' => 'sopir/dashboard'],
                ['label' => 'Pengajuan', 'icon' => '▣', 'url' => url('/sopir/pengajuan'), 'active' => 'sopir/pengajuan'],
                ['label' => 'Status Pengajuan', 'icon' => '☷', 'url' => url('/sopir/status-pengajuan'), 'active' => 'sopir/status-pengajuan'],
                ['label' => 'Barcode Saya', 'icon' => '▦', 'url' => url('/sopir/barcode'), 'active' => 'sopir/barcode'],
                ['label' => 'Reset Barcode', 'icon' => '↻', 'url' => url('/sopir/reset-barcode'), 'active' => 'sopir/reset-barcode'],
                ['label' => 'Chat Admin', 'icon' => '◌', 'url' => url('/sopir/chat'), 'active' => 'sopir/chat'],
                ['label' => 'Profil', 'icon' => '◎', 'url' => url('/sopir/profil'), 'active' => 'sopir/profil'],
                ];
                @endphp

                @foreach ($menus as $menu)
                <a href="{{ $menu['url'] }}" class="menu-item {{ request()->is($menu['active']) ? 'active' : '' }}">
                    <span class="menu-icon">{{ $menu['icon'] }}</span>
                    <span>{{ $menu['label'] }}</span>
                </a>
                @endforeach
            </nav>

            <div class="logout-menu">
                <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="menu-icon">↳</span>
                    <span>Logout</span>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        <main class="main">
            <header class="topbar">
                <div class="topbar-left">
                    <div class="hamburger" onclick="toggleSidebar()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="page-heading">
                        <h1>@yield('page-greeting', 'Hallo, Selamat Datang')</h1>
                        <p>@yield('page-subtitle', 'Sudah Siap Untuk Pengajuan?')</p>
                    </div>
                </div>
    <div class="topbar-right">
                    <div class="notif" id="notifBell" onclick="openNotifModal()">
                        🔔
                        @php
                            $unreadCountDB = auth()->check() ? \App\Models\Notification::where('user_id', auth()->id())->where('is_read', 0)->count() : 0;
                        @endphp
                        <span class="notif-badge" id="notifBadgeSopir" style="{{ $unreadCountDB > 0 ? 'display: flex;' : 'display: none;' }}">{{ $unreadCountDB }}</span>
                    </div>

                    <div class="user-box">
                        <div class="user-avatar" style="overflow: hidden; background: #111827;">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
                            @endif
                        </div>
                        <span>{{ auth()->user()->name ?? 'Sopir' }}</span>
                    </div>
                </div>
            </header>

    <section class="content">
        @yield('content')
    </section>
    </main>
    </div>

    <div class="notif-modal-overlay" id="notifModal">
        <div class="notif-modal-box">
            <div class="notif-modal-header">
                <h3>Notifikasi</h3>
                <button class="notif-modal-close" onclick="closeNotifModal()">&times;</button>
            </div>
            <div class="notif-modal-list" id="notifListContainer">
                <div class="notif-empty">Memuat...</div>
            </div>
            <div class="notif-modal-actions">
                <button class="btn-notif" onclick="markAllReadSopir()">Tandai semua sudah dibaca</button>
                <button class="btn-notif btn-notif-primary" onclick="closeNotifModal()">Tutup</button>
            </div>
        </div>
    </div>

    <div class="toast-notif" id="toastNotif"></div>

    <input type="hidden" id="currentLoginId" value="{{ auth()->id() }}">
    @stack('scripts')

    <script>
        // ============================================================
        //  SIDEBAR TOGGLE
        // ============================================================
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }
        }

        // ============================================================
        //  NOTIFIKASI - GLOBAL VARIABLES & HELPERS
        // ============================================================
        let lastUnreadCount = parseInt(document.getElementById('notifBadgeSopir')?.innerText || 0);

        function updateBadge(count) {
            const badge = document.getElementById('notifBadgeSopir');
            if (badge) {
                badge.innerText = count > 0 ? count : 0;
                badge.style.display = count > 0 ? 'flex' : 'none';
            }
            lastUnreadCount = count;
        }

        // FUNGSI UNTUK MUNCULKAN TOAST DENGAN TEKS MULTILINE (MENERIMA JUDUL & PESAN)
        function showToast(message) {
            const toast = document.getElementById('toastNotif');
            toast.innerText = message;
            toast.classList.add('show');
            clearTimeout(toast._timer);
            toast._timer = setTimeout(() => {
                toast.classList.remove('show');
            }, 6000); // Tampil 6 detik
        }

        // ============================================================
        //  AMBIL DAFTAR NOTIFIKASI (API)
        // ============================================================
        const notifIndexUrl = '{{ route("sopir.notifications.index") }}';
        const notifReadAllUrl = '{{ route("sopir.notifications.read-all") }}';
        const notifUnreadCountUrl = '{{ route("sopir.notifications.unread-count") }}';

        async function fetchNotifications() {
            const container = document.getElementById('notifListContainer');
            try {
                const response = await fetch(notifIndexUrl, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });
                const data = await response.json();

                if (data.notifications && data.notifications.length > 0) {
                    let html = '';
                    data.notifications.forEach(notif => {
                        const unreadClass = notif.is_read ? '' : 'unread';
                        html += `
                            <div class="notif-item-sopir ${unreadClass}" data-id="${notif.id}">
                                <div class="notif-title">${notif.title}</div>
                                <div class="notif-msg">${notif.message}</div>
                                <div class="notif-meta">
                                    <span><span class="badge-type">${notif.type}</span></span>
                                    <span>${notif.created_at}</span>
                                </div>
                            </div>
                        `;
                    });
                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<div class="notif-empty">Tidak ada notifikasi.</div>';
                }

                if (data.unread_count !== undefined) {
                    updateBadge(data.unread_count);
                }

                return data;
            } catch (error) {
                container.innerHTML = '<div class="notif-empty">Gagal memuat notifikasi.</div>';
                console.error('Fetch notif error:', error);
                return null;
            }
        }

        // ============================================================
        //  BUKA / TUTUP MODAL
        // ============================================================
        async function openNotifModal() {
            const modal = document.getElementById('notifModal');
            modal.classList.add('show');

            const data = await fetchNotifications();

            if (data && data.unread_count > 0) {
                await markAllReadSopir(true);
            }
        }

        function closeNotifModal() {
            document.getElementById('notifModal').classList.remove('show');
        }

        // ============================================================
        //  MARK ALL READ
        // ============================================================
        async function markAllReadSopir(silent = false) {
            try {
                const response = await fetch(notifReadAllUrl, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });
                const data = await response.json();
                if (data.success) {
                    document.querySelectorAll('.notif-item-sopir').forEach(el => {
                        el.classList.remove('unread');
                    });
                    updateBadge(0);
                    if (!silent) {
                        showToast('Semua notifikasi telah ditandai sudah dibaca.');
                    }
                }
            } catch (error) {
                if (!silent) {
                    showToast('Gagal menandai semua sudah dibaca.');
                }
                console.error(error);
            }
        }

        // ============================================================
        //  CEK UNREAD COUNT (Polling)
        // ============================================================
        async function checkUnreadCount() {
            try {
                const response = await fetch(notifUnreadCountUrl, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });
                const data = await response.json();
                if (data.unread_count !== undefined) {
                    const newCount = data.unread_count;
                    if (newCount > lastUnreadCount) {
                        const diff = newCount - lastUnreadCount;
                        showToast(`🔔 Anda memiliki ${diff} notifikasi baru.`);
                    }
                    updateBadge(newCount);
                }
            } catch (error) {
                console.error('Gagal cek unread count:', error);
            }
        }

        // ============================================================
        // ============================================================
        //  REALTIME DENGAN LARAVEL ECHO (WebSocket)
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Echo !== 'undefined') {

                // UBAH BARIS INI: Ambil ID dari input HTML, bukan dari tag PHP langsung
                const userIdInput = document.getElementById('currentLoginId');
                const userId = userIdInput ? userIdInput.value : null;

                if (userId) {
                    Echo.private('user.' + userId)
                        .listen('NotificationSent', (e) => {
                            const notif = e.notification;

                            // MENAMPILKAN TOAST DENGAN JUDUL DAN PESAN SEKALIGUS SAAT ADA NOTIFIKASI
                            showToast('🔔 ' + notif.title + '\n' + notif.message);

                            const newCount = lastUnreadCount + 1;
                            updateBadge(newCount);

                            // Jika modal notifikasi sedang terbuka, update listnya
                            const modal = document.getElementById('notifModal');
                            if (modal.classList.contains('show')) {
                                const container = document.getElementById('notifListContainer');
                                const emptyEl = container.querySelector('.notif-empty');
                                if (emptyEl) emptyEl.remove();

                                const item = document.createElement('div');
                                item.className = 'notif-item-sopir unread';
                                item.dataset.id = notif.id;
                                item.innerHTML = `
                                    <div class="notif-title">${notif.title}</div>
                                    <div class="notif-msg">${notif.message}</div>
                                    <div class="notif-meta">
                                        <span><span class="badge-type">${notif.type}</span></span>
                                        <span>Baru saja</span>
                                    </div>
                                `;
                                container.prepend(item);
                            }
                        });
                } else {
                    console.log('User ID tidak tersedia, Echo tidak diinisialisasi.');
                }
            } else {
                console.log('Laravel Echo tidak tersedia, fallback ke polling.');
                setInterval(checkUnreadCount, 10000);
                checkUnreadCount();
            }

            if (typeof Echo !== 'undefined') {
                checkUnreadCount();
            }
        });
        // Tutup modal dengan ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeNotifModal();
        });

        // Klik di luar modal untuk menutup
        document.getElementById('notifModal').addEventListener('click', function(e) {
            if (e.target === this) closeNotifModal();
        });
    </script>
</body>

</html>