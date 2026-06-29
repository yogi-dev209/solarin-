<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Barcode;
use App\Models\BarcodeResetRequest;
use App\Models\Notification;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Statistik Sopir
        $totalSopir = User::where('role', 'sopir')->count();
        $sopirAktif = User::where('role', 'sopir')->where('status', 'aktif')->count();

        // ── Statistik Pengajuan
        $totalPengajuan       = Submission::count();
        $pengajuanMenunggu    = Submission::where('status', 'menunggu_verifikasi')->count();
        $pengajuanPerluRevisi = Submission::where('status', 'perlu_revisi')->count();
        $pengajuanDiproses    = Submission::whereIn('status', [
            'diproses', 'menunggu_upload_barcode', 'menunggu_penerbitan',
        ])->count();
        $pengajuanSelesai     = Submission::whereIn('status', ['disetujui', 'barcode_terbit'])->count();
        $pengajuanDitolak     = Submission::where('status', 'ditolak')->count();

        // ── Butuh Tindakan Segera
        $butuhTindakan = Submission::whereIn('status', [
            'menunggu_verifikasi',
            'menunggu_upload_barcode',
            'menunggu_penerbitan',
        ])->with('vehicle.user')->latest()->limit(5)->get();

        // ── Barcode & Reset
        $totalBarcode  = Barcode::count();
        $resetMenunggu = BarcodeResetRequest::where('status', 'menunggu')->count();

        // ── Notifikasi Belum Dibaca
        $unreadNotif = Notification::where('user_id', Auth::id())->where('is_read', false)->count();

        // ── Pengajuan Terbaru (Banyakin sedikit untuk fitur Filter)
        $recentPengajuan = Submission::with('vehicle.user')
            ->latest()
            ->limit(10) 
            ->get();

        // ── Aktivitas Terbaru (Load relasi vehicle agar bisa ambil No Pintu)
        $recentActivity = ActivityLog::with(['user', 'submission.vehicle'])
            ->latest()
            ->limit(6)
            ->get();

        // ── Chart Pengajuan per Bulan (tahun ini)
        $monthlyRaw = Submission::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $namaBulan   = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $chartLabels = [];
        $chartData   = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $namaBulan[$i - 1];
            $chartData[]   = $monthlyRaw[$i] ?? 0;
        }

        // PASTIKAN NAMA FOLDER VIEW INI BENAR (Contoh: 'admin.dashboard.dashboard' atau 'admin.dashboard')
        return view('admin.dashboard.dashboard', compact(
            'totalSopir', 'sopirAktif',
            'totalPengajuan', 'pengajuanMenunggu', 'pengajuanPerluRevisi',
            'pengajuanDiproses', 'pengajuanSelesai', 'pengajuanDitolak',
            'butuhTindakan',
            'totalBarcode', 'resetMenunggu',
            'unreadNotif',
            'recentPengajuan', 'recentActivity',
            'chartLabels', 'chartData'
        ));
    }
}