<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorAuthController extends Controller
{
    /**
     * Tampilkan halaman login dokter.
     */
    public function showLogin(): View
    {
        return view('doctor.auth.login');
    }

    /**
     * Handle login dokter.
     * TODO: Implementasi autentikasi — akan dikerjakan saat koneksi database siap.
     */
    public function login(Request $request)
    {
        // Placeholder: langsung redirect ke dashboard dokter
        // Nanti diganti dengan logic autentikasi sesungguhnya
        return redirect()->route('dokter.dashboard');
    }

    /**
     * Handle logout dokter.
     * TODO: Implementasi logout — akan dikerjakan saat koneksi database siap.
     */
    public function logout(Request $request)
    {
        return redirect()->route('dokter.login');
    }
}
