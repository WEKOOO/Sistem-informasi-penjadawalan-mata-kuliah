<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna.
     */
    public function index()
    {
        $users = User::all(); // Mengambil semua data pengguna
        return view('users.index', compact('users')); // Tampilkan di view users.index
    }

    /**
     * Redirect berdasarkan role pengguna.
     */
    public function redirectByRole()
    {
        $user = auth()->user(); // Ambil pengguna yang sedang login

        if (!$user) {
            return redirect('/login')->withErrors(['error' => 'Anda belum login!']);
        }

        switch ($user->role) {
            case 'admin':
                return redirect('/dashboard/admin');
            case 'dosen':
                return redirect('/dashboard/dosen');
            case 'mahasiswa':
                return redirect('/dashboard/mahasiswa');
            default:
                return redirect('/')->withErrors(['error' => 'Role tidak dikenali.']);
        }
    }
}
