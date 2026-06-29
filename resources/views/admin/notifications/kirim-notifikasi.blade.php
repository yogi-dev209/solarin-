@extends('layouts.admin')

@section('title', 'Kirim Notifikasi - SolarIn')
@section('page-greeting', 'Selamat Datang, Admin')
@section('page-subtitle', 'Kelola dan Pantau Pengajuan Barcode Solar Subsidi')

@push('styles')
<style>
    .notif-page {
        padding-top: 22px;
    }

    .notif-title {
        font-size: 22px;
        font-weight: 900;
        margin: 0 0 22px 0;
        color: #111827;
    }

    .notif-form {
        width: 100%;
        border-bottom: 2px solid #9ca3af;
        padding: 0 0 28px 0;
        margin-bottom: 24px;
    }

    .form-group {
        margin-bottom: 17px;
    }

    .form-group label {
        display: block;
        font-size: 15px;
        font-weight: 800;
        margin-bottom: 7px;
        color: #374151;
    }

    .select-wrap {
        position: relative;
        width: 380px;
        max-width: 100%;
    }

    .form-select {
        width: 100%;
        height: 44px;
        border: 1.6px solid #111827;
        border-radius: 10px;
        padding: 0 42px 0 16px;
        font-size: 15px;
        color: #374151;
        background: #ffffff;
        outline: none;
        appearance: none;
        cursor: pointer;
    }

    .select-wrap::after {
        content: "▼";
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 13px;
        color: #111827;
        pointer-events: none;
    }

    .message-area {
        width: 100%;
        min-height: 118px;
        border: 1.6px solid #111827;
        border-radius: 10px;
        padding: 14px 16px;
        font-size: 15px;
        line-height: 1.5;
        color: #374151;
        resize: vertical;
        outline: none;
        font-family: Arial, Helvetica, sans-serif;
    }

    .message-area:focus,
    .form-select:focus {
        border-color: #003b78;
        box-shadow: 0 0 0 3px rgba(0, 59, 120, .12);
    }

    .button-row {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 15px;
        margin-top: 18px;
    }

    .btn {
        height: 48px;
        border-radius: 10px;
        padding: 0 28px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        border: 1.6px solid #111827;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-width: 125px;
    }

    .btn-cancel {
        background: #ffffff;
        color: #374151;
    }

    .btn-send {
        background: #155bd5;
        color: #ffffff;
        border-color: #155bd5;
        min-width: 220px;
    }

    .btn-send:hover {
        background: #0f4bbb;
    }

    .send-icon {
        font-size: 22px;
        line-height: 1;
    }

    .history-title {
        font-size: 22px;
        font-weight: 900;
        margin: 0 0 18px 0;
        color: #111827;
    }

    .history-list {
        display: flex;
        flex-direction: column;
        gap: 13px;
    }

    .history-card {
        border: 1.6px solid #111827;
        border-radius: 10px;
        background: #ffffff;
        min-height: 112px;
        padding: 18px 22px;
        display: grid;
        grid-template-columns: 82px minmax(0, 1fr) 96px;
        gap: 16px;
        align-items: center;
    }

    .history-icon {
        width: 64px;
        height: 64px;
        color: #155bd5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 47px;
    }

    .history-content {
        min-width: 0;
    }

    .history-content h4 {
        margin: 0 0 8px 0;
        font-size: 18px;
        font-weight: 900;
        color: #111827;
    }

    .history-content p {
        margin: 0;
        font-size: 15px;
        line-height: 1.45;
        color: #374151;
    }

    .history-date {
        margin-top: 4px !important;
        color: #4b5563 !important;
    }

    .history-status {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 7px;
        color: #155bd5;
        font-size: 13px;
        font-weight: 800;
    }

    .check-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #155bd5;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        font-weight: 900;
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
        box-shadow: 0 14px 35px rgba(0, 0, 0, .22);
    }

    .toast.show {
        display: block;
    }

    @media (max-width: 768px) {
        .notif-page {
            padding-top: 12px;
        }

        .notif-title,
        .history-title {
            font-size: 19px;
        }

        .select-wrap {
            width: 100%;
        }

        .button-row {
            flex-direction: column;
            align-items: stretch;
        }

        .btn {
            width: 100%;
        }

        .history-card {
            grid-template-columns: 52px minmax(0, 1fr);
            gap: 12px;
            padding: 15px;
        }

        .history-icon {
            width: 48px;
            height: 48px;
            font-size: 35px;
        }

        .history-status {
            grid-column: 1 / 3;
            align-items: flex-start;
            flex-direction: row;
            justify-content: flex-end;
        }

        .history-content h4 {
            font-size: 15px;
        }

        .history-content p {
            font-size: 13px;
        }

        .toast {
            left: 14px;
            right: 14px;
            bottom: 14px;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="notif-page">
    <section class="notif-form">
        <h2 class="notif-title">Kirim Notifikasi ke Sopir</h2>

        <div class="form-group">
            <label for="driverSelect">Pilih Sopir</label>

            <div class="select-wrap">
                <select id="driverSelect" class="form-select" onchange="changeDriver()">
                    @foreach ($sopirs as $sopir)
                    <option
                        value="{{ $sopir->id }}"
                        data-barcode="{{ $sopir->latest_barcode_number ?? '' }}"
                        data-name="{{ $sopir->name }}">
                        {{ $sopir->name }} ({{ $sopir->phone ?? '-' }})
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="messageInput">Pesan Notifikasi</label>
            <textarea id="messageInput" class="message-area"></textarea>
        </div>

        <div class="button-row">
            <button type="button" class="btn btn-cancel" onclick="resetForm()">Batal</button>
            <button type="button" class="btn btn-send" onclick="sendNotification()">
                <span class="send-icon">&#9992;</span>
                Kirim Notifikasi
            </button>
        </div>
    </section>

    <section class="history-section">
        <h2 class="history-title">Riwayat Notifikasi Terkirim</h2>

        <div class="history-list" id="historyList">
            @forelse ($history as $item)
            <div class="history-card">
                <div class="history-icon">&#9992;</div>
                <div class="history-content">
                    <h4>Notifikasi dikirim ke {{ $item->user->name }}</h4>
                    @foreach (explode("\n", $item->message) as $line)
                    <p>{{ $line }}</p>
                    @endforeach
                    <p class="history-date">
                        {{ $item->created_at->format('d/m/Y') }} . {{ $item->created_at->format('H:i') }}
                    </p>
                </div>
                <div class="history-status">
                    <div class="check-circle">&#10003;</div>
                    <span>Terkirim</span>
                </div>
            </div>
            @empty
            <p style="text-align:center; padding:24px; color:#64748b;">
                Belum ada notifikasi yang dikirim manual.
            </p>
            @endforelse
        </div>
    </section>
</div>

<div class="toast" id="toastBox">Berhasil.</div>
@endsection

@push('scripts')
<script>
    // Ambil CSRF token dengan fallback
    function getCsrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) {
            return meta.getAttribute('content');
        }
        // Fallback: ambil dari input tersembunyi (jika ada)
        var input = document.querySelector('input[name="_token"]');
        if (input) {
            return input.value;
        }
        return '';
    }

    function changeDriver() {
        var select = document.getElementById('driverSelect');
        var selectedOption = select.options[select.selectedIndex];
        var barcode = selectedOption.getAttribute('data-barcode');

        var messageInput = document.getElementById('messageInput');
        if (barcode) {
            messageInput.value = 'Pengajuan barcode ' + barcode + ' telah berhasil diterbitkan.\nSilakan cek aplikasi Anda.';
        } else {
            messageInput.value = 'Halo, ada pemberitahuan baru untuk Anda. Silakan cek aplikasi SolarIn.';
        }
    }

    function resetForm() {
        var select = document.getElementById('driverSelect');
        select.selectedIndex = 0;
        changeDriver();
        showToast('Form notifikasi dibatalkan.');
    }

    function showToast(message) {
        var toast = document.getElementById('toastBox');
        toast.innerText = message;
        toast.classList.add('show');
        clearTimeout(toast._timer);
        toast._timer = setTimeout(function() {
            toast.classList.remove('show');
        }, 2200);
    }

    async function sendNotification() {
        var select = document.getElementById('driverSelect');
        var selectedOption = select.options[select.selectedIndex];
        var driverId = selectedOption.value;
        var driverName = selectedOption.getAttribute('data-name') || selectedOption.text.split('(')[0].trim();
        var message = document.getElementById('messageInput').value.trim();

        if (message === '') {
            showToast('Pesan notifikasi tidak boleh kosong.');
            return;
        }

        var csrfToken = getCsrfToken();
        if (!csrfToken) {
            showToast('CSRF token tidak ditemukan. Refresh halaman.');
            return;
        }

        try {
            var response = await fetch('/admin/kirim-notifikasi', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    user_id: driverId,
                    message: message
                })
            });

            var data = await response.json();

            if (!response.ok || !data.success) {
                showToast(data.message || 'Gagal mengirim notifikasi.');
                return;
            }

            var now = new Date();
            var date = now.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            var time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });

            var lines = message.split('\n');
            var linesHtml = '';
            for (var i = 0; i < lines.length; i++) {
                linesHtml += '<p>' + lines[i] + '</p>';
            }

            var historyList = document.getElementById('historyList');
            // Hapus placeholder jika ada
            var placeholder = historyList.querySelector('p[style]');
            if (placeholder) {
                placeholder.remove();
            }

            var card = document.createElement('div');
            card.className = 'history-card';
            card.innerHTML =
                '<div class="history-icon">&#9992;</div>' +
                '<div class="history-content">' +
                '<h4>Notifikasi dikirim ke ' + driverName + '</h4>' +
                linesHtml +
                '<p class="history-date">' + date + ' . ' + time + '</p>' +
                '</div>' +
                '<div class="history-status">' +
                '<div class="check-circle">&#10003;</div>' +
                '<span>Terkirim</span>' +
                '</div>';

            historyList.prepend(card);

            showToast('Notifikasi berhasil dikirim ke ' + driverName + '.');
        } catch (error) {
            console.error(error);
            showToast('Terjadi kesalahan saat mengirim notifikasi.');
        }
    }

    document.addEventListener('DOMContentLoaded', changeDriver);
</script>
@endpush