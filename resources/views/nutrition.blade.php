<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nutrisi - GrowCare</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#F8F7F2] text-[#202725] overflow-x-hidden">

<div class="min-h-screen flex">

    {{-- ================= MOBILE HEADER ================= --}}
    <header class="lg:hidden fixed top-0 left-0 right-0 z-40
                   h-16 bg-[#FBFAF6]/95 backdrop-blur
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


                {{-- NUTRISI ACTIVE --}}
                <a href="{{ route('nutrition') }}"
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


                {{-- TANYA AI --}}
                <a href="{{ route('ai.chat') }}"
                   class="flex items-center gap-4
                          px-4 py-4 rounded-2xl
                          text-gray-600
                          hover:bg-white transition">

                    <span class="w-10 h-10 rounded-full
                                 bg-white
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
    <main class="w-full min-w-0 lg:ml-[285px] pt-16 lg:pt-0 pb-28 lg:pb-0">

        <div class="max-w-[1450px] mx-auto w-full min-w-0
                    px-4 sm:px-5 md:px-8 lg:px-10
                    py-5 sm:py-8">


            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row
                        md:items-center justify-between
                        gap-5 mb-8">

                <div>

                    <p class="text-sm text-[#4B988D]
                              font-semibold mb-2">
                        NUTRISI HARIAN
                    </p>

                    <h1 class="text-2xl sm:text-3xl font-bold">
                        Log Nutrisi Anak
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Pantau asupan makanan dan kebutuhan nutrisi si kecil.
                    </p>

                </div>


                <button type="button"
                        class="w-full sm:w-auto flex items-center gap-3
                               bg-white border border-stone-200
                               rounded-full py-2 pl-2 pr-4 sm:pr-5
                               shadow-sm">

                    <span class="w-10 h-10 rounded-full
                                 bg-[#E2F1ED]
                                 text-[#438F83]
                                 flex items-center justify-center">

                        <i data-lucide="baby"
                           class="w-5 h-5"></i>

                    </span>

                    <div class="text-left">

                        <p class="text-xs text-gray-400">
                            Anak
                        </p>

                        <p class="font-semibold text-sm">
                            Adam • 38 bulan
                        </p>

                    </div>

                    <i data-lucide="chevron-down"
                       class="w-4 h-4 text-gray-400"></i>

                </button>

            </div>


            {{-- ================= MACRO CARDS ================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-2
                        xl:grid-cols-4 gap-5">

                {{-- KALORI --}}
                <div class="bg-[#DCEFE9] rounded-[28px]
                            p-5 sm:p-6 border border-[#C9E2DB]">

                    <div class="flex items-center justify-between">

                        <span class="w-11 h-11 bg-white/70
                                     rounded-full
                                     flex items-center justify-center
                                     text-[#438F83]">

                            <i data-lucide="flame"
                               class="w-5 h-5"></i>

                        </span>

                        <span class="text-xs text-[#438F83]
                                     bg-white/70 px-3 py-1
                                     rounded-full font-semibold">
                            61%
                        </span>

                    </div>

                    <p class="text-sm text-gray-500 mt-5">
                        Kalori
                    </p>

                    <div class="flex items-end gap-2 mt-1">

                        <h2 class="text-3xl font-bold">
                            520
                        </h2>

                        <span class="text-sm text-gray-500 mb-1">
                            / 850 kkal
                        </span>

                    </div>

                    <div class="h-2 bg-white/60
                                rounded-full mt-5 overflow-hidden">

                        <div class="w-[61%] h-full
                                    bg-[#4B988D] rounded-full">
                        </div>

                    </div>

                </div>


                {{-- PROTEIN --}}
                <div class="bg-white rounded-[28px]
                            p-5 sm:p-6 border border-stone-100 shadow-sm">

                    <div class="flex items-center justify-between">

                        <span class="w-11 h-11
                                     bg-[#EAF6F3]
                                     text-[#438F83]
                                     rounded-full
                                     flex items-center justify-center">

                            <i data-lucide="drumstick"
                               class="w-5 h-5"></i>

                        </span>

                        <span class="text-xs text-gray-400">
                            Target 25g
                        </span>

                    </div>

                    <p class="text-sm text-gray-500 mt-5">
                        Protein
                    </p>

                    <h2 class="text-3xl font-bold mt-1">
                        18
                        <span class="text-sm font-normal
                                     text-gray-500 ml-1">
                            g
                        </span>
                    </h2>

                    <div class="h-2 bg-gray-100
                                rounded-full mt-5 overflow-hidden">

                        <div class="w-[72%] h-full
                                    bg-[#4B988D] rounded-full">
                        </div>

                    </div>

                </div>


                {{-- LEMAK --}}
                <div class="bg-white rounded-[28px]
                            p-5 sm:p-6 border border-stone-100 shadow-sm">

                    <div class="flex items-center justify-between">

                        <span class="w-11 h-11
                                     bg-[#EFF5E8]
                                     text-[#7FA56E]
                                     rounded-full
                                     flex items-center justify-center">

                            <i data-lucide="droplets"
                               class="w-5 h-5"></i>

                        </span>

                        <span class="text-xs text-gray-400">
                            Target 30g
                        </span>

                    </div>

                    <p class="text-sm text-gray-500 mt-5">
                        Lemak
                    </p>

                    <h2 class="text-3xl font-bold mt-1">
                        15
                        <span class="text-sm font-normal
                                     text-gray-500 ml-1">
                            g
                        </span>
                    </h2>

                    <div class="h-2 bg-gray-100
                                rounded-full mt-5 overflow-hidden">

                        <div class="w-1/2 h-full
                                    bg-[#86AA76] rounded-full">
                        </div>

                    </div>

                </div>


                {{-- KARBO --}}
                <div class="bg-white rounded-[28px]
                            p-5 sm:p-6 border border-stone-100 shadow-sm">

                    <div class="flex items-center justify-between">

                        <span class="w-11 h-11
                                     bg-[#FBF3E5]
                                     text-[#C49B50]
                                     rounded-full
                                     flex items-center justify-center">

                            <i data-lucide="wheat"
                               class="w-5 h-5"></i>

                        </span>

                        <span class="text-xs text-gray-400">
                            Target 110g
                        </span>

                    </div>

                    <p class="text-sm text-gray-500 mt-5">
                        Karbohidrat
                    </p>

                    <h2 class="text-3xl font-bold mt-1">
                        62
                        <span class="text-sm font-normal
                                     text-gray-500 ml-1">
                            g
                        </span>
                    </h2>

                    <div class="h-2 bg-gray-100
                                rounded-full mt-5 overflow-hidden">

                        <div class="w-[56%] h-full
                                    bg-[#C9A454] rounded-full">
                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= CONTENT ================= --}}
            <div class="grid grid-cols-1 xl:grid-cols-12
                        gap-6 mt-6">


                {{-- RIWAYAT MAKANAN --}}
                <div class="xl:col-span-8
                            bg-white rounded-[30px]
                            border border-stone-100
                            shadow-sm p-5 sm:p-7">

                    <div class="flex flex-col md:flex-row
                                md:items-center
                                justify-between gap-4">

                        <div>

                            <h2 class="text-2xl font-bold">
                                Riwayat Makanan
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Makanan yang dikonsumsi hari ini
                            </p>

                        </div>


                        <button onclick="openFoodModal()"
                                class="flex items-center justify-center
                                       gap-2 bg-[#4B988D]
                                       hover:bg-[#3D8379]
                                       text-white rounded-full
                                       px-5 py-3 font-semibold transition">

                            <i data-lucide="plus"
                               class="w-4 h-4"></i>

                            Tambah Makanan

                        </button>

                    </div>


                    {{-- SEARCH --}}
                    <div class="mt-6 flex items-center gap-3
                                bg-[#F8F7F3]
                                border border-stone-200
                                rounded-2xl px-4 py-3">

                        <i data-lucide="search"
                           class="w-5 h-5 text-gray-400"></i>

                        <input type="text"
                               placeholder="Cari makanan..."
                               class="w-full border-0
                                      bg-transparent p-0
                                      focus:ring-0 text-sm">

                    </div>


                    {{-- SARAPAN --}}
                    <div class="mt-7">

                        <div class="flex items-center
                                    justify-between mb-4">

                            <div class="flex items-center gap-3">

                                <span class="w-9 h-9
                                             bg-[#FFF5DE]
                                             rounded-full
                                             flex items-center justify-center">
                                    ☀️
                                </span>

                                <div>

                                    <h3 class="font-semibold">
                                        Sarapan
                                    </h3>

                                    <p class="text-xs text-gray-400">
                                        07:30
                                    </p>

                                </div>

                            </div>

                            <span class="text-sm font-semibold">
                                280 kkal
                            </span>

                        </div>


                        <div class="border border-stone-100
                                    rounded-2xl p-3 sm:p-4
                                    flex items-center gap-3 sm:gap-4">

                            <div class="w-12 h-12 sm:w-14 sm:h-14 shrink-0
                                        bg-[#F5EFE3]
                                        rounded-2xl
                                        flex items-center justify-center
                                        text-2xl">
                                🍚
                            </div>

                            <div class="flex-1 min-w-0">

                                <h4 class="font-semibold">
                                    Bubur Ayam
                                </h4>

                                <p class="text-xs text-gray-400 mt-1">
                                    1 mangkuk • 250 gram
                                </p>

                            </div>

                            <div class="text-right shrink-0">

                                <p class="font-semibold">
                                    280
                                </p>

                                <p class="text-xs text-gray-400">
                                    kkal
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- SNACK --}}
                    <div class="mt-7">

                        <div class="flex items-center
                                    justify-between mb-4">

                            <div class="flex items-center gap-3">

                                <span class="w-9 h-9
                                             bg-[#EAF6F3]
                                             rounded-full
                                             flex items-center justify-center">
                                    🍎
                                </span>

                                <div>

                                    <h3 class="font-semibold">
                                        Snack Pagi
                                    </h3>

                                    <p class="text-xs text-gray-400">
                                        10:00
                                    </p>

                                </div>

                            </div>

                            <span class="text-sm font-semibold">
                                90 kkal
                            </span>

                        </div>


                        <div class="border border-stone-100
                                    rounded-2xl p-3 sm:p-4
                                    flex items-center gap-3 sm:gap-4">

                            <div class="w-12 h-12 sm:w-14 sm:h-14 shrink-0
                                        bg-[#F4F6E8]
                                        rounded-2xl
                                        flex items-center justify-center
                                        text-2xl">
                                🍌
                            </div>

                            <div class="flex-1 min-w-0">

                                <h4 class="font-semibold">
                                    Pisang
                                </h4>

                                <p class="text-xs text-gray-400 mt-1">
                                    1 buah sedang
                                </p>

                            </div>

                            <div class="text-right shrink-0">

                                <p class="font-semibold">
                                    90
                                </p>

                                <p class="text-xs text-gray-400">
                                    kkal
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- MAKAN SIANG --}}
                    <div class="mt-7">

                        <div class="flex items-center
                                    justify-between mb-4">

                            <div class="flex items-center gap-3">

                                <span class="w-9 h-9
                                             bg-[#F5EDE2]
                                             rounded-full
                                             flex items-center justify-center">
                                    🍽️
                                </span>

                                <div>

                                    <h3 class="font-semibold">
                                        Makan Siang
                                    </h3>

                                    <p class="text-xs text-gray-400">
                                        12:30
                                    </p>

                                </div>

                            </div>

                            <span class="text-sm font-semibold">
                                150 kkal
                            </span>

                        </div>


                        <div class="border border-stone-100
                                    rounded-2xl p-3 sm:p-4
                                    flex items-center gap-3 sm:gap-4">

                            <div class="w-12 h-12 sm:w-14 sm:h-14 shrink-0
                                        bg-[#F6F1E8]
                                        rounded-2xl
                                        flex items-center justify-center
                                        text-2xl">
                                🍲
                            </div>

                            <div class="flex-1 min-w-0">

                                <h4 class="font-semibold">
                                    Sup Ayam Sayur
                                </h4>

                                <p class="text-xs text-gray-400 mt-1">
                                    1 mangkuk kecil
                                </p>

                            </div>

                            <div class="text-right shrink-0">

                                <p class="font-semibold">
                                    150
                                </p>

                                <p class="text-xs text-gray-400">
                                    kkal
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ================= RIGHT ================= --}}
                <div class="xl:col-span-4 space-y-6">

                    {{-- AI FOOD SCAN --}}
                    <div class="relative overflow-hidden
                                bg-gradient-to-br
                                from-[#4B988D]
                                to-[#33746C]
                                text-white rounded-[30px] p-5 sm:p-7">

                        <div class="absolute
                                    w-40 h-40
                                    bg-white/10 rounded-full
                                    -right-12 -top-14">
                        </div>

                        <div class="relative">

                            <div class="w-12 h-12
                                        bg-white/15
                                        rounded-2xl
                                        flex items-center justify-center">

                                <i data-lucide="scan-line"
                                   class="w-6 h-6"></i>

                            </div>

                            <p class="text-xs tracking-[0.2em]
                                      text-white/70 mt-6">
                                AI VISION
                            </p>

                            <h2 class="text-2xl font-bold mt-2">
                                AI Food Scan
                            </h2>

                            <p class="text-white/75
                                      text-sm leading-6 mt-2">

                                Foto makanan dan biarkan AI
                                membantu mengenali estimasi
                                nutrisi secara otomatis.

                            </p>


                            <a href="{{ route('food.scan') }}"
                               class="mt-6 w-fit
                                      bg-white text-[#3F887E]
                                      rounded-full px-5 py-3
                                      font-semibold
                                      flex items-center gap-2">

                                <i data-lucide="camera"
                                   class="w-4 h-4"></i>

                                Scan Makanan

                            </a>

                        </div>

                    </div>


                    {{-- REKOMENDASI --}}
                    <div class="bg-white rounded-[30px]
                                border border-stone-100
                                shadow-sm p-5 sm:p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-xs text-[#4B988D]
                                          font-semibold">
                                    REKOMENDASI
                                </p>

                                <h2 class="font-bold text-xl mt-1">
                                    Menu Hari Ini
                                </h2>

                            </div>

                            <span class="w-10 h-10
                                         bg-[#EAF6F3]
                                         text-[#438F83]
                                         rounded-full
                                         flex items-center justify-center">

                                <i data-lucide="sparkles"
                                   class="w-5 h-5"></i>

                            </span>

                        </div>


                        <div class="mt-6
                                    bg-[#F8F7F3]
                                    rounded-2xl p-4">

                            <div class="flex gap-4">

                                <div class="w-12 h-12 sm:w-14 sm:h-14 shrink-0
                                            bg-[#E8F1E7]
                                            rounded-2xl
                                            flex items-center justify-center
                                            text-2xl">
                                    🥣
                                </div>

                                <div>

                                    <h3 class="font-semibold">
                                        Sup Kentang Ayam
                                    </h3>

                                    <p class="text-xs
                                              text-gray-400 mt-1">
                                        Tinggi protein & mudah dicerna
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="mt-3
                                    bg-[#F8F7F3]
                                    rounded-2xl p-4">

                            <div class="flex gap-4">

                                <div class="w-12 h-12 sm:w-14 sm:h-14 shrink-0
                                            bg-[#F6F0E4]
                                            rounded-2xl
                                            flex items-center justify-center
                                            text-2xl">
                                    🥑
                                </div>

                                <div>

                                    <h3 class="font-semibold">
                                        Alpukat Pisang
                                    </h3>

                                    <p class="text-xs
                                              text-gray-400 mt-1">
                                        Lemak sehat & energi tambahan
                                    </p>

                                </div>

                            </div>

                        </div>

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

        {{-- BERANDA --}}
        <a href="{{ route('dashboard') }}"
           class="group flex flex-col items-center justify-center gap-1.5
                  min-w-0 text-gray-400 hover:text-[#438F83]
                  transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="house" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">
                Beranda
            </span>
        </a>

        {{-- NUTRISI ACTIVE --}}
        <a href="{{ route('nutrition') }}"
           class="group relative flex flex-col items-center justify-center gap-1.5
                  min-w-0 text-[#438F83] transition duration-200 active:scale-90">

            <span class="absolute -top-2 w-7 h-1 rounded-full bg-[#4B988D]
                         shadow-[0_2px_10px_rgba(75,152,141,0.45)]"></span>

            <span class="relative -mt-1 w-11 h-11 rounded-2xl
                         bg-gradient-to-br from-[#DDF1ED] to-[#CFE8E3]
                         ring-1 ring-[#BFDCD6]
                         shadow-[0_8px_18px_rgba(75,152,141,0.20)]
                         flex items-center justify-center
                         transition duration-200 group-hover:-translate-y-0.5">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                <span class="absolute -right-0.5 -top-0.5 w-2.5 h-2.5 rounded-full
                             bg-[#4B988D] border-2 border-white"></span>
            </span>

            <span class="text-[9px] sm:text-[10px] font-bold truncate w-full text-center">
                Nutrisi
            </span>
        </a>

        {{-- FOOD SCAN --}}
        <a href="{{ route('food.scan') }}"
           class="group flex flex-col items-center justify-center gap-1.5
                  min-w-0 text-gray-400 hover:text-[#438F83]
                  transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="scan-line" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">
                Scan
            </span>
        </a>

        {{-- TANYA AI --}}
        <a href="{{ route('ai.chat') }}"
           class="group flex flex-col items-center justify-center gap-1.5
                  min-w-0 text-gray-400 hover:text-[#438F83]
                  transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="message-circle" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">
                Tanya AI
            </span>
        </a>

        {{-- DATA ANAK --}}
        <a href="{{ route('children.index') }}"
           class="group flex flex-col items-center justify-center gap-1.5
                  min-w-0 text-gray-400 hover:text-[#438F83]
                  transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="baby" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">
                Anak
            </span>
        </a>

        {{-- PROFIL --}}
        <a href="{{ route('profile.edit') }}"
           class="group flex flex-col items-center justify-center gap-1.5
                  min-w-0 text-gray-400 hover:text-[#438F83]
                  transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="user-round" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">
                Profil
            </span>
        </a>

    </div>
</nav>

{{-- ================= MODAL TAMBAH MAKANAN ================= --}}
<div id="foodModal"
     class="hidden fixed inset-0 z-50
            bg-black/30 backdrop-blur-sm
            items-end sm:items-center justify-center
            p-0 sm:p-5">

    <div class="bg-white w-full max-w-md
                rounded-t-[28px] sm:rounded-[28px]
                p-5 sm:p-7 shadow-xl
                max-h-[90vh] overflow-y-auto">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold">
                    Tambah Makanan
                </h2>

                <p class="text-sm text-gray-400 mt-1">
                    Demo front-end GrowCare
                </p>

            </div>

            <button type="button"
                    onclick="closeFoodModal()"
                    class="w-10 h-10 rounded-full
                           bg-gray-100
                           flex items-center justify-center">

                <i data-lucide="x"
                   class="w-5 h-5"></i>

            </button>

        </div>


        <div class="mt-6">

            <label class="text-sm font-semibold">
                Nama Makanan
            </label>

            <input type="text"
                   placeholder="Contoh: Nasi Tim Ayam"
                   class="mt-2 w-full rounded-2xl
                          border-stone-200
                          bg-[#F8F7F3]
                          focus:border-[#4B988D]
                          focus:ring-[#4B988D]">

        </div>


        <div class="mt-4">

            <label class="text-sm font-semibold">
                Waktu Makan
            </label>

            <select class="mt-2 w-full rounded-2xl
                           border-stone-200
                           bg-[#F8F7F3]
                           focus:border-[#4B988D]
                           focus:ring-[#4B988D]">

                <option>Sarapan</option>
                <option>Snack Pagi</option>
                <option>Makan Siang</option>
                <option>Snack Sore</option>
                <option>Makan Malam</option>

            </select>

        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">

            <div>

                <label class="text-sm font-semibold">
                    Porsi
                </label>

                <input type="text"
                       placeholder="1 mangkuk"
                       class="mt-2 w-full rounded-2xl
                              border-stone-200
                              bg-[#F8F7F3]">

            </div>


            <div>

                <label class="text-sm font-semibold">
                    Kalori
                </label>

                <input type="number"
                       placeholder="250"
                       class="mt-2 w-full rounded-2xl
                              border-stone-200
                              bg-[#F8F7F3]">

            </div>

        </div>


        <button type="button"
                onclick="closeFoodModal()"
                class="mt-7 w-full py-4
                       bg-[#4B988D]
                       hover:bg-[#3F847B]
                       text-white font-semibold
                       rounded-2xl transition">

            Simpan Makanan

        </button>

    </div>

</div>


<script>

    lucide.createIcons();

    function openFoodModal() {

        const modal =
            document.getElementById('foodModal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

    }

    function closeFoodModal() {

        const modal =
            document.getElementById('foodModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

    }

</script>

</body>
</html>