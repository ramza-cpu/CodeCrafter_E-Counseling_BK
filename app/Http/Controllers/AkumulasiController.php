<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST DATA SURAT (HALAMAN ADMIN)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $surat = DB::table('surat')
            ->join('siswa', 'surat.id_siswa', '=', 'siswa.id_siswa')
            ->select(
                'surat.id_surat',
                'surat.jenis_surat',
                'surat.status',
                'surat.tanggal_cetak',
                'siswa.nama',
                'siswa.kelas'
            )
            ->orderBy('surat.created_at', 'desc')
            ->get();

        return view('admin.surat', compact('surat'));
    }


    /*
    |--------------------------------------------------------------------------
    | PROSES CETAK SURAT
    |--------------------------------------------------------------------------
    */
    public function cetak($id)
    {
        // ambil data surat + siswa
        $surat = DB::table('surat')
            ->join('siswa', 'surat.id_siswa', '=', 'siswa.id_siswa')
            ->where('surat.id_surat', $id)
            ->select(
                'surat.*',
                'siswa.nama',
                'siswa.kelas'
            )
            ->first();

        if (!$surat) {
            return back()->with('error', 'Data surat tidak ditemukan');
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL ID GURU DARI USER LOGIN
        |--------------------------------------------------------------------------
        */
        $guru = DB::table('guru')
            ->where('id_user', Auth::id())
            ->first();

        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan');
        }

        /*
        |--------------------------------------------------------------------------
        | GENERATE ISI SURAT
        |--------------------------------------------------------------------------
        */
        $isiSurat = $this->generateIsiSurat($surat);

        /*
        |--------------------------------------------------------------------------
        | GENERATE NOMOR SURAT
        |--------------------------------------------------------------------------
        */
        $nomorSurat = 'SP/' . date('Y') . '/' . str_pad($surat->id_surat, 3, '0', STR_PAD_LEFT);

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA SURAT
        |--------------------------------------------------------------------------
        */
        DB::table('surat')
            ->where('id_surat', $id)
            ->update([
                'id_guru' => $guru->id_guru,
                'tanggal_cetak' => now(),
                'status' => 'dicetak',
                'isi_surat' => $isiSurat,
                'nomor_surat' => $nomorSurat,
                'updated_at' => now()
            ]);

        return view('admin.cetak', [
            'surat' => $surat,
            'isi' => $isiSurat,
            'nomor' => $nomorSurat,
            'guru' => $guru
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE ISI SURAT OTOMATIS
    |--------------------------------------------------------------------------
    */
    private function generateIsiSurat($surat)
    {
        $nama = $surat->nama;
        $kelas = $surat->kelas;

        switch ($surat->jenis_surat) {

            case 'Surat Peringatan 1':
                return "Diberikan Surat Peringatan Pertama kepada siswa atas nama $nama kelas $kelas karena telah melakukan pelanggaran tata tertib sekolah.";

            case 'Surat Peringatan 2':
                return "Diberikan Surat Peringatan Kedua kepada siswa atas nama $nama kelas $kelas karena mengulangi pelanggaran dan tidak menunjukkan perbaikan.";

            case 'Surat Pengunduran Diri':
                return "Siswa atas nama $nama kelas $kelas dinyatakan mengundurkan diri dari sekolah karena telah mencapai batas maksimal pelanggaran.";

            default:
                return "Tidak ada isi surat.";
        }
    }
}