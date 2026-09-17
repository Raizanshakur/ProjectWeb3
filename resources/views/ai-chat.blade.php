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
    <aside class="hidden lg:flex fixed left-0 top-0 h-screen
                  w-[285px] bg-[#FBFAF6]
                  border-r border-stone-200
                  flex-col z-40">

        {{-- LOGO --}}
        <div class="h-28 flex items-center px-9">

            <a href="{{ route('dashboard') }}"
               class="flex items-center">

                <div class="w-10 h-10 rounded-full
                            bg-[#E0F0EB] text-[#438F83]
                            flex items-center justify-center">

                    <i data-lucide="sprout"
                       class="w-5 h-5"></i>

                </div>

                <div class="ml-3 text-2xl font-bold">
                    <span class="text-[#438F83]">Grow</span>Care
                </div>

            </a>

        </div>


        {{-- MENU --}}
        <div class="px-5">

            <p class="px-4 mb-4 text-xs
                      tracking-[0.2em]
                      text-gray-400 font-semibold">
                MENU
            </p>


            <nav class="space-y-2">

                {{-- BERANDA --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-4
                          px-4 py-4 rounded-2xl
                          text-gray-600
                          hover:bg-white transition">

                    <span class="w-10 h-10 rounded-full
                                 bg-white
                                 flex items-center justify-center">

                        <i data-lucide="house"
                           class="w-5 h-5"></i>

                    </span>

                    Beranda

                </a>


                {{-- NUTRISI --}}
                <a href="{{ route('nutrition') }}"
                   class="flex items-center gap-4
                          px-4 py-4 rounded-2xl
                          text-gray-600
                          hover:bg-white transition">

                    <span class="w-10 h-10 rounded-full
                                 bg-white
                                 flex items-center justify-center">

                        <i data-lucide="clipboard-list"
                           class="w-5 h-5"></i>

                    </span>

                    Nutrisi

                </a>


                {{-- AI FOOD SCAN --}}
                <a href="{{ route('food.scan') }}"
                   class="flex items-center gap-4
                          px-4 py-4 rounded-2xl
                          text-gray-600
                          hover:bg-white transition">

                    <span class="w-10 h-10 rounded-full
                                 bg-white
                                 flex items-center justify-center">

                        <i data-lucide="scan-line"
                           class="w-5 h-5"></i>

                    </span>

                    AI Food Scan

                </a>


                {{-- TANYA AI ACTIVE --}}
                <a href="{{ route('ai.chat') }}"
                   class="relative flex items-center gap-4
                          px-4 py-4 rounded-2xl
                          bg-[#DCEFEB]
                          text-[#438F83] font-semibold">

                    <span class="absolute left-0
                                 w-1 h-9
                                 bg-[#4DA397]
                                 rounded-r-full">
                    </span>

                    <span class="w-10 h-10 rounded-full
                                 bg-[#4B988D]
                                 text-white
                                 flex items-center justify-center">

                        <i data-lucide="message-circle"
                           class="w-5 h-5"></i>

                    </span>

                    Tanya AI

                </a>


                {{-- DATA ANAK --}}
                <a href="{{ route('children.index') }}"
                   class="flex items-center gap-4
                          px-4 py-4 rounded-2xl
                          text-gray-600
                          hover:bg-white transition">

                    <span class="w-10 h-10 rounded-full
                                 bg-white
                                 flex items-center justify-center">

                        <i data-lucide="baby"
                           class="w-5 h-5"></i>

                    </span>

                    Data Anak

                </a>


                {{-- PROFIL --}}
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-4
                          px-4 py-4 rounded-2xl
                          text-gray-600
                          hover:bg-white transition">

                    <span class="w-10 h-10 rounded-full
                                 bg-white
                                 flex items-center justify-center">

                        <i data-lucide="user-round"
                           class="w-5 h-5"></i>

                    </span>

                    Profil

                </a>

            </nav>

        </div>


        {{-- USER --}}
        <div class="mt-auto p-6">

            <div class="flex items-center gap-3
                        p-3 rounded-2xl bg-white">

                <div class="w-11 h-11 rounded-full
                            bg-[#D9F0ED]
                            flex items-center justify-center
                            font-bold text-[#438F83]">

                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                </div>


                <div class="min-w-0 flex-1">

                    <p class="font-semibold truncate">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="text-xs text-gray-400">
                        Orang Tua Aktif
                    </p>

                </div>


                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            class="w-10 h-10 rounded-xl
                                   bg-red-50 text-red-400
                                   flex items-center justify-center
                                   hover:bg-red-100 transition">

                        <i data-lucide="log-out"
                           class="w-5 h-5"></i>

                    </button>

                </form>

            </div>

        </div>

    </aside>


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


                {{-- CHILD --}}
                <button type="button"
                        class="w-full sm:w-auto flex items-center gap-3
                               bg-white
                               border border-stone-200
                               rounded-full
                               py-2 pl-2 pr-4 sm:pr-5 shadow-sm">

                    <span class="w-10 h-10 rounded-full
                                 bg-[#E2F1ED]
                                 text-[#438F83]
                                 flex items-center justify-center">

                        <i data-lucide="baby"
                           class="w-5 h-5"></i>

                    </span>

                    <div class="text-left">

                        <p class="text-xs text-gray-400">
                            Konsultasi untuk
                        </p>

                        <p class="text-sm font-semibold">
                            Adam • 38 bulan
                        </p>

                    </div>

                    <i data-lucide="chevron-down"
                       class="w-4 h-4 text-gray-400"></i>

                </button>

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

                {{-- DISCLAIMER --}}
                <div class="flex items-start gap-3
                            bg-[#EEF6F3]
                            border border-[#D9EAE5]
                            rounded-2xl p-4">

                    <span class="w-9 h-9 rounded-full
                                 bg-white text-[#438F83]
                                 flex items-center justify-center
                                 flex-shrink-0">

                        <i data-lucide="info"
                           class="w-4 h-4"></i>

                    </span>

                    <div>

                        <p class="font-semibold text-sm">
                            NutriBot adalah asisten informasi
                        </p>

                        <p class="text-xs
                                  text-gray-500
                                  mt-1 leading-5">

                            Informasi dari AI bukan diagnosis medis
                            dan tidak menggantikan konsultasi langsung
                            dengan dokter atau tenaga kesehatan.

                        </p>

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
                                             bg-green-500
                                             border-2 border-white
                                             rounded-full">
                                </span>

                            </div>


                            <div>

                                <h2 class="font-bold">
                                    NutriBot
                                </h2>

                                <p class="text-xs text-green-600">
                                    Online • AI GrowCare
                                </p>

                            </div>

                        </div>


                        <button type="button"
                                onclick="clearChat()"
                                class="w-10 h-10
                                       rounded-full
                                       hover:bg-gray-100
                                       text-gray-400
                                       flex items-center justify-center">

                            <i data-lucide="rotate-ccw"
                               class="w-4 h-4"></i>

                        </button>

                    </div>


                    {{-- CHAT MESSAGES --}}
                    <div id="chatMessages"
                         class="h-[55vh] min-h-[360px] max-h-[520px] sm:h-[430px]
                                overflow-y-auto
                                px-4 sm:px-5 md:px-8 py-5 sm:py-7">


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
                                             flex items-center justify-center">
                                    ✨
                                </span>

                            </div>


                            <h2 class="text-2xl font-bold mt-6">
                                Halo! Saya NutriBot
                            </h2>


                            <p class="text-gray-400
                                      text-sm max-w-md
                                      mt-2 leading-6">

                                Saya siap membantu memberikan informasi
                                tentang nutrisi dan tumbuh kembang si kecil.

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
                                               text-sm text-gray-600
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
                                               text-sm text-gray-600
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
                                               text-sm text-gray-600
                                               hover:bg-[#EDF6F3]
                                               hover:text-[#438F83]
                                               transition">

                                    Anak susah makan

                                </button>

                            </div>

                        </div>

                    </div>


                    {{-- INPUT --}}
                    <div class="border-t border-stone-100
                                px-4 sm:px-5 md:px-8 py-4 sm:py-5">

                        <form id="chatForm"
                              onsubmit="sendMessage(event)"
                              class="flex items-end gap-3">

                            <div class="flex-1
                                        bg-[#F7F6F2]
                                        border border-stone-200
                                        rounded-[22px]
                                        flex items-center px-4 sm:px-5 min-w-0">

                                <input
                                    id="messageInput"
                                    type="text"
                                    autocomplete="off"
                                    placeholder="Tanyakan tentang nutrisi anak..."
                                    class="w-full py-4
                                           border-0 bg-transparent
                                           focus:ring-0
                                           placeholder:text-gray-400"
                                >

                                <button type="button"
                                        class="text-gray-400
                                               hover:text-[#438F83]">

                                    <i data-lucide="paperclip"
                                       class="w-5 h-5"></i>

                                </button>

                            </div>


                            <button type="submit"
                                    class="w-12 h-12 sm:w-14 sm:h-14 shrink-0
                                           rounded-full
                                           bg-[#4B988D]
                                           hover:bg-[#3D8379]
                                           text-white
                                           flex items-center justify-center
                                           shadow-lg
                                           shadow-emerald-100
                                           transition">

                                <i data-lucide="send"
                                   class="w-5 h-5"></i>

                            </button>

                        </form>


                        <p class="text-[11px]
                                  text-gray-400
                                  text-center mt-3">

                            NutriBot dapat membuat kesalahan.
                            Gunakan informasi sebagai edukasi,
                            bukan diagnosis medis.

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


                    {{-- DOCTOR --}}
                    <div class="max-w-2xl mx-auto
                                mt-8
                                border border-stone-100
                                rounded-3xl p-5
                                flex flex-col sm:flex-row
                                sm:items-center gap-5">

                        <div class="w-16 h-16
                                    rounded-2xl
                                    bg-[#E7F2EF]
                                    text-[#438F83]
                                    flex items-center justify-center">

                            <i data-lucide="user-round"
                               class="w-7 h-7"></i>

                        </div>


                        <div class="flex-1">

                            <h3 class="font-bold">
                                dr. Maya Putri, Sp.A
                            </h3>

                            <p class="text-sm
                                      text-gray-400 mt-1">

                                Dokter Spesialis Anak

                            </p>

                            <div class="flex items-center
                                        gap-2 mt-2">

                                <span class="w-2 h-2
                                             bg-green-500
                                             rounded-full">
                                </span>

                                <span class="text-xs text-green-600">
                                    Tersedia
                                </span>

                            </div>

                        </div>


                        <button type="button"
                                onclick="doctorDemo()"
                                class="w-full sm:w-auto px-5 py-3
                                       rounded-full
                                       bg-[#4B988D]
                                       text-white
                                       text-sm font-semibold
                                       hover:bg-[#3D8379]
                                       transition">

                            Mulai Konsultasi

                        </button>

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


    function quickQuestion(question) {

        document.getElementById('messageInput').value = question;

        sendMessage(new Event('submit'));

    }


    function sendMessage(event) {

        event.preventDefault();

        const input =
            document.getElementById('messageInput');

        const message =
            input.value.trim();

        if (!message) {
            return;
        }


        const chat =
            document.getElementById('chatMessages');

        const empty =
            document.getElementById('emptyChat');

        if (empty) {
            empty.remove();
        }


        {{-- USER MESSAGE --}}
        const userMessage =
            document.createElement('div');

        userMessage.className =
            'flex justify-end mb-5';

        userMessage.innerHTML = `
            <div class="max-w-[88%] sm:max-w-[75%]">

                <div class="bg-[#4B988D]
                            text-white
                            px-5 py-3.5
                            rounded-[20px]
                            rounded-br-md
                            text-sm leading-6">

                    ${escapeHtml(message)}

                </div>

                <p class="text-[10px]
                          text-gray-400
                          text-right mt-1">
                    Baru saja
                </p>

            </div>
        `;

        chat.appendChild(userMessage);

        input.value = '';

        chat.scrollTop =
            chat.scrollHeight;


        {{-- TYPING --}}
        const typing =
            document.createElement('div');

        typing.id =
            'typingMessage';

        typing.className =
            'flex items-start gap-3 mb-5';

        typing.innerHTML = `
            <div class="w-9 h-9
                        rounded-xl
                        bg-[#E2F2ED]
                        text-[#438F83]
                        flex items-center justify-center
                        flex-shrink-0">

                <span class="text-sm">
                    AI
                </span>

            </div>

            <div class="bg-[#F4F5F1]
                        rounded-[20px]
                        rounded-tl-md
                        px-5 py-4">

                <div class="flex gap-1.5">

                    <span class="w-2 h-2
                                 bg-gray-400
                                 rounded-full
                                 animate-bounce">
                    </span>

                    <span class="w-2 h-2
                                 bg-gray-400
                                 rounded-full
                                 animate-bounce">
                    </span>

                    <span class="w-2 h-2
                                 bg-gray-400
                                 rounded-full
                                 animate-bounce">
                    </span>

                </div>

            </div>
        `;

        chat.appendChild(typing);

        chat.scrollTop =
            chat.scrollHeight;


        setTimeout(() => {

            typing.remove();

            const botMessage =
                document.createElement('div');

            botMessage.className =
                'flex items-start gap-3 mb-5';

            botMessage.innerHTML = `
                <div class="w-9 h-9
                            rounded-xl
                            bg-[#E2F2ED]
                            text-[#438F83]
                            flex items-center justify-center
                            flex-shrink-0">

                    <span class="text-sm font-bold">
                        AI
                    </span>

                </div>


                <div class="max-w-[88%] sm:max-w-[75%]">

                    <div class="bg-[#F4F5F1]
                                text-gray-700
                                px-5 py-3.5
                                rounded-[20px]
                                rounded-tl-md
                                text-sm leading-6">

                        ${getDemoAnswer(message)}

                    </div>

                    <p class="text-[10px]
                              text-gray-400 mt-1">
                        NutriBot • Baru saja
                    </p>

                </div>
            `;

            chat.appendChild(botMessage);

            chat.scrollTop =
                chat.scrollHeight;

        }, 1200);

    }


    function getDemoAnswer(message) {

        const text =
            message.toLowerCase();


        if (text.includes('kalori')) {

            return 'Kebutuhan energi anak berbeda berdasarkan usia, jenis kelamin, aktivitas, dan kondisi pertumbuhannya. Untuk pemantauan yang lebih tepat, kebutuhan anak sebaiknya dinilai berdasarkan data pertumbuhan dan saran tenaga kesehatan.';

        }


        if (text.includes('protein')) {

            return 'Beberapa sumber protein yang dapat menjadi bagian dari menu anak antara lain telur, ikan, ayam, daging, tahu, tempe, dan produk susu yang sesuai untuk anak. Variasikan sumber makanan agar menu tetap seimbang.';

        }


        if (
            text.includes('susah makan') ||
            text.includes('nafsu')
        ) {

            return 'Coba buat jadwal makan yang teratur, sajikan porsi kecil terlebih dahulu, variasikan bentuk dan warna makanan, serta hindari memaksa anak makan. Jika masalah makan berlangsung lama atau pertumbuhan terganggu, konsultasikan dengan tenaga kesehatan.';

        }


        return 'Saya bisa membantu memberikan informasi umum tentang nutrisi dan tumbuh kembang anak. Coba tanyakan mengenai kebutuhan nutrisi, pilihan makanan, pola makan, atau pemantauan pertumbuhan si kecil.';

    }


    function clearChat() {

        location.reload();

    }


    function doctorDemo() {

        alert(
            'Fitur konsultasi dokter masih berupa demo front-end GrowCare.'
        );

    }


    function escapeHtml(text) {

        const div =
            document.createElement('div');

        div.textContent =
            text;

        return div.innerHTML;

    }

</script>

</body>
</html>