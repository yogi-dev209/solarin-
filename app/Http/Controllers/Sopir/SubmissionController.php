<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sopir\StoreSubmissionRequest;
use App\Models\Submission;
use App\Models\SubmissionDocument;
use App\Models\Vehicle;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function __construct(private ActivityLogService $activityLog) {}

    // ========================================================
    // 1. HALAMAN STATUS PENGAJUAN
    // ========================================================
    public function index(Request $request)
    {
        $query = Submission::with(['vehicle', 'documents'])
            ->whereHas('vehicle', fn($q) => $q->where('user_id', Auth::id()));

        $submissions = $query->latest()->get(); 

        return view('sopir.submissions.status-pengajuan', compact('submissions'));
    }

    // ========================================================
    // 2. HALAMAN FORM BUAT PENGAJUAN
    // ========================================================
    public function create()
    {
        $vehicle = Vehicle::where('user_id', Auth::id())->first();

        return view('sopir.submissions.pengajuan', compact('vehicle'));
    }

    // ========================================================
    // 3. PROSES SIMPAN PENGAJUAN BARU
    // ========================================================
    public function store(StoreSubmissionRequest $request)
    {
        $vehicle = Vehicle::where('id', $request->vehicle_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Cegah pengajuan ganda 
        $hasActiveSubmission = Submission::where('vehicle_id', $vehicle->id)
            ->whereNotIn('status', ['ditolak', 'barcode_terbit'])
            ->exists();

        if ($hasActiveSubmission) {
            return back()->withErrors([
                'vehicle_id' => 'Kendaraan ini masih memiliki pengajuan yang sedang berjalan. Silakan cek di menu Status Pengajuan.',
            ]);
        }

        // Logika Generate ID Pengajuan (Solarin-{No Pintu}-001, dst)
        $doorNumber = strtoupper($vehicle->door_number);
        $nextSeq = Submission::where('vehicle_id', $vehicle->id)->count() + 1;
        $submissionCode = sprintf("Solarin-%s-%03d", $doorNumber, $nextSeq);

        while (Submission::where('submission_code', $submissionCode)->exists()) {
            $nextSeq++;
            $submissionCode = sprintf("Solarin-%s-%03d", $doorNumber, $nextSeq);
        }

        $submission = Submission::create([
            'submission_code' => $submissionCode,
            'vehicle_id'      => $vehicle->id,
            'submission_date' => now()->toDateString(),
            'status'          => 'menunggu_verifikasi',
        ]);

        if ($request->hasFile('foto_kendaraan')) {
            $path = $request->file('foto_kendaraan')->store('submissions/foto-kendaraan', 'public');
            SubmissionDocument::create([
                'submission_id' => $submission->id,
                'document_type' => 'foto_kendaraan',
                'file'          => $path,
                'status'        => 'menunggu',
            ]);
        }

        if ($request->hasFile('stnk_pajak')) {
            $path = $request->file('stnk_pajak')->store('submissions/stnk-pajak', 'public');
            SubmissionDocument::create([
                'submission_id' => $submission->id,
                'document_type' => 'stnk_pajak',
                'file'          => $path,
                'status'        => 'menunggu',
            ]);
        }

        $this->activityLog->log($submission, Auth::user(), 'pengajuan_dibuat', [
            'description' => "Pengajuan {$submission->submission_code} dibuat oleh sopir.",
        ]);

        return redirect()->route('sopir.status-pengajuan')
            ->with('success', 'Pengajuan berhasil dikirim. Tunggu verifikasi admin.');
    }
}