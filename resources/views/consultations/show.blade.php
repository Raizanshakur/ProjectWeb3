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
    <main class="w-full min-w-0 lg:ml-[285px] pt-20 lg:pt-8 pb-28 lg:pb-12 px-4 sm:px-6 md:px-8 lg:px-10">
        <div class="w-full">

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

            {{-- CHAT CONVERSATION CARD (TASK 4.4) --}}
            <div class="mt-6 bg-white rounded-3xl border border-stone-100 shadow-sm p-6 sm:p-8 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-stone-100 gap-3">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-[#E0F0EB] text-[#438F83] flex items-center justify-center shrink-0">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                        </span>
                        <div>
                            <h2 class="font-bold text-gray-800 text-lg">
                                Ruang Percakapan Konsultasi
                            </h2>
                            <p class="text-xs text-gray-400">
                                Komunikasi langsung dengan {{ $consultation->doctor->name ?? 'Dokter Spesialis Anak' }}
                            </p>
                        </div>
                    </div>

                    <div>
                        @if($consultation->status === 'accepted')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>Sesi Aktif</span>
                            </span>
                        @elseif($consultation->status === 'pending')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                Menunggu Respon Dokter
                            </span>
                        @elseif($consultation->status === 'completed')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-stone-100 text-stone-600 border border-stone-200">
                                Sesi Ditutup
                            </span>
                        @elseif($consultation->status === 'cancelled')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                Dibatalkan
                            </span>
                        @endif
                    </div>
                </div>

                {{-- MESSAGES STREAM --}}
                <div id="parentChatMessages" class="max-h-[460px] overflow-y-auto p-4 sm:p-5 rounded-2xl bg-stone-50 border border-stone-100 space-y-4">
                    @php
                        $lastDate = null;
                    @endphp
                    @forelse($consultation->messages as $msg)
                        @php
                            $msgDateTime = \Carbon\Carbon::parse($msg->created_at)->timezone('Asia/Jakarta');
                            $currentDate = $msgDateTime->toDateString();
                        @endphp

                        @if($lastDate !== $currentDate)
                            @php
                                $lastDate = $currentDate;
                            @endphp
                            <div class="flex justify-center my-2 sm:my-3">
                                <span class="inline-flex items-center px-4 py-1 rounded-full text-[11px] font-bold bg-[#E0F0EB] text-[#2D635B] border border-[#C6E7D0] shadow-2xs">
                                    {{ $msgDateTime->locale('id')->translatedFormat('l, d F Y') }}
                                </span>
                            </div>
                        @endif

                        @if($msg->sender_type === 'user' || $msg->sender_type === 'parent')
                            {{-- Parent message (Right aligned, sage green) --}}
                            <div class="flex flex-col items-end">
                                <div class="flex items-end gap-2 max-w-[85%] sm:max-w-[75%]">
                                    <div class="bg-[#438F83] text-white px-4 sm:px-5 py-3 rounded-2xl rounded-br-none shadow-xs text-xs sm:text-sm leading-relaxed break-words whitespace-pre-line">
                                        {{ $msg->message }}
                                    </div>
                                </div>
                                <span class="text-[11px] text-gray-400 mt-1 mr-1 flex items-center gap-1">
                                    {{ $msgDateTime->format('H.i') }} WIB
                                    @if($msg->is_read)
                                        <span class="text-[10px] text-[#438F83] font-semibold">✓ Dibaca dokter</span>
                                    @endif
                                </span>
                            </div>
                        @else
                            {{-- Doctor message (Left aligned, white card) --}}
                            <div class="flex flex-col items-start">
                                <div class="flex items-end gap-2 max-w-[85%] sm:max-w-[75%]">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mb-1">
                                        <i data-lucide="stethoscope" class="w-4 h-4"></i>
                                    </div>
                                    <div class="bg-white border border-stone-200 text-gray-800 px-4 sm:px-5 py-3 rounded-2xl rounded-bl-none shadow-xs text-xs sm:text-sm leading-relaxed break-words whitespace-pre-line">
                                        {{ $msg->message }}
                                    </div>
                                </div>
                                <span class="text-[11px] text-gray-400 mt-1 ml-10 flex items-center gap-1.5">
                                    <span class="font-medium text-gray-600">{{ $consultation->doctor->name ?? 'Dokter' }}</span> • {{ $msgDateTime->format('H.i') }} WIB
                                </span>
                            </div>
                        @endif
                    @empty
                        <div class="py-12 text-center">
                            <div class="w-12 h-12 rounded-full bg-[#E0F0EB] text-[#438F83] flex items-center justify-center mx-auto mb-3">
                                <i data-lucide="message-square" class="w-6 h-6"></i>
                            </div>
                            <p class="text-sm font-semibold text-gray-700">Belum ada percakapan pada konsultasi ini.</p>
                            <p class="text-xs text-gray-500 mt-1">Pesan dari Anda dan dokter akan ditampilkan di sini.</p>
                        </div>
                    @endforelse
                </div>

                {{-- INPUT FORM --}}
                <div>
                    @if($consultation->status === 'accepted')
                        <form action="{{ route('consultations.messages.store', $consultation) }}" method="POST" class="flex items-center gap-2 sm:gap-3">
                            @csrf
                            <button type="button"
                                    disabled
                                    aria-label="Lampiran"
                                    title="Lampiran belum tersedia"
                                    class="p-2.5 sm:p-3 text-gray-400 bg-stone-100 rounded-xl sm:rounded-2xl border border-stone-200 shrink-0 opacity-60 cursor-not-allowed">
                                <i data-lucide="paperclip" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                            </button>
                            <input 
                                type="text" 
                                name="message"
                                id="parentMessageInput"
                                required
                                maxlength="5000"
                                value="{{ old('message') }}"
                                placeholder="Ketik pesan atau pertanyaan untuk dokter..." 
                                class="flex-1 bg-stone-50 border border-stone-200 rounded-xl sm:rounded-2xl px-4 py-3 text-xs sm:text-sm focus:ring-2 focus:ring-[#438F83]/20 focus:border-[#438F83] focus:bg-white transition-all text-gray-800 placeholder-gray-400 outline-none"
                                autocomplete="off"
                            >
                            <button 
                                type="submit" 
                                aria-label="Kirim Pesan"
                                class="p-2.5 sm:p-3 bg-[#438F83] hover:bg-[#38786e] text-white rounded-xl sm:rounded-2xl transition-all shadow-xs hover:shadow-sm flex items-center justify-center shrink-0 cursor-pointer"
                            >
                                <i data-lucide="send" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                            </button>
                        </form>
                    @else
                        <div class="flex items-center gap-2 sm:gap-3">
                            <button type="button"
                                    disabled
                                    aria-label="Lampiran"
                                    class="p-2.5 sm:p-3 text-gray-400 bg-stone-100 rounded-xl sm:rounded-2xl border border-stone-200 shrink-0 opacity-60 cursor-not-allowed">
                                <i data-lucide="paperclip" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                            </button>
                            <input 
                                type="text" 
                                placeholder="{{ $consultation->status === 'pending' ? 'Obrolan akan aktif setelah dokter menerima permintaan konsultasi.' : ($consultation->status === 'completed' ? 'Sesi konsultasi telah selesai. Obrolan ditutup.' : 'Konsultasi telah dibatalkan. Obrolan dinonaktifkan.') }}" 
                                class="flex-1 bg-stone-100 border border-stone-200 rounded-xl sm:rounded-2xl px-4 py-3 text-xs sm:text-sm text-gray-400 placeholder-gray-400 outline-none cursor-not-allowed"
                                disabled
                            >
                            <button 
                                type="button" 
                                disabled
                                aria-label="Kirim Pesan"
                                class="p-2.5 sm:p-3 bg-stone-300 text-white rounded-xl sm:rounded-2xl opacity-60 cursor-not-allowed flex items-center justify-center shrink-0"
                            >
                                <i data-lucide="send" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>
</div>

<script>
    lucide.createIcons();

    const parentChatMessages = document.getElementById('parentChatMessages');
    if (parentChatMessages) {
        parentChatMessages.scrollTop = parentChatMessages.scrollHeight;
    }
</script>
</body>
</html>
