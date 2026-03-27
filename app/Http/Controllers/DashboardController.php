<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\Surat;
use Illuminate\Support\Facades\DB;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use App\Models\Siswa;
// use App\Models\Pelanggaran;
// use App\Models\Surat;
// use App\Models\JenisPelanggaran;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function getData()
    {
        // =========================
        // TOTAL MURID
        // =========================
        $totalMurid = Siswa::count();

        // =========================
        // BUTUH PERHATIAN (>=40)
        // =========================
        $butuhPerhatian = Siswa::where('skor', '>=', 40)->count();

        // =========================
        // STATISTIK BULANAN (PELAGGARAN)
        // =========================
        $statistikBulanan = Pelanggaran::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // =========================
        // TOP 4 KATEGORI KASUS
        // =========================
        $kategoriKasus = Pelanggaran::join('jenis_pelanggaran', 'pelanggaran.id_jenis_pelanggaran', '=', 'jenis_pelanggaran.id_jenis_pelanggaran')
            ->select('jenis_pelanggaran.nama_pelanggaran', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_pelanggaran.nama_pelanggaran')
            ->orderByDesc('total')
            ->limit(4)
            ->get();

        // =========================
        // NOTIF DARURAT (SURAT PENDING)
        // =========================
        $notifDarurat = Surat::join('siswa', 'surat.id_siswa', '=', 'siswa.id_siswa')
    ->where('surat.status', 'pending')
    ->select('siswa.nama', 'surat.jenis_surat', 'surat.created_at')
    ->orderBy('surat.created_at', 'desc')
    ->get();

        // =========================
        // REKAP POIN
        // =========================
        $tertib = Siswa::whereBetween('skor', [0, 20])->count();
        $pembinaan = Siswa::whereBetween('skor', [21, 39])->count();
        $prioritas = Siswa::whereBetween('skor', [40, 100])->count();

        // =========================
        // TINDAK LANJUT (STATUS PROSES)
        // =========================
        $tindakLanjut = Pelanggaran::join('siswa', 'pelanggaran.id_siswa', '=', 'siswa.id_siswa')
            ->join('jenis_pelanggaran', 'pelanggaran.id_jenis_pelanggaran', '=', 'jenis_pelanggaran.id_jenis_pelanggaran')
            ->where('pelanggaran.status', 'proses')
            ->select('siswa.nama', 'jenis_pelanggaran.nama_pelanggaran')
            ->orderBy('pelanggaran.created_at', 'desc')
            ->get();

        return response()->json([
            'total_murid' => $totalMurid,
            'butuh_perhatian' => $butuhPerhatian,
            'statistik_bulanan' => $statistikBulanan,
            'kategori_kasus' => $kategoriKasus,
            'notif_darurat' => $notifDarurat,
            'rekap' => [
                'tertib' => $tertib,
                'pembinaan' => $pembinaan,
                'prioritas' => $prioritas,
            ],
            'tindak_lanjut' => $tindakLanjut,
            'user' => auth()->user()->username,
        ]);
    }
}
