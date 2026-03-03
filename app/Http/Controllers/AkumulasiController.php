<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        if (!$siswa) {
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
            'keterangan' => 'required'
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

            if (!$guru) {
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

            if (!$siswa) {
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

            if (!$jenis) {
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
                'updated_at' => now()
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
                    'updated_at' => now()
                ]);

            DB::commit();

            return redirect()->route('scan')
                ->with('success', 'Pelanggaran berhasil ditambahkan.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}