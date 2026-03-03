<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScanController extends Controller
{
    public function index()
    {
        return view('admin.scan');
    }

    public function find(Request $request)
    {
        $siswa = DB::table('siswa')
            ->where('nisn', $request->nisn)
            ->first();

        return view('admin.scan', compact('siswa'));
    }
}