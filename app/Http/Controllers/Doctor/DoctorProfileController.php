<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorProfileController extends Controller
{
    /**
     * Tampilkan halaman profil dokter.
     * TODO: Ganti data dummy dengan query database.
     */
    public function index(): View
    {
        $doctor = (object) [
            'name'           => 'Dr. Anisa Rahma, Sp.A',
            'specialization' => 'Dokter Spesialis Anak',
            'str_number'     => 'STR-3120-1234-5678',
            'phone'          => '0812-3456-7890',
            'email'          => 'dr.anisa@growcare.id',
            'photo'          => null,
            'practice_days'  => 'Senin - Jumat',
            'start_time'     => '08:00',
            'end_time'       => '16:00',
            'is_available'   => true,
            'bio'            => 'Dokter Spesialis Anak dengan pengalaman lebih dari 10 tahun di bidang tumbuh kembang anak dan gizi pediatrik. Lulusan Fakultas Kedokteran Universitas Indonesia dengan spesialisasi di RSCM Jakarta.',
        ];

        return view('doctor.profile', compact('doctor'));
    }

    /**
     * Update profil dokter.
     * TODO: Implementasi update ke database.
     */
    public function update(Request $request)
    {
        // Placeholder — nanti diisi logic update ke database
        return redirect()->route('dokter.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
