<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use App\Events\MessageSent; // <-- [TAMBAHAN 1] Import Event
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Daftar semua chat milik admin yang login
    public function index()
    {
        $chats = Chat::with(['driver', 'messages' => fn($q) => $q->latest()->limit(1)])
            ->where('admin_id', Auth::id())
            ->withCount(['messages as unread_count' => fn($q) => $q->where('is_read', false)->where('sender_id', '!=', Auth::id())])
            ->latest('updated_at')
            ->get();

        return view('admin.chats.chat', compact('chats'));
    }

    // Buka/buat chat dengan sopir tertentu
    // Buka/buat chat dengan sopir tertentu
    public function openChat(User $sopir)
    {
        abort_if($sopir->role !== 'sopir', 404);

        $chat = Chat::firstOrCreate([
            'admin_id'  => auth::id(),
            'driver_id' => $sopir->id,
        ]);

        // Tandai pesan dari sopir sebagai sudah dibaca
        ChatMessage::where('chat_id', $chat->id)
            ->where('sender_id', $sopir->id)
            ->update(['is_read' => true]);

        $messages = $chat->messages()->with('sender')->latest()->paginate(30);

        // =========================================================
        // TAMBAHAN: Ambil ulang daftar semua chat untuk Panel Kiri
        // =========================================================
        $chats = Chat::with(['driver', 'messages' => fn($q) => $q->latest()->limit(1)])
            ->where('admin_id', auth::id())
            ->withCount(['messages as unread_count' => fn($q) => $q->where('is_read', false)->where('sender_id', '!=', auth::id())])
            ->latest('updated_at')
            ->get();

        // Pastikan variabel 'chats' ikut dikirim di dalam compact()
        return view('admin.chats.chat', compact('chats', 'chat', 'messages', 'sopir'));
    }

    // Kirim pesan
    public function sendMessage(Request $request, Chat $chat)
    {
        abort_if($chat->admin_id !== Auth::id(), 403);

        $request->validate([
            'message'    => 'required_without:attachment|nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('chat-attachments', 'public');
        }

        $message = ChatMessage::create([
            'chat_id'    => $chat->id,
            'sender_id'  => Auth::id(),
            'message'    => $request->message ?? '',
            'attachment' => $attachmentPath,
            'is_read'    => false,
        ]);

        $chat->touch();

        // <-- [TAMBAHAN 2] Tembakkan notifikasi real-time ke Sopir
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['success' => true, 'message' => $message->load('sender')]);
    }
}
