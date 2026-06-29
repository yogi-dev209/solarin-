<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;
use Illuminate\Support\Facades\Log;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


Broadcast::channel('chat.{chatId}', function ($user, $chatId) {

    Log::info([
        'login_user' => $user->id,
        'chat_id' => $chatId,
    ]);

    $chat = \App\Models\Chat::find($chatId);

    Log::info($chat);

    if (!$chat) {
        return false;
    }

    return $user->id === $chat->admin_id ||
           $user->id === $chat->driver_id;

});



// Saluran khusus notifikasi personal
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


