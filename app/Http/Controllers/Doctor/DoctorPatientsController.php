<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DoctorPatientsController extends Controller
{
    /**
     * Tampilkan daftar pasien anak yang terhubung melalui riwayat konsultasi dengan dokter yang sedang login.
     */
    public function index(Request $request): View
    {
        $doctor = Auth::user()?->doctor;
        $search = trim((string) $request->query('search', ''));

        // Jika dokter belum memiliki record profil di tabel doctors, kembalikan paginator kosong
        if (!$doctor) {
            $patients = new LengthAwarePaginator([], 0, 10, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);

            $counts = [
                'total'     => 0,
                'active'    => 0,
                'attention' => 'Belum tersedia',
            ];

            return view('doctor.patients', compact('patients', 'counts', 'search'));
        }

        $doctorId = $doctor->id;

        // ── 1. Agregasi Statistik Pasien Unik ──
        // Total Pasien: Jumlah anak unik yang pernah memiliki konsultasi dengan dokter ini
        $totalPatients = Child::whereHas('consultations', function ($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId);
        })->count();

        // Aktif: Jumlah anak unik yang memiliki setidaknya satu konsultasi berstatus accepted
        $activePatients = Child::whereHas('consultations', function ($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId)->where('status', 'accepted');
        })->count();

        // Perlu Perhatian: Cek apakah ada data penilaian status gizi yang valid pada sistem
        $hasAssessedRecords = Child::whereHas('consultations', function ($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId);
        })->whereHas('growthRecords', function ($gq) {
            $gq->whereNotNull('nutrition_status');
        })->exists();

        if ($hasAssessedRecords) {
            $attentionCount = Child::whereHas('consultations', function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            })->whereHas('latestGrowthRecord', function ($gq) {
                $gq->where(function ($sq) {
                    $sq->where('nutrition_status', 'like', '%kurang%')
                       ->orWhere('nutrition_status', 'like', '%buruk%')
                       ->orWhere('nutrition_status', 'like', '%perhatian%')
                       ->orWhere('nutrition_status', 'like', '%stunting%');
                });
            })->count();

            $attentionDisplay = $attentionCount . ' Anak';
        } else {
            $attentionDisplay = 'Belum tersedia';
        }

        $counts = [
            'total'     => $totalPatients,
            'active'    => $activePatients,
            'attention' => $attentionDisplay,
        ];

        // ── 2. Query Daftar Pasien Anak Unik ──
        $query = Child::whereHas('consultations', function ($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId);
        })->with([
            'user',
            'latestGrowthRecord',
            'consultations' => function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId)->latest('consultation_date')->latest('id');
            },
        ]);

        // Filter Pencarian (Nama Anak atau Nama Orang Tua)
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Pagination 10 pasien per halaman dengan menjaga query string
        $patients = $query->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('doctor.patients', compact('patients', 'counts', 'search'));
    }
}
