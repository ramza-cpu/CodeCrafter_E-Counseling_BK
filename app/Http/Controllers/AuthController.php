<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (! $user) {
            return back()->with('error', 'Username tidak ditemukan');
        }

        if (! Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah');
        }

        // simpan session
        session([
            'user_id' => $user->id_user,
            'username' => $user->username,
            'role' => $user->role,
        ]);

        // redirect berdasarkan role
        if ($user->role == 'admin') {
            return redirect('/admin');
        }

        if ($user->role == 'guru') {
            return redirect('/guru');
        }

        if ($user->role == 'siswa') {
            return redirect('/siswa');
        }

        if ($user->role == 'ortu') {
            return redirect('/ortu');
        }
    }

public function logout(Request $request)
{
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}

}
