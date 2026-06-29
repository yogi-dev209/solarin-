<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function __construct(private ActivityLogService $activityLog) {}

    // ========================================================
    // 1. TAMPILKAN HALAMAN VERIFIKASI (Kiri List, Kanan Detail)
    // ========================================================
    public function index(Request $request)
    {
        // Ambil semua data pengajuan beserta relasi kendaraan, user, dan dokumen
        $submissions = Submission::with(['vehicle.user', 'documents'])
            ->latest()
            ->get();

        return view('admin.submissions.verifikasi-dokumen', compact('submissions'));
    }

    // ========================================================
    // 2. PROSES PERSETUJUAN ATAU PENOLAKAN DARI ADMIN
    // ========================================================
    public function process(Request $request, Submission $submission)
    {
        $request->validate([
            'action'     => 'required|in:approve,reject',
            'admin_note' => 'nullable|string',
        ]);

        if ($request->action === 'approve') {
            $submission->update([
                'status'      => 'diproses', // Langsung diproses setelah dokumen valid
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'note'        => $request->admin_note
            ]);

            // Ubah status semua dokumen jadi disetujui
            $submission->documents()->update(['status' => 'disetujui']);

            $this->activityLog->log($submission, Auth::user(), 'status_berubah', [
                'description' => "Dokumen diverifikasi dan disetujui admin. Pengajuan masuk tahap diproses.",
            ]);

            return back()->with('success', 'Dokumen berhasil disetujui dan pengajuan dilanjutkan ke proses penerbitan.');
        }

        if ($request->action === 'reject') {
            $submission->update([
                'status'           => 'ditolak',
                'rejection_reason' => $request->admin_note,
                'verified_by'      => Auth::id(),
                'verified_at'      => now(),
            ]);

            // Ubah status semua dokumen jadi ditolak
            $submission->documents()->update(['status' => 'ditolak']);

            $this->activityLog->log($submission, Auth::user(), 'status_berubah', [
                'description' => "Pengajuan ditolak oleh admin. Alasan: " . $request->admin_note,
            ]);

            return back()->with('success', 'Pengajuan berhasil ditolak.');
        }
    }
}