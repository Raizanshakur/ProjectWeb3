<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tanya AI - GrowCare</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#F8F7F2] text-[#202725] overflow-x-hidden">

<div class="min-h-screen flex">

    {{-- ================= MOBILE HEADER ================= --}}
    <header class="lg:hidden fixed top-0 left-0 right-0 z-40
                   h-16 bg-[#FBFAF6]/95 backdrop-blur-xl
                   border-b border-stone-200
                   flex items-center justify-between px-4 sm:px-5">

        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <span class="w-9 h-9 rounded-full bg-[#E0F0EB] text-[#438F83]
                         flex items-center justify-center">
                <i data-lucide="sprout" class="w-5 h-5"></i>
            </span>
            <span class="text-xl font-bold">
                <span class="text-[#438F83]">Grow</span>Care
            </span>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="w-10 h-10 rounded-full bg-[#DDF1EE] text-[#438F83]
                  flex items-center justify-center">
            <i data-lucide="user-round" class="w-5 h-5"></i>
        </a>
    </header>

    {{-- ================= SIDEBAR ================= --}}
    <x-growcare-sidebar active="ai" />


    {{-- ================= MAIN ================= --}}
    <main class="w-full min-w-0 lg:ml-[285px] min-h-screen pt-16 lg:pt-0 pb-28 lg:pb-0">

        <div class="max-w-[1450px]
                    mx-auto w-full min-w-0
                    px-4 sm:px-5 md:px-8 lg:px-10
                    py-5 sm:py-8">


            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row
                        md:items-center
                        justify-between gap-5">

                <div>

                    <p class="text-xs tracking-[0.18em]
                              text-[#4B988D] font-semibold">
                        KONSULTASI
                    </p>

                    <h1 class="text-2xl sm:text-3xl font-bold mt-2">
                        Tanya GrowCare
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Temukan informasi seputar nutrisi dan tumbuh kembang anak.
                    </p>

                </div>


                {{-- CHILD SELECTOR --}}
                @if ($children->isNotEmpty())
                    <div class="w-full sm:w-auto flex items-center gap-2 bg-white border border-stone-200 rounded-full py-1.5 pl-3 pr-2 shadow-sm">
                        <span class="w-8 h-8 rounded-full bg-[#E2F1ED] text-[#438F83] flex items-center justify-center shrink-0">
                            <i data-lucide="baby" class="w-4 h-4"></i>
                        </span>
                        <span class="text-xs text-stone-500 font-medium">Topik Anak:</span>
                        <select id="chatChildId" onchange="switchChild(this.value)" class="border-0 bg-transparent text-xs font-semibold text-stone-800 focus:ring-0 cursor-pointer pr-7 py-1">
                            <option value="" {{ ! $selectedChild ? 'selected' : '' }}>Umum (Tanpa spesifik anak)</option>
                            @foreach ($children as $child)
                                <option value="{{ $child->id }}" {{ $selectedChild?->id === $child->id ? 'selected' : '' }}>
                                    {{ $child->name }} ({{ in_array($child->gender, ['L', 'male']) ? 'L' : 'P' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

            </div>


            {{-- TABS --}}
            <div class="mt-6 sm:mt-7 w-full overflow-x-auto pb-1">
                <div class="inline-flex min-w-max
                            bg-[#ECECE7]
                            p-1.5 rounded-full">

                <button id="aiTab"
                        type="button"
                        onclick="showAITab()"
                        class="flex items-center gap-2
                               px-6 py-3 rounded-full
                               bg-white text-[#438F83]
                               shadow-sm
                               font-semibold text-sm">

                    <i data-lucide="sparkles"
                       class="w-4 h-4"></i>

                    NutriBot AI

                </button>


                <button id="doctorTab"
                        type="button"
                        onclick="showDoctorTab()"
                        class="flex items-center gap-2
                               px-6 py-3 rounded-full
                               text-gray-500
                               font-semibold text-sm">

                    <i data-lucide="stethoscope"
                       class="w-4 h-4"></i>

                    Dokter

                </button>

                </div>
            </div>


            {{-- ================= AI CONTENT ================= --}}
            <div id="aiContent" class="mt-6">

                {{-- NOTICE BANNER: TENTANG NUTRIBOT --}}
                <div class="bg-[#EEF6F3]/80 border border-[#D5E8E2] rounded-2xl p-4 sm:p-5 shadow-sm">
                    <div class="flex items-start gap-3">
                        <span class="w-9 h-9 rounded-full bg-[#D5E8E2] text-[#438F83] flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="stethoscope" class="w-5 h-5"></i>
                        </span>
                        <div class="space-y-1">
                            <h3 class="font-bold text-sm text-stone-900">
                                Tentang NutriBot
                            </h3>
                            <p class="text-xs text-stone-600 leading-relaxed">
                                NutriBot adalah asisten edukasi nutrisi dan tumbuh kembang anak, <strong>bukan pengganti tenaga medis</strong>. NutriBot tidak memberikan diagnosis klinis atau dosis obat. Bila anak menunjukkan gejala darurat atau sakit mengkhawatirkan, segera periksakan ke dokter spesialis anak.
                            </p>
                        </div>
                    </div>
                </div>


                {{-- CHAT BOX --}}
                <div class="bg-white
                            rounded-[30px]
                            border border-stone-100
                            shadow-sm
                            mt-5 overflow-hidden">


                    {{-- CHAT HEADER --}}
                    <div class="border-b border-stone-100
                                px-4 sm:px-6 md:px-8 py-4 sm:py-5
                                flex items-center justify-between">

                        <div class="flex items-center gap-4">

                            <div class="relative">

                                <div class="w-12 h-12
                                            rounded-2xl
                                            bg-gradient-to-br
                                            from-[#DDF2EC]
                                            to-[#BFE1D7]
                                            text-[#438F83]
                                            flex items-center justify-center">

                                    <i data-lucide="bot"
                                       class="w-6 h-6"></i>

                                </div>

                                <span class="absolute
                                             -right-1 -bottom-1
                                             w-4 h-4
                                             bg-emerald-500
                                             border-2 border-white
                                             rounded-full">
                                </span>

                            </div>


                            <div>

                                <h2 class="font-bold text-stone-900">
                                    NutriBot AI
                                </h2>

                                <p class="text-xs text-emerald-600 font-medium">
                                    Online • Assistant AI
                                </p>

                            </div>

                        </div>


                        <button type="button"
                                onclick="clearChat()"
                                title="Hapus Riwayat Chat"
                                class="px-3.5 py-1.5 rounded-full hover:bg-red-50 text-stone-500 hover:text-red-600 border border-stone-200 hover:border-red-200 transition text-xs font-semibold flex items-center gap-1.5">

                            <i data-lucide="trash-2"
                               class="w-3.5 h-3.5"></i>

                            <span class="hidden sm:inline">Hapus Riwayat</span>

                        </button>

                    </div>


                    {{-- CHAT MESSAGES --}}
                    <div id="chatMessages"
                         class="h-[55vh] min-h-[360px] max-h-[520px] sm:h-[430px]
                                overflow-y-auto
                                px-4 sm:px-5 md:px-8 py-5 sm:py-7 space-y-4">

                        @if ($chats->isEmpty())
                            {{-- EMPTY STATE --}}
                            <div id="emptyChat"
                                 class="h-full
                                        flex flex-col
                                        items-center justify-center
                                        text-center">

                                <div class="relative">

                                    <div class="w-24 h-24
                                                rounded-[30px]
                                                bg-[#E2F2ED]
                                                text-[#438F83]
                                                flex items-center justify-center">

                                        <i data-lucide="bot"
                                           class="w-11 h-11"></i>

                                    </div>

                                    <span class="absolute
                                                 -right-3 -top-3
                                                 w-10 h-10
                                                 rounded-full
                                                 bg-[#FFF4D9]
                                                 flex items-center justify-center shadow-sm">
                                        ✨
                                    </span>

                                </div>


                                <h2 class="text-2xl font-bold mt-6 text-stone-900">
                                    Halo! Saya NutriBot
                                </h2>


                                <p class="text-stone-500
                                          text-sm max-w-md
                                          mt-2 leading-relaxed">

                                    Saya siap memberikan informasi edukatif tentang nutrisi dan tumbuh kembang si kecil.

                                </p>


                                {{-- QUICK QUESTIONS --}}
                                <div class="flex flex-wrap
                                            justify-center
                                            gap-2 mt-6 max-w-2xl">

                                    <button type="button"
                                            onclick="quickQuestion('Berapa kebutuhan kalori anak usia 3 tahun?')"
                                            class="px-4 py-2.5
                                                   rounded-full
                                                   border border-stone-200
                                                   text-xs sm:text-sm text-stone-600
                                                   hover:bg-[#EDF6F3]
                                                   hover:text-[#438F83]
                                                   transition">

                                        Kebutuhan kalori anak?

                                    </button>


                                    <button type="button"
                                            onclick="quickQuestion('Apa contoh makanan tinggi protein untuk anak?')"
                                            class="px-4 py-2.5
                                                   rounded-full
                                                   border border-stone-200
                                                   text-xs sm:text-sm text-stone-600
                                                   hover:bg-[#EDF6F3]
                                                   hover:text-[#438F83]
                                                   transition">

                                        Makanan tinggi protein

                                    </button>


                                    <button type="button"
                                            onclick="quickQuestion('Bagaimana cara meningkatkan nafsu makan anak?')"
                                            class="px-4 py-2.5
                                                   rounded-full
                                                   border border-stone-200
                                                   text-xs sm:text-sm text-stone-600
                                                   hover:bg-[#EDF6F3]
                                                   hover:text-[#438F83]
                                                   transition">

                                        Anak susah makan

                                    </button>

                                </div>

                            </div>
                        @else
                            @foreach ($chats as $chat)
                                {{-- USER BUBBLE --}}
                                <div class="flex justify-end mb-4">
                                    <div class="max-w-[88%] sm:max-w-[75%]">
                                        <div class="bg-[#4B988D] text-white px-5 py-3.5 rounded-[20px] rounded-br-md text-sm leading-relaxed shadow-sm">
                                            {{ $chat->user_message }}
                                        </div>
                                        <p class="text-[10px] text-stone-400 text-right mt-1">
                                            {{ $chat->created_at->format('H:i') }}
                                            @if ($chat->child)
                                                • <span class="text-stone-500 font-medium">{{ $chat->child->name }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                {{-- BOT BUBBLE --}}
                                <div class="flex items-start gap-3 mb-4">
                                    <div class="w-9 h-9 rounded-xl bg-[#E2F2ED] text-[#438F83] flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <span class="text-xs font-bold">AI</span>
                                    </div>
                                    <div class="max-w-[88%] sm:max-w-[75%]">
                                        <div class="bg-[#F4F5F1] text-stone-800 px-5 py-3.5 rounded-[20px] rounded-tl-md text-sm leading-relaxed border border-stone-200/50 whitespace-pre-wrap">
                                            {{ $chat->ai_response }}
                                        </div>
                                        <p class="text-[10px] text-stone-400 mt-1">
                                            NutriBot • Estimasi Edukasi • {{ $chat->created_at->format('H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>


                    {{-- INPUT --}}
                    <div class="border-t border-stone-100
                                px-4 sm:px-5 md:px-8 py-4 sm:py-5">

                        <form id="chatForm"
                              onsubmit="sendMessage(event)"
                              class="flex items-end gap-3">
                            @csrf

                            <div class="flex-1
                                        bg-[#F7F6F2]
                                        border border-stone-200
                                        rounded-[22px]
                                        flex items-center px-4 sm:px-5 min-w-0 focus-within:border-[#4B988D] focus-within:ring-1 focus-within:ring-[#4B988D] transition">

                                <input
                                    id="messageInput"
                                    type="text"
                                    name="user_message"
                                    maxlength="1000"
                                    autocomplete="off"
                                    placeholder="Tanyakan tentang nutrisi atau tumbuh kembang anak..."
                                    class="w-full py-4
                                           border-0 bg-transparent
                                           focus:ring-0
                                           placeholder:text-stone-400 text-sm text-stone-800"
                                    required
                                >

                            </div>


                            <button type="submit"
                                    id="sendBtn"
                                    class="w-12 h-12 sm:w-14 sm:h-14 shrink-0
                                           rounded-full
                                           bg-[#4B988D]
                                           hover:bg-[#3D8379]
                                           text-white
                                           flex items-center justify-center
                                           shadow-lg
                                           shadow-emerald-900/10
                                           transition active:scale-95 disabled:opacity-50">

                                <i data-lucide="send"
                                   class="w-5 h-5"></i>

                            </button>

                        </form>


                        <p class="text-[11px]
                                  text-stone-400
                                  text-center mt-3">

                            NutriBot memberikan informasi edukasi umum. Mohon tidak memasukkan data pribadi anak.

                        </p>

                    </div>

                </div>

            </div>


            {{-- ================= DOCTOR CONTENT ================= --}}
            <div id="doctorContent"
                 class="hidden mt-6">

                <div class="bg-white
                            rounded-[30px]
                            border border-stone-100
                            shadow-sm p-5 sm:p-8">

                    <div class="text-center
                                max-w-lg mx-auto">

                        <div class="w-20 h-20
                                    mx-auto rounded-[25px]
                                    bg-[#E2F2ED]
                                    text-[#438F83]
                                    flex items-center justify-center">

                            <i data-lucide="stethoscope"
                               class="w-9 h-9"></i>

                        </div>


                        <h2 class="text-2xl font-bold mt-5">
                            Konsultasi Dokter
                        </h2>


                        <p class="text-gray-500
                                  text-sm leading-6 mt-2">

                            Pilih dokter untuk berkonsultasi
                            mengenai tumbuh kembang dan nutrisi anak.

                        </p>

                    </div>


                    {{-- LIST DOKTER ATAU EMPTY STATE --}}
                    @if(isset($availableDoctors) && $availableDoctors->count() > 0)
                        <div class="max-w-2xl mx-auto mt-8 space-y-4">
                            @foreach($availableDoctors as $doc)
                                <div class="border border-stone-200/80 rounded-3xl p-5
                                            flex flex-col sm:flex-row sm:items-center gap-5
                                            hover:border-[#4B988D]/40 transition bg-[#FCFBF8]">

                                    <div class="w-16 h-16 rounded-2xl bg-[#E7F2EF] text-[#438F83]
                                                flex items-center justify-center shrink-0">
                                        <i data-lucide="stethoscope" class="w-7 h-7"></i>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-base sm:text-lg text-[#202725] truncate">
                                            {{ $doc->name }}
                                        </h3>

                                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                                            {{ $doc->specialization ?? 'Dokter Spesialis Anak' }}
                                        </p>

                                        @if($doc->practice_days)
                                            <p class="text-xs text-gray-400 mt-1 flex items-center gap-1.5">
                                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                                {{ $doc->practice_days }} ({{ \Illuminate\Support\Str::substr($doc->start_time ?? '08:00', 0, 5) }} - {{ \Illuminate\Support\Str::substr($doc->end_time ?? '16:00', 0, 5) }})
                                            </p>
                                        @endif

                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                            <span class="text-xs font-medium text-emerald-700">Tersedia untuk Konsultasi</span>
                                        </div>
                                    </div>

                                    <a href="{{ route('consultations.create', array_filter(['doctor_id' => $doc->id, 'child_id' => $selectedChild?->id])) }}"
                                       class="w-full sm:w-auto px-5 py-3 rounded-full bg-[#4B988D] text-white
                                              text-sm font-semibold hover:bg-[#3D8379] transition
                                              flex items-center justify-center gap-2 shrink-0">
                                        <span>Ajukan Konsultasi</span>
                                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="max-w-lg mx-auto mt-8 p-6 rounded-3xl bg-stone-50 border border-stone-200 text-center">
                            <div class="w-12 h-12 mx-auto rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                                <i data-lucide="user-x" class="w-6 h-6"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 text-base mb-1">
                                Belum Ada Dokter Tersedia
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-500 leading-relaxed mb-4">
                                Saat ini belum ada dokter spesialis anak yang tersedia untuk konsultasi online.
                            </p>
                            <div class="p-3 bg-amber-50/70 border border-amber-200/60 rounded-xl text-left text-xs text-amber-800 mb-4">
                                <strong class="block font-semibold mb-1">💡 Petunjuk Lingkungan Lokal:</strong>
                                Jalankan <code class="px-1.5 py-0.5 bg-white rounded font-mono text-[11px] border border-amber-300">php artisan db:seed</code> untuk mengisi akun dokter default (Dr. Anisa Rahma, Sp.A).
                            </div>
                        </div>
                    @endif

                    <div class="text-center mt-6">
                        <a href="{{ route('consultations.index') }}"
                           class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-[#438F83] hover:underline">
                            <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                            <span>Lihat Riwayat & Daftar Konsultasi Saya</span>
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </main>

</div>


{{-- ================= MOBILE BOTTOM NAVIGATION ================= --}}
<nav class="lg:hidden fixed bottom-3 left-3 right-3 z-40
            rounded-[26px]
            bg-white/95 backdrop-blur-xl
            border border-white/80
            shadow-[0_14px_40px_rgba(46,88,80,0.18)]
            px-2 pt-2.5
            pb-[max(0.65rem,env(safe-area-inset-bottom))]">

    <div class="max-w-md mx-auto grid grid-cols-6 items-end">

        <a href="{{ route('dashboard') }}"
           class="group flex flex-col items-center justify-center gap-1.5 min-w-0
                  text-gray-400 hover:text-[#438F83] transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition group-hover:-translate-y-0.5">
                <i data-lucide="house" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">Beranda</span>
        </a>

        <a href="{{ route('nutrition') }}"
           class="group flex flex-col items-center justify-center gap-1.5 min-w-0
                  text-gray-400 hover:text-[#438F83] transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition group-hover:-translate-y-0.5">
                <i data-lucide="clipboard-list" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">Nutrisi</span>
        </a>

        <a href="{{ route('food.scan') }}"
           class="group flex flex-col items-center justify-center gap-1.5 min-w-0
                  text-gray-400 hover:text-[#438F83] transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition group-hover:-translate-y-0.5">
                <i data-lucide="scan-line" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">Scan</span>
        </a>

        {{-- TANYA AI ACTIVE --}}
        <a href="{{ route('ai.chat') }}"
           class="group relative flex flex-col items-center justify-center gap-1.5 min-w-0
                  text-[#438F83] transition duration-200 active:scale-90">

            <span class="absolute -top-2 w-7 h-1 rounded-full bg-[#4B988D]
                         shadow-[0_2px_10px_rgba(75,152,141,0.45)]"></span>

            <span class="relative -mt-1 w-11 h-11 rounded-2xl
                         bg-gradient-to-br from-[#DDF1ED] to-[#CFE8E3]
                         ring-1 ring-[#BFDCD6]
                         shadow-[0_8px_18px_rgba(75,152,141,0.20)]
                         flex items-center justify-center">
                <i data-lucide="message-circle" class="w-5 h-5"></i>
                <span class="absolute -right-0.5 -top-0.5 w-2.5 h-2.5 rounded-full
                             bg-[#4B988D] border-2 border-white"></span>
            </span>

            <span class="text-[9px] sm:text-[10px] font-bold truncate w-full text-center">Tanya AI</span>
        </a>

        <a href="{{ route('children.index') }}"
           class="group flex flex-col items-center justify-center gap-1.5 min-w-0
                  text-gray-400 hover:text-[#438F83] transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition group-hover:-translate-y-0.5">
                <i data-lucide="baby" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">Anak</span>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="group flex flex-col items-center justify-center gap-1.5 min-w-0
                  text-gray-400 hover:text-[#438F83] transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition group-hover:-translate-y-0.5">
                <i data-lucide="user-round" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">Profil</span>
        </a>

    </div>
</nav>

<script>

    lucide.createIcons();


    function showAITab() {

        document.getElementById('aiContent')
            .classList.remove('hidden');

        document.getElementById('doctorContent')
            .classList.add('hidden');


        document.getElementById('aiTab').className =
            'flex items-center gap-2 px-6 py-3 rounded-full bg-white text-[#438F83] shadow-sm font-semibold text-sm';

        document.getElementById('doctorTab').className =
            'flex items-center gap-2 px-6 py-3 rounded-full text-gray-500 font-semibold text-sm';

        lucide.createIcons();

    }


    function showDoctorTab() {

        document.getElementById('doctorContent')
            .classList.remove('hidden');

        document.getElementById('aiContent')
            .classList.add('hidden');


        document.getElementById('doctorTab').className =
            'flex items-center gap-2 px-6 py-3 rounded-full bg-white text-[#438F83] shadow-sm font-semibold text-sm';

        document.getElementById('aiTab').className =
            'flex items-center gap-2 px-6 py-3 rounded-full text-gray-500 font-semibold text-sm';

        lucide.createIcons();

    }


    // Auto-scroll chat to bottom on page load
    const chatContainer = document.getElementById('chatMessages');
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function switchChild(childId) {
        const url = new URL(window.location.origin + window.location.pathname);
        if (childId) {
            url.searchParams.set('child_id', childId);
        }
        window.location.href = url.toString();
    }

    function quickQuestion(question) {
        const input = document.getElementById('messageInput');
        input.value = question;
        sendMessage(new Event('submit'));
    }

    async function sendMessage(event) {
        event.preventDefault();

        const input = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');
        const message = input.value.trim();

        if (!message) {
            return;
        }

        const childSelect = document.getElementById('chatChildId');
        const childId = (childSelect && childSelect.value) ? childSelect.value : null;

        const chat = document.getElementById('chatMessages');
        const empty = document.getElementById('emptyChat');
        if (empty) {
            empty.remove();
        }

        // Render User Message
        const now = new Date();
        const timeStr = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');

        const userDiv = document.createElement('div');
        userDiv.className = 'flex justify-end mb-4';
        userDiv.innerHTML = `
            <div class="max-w-[88%] sm:max-w-[75%]">
                <div class="bg-[#4B988D] text-white px-5 py-3.5 rounded-[20px] rounded-br-md text-sm leading-relaxed shadow-sm">
                    ${escapeHtml(message)}
                </div>
                <p class="text-[10px] text-stone-400 text-right mt-1">
                    ${timeStr}
                </p>
            </div>
        `;
        chat.appendChild(userDiv);
        input.value = '';
        input.disabled = true;
        if (sendBtn) sendBtn.disabled = true;
        chat.scrollTop = chat.scrollHeight;

        // Render Typing Indicator
        const typing = document.createElement('div');
        typing.id = 'typingMessage';
        typing.className = 'flex items-start gap-3 mb-4';
        typing.innerHTML = `
            <div class="w-9 h-9 rounded-xl bg-[#E2F2ED] text-[#438F83] flex items-center justify-center flex-shrink-0 mt-0.5">
                <span class="text-xs font-bold">AI</span>
            </div>
            <div class="bg-[#F4F5F1] rounded-[20px] rounded-tl-md px-5 py-4 border border-stone-200/50">
                <div class="flex gap-1.5">
                    <span class="w-2 h-2 bg-stone-400 rounded-full animate-bounce"></span>
                    <span class="w-2 h-2 bg-stone-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                    <span class="w-2 h-2 bg-stone-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                </div>
            </div>
        `;
        chat.appendChild(typing);
        chat.scrollTop = chat.scrollHeight;

        try {
            const response = await fetch("{{ route('ai.chat.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    user_message: message,
                    child_id: childId ? parseInt(childId) : null,
                }),
            });

            const data = await response.json();
            typing.remove();

            if (response.ok && data.success) {
                const botDiv = document.createElement('div');
                botDiv.className = 'flex items-start gap-3 mb-4';
                botDiv.innerHTML = `
                    <div class="w-9 h-9 rounded-xl bg-[#E2F2ED] text-[#438F83] flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold">AI</span>
                    </div>
                    <div class="max-w-[88%] sm:max-w-[75%]">
                        <div class="bg-[#F4F5F1] text-stone-800 px-5 py-3.5 rounded-[20px] rounded-tl-md text-sm leading-relaxed border border-stone-200/50 whitespace-pre-wrap">
                            ${escapeHtml(data.chat.ai_response)}
                        </div>
                        <p class="text-[10px] text-stone-400 mt-1">
                            NutriBot • Estimasi Edukasi • ${data.chat.created_at || timeStr}
                        </p>
                    </div>
                `;
                chat.appendChild(botDiv);
            } else {
                const errDiv = document.createElement('div');
                errDiv.className = 'flex items-start gap-3 mb-4';
                errDiv.innerHTML = `
                    <div class="w-9 h-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    </div>
                    <div class="max-w-[88%] sm:max-w-[75%]">
                        <div class="bg-red-50 text-red-800 px-5 py-3.5 rounded-[20px] rounded-tl-md text-sm leading-relaxed border border-red-200">
                            <strong>Gagal memproses pertanyaan:</strong> ${escapeHtml(data.message || 'Terjadi kesalahan sistem saat menghubungi AI.')}
                        </div>
                    </div>
                `;
                chat.appendChild(errDiv);
                lucide.createIcons();
            }
        } catch (err) {
            typing.remove();
            const errDiv = document.createElement('div');
            errDiv.className = 'flex items-start gap-3 mb-4';
            errDiv.innerHTML = `
                <div class="w-9 h-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                </div>
                <div class="max-w-[88%] sm:max-w-[75%]">
                    <div class="bg-red-50 text-red-800 px-5 py-3.5 rounded-[20px] rounded-tl-md text-sm leading-relaxed border border-red-200">
                        <strong>Koneksi terputus:</strong> Tidak dapat menghubungi server. Silakan periksa jaringan Anda.
                    </div>
                </div>
            `;
            chat.appendChild(errDiv);
            lucide.createIcons();
        } finally {
            input.disabled = false;
            if (sendBtn) sendBtn.disabled = false;
            input.focus();
            chat.scrollTop = chat.scrollHeight;
        }
    }

    async function clearChat() {
        if (!confirm('Apakah Anda yakin ingin menghapus seluruh riwayat percakapan dengan NutriBot? Tindakan ini tidak dapat dibatalkan.')) {
            return;
        }

        const childSelect = document.getElementById('chatChildId');
        const childId = (childSelect && childSelect.value) ? childSelect.value : null;

        try {
            const response = await fetch("{{ route('ai.chat.clear') }}", {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    child_id: childId ? parseInt(childId) : null,
                }),
            });

            if (response.ok) {
                location.reload();
            } else {
                alert('Gagal menghapus riwayat chat.');
            }
        } catch (e) {
            alert('Terjadi kesalahan jaringan saat menghapus riwayat.');
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>

</body>
</html>