<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konsultasi #{{ $consultation->id }} - GrowCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#F8F7F2] text-[#202725] overflow-x-hidden min-h-screen">
<div class="min-h-screen flex">

    {{-- ================= MOBILE HEADER ================= --}}
    <header class="lg:hidden fixed top-0 left-0 right-0 z-40 h-16
                   bg-[#FBFAF6]/95 backdrop-blur-xl border-b border-stone-200
                   flex items-center justify-between px-4 sm:px-5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <span class="w-9 h-9 rounded-full bg-[#E0F0EB] text-[#438F83]
                         flex items-center justify-center">
                <i data-lucide="sprout" class="w-5 h-5"></i>
            </span>
            <span class="text-xl font-bold"><span class="text-[#438F83]">Grow</span>Care</span>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="w-10 h-10 rounded-full bg-[#DDF1EE] text-[#438F83]
                  flex items-center justify-center">
            <i data-lucide="user-round" class="w-5 h-5"></i>
        </a>
    </header>

    {{-- ================= SIDEBAR ================= --}}
    <x-growcare-sidebar active="consultations" />

    {{-- ================= MAIN ================= --}}
    <main class="w-full min-w-0 lg:ml-[285px] pt-20 lg:pt-8 pb-28 lg:pb-12 px-4 sm:px-6 md:px-10">
        <div class="max-w-[850px] mx-auto w-full">

            {{-- BREADCRUMB / BACK --}}
            <a href="{{ route('consultations.index') }}"
               class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-[#438F83] transition mb-4">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali ke Daftar Konsultasi</span>
            </a>

            {{-- ALERTS --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 shrink-0"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            {{-- STATUS BANNER --}}
            @if($consultation->status === 'pending')
                <div class="mb-6 p-5 sm:p-6 rounded-3xl bg-amber-50/80 border border-amber-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <span class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </span>
                        <div>
                            <h2 class="font-bold text-amber-900 text-base">
                                Menunggu Respon Dokter
                            </h2>
                            <p class="text-xs sm:text-sm text-amber-800/90 mt-0.5 leading-relaxed">
                                Permintaan konsultasi telah dikirim ke dokter terpilih. Anda dapat membatalkan pengajuan ini selama dokter belum menerima sesi.
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('consultations.cancel', $consultation) }}"
                          onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan konsultasi ini?');"
                          class="shrink-0">
                        @csrf
                        <button type="submit"
                                class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-white border border-amber-300 hover:bg-amber-100/60 text-amber-800 font-semibold text-xs transition shadow-sm">
                            Batalkan Permintaan
                        </button>
                    </form>
                </div>
            @elseif($consultation->status === 'accepted')
                <div class="mb-6 p-5 sm:p-6 rounded-3xl bg-blue-50/80 border border-blue-200 flex items-start gap-3.5">
                    <span class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 mt-0.5">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                    </span>
                    <div>
                        <h2 class="font-bold text-blue-900 text-base">
                            Konsultasi Diterima Dokter
                        </h2>
                        <p class="text-xs sm:text-sm text-blue-800/90 mt-0.5 leading-relaxed">
                            Dokter telah menerima permintaan konsultasi Anda. Sesi komunikasi aktif.
                        </p>
                    </div>
                </div>
            @elseif($consultation->status === 'completed')
                <div class="mb-6 p-5 sm:p-6 rounded-3xl bg-emerald-50/80 border border-emerald-200 flex items-start gap-3.5">
                    <span class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                        <i data-lucide="award" class="w-5 h-5"></i>
                    </span>
                    <div>
                        <h2 class="font-bold text-emerald-900 text-base">
                            Konsultasi Selesai
                        </h2>
                        <p class="text-xs sm:text-sm text-emerald-800/90 mt-0.5 leading-relaxed">
                            Sesi konsultasi telah diselesaikan oleh dokter spesialis anak.
                        </p>
                    </div>
                </div>
            @elseif($consultation->status === 'cancelled')
                <div class="mb-6 p-5 sm:p-6 rounded-3xl bg-stone-100 border border-stone-200 flex items-start gap-3.5">
                    <span class="w-10 h-10 rounded-2xl bg-stone-200 text-stone-600 flex items-center justify-center shrink-0 mt-0.5">
                        <i data-lucide="x-circle" class="w-5 h-5"></i>
                    </span>
                    <div>
                        <h2 class="font-bold text-stone-800 text-base">
                            Konsultasi Dibatalkan
                        </h2>
                        <p class="text-xs sm:text-sm text-stone-600 mt-0.5 leading-relaxed">
                            Permintaan konsultasi ini telah dibatalkan oleh orang tua.
                        </p>
                    </div>
                </div>
            @endif

            {{-- MAIN DETAILS CARD --}}
            <div class="bg-white rounded-3xl border border-stone-100 shadow-sm p-6 sm:p-8 space-y-6">

                {{-- INFO HEADER --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-stone-100 gap-4">
                    <div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">ID KONSULTASI</span>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mt-0.5">
                            Konsultasi #{{ $consultation->id }}
                        </h1>
                        <p class="text-xs text-gray-400 mt-1">
                            Diajukan pada {{ $consultation->created_at->format('d F Y, H:i') }}
                        </p>
                    </div>

                    <div>
                        @if($consultation->status === 'pending')
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                Pending
                            </span>
                        @elseif($consultation->status === 'accepted')
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                Diterima
                            </span>
                        @elseif($consultation->status === 'completed')
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Selesai
                            </span>
                        @elseif($consultation->status === 'cancelled')
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-stone-100 text-stone-600 border border-stone-200">
                                Dibatalkan
                            </span>
                        @endif
                    </div>
                </div>

                {{-- PARTICIPANTS GRID --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- PASIEN ANAK --}}
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100 flex items-start gap-3.5">
                        <span class="w-12 h-12 rounded-2xl bg-[#E8F4F0] text-[#438F83] flex items-center justify-center shrink-0">
                            <i data-lucide="baby" class="w-6 h-6"></i>
                        </span>
                        <div class="min-w-0">
                            <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Pasien Anak</span>
                            <h3 class="font-bold text-gray-800 text-base truncate">
                                {{ $consultation->child->name ?? 'Anak' }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $consultation->child->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                @if($consultation->child->birth_date)
                                    • {{ \Carbon\Carbon::parse($consultation->child->birth_date)->age }} tahun
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- DOKTER --}}
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-100 flex items-start gap-3.5">
                        <span class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <i data-lucide="stethoscope" class="w-6 h-6"></i>
                        </span>
                        <div class="min-w-0">
                            <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Dokter Terpilih</span>
                            <h3 class="font-bold text-gray-800 text-base truncate">
                                {{ $consultation->doctor->name ?? 'dr. Spesialis' }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $consultation->doctor->specialization ?? 'Dokter Spesialis Anak' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- JADWAL TENTATIF JIKA ADA --}}
                @if($consultation->consultation_date)
                    <div class="p-4 rounded-2xl bg-[#FAF9F5] border border-stone-100 flex items-center gap-3">
                        <i data-lucide="calendar" class="w-5 h-5 text-gray-500"></i>
                        <div class="text-xs text-gray-600">
                            <strong>Rencana Waktu:</strong> {{ $consultation->consultation_date->format('d F Y, H:i') }}
                        </div>
                    </div>
                @endif

                {{-- KELUHAN ORANG TUA --}}
                <div>
                    <h3 class="font-bold text-sm text-gray-800 mb-2">
                        Keluhan & Pertanyaan Medis:
                    </h3>
                    <div class="p-5 rounded-2xl bg-stone-50 border border-stone-100 text-sm text-gray-800 leading-relaxed whitespace-pre-line">
                        {{ $consultation->complaint }}
                    </div>
                </div>

                {{-- CATATAN DOKTER --}}
                @if($consultation->doctor_notes)
                    <div class="pt-2">
                        <h3 class="font-bold text-sm text-emerald-800 mb-2 flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4 text-emerald-600"></i>
                            <span>Catatan & Rekomendasi Dokter:</span>
                        </h3>
                        <div class="p-5 rounded-2xl bg-emerald-50/60 border border-emerald-200/80 text-sm text-gray-800 leading-relaxed whitespace-pre-line">
                            {{ $consultation->doctor_notes }}
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </main>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
