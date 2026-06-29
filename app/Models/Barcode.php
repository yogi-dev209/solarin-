<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'barcode_number',
        'barcode_file',
        'issued_date',
        'note',
    ];

    protected $casts = [
        'issued_date' => 'date',
    ];

    // Pengajuan asal barcode ini diterbitkan
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class, 'submission_id');
    }

    // Permintaan reset yang pernah diajukan untuk barcode ini
    public function resetRequests(): HasMany
    {
        return $this->hasMany(BarcodeResetRequest::class, 'barcode_id');
    }
}