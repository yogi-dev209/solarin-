<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'theme',
        'language',
        'address',
        'operational_area',
        'join_date',
        'photo',
        'last_login',
        'last_latitude',
        'last_longitude',
        'last_location_updated',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password'             => 'hashed',
        'join_date'             => 'date',
        'last_login'            => 'datetime',
        'last_latitude'         => 'decimal:8',
        'last_longitude'        => 'decimal:8',
        'last_location_updated' => 'datetime',
    ];

    // Kendaraan milik user ini (jika role-nya sopir)
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'user_id');
    }

    // Pengajuan yang diverifikasi oleh user ini (admin)
    public function verifiedSubmissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'verified_by');
    }

    // Pengajuan yang diproses oleh user ini (admin)
    public function processedSubmissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'processed_by');
    }

    // Notifikasi milik user ini (override relasi default dari trait Notifiable,
    // karena tabel notifications di sini pakai kolom user_id, bukan format default Laravel)
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    // Log aktivitas yang dilakukan user ini
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    // Chat dimana user ini berperan sebagai admin
    public function chatsAsAdmin(): HasMany
    {
        return $this->hasMany(Chat::class, 'admin_id');
    }

    // Chat dimana user ini berperan sebagai driver
    public function chatsAsDriver(): HasMany
    {
        return $this->hasMany(Chat::class, 'driver_id');
    }

    // Pesan chat yang dikirim oleh user ini
    public function sentChatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }
}