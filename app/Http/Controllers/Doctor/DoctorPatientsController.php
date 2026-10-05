<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DoctorPatientsController extends Controller
{
    /**
     * Tampilkan daftar semua pasien anak.
     * TODO: Ganti data dummy dengan query database.
     */
    public function index(): View
    {
        // Data dummy pasien — akan diganti saat koneksi database siap
        $patients = collect([
            (object) [
                'id'            => 1,
                'name'          => 'Ahmad',
                'gender'        => 'L',
                'birth_date'    => '2025-08-15',
                'parent_name'   => 'Siti Nurhaliza',
                'weight'        => '9.5',
                'height'        => '76',
                'status'        => 'optimal',
                'consultations' => 3,
            ],
            (object) [
                'id'            => 2,
                'name'          => 'Bella',
                'gender'        => 'P',
                'birth_date'    => '2026-02-10',
                'parent_name'   => 'Rina Wati',
                'weight'        => '7.2',
                'height'        => '68',
                'status'        => 'optimal',
                'consultations' => 2,
            ],
            (object) [
                'id'            => 3,
                'name'          => 'Citra',
                'gender'        => 'P',
                'birth_date'    => '2024-10-05',
                'parent_name'   => 'Budi Santoso',
                'weight'        => '11.0',
                'height'        => '85',
                'status'        => 'perhatian',
                'consultations' => 5,
            ],
            (object) [
                'id'            => 4,
                'name'          => 'Dimas',
                'gender'        => 'L',
                'birth_date'    => '2025-04-20',
                'parent_name'   => 'Dewi Lestari',
                'weight'        => '10.1',
                'height'        => '80',
                'status'        => 'optimal',
                'consultations' => 1,
            ],
            (object) [
                'id'            => 5,
                'name'          => 'Farah',
                'gender'        => 'P',
                'birth_date'    => '2025-12-01',
                'parent_name'   => 'Eka Putri',
                'weight'        => '8.0',
                'height'        => '72',
                'status'        => 'optimal',
                'consultations' => 2,
            ],
            (object) [
                'id'            => 6,
                'name'          => 'Galih',
                'gender'        => 'L',
                'birth_date'    => '2026-04-15',
                'parent_name'   => 'Fitri Handayani',
                'weight'        => '6.8',
                'height'        => '65',
                'status'        => 'perhatian',
                'consultations' => 4,
            ],
        ]);

        return view('doctor.patients', compact('patients'));
    }
}
