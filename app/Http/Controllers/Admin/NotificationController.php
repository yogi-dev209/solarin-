<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SendNotificationRequest;
use App\Models\Barcode;
use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $notification) {}

    public function index()
    {
        // Admin melihat SEMUA notifikasi yang dikirim ke semua user
        $notifications = Notification::with('user')->latest()->get();

        $totalNotif     = $notifications->count();
        $unreadCount    = $notifications->where('is_read', false)->count();
        $pengajuanCount = $notifications->where('type', 'pengajuan')->count();
        $resetCount     = $notifications->where('type', 'reset')->count();

        return view('admin.notifications.notifikasi', compact(
            'notifications', 'totalNotif', 'unreadCount', 'pengajuanCount', 'resetCount'
        ));
    }

    public function markAsRead(Notification $notification)
    {
        // Admin boleh tandai semua notifikasi sebagai dibaca

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function create()
    {
        $sopirs = User::where('role', 'sopir')->where('status', 'aktif')->orderBy('name')->get();

        $sopirs->each(function ($sopir) {
            $latestBarcode = Barcode::whereHas(
                'submission.vehicle',
                fn($q) => $q->where('user_id', $sopir->id)
            )->latest()->first();

            $sopir->latest_barcode_number = $latestBarcode?->barcode_number;
        });

        $history = Notification::with('user')
            ->where('type', 'umum')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.notifications.kirim-notifikasi', compact('sopirs', 'history'));
    }

    public function send(SendNotificationRequest $request)
    {
        $sopir = User::findOrFail($request->user_id);

        $this->notification->sendToUser($sopir, 'Notifikasi dari Admin', $request->message, 'umum');

        return response()->json([
            'success'     => true,
            'message'     => 'Notifikasi berhasil dikirim.',
            'driver_name' => $sopir->name,
        ]);
    }
}