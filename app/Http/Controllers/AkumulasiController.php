<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AkumulasiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN HALAMAN AKUMULASI
    |--------------------------------------------------------------------------
    */
    public function create($id_siswa)
    {
        $siswa = DB::table('siswa')
            ->where('id_siswa', $id_siswa)
            ->first();

        if (! $siswa) {
            return redirect()->route('scan')
                ->with('error', 'Data siswa tidak ditemukan');
        }

        $jenis = DB::table('jenis_pelanggaran')->get();

        return view('admin.akumulasi', compact('siswa', 'jenis'));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA PELANGGARAN
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required',
            'id_jenis_pelanggaran' => 'required',
            'keterangan' => 'required',
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------
            | 1️⃣ Ambil id_user yang login
            |--------------------------------------------------------------
            */
            $idUser = Auth::id();

            /*
            |--------------------------------------------------------------
            | 2️⃣ Cari id_guru berdasarkan id_user
            |--------------------------------------------------------------
            */
            $guru = DB::table('guru')
                ->where('id_user', $idUser)
                ->first();

            if (! $guru) {
                return back()->with('error', 'Guru tidak ditemukan.');
            }

            /*
            |--------------------------------------------------------------
            | 3️⃣ Ambil data siswa
            |--------------------------------------------------------------
            */
            $siswa = DB::table('siswa')
                ->where('id_siswa', $request->id_siswa)
                ->first();

            if (! $siswa) {
                return back()->with('error', 'Siswa tidak ditemukan.');
            }

            /*
            |--------------------------------------------------------------
            | 4️⃣ Ambil jenis pelanggaran
            |--------------------------------------------------------------
            */
            $jenis = DB::table('jenis_pelanggaran')
                ->where('id_jenis_pelanggaran', $request->id_jenis_pelanggaran)
                ->first();

            if (! $jenis) {
                return back()->with('error', 'Jenis pelanggaran tidak ditemukan.');
            }

            $poin = $jenis->poin;

            /*
            |--------------------------------------------------------------
            | 5️⃣ Hitung skor baru (maksimal 100)
            |--------------------------------------------------------------
            */
            $skorBaru = $siswa->skor + $poin;

            if ($skorBaru > 100) {
                $skorBaru = 100;
            }

            /*
            |--------------------------------------------------------------
            | 6️⃣ Insert ke tabel pelanggaran
            |--------------------------------------------------------------
            */
            DB::table('pelanggaran')->insert([
                'id_siswa' => $request->id_siswa,
                'id_jenis_pelanggaran' => $request->id_jenis_pelanggaran,
                'id_guru' => $guru->id_guru,
                'tanggal' => now(),
                'poin' => $poin,
                'keterangan' => $request->keterangan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------
            | 7️⃣ Update skor siswa
            |--------------------------------------------------------------
            */
            DB::table('siswa')
                ->where('id_siswa', $request->id_siswa)
                ->update([
                    'skor' => $skorBaru,
                    'updated_at' => now(),
                ]);

            /*
            |--------------------------------------------------------------
            | 8️⃣ GENERATE SURAT OTOMATIS 🔥
            |--------------------------------------------------------------
            */
            $this->generateSuratIfNeeded($request->id_siswa, $skorBaru);

            DB::commit();

            return redirect()->route('scan')
                ->with('success', 'Pelanggaran berhasil ditambahkan.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE SURAT BERDASARKAN SKOR
    |--------------------------------------------------------------------------
    */
    private function generateSuratIfNeeded($id_siswa, $skor)
    {
        // SP1
        if ($skor >= 40 && ! $this->suratSudahAda($id_siswa, 'Surat Peringatan 1')) {
            $this->createSurat($id_siswa, 'Surat Peringatan 1');
        }

        // SP2
        if ($skor >= 70 && ! $this->suratSudahAda($id_siswa, 'Surat Peringatan 2')) {
            $this->createSurat($id_siswa, 'Surat Peringatan 2');
        }

        // Pengunduran Diri
        if ($skor >= 100 && ! $this->suratSudahAda($id_siswa, 'Surat Pengunduran Diri')) {
            $this->createSurat($id_siswa, 'Surat Pengunduran Diri');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | JIKA SURAT SUDAH DITERIMA SISWA SEBELUMNYA
    |--------------------------------------------------------------------------
    */

    private function suratSudahAda($id_siswa, $jenis_surat)
    {
        return DB::table('surat')
            ->where('id_siswa', $id_siswa)
            ->where('jenis_surat', $jenis_surat)
            ->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | INSERT SURAT
    |--------------------------------------------------------------------------
    */
    private function createSurat($id_siswa, $jenis_surat)
    {
        // ambil pelanggaran siswa
        $pelanggaranList = DB::table('pelanggaran')
            ->join(
                'jenis_pelanggaran',
                'pelanggaran.id_jenis_pelanggaran',
                '=',
                'jenis_pelanggaran.id_jenis_pelanggaran'
            )
            ->where('pelanggaran.id_siswa', $id_siswa)
            ->pluck('jenis_pelanggaran.nama_pelanggaran')
            ->unique()
            ->values()
            ->toArray();

        // ubah jadi string
        $pelanggaranText = implode(', ', $pelanggaranList);

        // format nomor surat: ddmmyy
        // ambil tanggal hari ini
        $tanggal = date('dmy');

        // hitung jumlah surat hari ini
        $count = DB::table('surat')
            ->whereDate('created_at', now())
            ->count() + 1;

        // format jadi 3 digit
        $urutan = str_pad($count, 3, '0', STR_PAD_LEFT);

        // hasil akhir
        $nomorSurat = "SR-{$tanggal}-{$urutan}";

        DB::table('surat')->insert([
            'id_siswa' => $id_siswa,
            'jenis_surat' => $jenis_surat,
            'jenis_pelanggaran' => $pelanggaranText, // ✅ isi otomatis
            'nomor_surat' => $nomorSurat, // ✅ format ddmmyy
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
