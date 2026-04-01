<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $query = Pelanggaran::with(['siswa', 'jenisPelanggaran']);

        if ($search) {
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', '%'.$search.'%');
            });
        }

        $riwayat = $query->orderBy('tanggal', 'desc')->paginate(15)->withQueryString();

        $totalPelanggaran = Pelanggaran::count();

        $siswaPembinaan = Pelanggaran::selectRaw('id_siswa, SUM(poin) as total_poin')
            ->groupBy('id_siswa')
            ->having('total_poin', '>=', 50)
            ->count();

        return view('admin.riwayat', compact(
            'riwayat',
            'totalPelanggaran',
            'siswaPembinaan',
            'search'
        ));
    }

    public function selesai($id)
    {
        $data = Pelanggaran::findOrFail($id);

        $data->update([
            'status' => 'selesai',
        ]);

        return redirect()->back()->with('success', 'Status berhasil diubah menjadi selesai');
    }

    public function riwayatSiswa()
    {
        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan');
        }

        $riwayat = Pelanggaran::with(['siswa', 'jenisPelanggaran'])
            ->where('id_siswa', $siswa->id_siswa)
            ->orderBy('tanggal', 'desc')
            ->paginate(100);

        $totalPelanggaran = Pelanggaran::where('id_siswa', $siswa->id_siswa)->count();

        $totalPoin = Pelanggaran::where('id_siswa', $siswa->id_siswa)->sum('poin');

        return view('siswa.riwayat', compact(
            'riwayat',
            'totalPelanggaran',
            'totalPoin',
            'siswa'
        ));
    }
}
