<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarcodeResetRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode_id',
        'reason',
        'status',
        'admin_note',
    ];

    // Barcode yang diminta untuk direset
    public function barcode(): BelongsTo
    {
        return $this->belongsTo(Barcode::class, 'barcode_id');
    }
}