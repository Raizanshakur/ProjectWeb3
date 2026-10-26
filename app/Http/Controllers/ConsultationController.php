<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsultationRequest;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Notifications\ConsultationCancelledNotification;
use App\Notifications\ConsultationRequestedNotification;
use App\Notifications\NewConsultationMessageNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ConsultationController extends Controller
{
    /**
     * Tampilkan daftar konsultasi milik orang tua yang sedang login.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $query = Consultation::forParent(Auth::id())
            ->with(['child', 'doctor'])
            ->latest();

        if ($status && in_array($status, ['pending', 'accepted', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        $consultations = $query->paginate(10)->withQueryString();

        return view('consultations.index', compact('consultations'));
    }

    /**
     * Tampilkan formulir pembuatan permintaan konsultasi.
     */
    public function create(Request $request): View
    {
        $children = Auth::user()
            ->children()
            ->latest()
            ->get();

        $doctors = Doctor::with('user')
            ->available()
            ->get();

        $selectedChildId = $request->query('child_id');
        $selectedDoctorId = $request->query('doctor_id');

        return view('consultations.create', compact(
            'children',
            'doctors',
            'selectedChildId',
            'selectedDoctorId'
        ));
    }

    /**
     * Simpan permintaan konsultasi baru dengan status pending.
     */
    public function store(StoreConsultationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $consultation = Consultation::create([
            'user_id' => Auth::id(),
            'child_id' => $validated['child_id'],
            'doctor_id' => $validated['doctor_id'],
            'complaint' => $validated['complaint'],
            'consultation_date' => $validated['consultation_date'] ?? null,
            'status' => 'pending',
            'doctor_notes' => null,
        ]);

        // Notifikasi ke Dokter yang dipilih jika akun user dokter tersedia
        $doctor = Doctor::with('user')->find($validated['doctor_id']);
        if ($doctor?->user) {
            $consultation->loadMissing('child', 'user');
            $doctor->user->notify(new ConsultationRequestedNotification($consultation));
        }

        return redirect()
            ->route('consultations.show', $consultation)
            ->with('success', 'Permintaan konsultasi berhasil diajukan dan sedang menunggu respon dokter.');
    }

    /**
     * Tampilkan detail konsultasi milik orang tua yang sedang login.
     */
    public function show(Consultation $consultation): View
    {
        abort_unless($consultation->user_id === Auth::id(), 403, 'Anda tidak memiliki hak akses untuk konsultasi ini.');

        // Tandai pesan dari dokter yang belum dibaca sebagai sudah dibaca
        $consultation->messages()
            ->where('sender_type', 'doctor')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $consultation->load([
            'child',
            'doctor',
            'messages' => fn ($q) => $q->oldest('created_at')->oldest('id'),
        ]);

        return view('consultations.show', compact('consultation'));
    }

    /**
     * Kirim pesan baru dari orang tua pada sesi konsultasi yang telah diterima dokter.
     */
    public function sendMessage(Request $request, Consultation $consultation): RedirectResponse
    {
        abort_unless($consultation->user_id === Auth::id(), 403, 'Anda tidak memiliki hak akses untuk konsultasi ini.');

        if ($consultation->status !== 'accepted') {
            return redirect()
                ->route('consultations.show', $consultation)
                ->with('error', 'Pesan hanya dapat dikirim saat sesi konsultasi telah diterima oleh dokter.');
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
                ->route('consultations.show', $consultation)
                ->with('error', 'Pesan tidak boleh hanya berisi spasi.');
        }

        $msg = DB::transaction(function () use ($consultation, $trimmedMessage) {
            return $consultation->messages()->create([
                'sender_type' => 'user',
                'message'     => $trimmedMessage,
                'is_read'     => false,
            ]);
        });

        // Notifikasi pesan baru ke Dokter
        $consultation->loadMissing('doctor.user', 'user');
        if ($doctorUser = $consultation->doctor?->user) {
            $doctorUser->notify(new NewConsultationMessageNotification($consultation, $msg));
        }

        return redirect()
            ->route('consultations.show', $consultation)
            ->with('success', 'Pesan berhasil dikirim.');
    }

    /**
     * Batalkan konsultasi yang masih berstatus pending secara aman dan atomik.
     */
    public function cancel(Request $request, Consultation $consultation)
    {
        abort_unless($consultation->user_id === Auth::id(), 403, 'Anda tidak memiliki hak akses untuk membatalkan konsultasi ini.');

        $cancelled = DB::transaction(function () use ($consultation) {
            $locked = Consultation::where('id', $consultation->id)
                ->where('user_id', Auth::id())
                ->lockForUpdate()
                ->firstOrFail();

            if ($locked->status !== 'pending') {
                return false;
            }

            $locked->update(['status' => 'cancelled']);
            return true;
        });

        if (! $cancelled) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Hanya konsultasi berstatus pending yang dapat dibatalkan.',
                ], 422);
            }

            abort(422, 'Hanya konsultasi berstatus pending yang dapat dibatalkan.');
        }

        $consultation->refresh();

        // Notifikasi pembatalan ke Dokter
        $consultation->loadMissing('doctor.user', 'child', 'user');
        if ($doctorUser = $consultation->doctor?->user) {
            $doctorUser->notify(new ConsultationCancelledNotification($consultation));
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Konsultasi berhasil dibatalkan.',
            ]);
        }

        return redirect()
            ->route('consultations.show', $consultation)
            ->with('success', 'Konsultasi berhasil dibatalkan.');
    }
}
