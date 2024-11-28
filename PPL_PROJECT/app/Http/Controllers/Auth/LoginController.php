<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            $role = Auth::user()->role;
            switch ($role) {
                case 'admin':
                    return redirect('/dashboard/admin');
                case 'dosen':
                    return redirect('/dashboard/dosen');
                case 'mahasiswa':
                    return redirect('/dashboard/mahasiswa');
                default:
                    return redirect('/')->withErrors(['login' => 'Role tidak dikenali.']);
            }
        }

        // Jika login gagal
        return back()->withErrors([
            'login' => 'Email atau password salah.',
        ]);
    }
}
