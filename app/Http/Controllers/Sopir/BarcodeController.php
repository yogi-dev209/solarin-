<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use App\Models\Barcode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BarcodeController extends Controller
{
    // Tampilkan Barcode Sopir
    public function index()
    {
        // PERBAIKAN: Barcode HANYA muncul jika statusnya benar-benar 'barcode_terbit'
        $barcode = Barcode::with('submission.vehicle.user')
            ->whereHas('submission', function ($q) {
                // Syarat mutlak: Statusnya harus barcode_terbit
                $q->where('status', 'barcode_terbit') 
                  ->whereHas('vehicle', function ($v) {
                      $v->where('user_id', auth::id());
                  });
            })
            ->latest()
            ->first();

        return view('sopir.barcodes.barcode', compact('barcode'));
    }

    // Download file barcode asli
    public function download(Barcode $barcode)
    {
        abort_if($barcode->submission->vehicle->user_id !== auth::id(), 403);
        
        // Cegah download jika status pengajuan sedang di-reset
        abort_if($barcode->submission->status !== 'barcode_terbit', 403, 'Barcode ini sedang dalam proses reset dan tidak aktif.');

        if (! $barcode->barcode_file || ! Storage::disk('public')->exists($barcode->barcode_file)) {
            abort(404, 'File barcode belum tersedia.');
        }

        $extension = pathinfo($barcode->barcode_file, PATHINFO_EXTENSION);
        $path = Storage::disk('public')->path($barcode->barcode_file);

        return response()->download(
            $path,
            "barcode-{$barcode->barcode_number}.{$extension}"
        );
    }
}