<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DoctorDashboardController extends Controller
{
    /**
     * Tampilkan dashboard dokter dengan data dinamis dari database asli.
     */
    public function index(): View
    {
        $user = Auth::user();
        $doctor = $user->doctor;
        $doctorId = $doctor?->id;

        // Representasi data dokter dari relasi atau fallback akun autentikasi
        $doctorData = $doctor ?? (object) [
            'id'             => null,
            'name'           => $user->name,
            'specialization' => null,
            'email'          => $user->email,
            'phone'          => null,
            'photo'          => null,
            'is_available'   => false,
            'practice_days'  => null,
            'start_time'     => null,
            'end_time'       => null,
            'bio'            => null,
        ];

        if ($doctorId) {
            // A. Total Konsultasi: Seluruh konsultasi yang ditujukan ke dokter ini
            $totalConsultations = Consultation::where('doctor_id', $doctorId)->count();

            // B. Pasien Hari Ini: Pasien unik (anak) yang memiliki jadwal konsultasi hari ini (status aktif/tidak dibatalkan)
            $todayPatients = Consultation::where('doctor_id', $doctorId)
                ->whereDate('consultation_date', today())
                ->where('status', '!=', 'cancelled')
                ->distinct('child_id')
                ->count('child_id');

            // C. Menunggu: Konsultasi berstatus pending yang menunggu respon dokter
            $pendingConsultations = Consultation::where('doctor_id', $doctorId)
                ->where('status', 'pending')
                ->count();

            // D. Selesai Hari Ini: Konsultasi terjadwal hari ini yang telah diselesaikan (status completed)
            // Catatan: Schema belum memiliki kolom 'completed_at', sehingga metrik merujuk pada jadwal hari ini yang berstatus completed.
            $completedToday = Consultation::where('doctor_id', $doctorId)
                ->where('status', 'completed')
                ->whereDate('consultation_date', today())
                ->count();

            // Konsultasi Terbaru (Maksimal 5)
            $recentConsultations = Consultation::where('doctor_id', $doctorId)
                ->with(['user', 'child'])
                ->latest('created_at')
                ->latest('id')
                ->take(5)
                ->get()
                ->map(function ($consultation) {
                    return (object) [
                        'id'                => $consultation->id,
                        'parent_name'       => $consultation->user?->name ?? 'Orang Tua',
                        'child_name'        => $consultation->child?->name ?? 'Anak',
                        'child_age'         => $consultation->child?->formatted_age,
                        'complaint'         => $consultation->complaint,
                        'status'            => $consultation->status,
                        'consultation_date' => $consultation->consultation_date ?? $consultation->created_at,
                    ];
                });

            // Jadwal Hari Ini: Konsultasi aktif hari ini, diurutkan berdasarkan jam konsultasi
            $todaySchedule = Consultation::where('doctor_id', $doctorId)
                ->whereDate('consultation_date', today())
                ->where('status', '!=', 'cancelled')
                ->with(['user', 'child'])
                ->orderBy('consultation_date', 'asc')
                ->get()
                ->map(function ($consultation) {
                    $statusLabel = match ($consultation->status) {
                        'pending'   => 'Menunggu Respon',
                        'accepted'  => 'Konsultasi Aktif',
                        'completed' => 'Selesai',
                        default     => ucfirst($consultation->status),
                    };

                    return (object) [
                        'id'          => $consultation->id,
                        'time'        => $consultation->consultation_date ? $consultation->consultation_date->format('H:i') : null,
                        'parent_name' => $consultation->user?->name ?? 'Orang Tua',
                        'child_name'  => $consultation->child?->name ?? 'Anak',
                        'type'        => $statusLabel,
                        'status'      => $consultation->status,
                    ];
                });
        } else {
            $totalConsultations = 0;
            $todayPatients = 0;
            $pendingConsultations = 0;
            $completedToday = 0;
            $recentConsultations = collect();
            $todaySchedule = collect();
        }

        $stats = [
            'total_consultations'   => $totalConsultations,
            'today_patients'        => $todayPatients,
            'pending_consultations' => $pendingConsultations,
            'completed_today'       => $completedToday,
        ];

        return view('doctor.dashboard', [
            'doctor'              => $doctorData,
            'stats'               => $stats,
            'recentConsultations' => $recentConsultations,
            'todaySchedule'       => $todaySchedule,
        ]);
    }
}
