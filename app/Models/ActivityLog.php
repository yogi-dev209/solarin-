<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'user_id',
        'action',
        'description',
        'old_value',
        'new_value',
    ];

    // Pengajuan yang terkait log ini
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class, 'submission_id');
    }

    // User yang melakukan aksi ini
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}