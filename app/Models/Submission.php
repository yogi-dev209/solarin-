<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_code',
        'vehicle_id',
        'submission_date',
        'status',
        'note',
        'verified_by',
        'verified_at',
        'rejection_reason',
        'processed_by',
    ];

    protected $casts = [
        'submission_date' => 'date',
        'verified_at'     => 'datetime',
    ];

    // Kendaraan yang diajukan
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    // Admin yang memverifikasi pengajuan ini
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Admin yang memproses pengajuan ini
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Dokumen-dokumen yang diupload untuk pengajuan ini
    public function documents(): HasMany
    {
        return $this->hasMany(SubmissionDocument::class, 'submission_id');
    }

    // Barcode yang terbit dari pengajuan ini (1 pengajuan -> 1 barcode)
    public function barcode(): HasOne
    {
        return $this->hasOne(Barcode::class, 'submission_id');
    }

    // Riwayat aktivitas terkait pengajuan ini
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'submission_id');
    }
}