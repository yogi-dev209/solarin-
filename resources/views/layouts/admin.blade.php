<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - SolarIn')</title>

    <style>
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
            background: #003b78;
            color: #ffffff;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 50;
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
            background: linear-gradient(135deg, #1f7ae0 40%, #f5b21b 40%);
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
            padding: 11px 16px;
            color: #ffffff;
            text-decoration: none;
            font-size: 12px;
            border-left: 4px solid transparent;
            opacity: .95;
        }

        .menu-item:hover,
        .menu-item.active {
            background: #0b5fc4;
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

        /* CSS ICON LONCENG */
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
            width: 14px;
            height: 14px;
            background: #e11d48;
            color: white;
            border-radius: 50%;
            font-size: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
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
            font-size: 14px;
            text-transform: uppercase;
        }

        .content {
            padding: 18px 24px 28px 24px;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .sidebar {
                width: 145px;
            }

            .main {
                margin-left: 145px;
                width: calc(100% - 145px);
            }
        }

        .mobile-overlay {
            display: none;
        }

        @media (max-width: 768px) {
            body {
                font-size: 12px;
            }

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
            }

            .page-heading h1 {
                font-size: 14px;
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
                ['label' => 'Dashboard', 'icon' => '⌂', 'url' => url('/admin/dashboard'), 'active' => 'admin/dashboard'],
                ['label' => 'Data Sopir', 'icon' => '◉', 'url' => url('/admin/data-sopir'), 'active' => 'admin/data-sopir'],
                ['label' => 'Data Pengajuan', 'icon' => '▣', 'url' => url('/admin/data-pengajuan'), 'active' => 'admin/data-pengajuan'],
                ['label' => 'Verifikasi Dokumen', 'icon' => '✓', 'url' => url('/admin/verifikasi-dokumen'), 'active' => 'admin/verifikasi-dokumen'],
                ['label' => 'Monitoring Pengajuan', 'icon' => '▧', 'url' => url('/admin/monitoring-pengajuan'), 'active' => 'admin/monitoring-pengajuan'],
                ['label' => 'Chat Admin', 'icon' => '◌', 'url' => url('/admin/chat'), 'active' => 'admin/chat*'],
                ['label' => 'Pengelolaan Barcode', 'icon' => '▥', 'url' => url('/admin/upload-barcode'), 'active' => 'admin/upload-barcode'],
                ['label' => 'Reset Barcode', 'icon' => '↻', 'url' => url('/admin/reset-barcode'), 'active' => 'admin/reset-barcode'],
                ['label' => 'Notifikasi', 'icon' => '●', 'url' => url('/admin/notifikasi'), 'active' => 'admin/notifikasi'],
                ['label' => 'Pengaturan', 'icon' => '⚙', 'url' => url('/admin/pengaturan'), 'active' => 'admin/pengaturan'],
                ['label' => 'Manajemen User', 'icon' => '◎', 'url' => url('/admin/manajemen-user'), 'active' => 'admin/manajemen-user'],
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
                        <h1>@yield('page-greeting', 'Selamat Datang, Admin')</h1>
                        <p>@yield('page-subtitle', 'Kelola dan Pantau Pengajuan Barcode Solar Subsidi')</p>
                    </div>
                </div>

                <div class="topbar-right">
                    <div class="notif">
                        <a href="{{ url('/admin/notifikasi') }}" style="text-decoration: none; color: inherit;">
                            🔔
                            @php
                            // Mengambil jumlah notifikasi yang belum dibaca dari database
                            $unreadNotif = auth()->check() ? \App\Models\Notification::where('user_id', auth()->id())->where('is_read', 0)->count() : 0;
                            @endphp

                            <span class="notif-badge" id="notifBadgeCounter" style="{{ $unreadNotif > 0 ? 'display: flex;' : 'display: none;' }}">
                                {{ $unreadNotif }}
                            </span>
                        </a>
                    </div>

                    <div class="user-box">
                        <div class="user-avatar" style="overflow: hidden; background: #111827;">
                            @if(auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            @endif
                        </div>
                        <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </header>

            <section class="content">
                @yield('content')
            </section>
        </main>
    </div>

    <div id="globalNotifToast" style="display: none; position: fixed; top: 24px; right: 24px; background: #111827; color: #ffffff; padding: 16px 20px; border-radius: 12px; z-index: 9999; box-shadow: 0 15px 30px rgba(0,0,0,0.3); border-left: 5px solid #38bdf8; min-width: 280px; max-width: 350px;">
        <strong id="globalNotifTitle" style="display: block; font-size: 15px; margin-bottom: 6px; font-weight: 900;"></strong>
        <span id="globalNotifMessage" style="font-size: 13px; line-height: 1.4; color: #d1d5db;"></span>
    </div>

    <input type="hidden" id="currentAdminId" value="{{ auth()->id() }}">

    @stack('scripts')

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');

            if (sidebar && overlay) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }
        }

        // ==============================================================
        // SCRIPT PENANGKAP NOTIFIKASI REAL-TIME (LARAVEL ECHO)
        // ==============================================================
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil ID Admin yang sedang login melalui input tersembunyi agar tidak dirusak oleh Formatter
            const userIdInput = document.getElementById('currentAdminId');
            const userId = userIdInput ? userIdInput.value : null;

            if (userId && typeof window.Echo !== 'undefined') {
                // Mendengarkan channel notifikasi pribadi milik Admin ini
                window.Echo.private(`user.${userId}`)
                    .listen('NotificationSent', (e) => {

                        // 1. Munculkan kotak Toast Notifikasi
                        const toast = document.getElementById('globalNotifToast');
                        document.getElementById('globalNotifTitle').innerText = e.notification.title;
                        document.getElementById('globalNotifMessage').innerText = e.notification.message;

                        toast.style.display = 'block';

                        // 2. Sembunyikan pop-up secara otomatis setelah 6 detik
                        setTimeout(() => {
                            toast.style.display = 'none';
                        }, 6000);

                        // 3. Update angka merah di icon lonceng
                        const badge = document.getElementById('notifBadgeCounter');
                        if (badge) {
                            badge.style.display = 'flex';
                            badge.innerText = parseInt(badge.innerText || 0) + 1;
                        }
                    });
            }
        });
    </script>
</body>

</html>