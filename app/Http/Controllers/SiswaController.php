<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('user');

        // AMBIL INPUT
        $search = strtolower(trim($request->search));
        $kelas = trim($request->kelas);

        // 🔍 SEARCH NAMA DEPAN (HARUS PERSIS)
        if (! empty($search)) {
            $query->whereRaw(
                "LOWER(SUBSTRING_INDEX(nama, ' ', 1)) = ?",
                [$search]
            );
        }

        // 🎯 FILTER KELAS (HARUS PERSIS, TIDAK BOLEH NYASAR)
        if (! empty($kelas)) {
            $query->whereRaw(
                "SUBSTRING_INDEX(kelas, '-', 1) = ?",
                [$kelas]
            );
        }

        $siswa = $query->paginate(10);

        // AJAX
        if ($request->ajax()) {
            return view('admin.partials.table_siswa', compact('siswa'))->render();
        }

        // STAT CARD (BIAR KONSISTEN JUGA)
        $totalSiswa = Siswa::count();
        $kelasX = Siswa::whereRaw("SUBSTRING_INDEX(kelas, '-', 1) = 'X'")->count();
        $kelasXI = Siswa::whereRaw("SUBSTRING_INDEX(kelas, '-', 1) = 'XI'")->count();
        $kelasXII = Siswa::whereRaw("SUBSTRING_INDEX(kelas, '-', 1) = 'XII'")->count();

        return view('admin.manajemen', compact(
            'siswa',
            'totalSiswa',
            'kelasX',
            'kelasXI',
            'kelasXII'
        ));
    }

    public function store(Request $request)
    {

        $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'nisn' => 'required|unique:siswa,nisn',
            'nama' => 'required',
            'kelas' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make('123456'),
                'role' => 'siswa',
            ]);

            Siswa::create([
                'id_user' => $user->id_user,
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'skor' => $request->skor,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Data siswa berhasil ditambahkan');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function update(Request $request, $id)
    {

        try {

            $siswa = Siswa::findOrFail($id);

            $siswa->update([
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'skor' => $request->skor,
            ]);

            $siswa->user->update([
                'username' => $request->username,
                'email' => $request->email,
            ]);

            return redirect()->back()->with('success', 'Data berhasil diperbarui');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Gagal memperbarui data');

        }

    }

    public function destroy($id)
    {

        try {

            $siswa = Siswa::findOrFail($id);

            $siswa->user()->delete();

            $siswa->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Gagal menghapus data');

        }

    }
}
