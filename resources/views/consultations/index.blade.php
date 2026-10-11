<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi Dokter - GrowCare</title>
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
        <div class="max-w-[1100px] mx-auto w-full">

            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <span class="text-xs uppercase tracking-wider font-semibold text-[#4B988D]">
                        Layanan Kesehatan
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-bold mt-1 text-[#202725]">
                        Konsultasi Dokter
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Daftar dan pantau status konsultasi kesehatan anak Anda bersama dokter spesialis.
                    </p>
                </div>

                <div>
                    <a href="{{ route('consultations.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl
                              bg-[#4B988D] hover:bg-[#3E8379] text-white font-semibold text-sm
                              shadow-sm shadow-[#4B988D]/20 transition">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Ajukan Konsultasi</span>
                    </a>
                </div>
            </div>

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

            {{-- CONTENT --}}
            @if($consultations->isEmpty())
                {{-- EMPTY STATE --}}
                <div class="bg-white rounded-3xl border border-stone-100 shadow-sm p-8 sm:p-12 text-center max-w-xl mx-auto my-6">
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-[#E8F4F0] text-[#438F83] flex items-center justify-center mb-4">
                        <i data-lucide="clipboard-list" class="w-8 h-8"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">
                        Belum Ada Konsultasi
                    </h2>
                    <p class="text-sm text-gray-500 leading-relaxed mb-6">
                        Anda belum memiliki riwayat atau pengajuan konsultasi dokter. Pilih dokter spesialis anak dan ajukan keluhan tumbuh kembang si kecil.
                    </p>
                    <a href="{{ route('consultations.create') }}"
                       class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-[#4B988D] hover:bg-[#3E8379] text-white font-semibold text-sm transition">
                        <i data-lucide="stethoscope" class="w-4 h-4"></i>
                        <span>Ajukan Konsultasi Sekarang</span>
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($consultations as $consultation)
                        <div class="bg-white rounded-3xl border border-stone-100 p-5 sm:p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2.5 mb-2">
                                        {{-- STATUS BADGE --}}
                                        @if($consultation->status === 'pending')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                                Menunggu Respon Dokter
                                            </span>
                                        @elseif($consultation->status === 'accepted')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                                Konsultasi Diterima
                                            </span>
                                        @elseif($consultation->status === 'completed')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                Selesai
                                            </span>
                                        @elseif($consultation->status === 'cancelled')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-stone-100 text-stone-600 border border-stone-200 flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-stone-400"></span>
                                                Dibatalkan
                                            </span>
                                        @endif

                                        <span class="text-xs text-gray-400">
                                            Diajukan: {{ $consultation->created_at->format('d M Y, H:i') }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="w-8 h-8 rounded-xl bg-[#E8F4F0] text-[#438F83] flex items-center justify-center shrink-0">
                                                <i data-lucide="baby" class="w-4 h-4"></i>
                                            </span>
                                            <div class="min-w-0">
                                                <p class="text-xs text-gray-400">Pasien Anak</p>
                                                <p class="text-sm font-bold text-gray-800 truncate">
                                                    {{ $consultation->child->name ?? 'Anak' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                                <i data-lucide="stethoscope" class="w-4 h-4"></i>
                                            </span>
                                            <div class="min-w-0">
                                                <p class="text-xs text-gray-400">Dokter Spesialis</p>
                                                <p class="text-sm font-bold text-gray-800 truncate">
                                                    {{ $consultation->doctor->name ?? 'dr. Spesialis Anak' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-stone-50 rounded-2xl p-3.5 border border-stone-100">
                                        <p class="text-xs font-semibold text-gray-500 mb-1">Keluhan:</p>
                                        <p class="text-xs sm:text-sm text-gray-700 leading-relaxed line-clamp-2">
                                            {{ $consultation->complaint }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-row lg:flex-col items-center justify-end gap-2.5 shrink-0 pt-2 lg:pt-0 border-t lg:border-t-0 border-stone-100">
                                    <a href="{{ route('consultations.show', $consultation) }}"
                                       class="px-4 py-2.5 rounded-xl bg-[#EDF5F2] hover:bg-[#DCEFEB] text-[#438F83] font-semibold text-xs transition flex items-center gap-1.5">
                                        <span>Lihat Detail</span>
                                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </a>

                                    @if($consultation->isPending())
                                        <form method="POST"
                                              action="{{ route('consultations.cancel', $consultation) }}"
                                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan konsultasi ini?');">
                                            @csrf
                                            <button type="submit"
                                                    class="px-4 py-2.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-xs transition">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- PAGINATION --}}
                    <div class="mt-6">
                        {{ $consultations->links() }}
                    </div>
                </div>
            @endif

        </div>
    </main>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
