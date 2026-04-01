<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\Surat;
use Illuminate\Support\Facades\Auth;
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

    // UNTUK DASHBOARD SISWA
    public function siswa()
    {
        $user = Auth::user();

        // Ambil data siswa berdasarkan id_user
        $siswa = Siswa::where('id_user', $user->id_user)->first();

        // Validasi (biar gak error kalau tidak ketemu)
        if (! $siswa) {
            abort(404, 'Data siswa tidak ditemukan');
        }

        // 1. Dua pelanggaran terakhir + join ke jenis_pelanggaran
        $pelanggaran = DB::table('pelanggaran')
            ->join('jenis_pelanggaran', 'pelanggaran.id_jenis_pelanggaran', '=', 'jenis_pelanggaran.id_jenis_pelanggaran')
            ->where('pelanggaran.id_siswa', $siswa->id_siswa)
            ->orderBy('pelanggaran.tanggal', 'desc')
            ->limit(2)
            ->select(
                'pelanggaran.*',
                'jenis_pelanggaran.nama_pelanggaran'
            )
            ->get();

        // 2. Surat peringatan (jika ada)
        $surat = Surat::where('id_siswa', $siswa->id_siswa)
            ->orderBy('tanggal_cetak', 'desc')
            ->first();

        // 3. Skor siswa
        $skor = $siswa->skor ?? 0;

        // Rekap poin
        $tertib = max(0, 100 - $skor); // biar tidak minus
        $pembinaan = $skor;

        return view('siswa.dashboard', [
            'siswa' => $siswa,
            'pelanggaran' => $pelanggaran,
            'surat' => $surat,
            'skor' => $skor,
            'tertib' => $tertib,
            'pembinaan' => $pembinaan,
        ]);
    }

    public function ortu()
    {
        $user = Auth::user();

        // Ambil data orang tua
        $ortu = DB::table('orang_tua')
            ->where('id_user', $user->id_user)
            ->first();

        if (! $ortu) {
            abort(404, 'Data orang tua tidak ditemukan');
        }

        // Ambil siswa berdasarkan id_siswa dari orang_tua
        $siswa = Siswa::where('id_siswa', $ortu->id_siswa)->first();

        if (! $siswa) {
            abort(404, 'Data siswa tidak ditemukan');
        }

        // 1. Dua pelanggaran terakhir + join jenis
        $pelanggaran = DB::table('pelanggaran')
            ->join('jenis_pelanggaran', 'pelanggaran.id_jenis_pelanggaran', '=', 'jenis_pelanggaran.id_jenis_pelanggaran')
            ->where('pelanggaran.id_siswa', $siswa->id_siswa)
            ->orderBy('pelanggaran.tanggal', 'desc')
            ->limit(2)
            ->select(
                'pelanggaran.*',
                'jenis_pelanggaran.nama_pelanggaran'
            )
            ->get();

        // 2. Surat
        $surat = Surat::where('id_siswa', $siswa->id_siswa)
            ->orderBy('tanggal_cetak', 'desc')
            ->first();

        // 3. Skor
        $skor = $siswa->skor ?? 0;

        // Rekap poin
        $tertib = max(0, 100 - $skor);
        $pembinaan = $skor;

        return view('ortu.dashboard', [
            'user' => $user,
            'siswa' => $siswa,
            'pelanggaran' => $pelanggaran,
            'surat' => $surat,
            'skor' => $skor,
            'tertib' => $tertib,
            'pembinaan' => $pembinaan,
        ]);
    }

    public function guru()
    {
        $user = Auth::user();

        // =========================
        // DATA GURU
        // =========================
        $guru = DB::table('guru')
            ->where('id_user', $user->id_user)
            ->first();

        if (! $guru) {
            abort(404);
        }

        // =========================
        // TOTAL MURID (TETAP)
        // =========================
        $totalMurid = Siswa::count();

        // =========================
        // BUTUH PERHATIAN (TETAP)
        // =========================
        $butuhPerhatian = Siswa::where('skor', '>=', 40)->count();

        // =========================
        // STATISTIK BULANAN
        // =========================
        $statistikBulanan = Pelanggaran::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // =========================
        // KATEGORI KASUS
        // =========================
        $kategoriKasus = Pelanggaran::join('jenis_pelanggaran', 'pelanggaran.id_jenis_pelanggaran', '=', 'jenis_pelanggaran.id_jenis_pelanggaran')
            ->select('jenis_pelanggaran.nama_pelanggaran', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_pelanggaran.nama_pelanggaran')
            ->orderByDesc('total')
            ->limit(4)
            ->get();

        // =========================
        // NOTIF DARURAT
        // =========================
        $notifDarurat = Surat::join('siswa', 'surat.id_siswa', '=', 'siswa.id_siswa')
            ->where('surat.status', 'pending')
            ->select('siswa.nama', 'surat.jenis_surat', 'surat.tanggal_cetak')
            ->orderBy('surat.tanggal_cetak', 'desc')
            ->limit(5)
            ->get();

        // =========================
        // REKAP POIN
        // =========================
        $tertib = Siswa::whereBetween('skor', [0, 20])->count();
        $pembinaan = Siswa::whereBetween('skor', [21, 39])->count();
        $prioritas = Siswa::whereBetween('skor', [40, 100])->count();

        // =========================
        // TINDAK LANJUT (TETAP)
        // =========================
        $tindakLanjut = Pelanggaran::join('siswa', 'pelanggaran.id_siswa', '=', 'siswa.id_siswa')
            ->join('jenis_pelanggaran', 'pelanggaran.id_jenis_pelanggaran', '=', 'jenis_pelanggaran.id_jenis_pelanggaran')
            ->where('pelanggaran.status', 'proses')
            ->select('siswa.nama', 'jenis_pelanggaran.nama_pelanggaran')
            ->orderBy('pelanggaran.tanggal', 'desc') // FIX ERROR SEBELUMNYA
            ->limit(5)
            ->get();

        return view('guru.dashboard', compact(
            'guru',
            'totalMurid',
            'butuhPerhatian',
            'statistikBulanan',
            'kategoriKasus',
            'notifDarurat',
            'tertib',
            'pembinaan',
            'prioritas',
            'tindakLanjut'
        ));
    }
}
