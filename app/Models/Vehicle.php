<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plate_number',
        'door_number',
        'vehicle_type',
        'fuel_type',
        'wheels_count',
        'tax_expired',
        'stnk_expired',
    ];

    protected $casts = [
        'wheels_count' => 'integer',
        'tax_expired'  => 'date',
        'stnk_expired' => 'date',
    ];

    // Pemilik / sopir kendaraan ini
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Semua pengajuan yang dibuat untuk kendaraan ini
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'vehicle_id');
    }
}