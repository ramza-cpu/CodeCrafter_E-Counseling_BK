<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        // cari user
        $user = User::where('username', $request->username)->first();

        if (! $user) {
            return back()->with('error', 'Username tidak ditemukan');
        }

        if (! Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah');
        }

        // ✅ LOGIN MENGGUNAKAN AUTH LARAVEL
        Auth::login($user);

        // regenerate session biar aman
        $request->session()->regenerate();

        // redirect sesuai role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'guru':
                return redirect()->route('guru.dashboard');

            case 'siswa':
                return redirect()->route('siswa.dashboard');

            case 'ortu':
                return redirect()->route('ortu.dashboard');

            default:
                Auth::logout();
                return redirect('/login')->with('error', 'Role tidak valid');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}