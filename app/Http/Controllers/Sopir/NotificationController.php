<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth::id())
            ->latest()
            ->get();

        return response()->json([
            'notifications' => $notifications->map(function ($notif) {
                return [
                    'id'         => $notif->id,
                    'title'      => $notif->title,
                    'message'    => $notif->message,
                    'type'       => $notif->type,
                    'is_read'    => (bool) $notif->is_read,
                    'created_at' => $notif->created_at->format('d/m/Y H:i'),
                ];
            }),
            'unread_count' => $notifications->where('is_read', false)->count(),
        ]);
    }

    public function unreadCount()
    {
        $count = Notification::where('user_id', auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $count]);
    }

    public function markAsRead(Notification $notification)
    {
        abort_if($notification->user_id !== auth::id(), 403);

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}