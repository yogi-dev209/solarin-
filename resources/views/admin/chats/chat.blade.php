@extends('layouts.admin')

@section('title', 'Chat Admin - SolarIn')
@section('page-greeting', 'Selamat Datang, Admin')
@section('page-subtitle', 'Komunikasi dengan sopir terkait pengajuan dan kendala barcode')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* ========== WHATSAPP-LIKE UI (REVISED) ========== */
    :root {
        --wa-primary: #075e54;
        --wa-primary-dark: #054c44;
        --wa-secondary: #128c7e;
        --wa-bg: #e5ddd5;
        --wa-bubble-driver: #ffffff;
        --wa-bubble-admin: #dcf8c6;
        --wa-border: #e2e2e2;
        --wa-text: #303030;
        --wa-text-light: #667781;
        --wa-unread: #25d366;
        --online: #25d366;
        --offline: #b9b9b9;
    }

    .chat-page {
        padding-top: 0;
        height: calc(100vh - 80px);
        display: flex;
        flex-direction: column;
    }

    .chat-title {
        display: none;
    }

    .chat-layout {
        display: grid;
        grid-template-columns: 35% minmax(0, 65%);
        gap: 0;
        height: 100%;
        min-height: 560px;
        background: #dddbd2;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border-radius: 0;
    }

    /* Panel kiri */
    .panel {
        border: none;
        border-radius: 0;
        background: #ffffff;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .chat-left {
        border-right: 1px solid rgba(0, 0, 0, 0.08);
    }

    .panel-header {
        padding: 10px 16px;
        background: var(--wa-primary);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
        border-bottom: none;
    }

    .panel-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .panel-header span {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.85);
    }

    .chat-search {
        height: 35px;
        border: none;
        border-radius: 18px;
        padding: 0 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 8px 12px;
        background: #f0f2f5;
        flex-shrink: 0;
    }

    .chat-search span {
        font-size: 14px;
        color: #919191;
    }

    .chat-search input {
        border: none;
        outline: none;
        width: 100%;
        background: transparent;
        font-size: 13px;
    }

    .chat-list {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    /* Contact item - dengan indikator online */
    .chat-contact {
        border: none;
        border-bottom: 1px solid #f2f2f2;
        border-radius: 0;
        padding: 10px 12px;
        cursor: pointer;
        background: #ffffff;
        transition: background 0.15s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: inherit;
        position: relative;
    }

    .chat-contact:hover,
    .chat-contact.active {
        background: #f0f2f5;
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
        text-transform: uppercase;
        position: relative;
        /* untuk indikator online */
    }

    /* Indikator online/offline */
    .online-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 2px solid white;
        position: absolute;
        bottom: -2px;
        right: -2px;
        background: var(--offline);
        transition: background 0.2s;
    }

    .online-dot.online {
        background: var(--online);
    }

    .contact-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .contact-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }

    .contact-name {
        font-size: 16px;
        font-weight: 600;
        color: #111b21;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .contact-time {
        font-size: 11.5px;
        color: var(--wa-text-light);
        white-space: nowrap;
        margin-left: 8px;
    }

    .last-message {
        font-size: 13px;
        color: #667781;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .unread-badge {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--wa-unread);
        color: white;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: auto;
        flex-shrink: 0;
    }

    /* Panel kanan - ruang chat */
    .chat-room {
        display: flex;
        flex-direction: column;
        height: 100%;
        background: var(--wa-bg);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='260' height='260' viewBox='0 0 260 260'%3E%3Cpath fill='%23cfcbc4' opacity='.4' d='M130 0C58.2 0 0 58.2 0 130s58.2 130 130 130 130-58.2 130-130S201.8 0 130 0zm0 234c-57.4 0-104-46.6-104-104S72.6 26 130 26s104 46.6 104 104-46.6 104-104 104z'/%3E%3C/svg%3E");
        background-size: 260px 260px;
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
        border-bottom: none;
    }

    .room-user {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .room-user .avatar {
        width: 40px;
        height: 40px;
        font-size: 16px;
        background: #ffffff22;
        color: white;
    }

    .room-user-info {
        min-width: 0;
    }

    .room-name-row h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .room-user p {
        margin: 2px 0 0 0;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.85);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Status online/offline teks di header */
    .status-text {
        font-weight: 500;
        margin-left: 4px;
    }

    .status-text.online {
        color: #25d366;
    }

    .status-text.offline {
        color: #cccccc;
    }

    /* Area pesan */
    .messages {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding: 20px 60px;
        display: flex;
        flex-direction: column;
        gap: 2px;
        background: transparent;
    }

    .message-row {
        display: flex;
        margin-bottom: 2px;
    }

    .message-row.admin {
        justify-content: flex-end;
    }

    .message-row.driver {
        justify-content: flex-start;
    }

    .message-bubble {
        max-width: 60%;
        padding: 6px 8px 4px;
        font-size: 13.6px;
        line-height: 1.4;
        border-radius: 8px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.08);
        position: relative;
        word-wrap: break-word;
    }

    .driver .message-bubble {
        background: var(--wa-bubble-driver);
        color: #303030;
        border-radius: 0 8px 8px 8px;
    }

    .admin .message-bubble {
        background: var(--wa-bubble-admin);
        color: #303030;
        border-radius: 8px 0 8px 8px;
    }

    .message-time {
        display: flex;
        justify-content: flex-end;
        font-size: 10.5px;
        color: #667781;
        margin-top: 4px;
        gap: 2px;
        align-items: center;
    }

    .quick-replies {
        padding: 6px 16px;
        background: #ffffff;
        border-top: 1px solid #e9edef;
        display: flex;
        gap: 6px;
        overflow-x: auto;
        flex-shrink: 0;
    }

    .quick-btn {
        border: 1px solid var(--wa-secondary);
        background: #ffffff;
        color: var(--wa-secondary);
        border-radius: 18px;
        padding: 5px 14px;
        font-size: 12.5px;
        font-weight: 500;
        white-space: nowrap;
        cursor: pointer;
        transition: 0.15s;
    }

    .quick-btn:hover {
        background: #eaf8f4;
    }

    .chat-input-area {
        background: #f0f2f5;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .chat-input {
        flex: 1;
        height: 42px;
        border: none;
        border-radius: 21px;
        padding: 0 18px;
        font-size: 14px;
        outline: none;
        background: white;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
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
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        flex-shrink: 0;
    }

    .send-btn:hover {
        background: var(--wa-primary-dark);
    }

    .send-btn:disabled {
        background: #9fc1b3;
        box-shadow: none;
    }

    .empty-state {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #8696a0;
        background: #f0f2f5;
        font-weight: 500;
        font-size: 16px;
    }

    .empty-state-icon {
        font-size: 52px;
        color: #ccd7db;
        margin-bottom: 12px;
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
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .toast.show {
        display: block;
    }

    /* Scrollbar styling */
    .chat-list::-webkit-scrollbar,
    .messages::-webkit-scrollbar {
        width: 5px;
    }

    .chat-list::-webkit-scrollbar-track,
    .messages::-webkit-scrollbar-track {
        background: transparent;
    }

    .chat-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .messages::-webkit-scrollbar-thumb {
        background: #b6b6b6;
        border-radius: 10px;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .chat-layout {
            grid-template-columns: 1fr;
            height: auto;
            min-height: auto;
            border-radius: 0;
        }

        .chat-left {
            min-height: 480px;
            border-right: none;
        }

        .chat-list {
            max-height: 360px;
        }

        .chat-room {
            height: 650px;
        }

        .messages {
            padding: 16px 20px;
        }
    }

    @media (max-width: 768px) {
        .chat-page {
            height: auto;
        }

        .message-bubble {
            max-width: 85%;
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
    }
</style>
@endpush

@section('content')
<div class="chat-page">
    <div class="chat-layout">
        {{-- PANEL KIRI: DAFTAR CHAT --}}
        <div class="panel chat-left">
            <div class="panel-header">
                <h3>Chat</h3>
                <span id="chatCounter">{{ $chats->count() }} obrolan</span>
            </div>

            <div class="chat-search">
                <span>&#x1F50D;</span>
                <input type="text" id="searchInput" placeholder="Cari atau mulai chat baru" onkeyup="searchChat()">
            </div>

            <div class="chat-list" id="chatList">
                @forelse ($chats as $c)
                @php
                $unread = $c->unread_count ?? 0;
                $lastMsg = $c->messages->first();
                $time = $lastMsg ? \Carbon\Carbon::parse($lastMsg->created_at)->format('H:i') : '';
                $text = $lastMsg ? $lastMsg->message : 'Belum ada percakapan.';
                $driverName = $c->driver->name ?? 'Sopir Terhapus';
                $isActive = isset($chat) && $chat->id === $c->id;
                // Asumsi method isOnline() ada di model Driver, atau field is_online
                $isOnline = $c->driver->is_online ?? false;
                @endphp

                <a href="{{ url('admin/chat/' . $c->driver_id) }}"
                    class="chat-contact {{ $isActive ? 'active' : '' }}"
                    data-search="{{ strtolower($driverName) }}"
                    data-driver-id="{{ $c->driver_id }}">
                    <div class="avatar">
                        {{ substr($driverName, 0, 1) }}
                        <span class="online-dot {{ $isOnline ? 'online' : 'offline' }}"
                            id="status-dot-{{ $c->driver_id }}"></span>
                    </div>
                    <div class="contact-info">
                        <div class="contact-row">
                            <span class="contact-name">{{ $driverName }}</span>
                            <span class="contact-time">{{ $time }}</span>
                        </div>
                        <div class="last-message">{{ $text }}</div>
                    </div>
                    @if($unread > 0)
                    <span class="unread-badge">{{ $unread }}</span>
                    @endif
                </a>
                @empty
                <div style="text-align: center; padding: 30px 20px; color: #8696a0; font-size: 13px;">
                    Belum ada riwayat percakapan dengan sopir.
                </div>
                @endforelse
            </div>
        </div>

        {{-- PANEL KANAN: ISI CHAT --}}
        <div class="panel chat-room">
            @if(isset($chat))
            <input type="hidden" id="activeChatId" value="{{ $chat->id }}">
            <input type="hidden" id="activeUserId" value="{{ auth()->id() }}">
            <input type="hidden" id="activeDriverId" value="{{ $sopir->id }}">

            <div class="room-header">
                <div class="room-user">
                    <div class="avatar">
                        {{ substr($sopir->name, 0, 1) }}
                        <span class="online-dot {{ $sopir->is_online ? 'online' : 'offline' }}"
                            id="room-status-dot"></span>
                    </div>
                    <div class="room-user-info">
                        <div class="room-name-row">
                            <h3>
                                {{ $sopir->name }}
                                <span class="status-text {{ $sopir->is_online ? 'online' : 'offline' }}"
                                    id="room-status-text">
                                    {{ $sopir->is_online ? 'online' : 'offline' }}
                                </span>
                            </h3>
                        </div>
                        <p>{{ $sopir->phone ?? 'Tidak ada No. HP' }}</p>
                    </div>
                </div>
            </div>

            <div class="messages" id="messages">
                @forelse ($messages->reverse() as $msg)
                @php
                $isAdmin = $msg->sender_id === auth()->id();
                @endphp
                <div class="message-row {{ $isAdmin ? 'admin' : 'driver' }}">
                    <div class="message-bubble">
                        {{ $msg->message }}
                        <span class="message-time">
                            {{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}
                        </span>
                    </div>
                </div>
                @empty
                <div style="text-align: center; margin-top: 40px; color: #8696a0; font-size: 13px;">
                    Mulai percakapan dengan {{ $sopir->name }}...
                </div>
                @endforelse
            </div>

            <div class="quick-replies">
                <button class="quick-btn" onclick="useQuickReply('Mohon ditunggu, sedang kami proses.')">Sedang diproses</button>
                <button class="quick-btn" onclick="useQuickReply('Barcode Anda sudah terbit, silakan dicek.')">Barcode sudah terbit</button>
                <button class="quick-btn" onclick="useQuickReply('Ada dokumen yang kurang jelas, mohon upload ulang.')">Minta upload ulang</button>
            </div>

            <div class="chat-input-area">
                <input type="text" class="chat-input" id="messageInput" placeholder="Ketik pesan..." onkeydown="handleEnter(event)">
                <button class="send-btn" id="btnSend" onclick="sendMessage()">&#10148;</button>
            </div>
            @else
            <div class="empty-state">
                <div class="empty-state-icon">💬</div>
                Pilih nama sopir di sebelah kiri untuk mulai mengobrol.
            </div>
            @endif
        </div>
    </div>
</div>

<div class="toast" id="toastBox">Berhasil.</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        scrollBottom();
        initRealTime();
        initOnlineStatusListener();
    });

    function scrollBottom() {
        const messages = document.getElementById('messages');
        if (messages) {
            messages.scrollTop = messages.scrollHeight;
        }
    }

    function searchChat() {
        const keyword = document.getElementById('searchInput').value.trim().toLowerCase();
        const contacts = document.querySelectorAll('.chat-contact');
        let count = 0;

        contacts.forEach(contact => {
            const searchText = contact.getAttribute('data-search');
            if (keyword === '' || searchText.includes(keyword)) {
                contact.style.display = 'flex';
                count++;
            } else {
                contact.style.display = 'none';
            }
        });
        document.getElementById('chatCounter').innerText = count + ' obrolan';
    }

    function useQuickReply(text) {
        document.getElementById('messageInput').value = text;
        document.getElementById('messageInput').focus();
    }

    function handleEnter(event) {
        if (event.key === 'Enter') sendMessage();
    }

    function sendMessage() {
        const chatInputEl = document.getElementById('activeChatId');
        if (!chatInputEl) return;

        const chatId = chatInputEl.value;
        const input = document.getElementById('messageInput');
        const btnSend = document.getElementById('btnSend');
        const text = input.value.trim();

        if (text === '') return;

        btnSend.innerText = '...';
        btnSend.disabled = true;

        fetch(`/admin/chat/${chatId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    message: text
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    appendMessage(data.message, 'admin');
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

        console.log("initRealTime dipanggil");

        const chatInputEl = document.getElementById('activeChatId');
        const userInputEl = document.getElementById('activeUserId');

        console.log(chatInputEl);
        console.log(userInputEl);
        console.log(window.Echo);

        if (!chatInputEl || !userInputEl) {
            console.log("Input chat tidak ditemukan");
            return;
        }

        const chatId = chatInputEl.value;
        const currentUserId = parseInt(userInputEl.value);

        console.log("Subscribe ke chat", chatId);

        window.Echo.private(`chat.${chatId}`)
            .subscribed(() => {
                console.log("BERHASIL SUBSCRIBE");
            })
            .error((e) => {
                console.error("ERROR CHANNEL", e);
            })
            .listen("MessageSent", (e) => {
                console.log("EVENT MASUK", e);

                if (e.chatMessage.sender_id != currentUserId) {
                    appendMessage(e.chatMessage, "driver");
                }
            });

    }

    /**
     * Mendengarkan event online/offline sopir melalui presence channel
     * (asumsi backend sudah menyediakan channel 'drivers-status')
     */
    function initOnlineStatusListener() {
        if (typeof window.Echo === 'undefined') return;

        // Presence channel untuk memantau status online sopir
        window.Echo.join('drivers-status')
            .here((users) => {
                // users adalah daftar driver yang sedang online
                updateOnlineDrivers(users.map(u => u.id));
            })
            .joining((user) => {
                setDriverOnline(user.id, true);
            })
            .leaving((user) => {
                setDriverOnline(user.id, false);
            });
    }

    function updateOnlineDrivers(onlineIds) {
        // Set semua driver menjadi offline dulu, lalu aktifkan yang online
        document.querySelectorAll('.online-dot').forEach(dot => {
            dot.classList.remove('online');
            dot.classList.add('offline');
        });
        document.querySelectorAll('.status-text').forEach(span => {
            span.classList.remove('online');
            span.classList.add('offline');
            span.textContent = 'offline';
        });

        onlineIds.forEach(id => setDriverOnline(id, true));
    }

    function setDriverOnline(driverId, isOnline) {
        // Update dot di daftar kontak
        const dot = document.getElementById(`status-dot-${driverId}`);
        if (dot) {
            if (isOnline) {
                dot.classList.add('online');
                dot.classList.remove('offline');
            } else {
                dot.classList.remove('online');
                dot.classList.add('offline');
            }
        }

        // Update di header ruang chat jika sedang membuka sopir tersebut
        const activeDriverEl = document.getElementById('activeDriverId');
        if (activeDriverEl && activeDriverEl.value == driverId) {
            const roomDot = document.getElementById('room-status-dot');
            const roomText = document.getElementById('room-status-text');
            if (roomDot) {
                roomDot.classList.toggle('online', isOnline);
                roomDot.classList.toggle('offline', !isOnline);
            }
            if (roomText) {
                roomText.textContent = isOnline ? 'online' : 'offline';
                roomText.classList.toggle('online', isOnline);
                roomText.classList.toggle('offline', !isOnline);
            }
        }
    }

    function appendMessage(msgData, roleClass) {
        const messagesDiv = document.getElementById('messages');

        const date = new Date(msgData.created_at);
        const timeStr = date.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });

        const row = document.createElement('div');
        row.className = `message-row ${roleClass}`;
        row.innerHTML = `
            <div class="message-bubble">
                ${msgData.message}
                <span class="message-time">${timeStr}</span>
            </div>
        `;

        const emptyText = messagesDiv.querySelector('div[style*="text-align: center"]');
        if (emptyText) emptyText.remove();

        messagesDiv.appendChild(row);
        scrollBottom();
    }

    function showToast(message) {
        const toast = document.getElementById('toastBox');
        toast.innerText = message;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2200);
    }
</script>
@endpush