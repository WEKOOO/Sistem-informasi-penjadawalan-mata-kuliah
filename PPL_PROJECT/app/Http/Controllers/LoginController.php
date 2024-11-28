<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Autentikasi pengguna
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role pengguna
            $role = Auth::user()->role;
            switch ($role) {
                case 'admin':
                    return redirect('/dashboard'); // Halaman admin
                case 'dosen':
                    return redirect('/dashboard-dosen'); // Halaman dosen
                case 'mahasiswa':
                    return redirect('/mahasiswaPage'); // Halaman mahasiswa
                default:
                    Auth::logout(); // Jika role tidak valid, logout pengguna
                    return redirect('/login')->withErrors(['login' => 'Role tidak dikenali.']);
            }
        }

        // Jika login gagal
        return back()->withErrors([
            'login' => 'Email atau password salah.',
        ]);
    }

    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // Mengembalikan tampilan form login
        return view('auth.login'); // File di resources/views/auth/login.blade.php
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Logout pengguna
        $request->session()->invalidate(); // Hancurkan sesi
        $request->session()->regenerateToken(); // Regenerasi token CSRF
        return redirect('/login'); // Redirect ke halaman login
    }
}
