<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuratController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST SURAT
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $surat = DB::table('surat')
            ->join('siswa', 'surat.id_siswa', '=', 'siswa.id_siswa')
            ->select(
                'surat.id_surat',
                'surat.nomor_surat',
                'surat.jenis_surat',
                'surat.jenis_pelanggaran',
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
    | PREVIEW SURAT
    |--------------------------------------------------------------------------
    */
    public function preview($id)
    {
        $surat = $this->getSurat($id);

        if (! $surat) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        // ambil pelanggaran
        $pelanggaranList = $this->getPelanggaranList($surat->id_siswa);

        // ambil orang tua
        $ortu = $this->getOrangTua($surat->id_siswa);

        // ambil guru login
        $guru = $this->getGuruLogin();

        // generate isi
        $isi = $this->generateIsi($surat, $pelanggaranList);

        return view('admin.preview', [
            'surat' => $surat,
            'isi' => $isi,
            'pelanggaranList' => $pelanggaranList,
            'ortu' => $ortu,
            'guru' => $guru,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CETAK SURAT (STATUS → TERCETAK)
    |--------------------------------------------------------------------------
    */
    public function cetak($id)
    {
        $surat = $this->getSurat($id);

        if (! $surat) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $guru = $this->getGuruLogin();

        if (! $guru) {
            return response()->json(['error' => 'Guru tidak ditemukan'], 404);
        }

        // ambil pelanggaran
        $pelanggaranList = $this->getPelanggaranList($surat->id_siswa);
        $pelanggaranText = implode(', ', $pelanggaranList);

        // nomor surat
        $nomorSurat = 'SP/'.date('Y').'/'.str_pad($surat->id_surat, 3, '0', STR_PAD_LEFT);

        DB::table('surat')->where('id_surat', $id)->update([
            'id_guru' => $guru->id_guru,
            'tanggal_cetak' => now(),
            'status' => 'tercetak', // ✅ sesuai permintaan
            'jenis_pelanggaran' => $pelanggaranText,
            'nomor_surat' => $nomorSurat,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Surat berhasil dicetak',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GET SURAT + SISWA
    |--------------------------------------------------------------------------
    */
    private function getSurat($id)
    {
        return DB::table('surat')
            ->join('siswa', 'surat.id_siswa', '=', 'siswa.id_siswa')
            ->where('surat.id_surat', $id)
            ->select(
                'surat.*',
                'siswa.id_siswa',
                'siswa.nama',
                'siswa.kelas'
            )
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | GET ORANG TUA
    |--------------------------------------------------------------------------
    */
    private function getOrangTua($id_siswa)
    {
        return DB::table('orang_tua')
            ->where('id_siswa', $id_siswa)
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | GET GURU LOGIN
    |--------------------------------------------------------------------------
    */
    private function getGuruLogin()
    {
        return DB::table('guru')
            ->where('id_user', Auth::id())
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | GET PELANGGARAN
    |--------------------------------------------------------------------------
    */
    private function getPelanggaranList($id_siswa)
    {
        return DB::table('pelanggaran')
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
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE ISI SURAT
    |--------------------------------------------------------------------------
    */
    private function generateIsi($surat, $pelanggaranList)
    {
        $nama = $surat->nama;
        $kelas = $surat->kelas;
        $pelanggaranText = implode(', ', $pelanggaranList);

        if ($surat->jenis_surat == 'Surat Peringatan 1') {
            return "
Dengan hormat,

Kami memberitahukan bahwa siswa atas nama {$nama} kelas {$kelas} telah melakukan pelanggaran berupa: {$pelanggaranText}.

Kami menghimbau kepada orang tua/wali murid agar dapat lebih memperhatikan serta membimbing putra/putrinya agar tidak mengulangi pelanggaran.

Kerja sama dari Bapak/Ibu sangat kami harapkan demi kebaikan siswa di masa depan.

Demikian surat ini kami sampaikan, atas perhatian dan kerja samanya kami ucapkan terima kasih.
";
        }

        if ($surat->jenis_surat == 'Surat Peringatan 2') {
            return "
Dengan hormat,

Berdasarkan catatan pelanggaran, siswa atas nama {$nama} kelas {$kelas} telah melakukan pelanggaran berulang, yaitu: {$pelanggaranText}.

Kami sangat mengharapkan perhatian serius dari orang tua/wali murid untuk melakukan pembinaan lebih lanjut.

Apabila pelanggaran terus berlanjut, sekolah akan mengambil tindakan lebih tegas sesuai peraturan.

Demikian surat ini kami sampaikan.
";
        }

        if ($surat->jenis_surat == 'Surat Pengunduran Diri') {
            return "
Dengan hormat,

Siswa atas nama {$nama} kelas {$kelas} telah melakukan pelanggaran berat yaitu: {$pelanggaranText}.

Dengan ini pihak sekolah memutuskan bahwa siswa tersebut dinyatakan mengundurkan diri.

Keputusan ini diambil berdasarkan aturan yang berlaku di sekolah.

Demikian surat ini dibuat.
";
        }

        return 'Tidak ada isi surat.';
    }
}
