<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DoctorProfileController extends Controller
{
    /**
     * Tampilkan halaman profil dokter berdasarkan akun dan database asli.
     */
    public function index(): View
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        // Jika dokter belum memiliki record di tabel doctors, tampilkan representasi
        // data asli dari akun User dengan nilai field profesional yang kosong (tanpa dummy)
        $doctorData = $doctor ?? (object) [
            'id'             => null,
            'name'           => $user->name,
            'specialization' => null,
            'str_number'     => null,
            'phone'          => null,
            'email'          => $user->email,
            'photo'          => null,
            'practice_days'  => null,
            'start_time'     => null,
            'end_time'       => null,
            'is_available'   => false,
            'bio'            => null,
        ];

        return view('doctor.profile', [
            'doctor' => $doctorData,
        ]);
    }

    /**
     * Perbarui data profil dokter dan akun pengguna secara aman dalam transaksi database.
     */
    public function update(DoctorProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        $doctor = $user->doctor;

        // Tangani status ketersediaan secara aman:
        // Jika parameter is_available dikirimkan pada request, gunakan nilai boolean-nya.
        // Jika request parsial tidak menyertakan is_available, pertahankan nilai database existing.
        $isAvailable = $request->has('is_available')
            ? $request->boolean('is_available')
            : ($doctor?->is_available ?? false);

        DB::transaction(function () use ($user, $doctor, $validated, $isAvailable) {
            // 1. Perbarui kredensial nama & email akun pengguna
            $user->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);

            // 2. Siapkan payload field profil profesional dokter
            $doctorPayload = [
                'name'           => $validated['name'],
                'email'          => $validated['email'],
                'specialization' => $validated['specialization'] ?? null,
                'str_number'     => $validated['str_number'] ?? null,
                'phone'          => $validated['phone'] ?? null,
                'practice_days'  => $validated['practice_days'] ?? null,
                'start_time'     => $validated['start_time'] ?? null,
                'end_time'       => $validated['end_time'] ?? null,
                'bio'            => $validated['bio'] ?? null,
                'is_available'   => $isAvailable,
            ];

            // 3. Perbarui record yang ada atau buat baru terikat langsung ke $user->id
            if ($doctor) {
                $doctor->update($doctorPayload);
            } else {
                $user->doctor()->create($doctorPayload);
            }
        });

        return redirect()->route('dokter.profil')
            ->with('success', 'Profil dokter berhasil diperbarui.');
    }
}
