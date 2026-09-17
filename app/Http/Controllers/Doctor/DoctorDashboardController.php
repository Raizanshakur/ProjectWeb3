<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DoctorDashboardController extends Controller
{
    /**
     * Tampilkan dashboard dokter dengan data dummy.
     * TODO: Ganti data dummy dengan query database sesungguhnya.
     */
    public function index(): View
    {
        // Data dummy — akan diganti saat koneksi database siap
        $doctor = (object) [
            'name'           => 'Dr. Anisa Rahma',
            'specialization' => 'Dokter Anak',
            'email'          => 'dr.anisa@growcare.id',
            'phone'          => '0812-3456-7890',
            'photo'          => null,
            'is_available'   => true,
        ];

        $stats = [
            'total_consultations'   => 156,
            'today_patients'        => 8,
            'pending_consultations' => 5,
            'completed_today'       => 3,
        ];

        $recentConsultations = collect([
            (object) [
                'id'                => 1,
                'parent_name'       => 'Siti Nurhaliza',
                'child_name'        => 'Ahmad',
                'child_age'         => '14 bulan',
                'complaint'         => 'Anak tidak mau makan sejak 3 hari lalu, berat badan turun.',
                'status'            => 'pending',
                'consultation_date' => now()->subHours(2),
            ],
            (object) [
                'id'                => 2,
                'parent_name'       => 'Rina Wati',
                'child_name'        => 'Bella',
                'child_age'         => '8 bulan',
                'complaint'         => 'Demam tinggi disertai ruam merah di seluruh badan.',
                'status'            => 'accepted',
                'consultation_date' => now()->subHours(5),
            ],
            (object) [
                'id'                => 3,
                'parent_name'       => 'Budi Santoso',
                'child_name'        => 'Citra',
                'child_age'         => '24 bulan',
                'complaint'         => 'Anak belum bisa bicara kata-kata sederhana.',
                'status'            => 'completed',
                'consultation_date' => now()->subDay(),
            ],
            (object) [
                'id'                => 4,
                'parent_name'       => 'Dewi Lestari',
                'child_name'        => 'Dimas',
                'child_age'         => '18 bulan',
                'complaint'         => 'Konsultasi pertumbuhan berat badan anak.',
                'status'            => 'pending',
                'consultation_date' => now()->subHours(1),
            ],
            (object) [
                'id'                => 5,
                'parent_name'       => 'Eka Putri',
                'child_name'        => 'Farah',
                'child_age'         => '10 bulan',
                'complaint'         => 'Anak sering muntah setelah makan.',
                'status'            => 'cancelled',
                'consultation_date' => now()->subDays(2),
            ],
        ]);

        $todaySchedule = collect([
            (object) [
                'time'        => '09:00',
                'parent_name' => 'Siti Nurhaliza',
                'child_name'  => 'Ahmad',
                'type'        => 'Konsultasi Baru',
            ],
            (object) [
                'time'        => '10:30',
                'parent_name' => 'Rina Wati',
                'child_name'  => 'Bella',
                'type'        => 'Follow-up',
            ],
            (object) [
                'time'        => '13:00',
                'parent_name' => 'Dewi Lestari',
                'child_name'  => 'Dimas',
                'type'        => 'Konsultasi Baru',
            ],
        ]);

        return view('doctor.dashboard', compact(
            'doctor',
            'stats',
            'recentConsultations',
            'todaySchedule'
        ));
    }
}
