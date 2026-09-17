<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorConsultationController extends Controller
{
    /**
     * Tampilkan daftar semua konsultasi.
     * TODO: Ganti data dummy dengan query database.
     */
    public function index(): View
    {
        $consultations = collect([
            (object) [
                'id'                => 1,
                'parent_name'       => 'Siti Nurhaliza',
                'child_name'        => 'Ahmad',
                'child_age'         => '14 bulan',
                'child_gender'      => 'L',
                'complaint'         => 'Anak tidak mau makan sejak 3 hari lalu, berat badan turun.',
                'status'            => 'pending',
                'consultation_date' => now()->subHours(2),
            ],
            (object) [
                'id'                => 2,
                'parent_name'       => 'Rina Wati',
                'child_name'        => 'Bella',
                'child_age'         => '8 bulan',
                'child_gender'      => 'P',
                'complaint'         => 'Demam tinggi disertai ruam merah di seluruh badan.',
                'status'            => 'accepted',
                'consultation_date' => now()->subHours(5),
            ],
            (object) [
                'id'                => 3,
                'parent_name'       => 'Budi Santoso',
                'child_name'        => 'Citra',
                'child_age'         => '24 bulan',
                'child_gender'      => 'P',
                'complaint'         => 'Anak belum bisa bicara kata-kata sederhana.',
                'status'            => 'completed',
                'consultation_date' => now()->subDay(),
            ],
            (object) [
                'id'                => 4,
                'parent_name'       => 'Dewi Lestari',
                'child_name'        => 'Dimas',
                'child_age'         => '18 bulan',
                'child_gender'      => 'L',
                'complaint'         => 'Konsultasi pertumbuhan berat badan anak.',
                'status'            => 'pending',
                'consultation_date' => now()->subHours(1),
            ],
            (object) [
                'id'                => 5,
                'parent_name'       => 'Eka Putri',
                'child_name'        => 'Farah',
                'child_age'         => '10 bulan',
                'child_gender'      => 'P',
                'complaint'         => 'Anak sering muntah setelah makan.',
                'status'            => 'cancelled',
                'consultation_date' => now()->subDays(2),
            ],
            (object) [
                'id'                => 6,
                'parent_name'       => 'Fitri Handayani',
                'child_name'        => 'Galih',
                'child_age'         => '6 bulan',
                'child_gender'      => 'L',
                'complaint'         => 'Anak belum bisa duduk sendiri.',
                'status'            => 'completed',
                'consultation_date' => now()->subDays(3),
            ],
            (object) [
                'id'                => 7,
                'parent_name'       => 'Hana Safitri',
                'child_name'        => 'Iqbal',
                'child_age'         => '12 bulan',
                'child_gender'      => 'L',
                'complaint'         => 'Tanyakan jadwal imunisasi yang terlewat.',
                'status'            => 'completed',
                'consultation_date' => now()->subDays(4),
            ],
        ]);

        return view('doctor.consultations.index', compact('consultations'));
    }

    /**
     * Tampilkan detail konsultasi.
     * TODO: Ganti data dummy dengan query database.
     */
    public function show(string $id): View
    {
        // Data dummy konsultasi
        $consultation = (object) [
            'id'                => $id,
            'parent_name'       => 'Siti Nurhaliza',
            'parent_email'      => 'siti@email.com',
            'parent_phone'      => '0813-1234-5678',
            'child_name'        => 'Ahmad',
            'child_age'         => '14 bulan',
            'child_gender'      => 'L',
            'child_birth_date'  => '2025-07-15',
            'child_weight'      => '9.5 kg',
            'child_height'      => '76 cm',
            'complaint'         => 'Anak tidak mau makan sejak 3 hari lalu, berat badan turun. Sudah dicoba berbagai makanan tapi tetap menolak. Hanya mau minum susu saja.',
            'status'            => 'pending',
            'consultation_date' => now()->subHours(2),
            'doctor_notes'      => null,
        ];

        // Data dummy pesan/chat
        $messages = collect([
            (object) [
                'sender_type' => 'parent',
                'message'     => 'Selamat pagi Dok, anak saya Ahmad (14 bulan) tidak mau makan sejak 3 hari lalu. Sudah dicoba berbagai makanan tapi tetap menolak.',
                'created_at'  => now()->subHours(3),
            ],
            (object) [
                'sender_type' => 'parent',
                'message'     => 'Dia hanya mau minum susu saja. Berat badannya sepertinya turun, Dok.',
                'created_at'  => now()->subHours(3)->addMinutes(5),
            ],
            (object) [
                'sender_type' => 'doctor',
                'message'     => 'Selamat pagi, Bu Siti. Terima kasih sudah menghubungi. Apakah Ahmad mengalami demam atau gejala lain seperti diare atau muntah?',
                'created_at'  => now()->subHours(2)->addMinutes(30),
            ],
            (object) [
                'sender_type' => 'parent',
                'message'     => 'Tidak ada demam, Dok. Tapi memang agak rewel dan tidurnya gelisah.',
                'created_at'  => now()->subHours(2)->addMinutes(45),
            ],
        ]);

        return view('doctor.consultations.show', compact(
            'consultation',
            'messages'
        ));
    }
}
