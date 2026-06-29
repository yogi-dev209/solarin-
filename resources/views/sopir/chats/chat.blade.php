@extends('layouts.sopir')

@section('title', 'Chat Sopir - SolarIn')
@section('page-greeting', 'Hallo, Selamat Datang')
@section('page-subtitle', 'Pusat Bantuan dan Komunikasi dengan Admin')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    :root {
        --wa-primary: #075e54;
        --wa-primary-dark: #054c44;
        --wa-bg: #e5ddd5;
        --wa-bubble-admin: #ffffff;
        --wa-bubble-sopir: #dcf8c6;
        --wa-text: #303030;
        --wa-text-light: #667781;
        --wa-online: #25d366;
    }

    /* Container utama */
    .chat-page {
        padding-top: 0;
        height: calc(100vh - 80px); /* sesuaikan dengan tinggi header layout */
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .page-title {
        display: none; /* tidak perlu ditampilkan */
    }

    .chat-layout {
        display: grid;
        grid-template-columns: minmax(280px, 35%) 1fr;
        gap: 0;
        height: 100%;
        min-height: 560px;
        background: #dddbd2;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        overflow: hidden;
        border-radius: 8px; /* tambahan agar pojok lebih halus */
    }

    /* Sidebar kiri */
    .chat-sidebar {
        border-right: 1px solid rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        min-width: 0;
        background: #ffffff;
        overflow: hidden;
    }

    .search-area {
        padding: 12px;
        background: #ffffff;
        flex-shrink: 0;
    }

    .search-box {
        height: 36px;
        border-radius: 18px;
        padding: 0 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f0f2f5;
    }

    .search-icon {
        font-size: 14px;
        color: #919191;
    }

    .search-box input {
        border: none;
        outline: none;
        width: 100%;
        background: transparent;
        font-size: 13px;
        color: #667781;
        font-weight: 400;
    }

    .admin-list {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        background: #ffffff;
    }

    .admin-contact {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-bottom: 1px solid #f2f2f2;
        cursor: default;
        background: #ffffff;
    }

    .avatar {
        width: 49px;
        height: 49px;
        border-radius: 50%;
        background: #dfe5e7;
        color: #51585c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        flex-shrink: 0;
        position: relative;
        text-transform: uppercase;
    }

    .presence {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--wa-online);
        border: 2px solid #ffffff;
        z-index: 3;
    }

    .contact-main {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .contact-name-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-name {
        font-size: 16px;
        font-weight: 600;
        color: #111b21;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .last-message {
        font-size: 13px;
        color: #667781;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Ruang chat kanan */
    .chat-room {
        display: flex;
        flex-direction: column;
        height: 100%;
        background: var(--wa-bg);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='260' height='260' viewBox='0 0 260 260'%3E%3Cpath fill='%23cfcbc4' opacity='.4' d='M130 0C58.2 0 0 58.2 0 130s58.2 130 130 130 130-58.2 130-130S201.8 0 130 0zm0 234c-57.4 0-104-46.6-104-104S72.6 26 130 26s104 46.6 104 104-46.6 104-104 104z'/%3E%3C/svg%3E");
        background-size: 260px 260px;
        overflow: hidden; /* penting agar background tidak meluber */
    }

    .room-header {
        padding: 10px 16px;
        background: var(--wa-primary);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .room-user {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .avatar-small {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        position: relative;
        text-transform: uppercase;
    }

    .avatar-small .presence {
        width: 10px;
        height: 10px;
        right: 0;
        bottom: 0;
        border: 2px solid var(--wa-primary);
    }

    .room-name-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
        flex-wrap: wrap;
    }

    .room-name {
        font-size: 16px;
        font-weight: 600;
        white-space: nowrap;
    }

    .presence-label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
        background: rgba(255,255,255,0.2);
        color: white;
    }

    /* Area pesan */
    .messages {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding: 20px 60px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        background: transparent;
        scroll-behavior: smooth;
    }

    .message-row {
        display: flex;
        margin-bottom: 2px;
    }

    .message-row.sopir {
        justify-content: flex-end;
    }

    .message-row.admin {
        justify-content: flex-start;
    }

    .bubble {
        max-width: 65%;
        padding: 6px 8px 6px 8px;
        font-size: 13.6px;
        line-height: 1.5;
        border-radius: 8px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.08);
        position: relative;
        word-wrap: break-word;
        hyphens: auto;
    }

    .sopir .bubble {
        background: var(--wa-bubble-sopir);
        color: #303030;
        border-radius: 8px 0 8px 8px;
    }

    .admin .bubble {
        background: var(--wa-bubble-admin);
        color: #303030;
        border-radius: 0 8px 8px 8px;
    }

    .bubble-time {
        display: flex;
        justify-content: flex-end;
        font-size: 10.5px;
        color: #667781;
        margin-top: 4px;
        gap: 2px;
        align-items: center;
    }

    /* Input area */
    .input-area {
        background: #f0f2f5;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
        border-top: 1px solid rgba(0,0,0,0.05);
    }

    .circle-btn {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
        background: transparent;
        color: #8696a0;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.15s;
    }

    .circle-btn:hover {
        background: rgba(0,0,0,0.05);
    }

    .message-input {
        flex: 1;
        height: 42px;
        border: none;
        border-radius: 21px;
        padding: 0 18px;
        font-size: 14px;
        outline: none;
        background: white;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        min-width: 0;
    }

    .send-btn {
        width: 42px;
        height: 42px;
        border: none;
        border-radius: 50%;
        background: var(--wa-primary);
        color: white;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        flex-shrink: 0;
    }

    .send-btn:hover {
        background: var(--wa-primary-dark);
    }

    .send-btn:disabled {
        background: #9fc1b3;
        box-shadow: none;
        cursor: not-allowed;
    }

    /* Toast notifikasi */
    .toast {
        display: none;
        position: fixed;
        right: 24px;
        bottom: 24px;
        background: var(--wa-primary);
        color: #ffffff;
        padding: 13px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        z-index: 300;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: opacity 0.2s;
    }

    .toast.show {
        display: block;
    }

    /* Scrollbar styling */
    .admin-list::-webkit-scrollbar,
    .messages::-webkit-scrollbar {
        width: 6px;
    }

    .admin-list::-webkit-scrollbar-track,
    .messages::-webkit-scrollbar-track {
        background: transparent;
    }

    .admin-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .messages::-webkit-scrollbar-thumb {
        background: #b6b6b6;
        border-radius: 10px;
    }

    /* Responsive */
    @media (max-width: 1000px) {
        .chat-layout {
            grid-template-columns: 1fr;
            height: auto;
            min-height: auto;
        }

        .chat-sidebar {
            border-right: none;
            border-bottom: 1px solid rgba(0,0,0,0.08);
            max-height: 200px;
        }

        .chat-room {
            height: 620px;
        }
    }

    @media (max-width: 768px) {
        .chat-page {
            height: auto;
        }

        .messages {
            padding: 16px 16px;
        }

        .bubble {
            max-width: 85%;
        }

        .chat-room {
            height: 560px;
        }

        .toast {
            left: 14px;
            right: 14px;
            bottom: 14px;
            text-align: center;
        }

        .chat-layout {
            border-radius: 0;
        }

        .room-header {
            padding: 10px 12px;
        }
    }
</style>
@endpush

@section('content')

@php
$adminName = $chat->admin->name ?? 'Admin SolarIn';
@endphp

@if(isset($chat))
<div class="chat-page">
    <div class="chat-layout">
        {{-- PANEL KIRI: INFO KONTAK ADMIN --}}
        <aside class="chat-sidebar">
            <div class="search-area">
                <div class="search-box">
                    <span class="search-icon">&#x1F50D;</span>
                    <input type="text" readonly value="Terhubung dengan Layanan Admin">
                </div>
            </div>

            <div class="admin-list">
                <div class="admin-contact">
                    <div class="avatar">
                        {{ strtoupper(substr($adminName, 0, 1)) }}
                        <span class="presence"></span>
                    </div>
                    <div class="contact-main">
                        <div class="contact-name-row">
                            <div class="contact-name">{{ $adminName }}</div>
                        </div>
                        <div class="last-message">Petugas Bantuan Resmi</div>
                    </div>
                </div>
            </div>
        </aside>

        {{-- PANEL KANAN: RUANG CHAT --}}
        <section class="chat-room">
            <input type="hidden" id="activeChatId" value="{{ $chat->id }}">
            <input type="hidden" id="activeUserId" value="{{ auth()->id() }}">

            <div class="room-header">
                <div class="room-user">
                    <div class="avatar-small">
                        {{ strtoupper(substr($adminName, 0, 1)) }}
                        <span class="presence"></span>
                    </div>
                    <div class="room-name-wrap">
                        <div class="room-name">{{ $adminName }}</div>
                        <span class="presence-label">online</span>
                    </div>
                </div>
            </div>

            <div class="messages" id="messages">
                @forelse ($messages->reverse() as $msg)
                @php
                    $isSopir = $msg->sender_id === auth()->id();
                    $timeStr = \Carbon\Carbon::parse($msg->created_at)->format('H:i');
                @endphp
                <div class="message-row {{ $isSopir ? 'sopir' : 'admin' }}">
                    <div class="bubble">
                        {{ $msg->message }}
                        <span class="bubble-time">{{ $timeStr }}</span>
                    </div>
                </div>
                @empty
                <div style="text-align: center; margin-top: 40px; color: #8696a0; font-size: 14px; opacity:0.9;">
                    Kirim pesan untuk memulai obrolan dengan Admin.
                </div>
                @endforelse
            </div>

            <div class="input-area">
                <button class="circle-btn" onclick="showToast('Fitur lampiran sedang dalam pengembangan.')">📎</button>
                <input type="text" id="messageInput" class="message-input" placeholder="Ketik pesan..." autocomplete="off" onkeydown="handleEnter(event)">
                <button class="send-btn" id="btnSend" onclick="sendMessage()">&#10148;</button>
            </div>
        </section>
    </div>
</div>
@else
<div style="text-align:center; padding: 40px; font-size: 16px; color: #667781;">
    Tidak ada chat yang tersedia.
</div>
@endif

<div class="toast" id="toastBox">Berhasil.</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        scrollBottom();
        initRealTime();
        // Auto resize textarea jika butuh (opsional, tidak perlu karena input)
    });

    function scrollBottom() {
        const messages = document.getElementById('messages');
        if (messages) {
            messages.scrollTop = messages.scrollHeight;
        }
    }

    function handleEnter(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            sendMessage();
        }
    }

    function sendMessage() {
        const chatIdEl = document.getElementById('activeChatId');
        if (!chatIdEl) return;

        const chatId = chatIdEl.value;
        const input = document.getElementById('messageInput');
        const btnSend = document.getElementById('btnSend');
        const text = input.value.trim();

        if (text === '') return;

        btnSend.innerHTML = '...';
        btnSend.disabled = true;

        fetch(`/sopir/chat/${chatId}/send`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: text })
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                appendMessage(data.message, 'sopir');
                input.value = '';
            } else {
                showToast('Gagal mengirim pesan.');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('Terjadi kesalahan jaringan.');
        })
        .finally(() => {
            btnSend.innerHTML = '&#10148;';
            btnSend.disabled = false;
            input.focus();
        });
    }

    function initRealTime() {
        const chatIdEl = document.getElementById('activeChatId');
        const userIdEl = document.getElementById('activeUserId');

        if (chatIdEl && userIdEl && typeof window.Echo !== 'undefined') {
            const chatId = chatIdEl.value;
            const currentUserId = parseInt(userIdEl.value);

            window.Echo.private(`chat.${chatId}`)
                .listen('MessageSent', (e) => {
                    if (e.chatMessage && e.chatMessage.sender_id !== currentUserId) {
                        appendMessage(e.chatMessage, 'admin');
                    }
                });
        }
    }

    function appendMessage(msgData, roleClass) {
        const messagesDiv = document.getElementById('messages');
        if (!messagesDiv) return;

        const date = new Date(msgData.created_at);
        const timeStr = date.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });

        const row = document.createElement('div');
        row.className = `message-row ${roleClass}`;
        row.innerHTML = `
            <div class="bubble">
                ${escapeHtml(msgData.message)}
                <span class="bubble-time">${timeStr}</span>
            </div>
        `;

        // Hapus placeholder jika ada
        const emptyText = messagesDiv.querySelector('div[style*="text-align: center"]');
        if (emptyText) emptyText.remove();

        messagesDiv.appendChild(row);
        scrollBottom();
    }

    // Fungsi sederhana untuk mencegah XSS (meskipun dari server sudah bersih)
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    function showToast(message) {
        const toast = document.getElementById('toastBox');
        if (!toast) return;
        toast.innerText = message;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2200);
    }
</script>
@endpush