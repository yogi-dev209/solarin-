<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sopir\BarcodeResetRequest;
use App\Models\Barcode;
use App\Models\BarcodeResetRequest as ResetModel;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;

class BarcodeResetController extends Controller
{
    public function __construct(private ActivityLogService $activityLog) {}

    public function create()
    {
        $barcode = Barcode::with('submission.vehicle.user')
            ->whereHas('submission.vehicle', function($q) {
                $q->where('user_id', Auth::id());
            })->latest()->first();

        if (!$barcode) {
            return redirect()->route('sopir.dashboard')->with('error', 'Anda belum memiliki barcode aktif untuk direset.');
        }

        // 1. Cek apakah ada pengajuan reset yang masih "Menunggu" jawaban Admin
        $activeReset = ResetModel::where('barcode_id', $barcode->id)
            ->where('status', 'menunggu')
            ->latest()
            ->first();

        // 2. Jika tidak ada yang menunggu, cek apakah Admin sudah menyetujui TAPI belum mengupload Barcode baru
        if (!$activeReset && $barcode->submission->status === 'menunggu_upload_barcode') {
            $activeReset = ResetModel::where('barcode_id', $barcode->id)
                ->where('status', 'disetujui')
                ->latest()
                ->first();
        }

        // Jika $activeReset ditemukan, berarti proses reset MASIH BERJALAN.
        // Jika null (misal Admin sudah upload barcode baru), berarti proses SELESAI dan form bisa dipakai lagi.
        $alreadyRequested = $activeReset ? true : false;

        return view('sopir.barcodes.reset-barcode', compact('barcode', 'alreadyRequested', 'activeReset'));
    }

    public function store(BarcodeResetRequest $request)
    {
        $barcode = Barcode::whereHas('submission.vehicle', function($q) {
            $q->where('user_id', Auth::id());
        })->latest()->firstOrFail();

        // Lakukan pencegahan agar sopir tidak spam request saat masih diproses
        $isMenunggu = ResetModel::where('barcode_id', $barcode->id)
            ->where('status', 'menunggu')
            ->exists();
            
        $isBelumDiupload = ($barcode->submission->status === 'menunggu_upload_barcode');

        if ($isMenunggu || $isBelumDiupload) {
            return back()->withErrors(['error' => 'Anda masih memiliki pengajuan reset yang sedang diproses.']);
        }

        ResetModel::create([
            'barcode_id' => $barcode->id,
            'reason'     => $request->reason,
            'status'     => 'menunggu',
        ]);

        $this->activityLog->log($barcode->submission, Auth::user(), 'reset_diajukan', [
            'description' => "Pengajuan reset barcode: {$request->reason}",
        ]);

        return redirect()->route('sopir.reset-barcode')
            ->with('success', 'Pengajuan reset barcode berhasil dikirim. Silakan tunggu konfirmasi Admin.');
    }
}