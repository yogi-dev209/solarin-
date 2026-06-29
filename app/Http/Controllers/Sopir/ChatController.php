<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use App\Events\MessageSent; // <-- [TAMBAHAN 1] Import Event
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Sopir tidak pilih admin — otomatis cari chat yang ada, atau bikin baru
    public function index()
    {
        $chat = Chat::where('driver_id', Auth::id())->latest('updated_at')->first();

        if (! $chat) {
            $admin = User::whereIn('role', ['admin', 'manajemen_driver', 'senior_manager'])->first();

            abort_if(! $admin, 404, 'Belum ada admin terdaftar untuk memulai chat.');

            $chat = Chat::create([
                'admin_id'  => $admin->id,
                'driver_id' => Auth::id(),
            ]);
        }

        // Tandai pesan dari admin sebagai sudah dibaca
        ChatMessage::where('chat_id', $chat->id)
            ->where('sender_id', '!=', Auth::id())
            ->update(['is_read' => true]);

        $messages = $chat->messages()->with('sender')->latest()->paginate(30);

        return view('sopir.chats.chat', compact('chat', 'messages'));
    }

    // Kirim pesan
    public function sendMessage(Request $request, Chat $chat)
    {
        abort_if($chat->driver_id !== Auth::id(), 403);

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

        // <-- [TAMBAHAN 2] Tembakkan notifikasi real-time ke Admin
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['success' => true, 'message' => $message->load('sender')]);
    }
}