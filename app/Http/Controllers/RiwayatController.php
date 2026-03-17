<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use Illuminate\Http\Request;

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
        'status' => 'selesai'
    ]);

    return redirect()->back()->with('success', 'Status berhasil diubah menjadi selesai');
}
}
