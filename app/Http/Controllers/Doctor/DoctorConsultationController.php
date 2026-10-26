<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Notifications\ConsultationAcceptedNotification;
use App\Notifications\ConsultationCompletedNotification;
use App\Notifications\NewConsultationMessageNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DoctorConsultationController extends Controller
{
    /**
     * Tampilkan daftar semua konsultasi milik dokter yang login dengan filter, pencarian, dan pagination.
     */
    public function index(Request $request): View
    {
        $doctorId = Auth::user()->doctor?->id;

        $status = $request->query('status');
        $search = trim((string) $request->query('search', ''));

        // Validasi status yang diizinkan
        $validStatuses = ['pending', 'accepted', 'completed', 'cancelled'];
        $currentStatus = in_array($status, $validStatuses, true) ? $status : 'all';

        // Jika dokter belum memiliki record profil di tabel doctors, kembalikan paginator kosong
        if (!$doctorId) {
            $consultations = new LengthAwarePaginator([], 0, 10, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);

            $counts = [
                'total'     => 0,
                'pending'   => 0,
                'accepted'  => 0,
                'completed' => 0,
                'cancelled' => 0,
            ];

            return view('doctor.consultations.index', compact(
                'consultations',
                'counts',
                'currentStatus',
                'search'
            ));
        }

        // ── Agregasi Global Statistik & Tab dari Database ──
        $baseQuery = Consultation::where('doctor_id', $doctorId);
        $counts = [
            'total'     => (clone $baseQuery)->count(),
            'pending'   => (clone $baseQuery)->where('status', 'pending')->count(),
            'accepted'  => (clone $baseQuery)->where('status', 'accepted')->count(),
            'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
            'cancelled' => (clone $baseQuery)->where('status', 'cancelled')->count(),
        ];

        // ── Query Utama Konsultasi Dokter ──
        $query = Consultation::where('doctor_id', $doctorId)
            ->with(['user', 'child']);

        // Filter Berdasarkan Status
        if ($currentStatus !== 'all') {
            $query->where('status', $currentStatus);
        }

        // Pencarian (Nama Anak, Nama Orang Tua, atau Keluhan)
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('child', function ($childQuery) use ($search) {
                    $childQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('user', function ($parentQuery) use ($search) {
                    $parentQuery->where('name', 'like', "%{$search}%");
                })->orWhere('complaint', 'like', "%{$search}%");
            });
        }

        // Urutkan terbaru dan lakukan pagination 10 item per halaman
        $consultations = $query->latest('created_at')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('doctor.consultations.index', compact(
            'consultations',
            'counts',
            'currentStatus',
            'search'
        ));
    }

    /**
     * Tampilkan detail konsultasi milik dokter yang login dari database.
     */
    public function show(string $id): View
    {
        $consultation = $this->getDoctorConsultation($id);

        // Tandai pesan dari orang tua yang belum dibaca sebagai sudah dibaca
        $consultation->messages()
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $consultation->load([
            'user',
            'child.latestGrowthRecord',
            'messages' => fn ($q) => $q->oldest('created_at')->oldest('id'),
        ]);

        $latestGrowth = $consultation->child?->latestGrowthRecord;
        $messages = $consultation->messages;

        return view('doctor.consultations.show', compact(
            'consultation',
            'latestGrowth',
            'messages'
        ));
    }

    /**
     * Kirim pesan baru dari dokter pada konsultasi yang sedang aktif/diterima.
     */
    public function sendMessage(Request $request, string $id): RedirectResponse
    {
        $consultation = $this->getDoctorConsultation($id);

        if ($consultation->status !== 'accepted') {
            return redirect()
                ->route('dokter.konsultasi.detail', $consultation->id)
                ->with('error', 'Pesan hanya dapat dikirim saat sesi konsultasi aktif / telah diterima.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ], [
            'message.required' => 'Pesan tidak boleh kosong.',
            'message.max' => 'Pesan tidak boleh melebihi 5000 karakter.',
        ]);

        $trimmedMessage = trim($validated['message']);
        if ($trimmedMessage === '') {
            return redirect()
                ->route('dokter.konsultasi.detail', $consultation->id)
                ->with('error', 'Pesan tidak boleh hanya berisi spasi.');
        }

        $msg = DB::transaction(function () use ($consultation, $trimmedMessage) {
            return $consultation->messages()->create([
                'sender_type' => 'doctor',
                'message'     => $trimmedMessage,
                'is_read'     => false,
            ]);
        });

        // Notifikasi pesan baru ke Orang Tua (Parent)
        $consultation->loadMissing('user', 'doctor');
        if ($parentUser = $consultation->user) {
            $parentUser->notify(new NewConsultationMessageNotification($consultation, $msg));
        }

        return redirect()
            ->route('dokter.konsultasi.detail', $consultation->id)
            ->with('success', 'Pesan berhasil dikirim.');
    }

    /**
     * Terima konsultasi yang berstatus pending secara aman dan bebas race condition.
     */
    public function accept(string $id): RedirectResponse
    {
        $doctor = Auth::user()?->doctor;
        if (! $doctor) {
            abort(404, 'Konsultasi tidak ditemukan.');
        }

        $notificationToSend = null;

        $accepted = DB::transaction(function () use ($id, $doctor, &$notificationToSend) {
            $consultation = Consultation::where('id', $id)
                ->where('doctor_id', $doctor->id)
                ->lockForUpdate()
                ->first();

            if (! $consultation) {
                return null;
            }

            if ($consultation->status !== 'pending') {
                return false;
            }

            $consultation->update([
                'status' => 'accepted',
            ]);

            $consultation->loadMissing('user', 'doctor');
            if ($parentUser = $consultation->user) {
                $notificationToSend = [$parentUser, new ConsultationAcceptedNotification($consultation)];
            }

            return true;
        });

        if ($accepted === null) {
            abort(404, 'Konsultasi tidak ditemukan.');
        }

        if (! $accepted) {
            return redirect()
                ->route('dokter.konsultasi.detail', $id)
                ->with('error', 'Konsultasi tidak dapat diterima karena statusnya bukan menunggu.');
        }

        if ($notificationToSend) {
            [$recipient, $notification] = $notificationToSend;
            $recipient->notify($notification);
        }

        return redirect()
            ->route('dokter.konsultasi.detail', $id)
            ->with('success', 'Konsultasi berhasil diterima.');
    }

    /**
     * Simpan catatan medis dokter untuk konsultasi yang sedang aktif/diterima.
     */
    public function saveNotes(Request $request, string $id): RedirectResponse
    {
        $consultation = $this->getDoctorConsultation($id);

        if ($consultation->status !== 'accepted') {
            return redirect()
                ->route('dokter.konsultasi.detail', $consultation->id)
                ->with('error', 'Catatan hanya dapat disimpan ketika konsultasi sedang aktif / diterima.');
        }

        $validated = $request->validate([
            'doctor_notes' => 'required|string|max:5000',
        ], [
            'doctor_notes.required' => 'Catatan medis dokter wajib diisi.',
            'doctor_notes.max' => 'Catatan medis dokter maksimal 5000 karakter.',
        ]);

        $consultation->update([
            'doctor_notes' => $validated['doctor_notes'],
        ]);

        return redirect()
            ->route('dokter.konsultasi.detail', $consultation->id)
            ->with('success', 'Catatan medis dokter berhasil disimpan.');
    }

    /**
     * Selesaikan konsultasi yang berstatus accepted secara aman dan bebas race condition.
     */
    public function complete(string $id): RedirectResponse
    {
        $doctor = Auth::user()?->doctor;
        if (! $doctor) {
            abort(404, 'Konsultasi tidak ditemukan.');
        }

        $notificationToSend = null;

        $completed = DB::transaction(function () use ($id, $doctor, &$notificationToSend) {
            $consultation = Consultation::where('id', $id)
                ->where('doctor_id', $doctor->id)
                ->lockForUpdate()
                ->first();

            if (! $consultation) {
                return null;
            }

            if ($consultation->status !== 'accepted') {
                return false;
            }

            $consultation->update([
                'status' => 'completed',
            ]);

            $consultation->loadMissing('user', 'doctor');
            if ($parentUser = $consultation->user) {
                $notificationToSend = [$parentUser, new ConsultationCompletedNotification($consultation)];
            }

            return true;
        });

        if ($completed === null) {
            abort(404, 'Konsultasi tidak ditemukan.');
        }

        if (! $completed) {
            return redirect()
                ->route('dokter.konsultasi.detail', $id)
                ->with('error', 'Konsultasi hanya dapat diselesaikan jika statusnya sedang aktif / diterima.');
        }

        if ($notificationToSend) {
            [$recipient, $notification] = $notificationToSend;
            $recipient->notify($notification);
        }

        return redirect()
            ->route('dokter.konsultasi.detail', $id)
            ->with('success', 'Konsultasi telah berhasil diselesaikan.');
    }

    /**
     * Ambil record konsultasi milik dokter yang sedang login, atau gagal dengan 404 jika tidak ditemukan.
     */
    protected function getDoctorConsultation(int|string $id): Consultation
    {
        $doctor = Auth::user()?->doctor;

        if (!$doctor) {
            abort(404, 'Konsultasi tidak ditemukan.');
        }

        $consultation = Consultation::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->first();

        if (!$consultation) {
            abort(404, 'Konsultasi tidak ditemukan.');
        }

        return $consultation;
    }
}
