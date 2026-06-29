<?php

namespace App\Services;

use App\Models\Notification;
use App\Events\NotificationSent;

class NotificationService
{
    public function sendToUser($user, $title, $message, $type = 'umum')
    {
        // 1. Simpan ke database
        $notification = Notification::create([
            'user_id' => $user->id,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'is_read' => false,
        ]);

        // 2. TEMBAKKAN SINYAL REAL-TIME!
        broadcast(new NotificationSent($notification));

        return $notification;
    }
}