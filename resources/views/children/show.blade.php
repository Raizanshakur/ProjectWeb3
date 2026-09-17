<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $child->name }} - GrowCare</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-[#F8F7F2] text-[#202725] overflow-x-hidden">

<div class="min-h-screen flex">

    {{-- ================= MOBILE HEADER ================= --}}
    <header class="lg:hidden fixed top-0 left-0 right-0 z-40 h-16
                   bg-[#FBFAF6]/95 backdrop-blur-xl border-b border-stone-200
                   flex items-center justify-between px-4 sm:px-5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <span class="w-9 h-9 rounded-full bg-[#E0F0EB] text-[#438F83] flex items-center justify-center">
                <i data-lucide="sprout" class="w-5 h-5"></i>
            </span>
            <span class="text-xl font-bold"><span class="text-[#438F83]">Grow</span>Care</span>
        </a>
        <a href="{{ route('profile.edit') }}"
           class="w-10 h-10 rounded-full bg-[#DDF1EE] text-[#438F83] flex items-center justify-center">
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


                {{-- DATA ANAK ACTIVE --}}
                <a href="{{ route('children.index') }}"
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
                                   hover:bg-red-100
                                   flex items-center justify-center">

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
                    px-4 sm:px-5 md:px-8 lg:px-10 py-5 sm:py-7">


            {{-- TOP --}}
            <div class="flex flex-col sm:flex-row
                        sm:items-center justify-between gap-4">

                <div>

                    <a href="{{ route('children.index') }}"
                       class="inline-flex items-center gap-2
                              text-sm text-gray-400
                              hover:text-[#438F83] transition">

                        <i data-lucide="arrow-left"
                           class="w-4 h-4"></i>

                        Kembali ke Data Anak

                    </a>

                    <h1 class="text-2xl sm:text-3xl font-bold mt-3">
                        Detail Anak
                    </h1>

                    <p class="text-gray-400 mt-1">
                        Pantau profil dan perkembangan si kecil.
                    </p>

                </div>


                <a href="{{ route('children.edit', $child) }}"
                   class="w-full sm:w-auto inline-flex items-center
                          justify-center gap-2
                          bg-white
                          border border-stone-200
                          rounded-full px-5 py-3
                          font-semibold
                          hover:bg-stone-50 transition">

                    <i data-lucide="pencil"
                       class="w-4 h-4"></i>

                    Edit Profil

                </a>

            </div>


            {{-- ================= PROFILE HERO ================= --}}
            <div class="mt-7
                        bg-gradient-to-br
                        from-[#DCEFE9]
                        via-[#E7F4EF]
                        to-[#F4F1E6]
                        rounded-[26px] sm:rounded-[30px]
                        p-5 sm:p-6 md:p-8
                        border border-white">

                <div class="flex flex-col md:flex-row
                            md:items-center gap-6">


                    {{-- AVATAR --}}
                    <div class="w-24 h-24 sm:w-28 sm:h-28
                                rounded-[26px] sm:rounded-[30px]
                                bg-white shadow-sm
                                flex items-center
                                justify-center
                                text-6xl shrink-0">

                        {{ $child->gender === 'P' ? '👧' : '👦' }}

                    </div>


                    {{-- PROFILE --}}
                    <div class="flex-1 min-w-0">

                        <div class="flex flex-wrap
                                    items-center gap-3">

                            <h2 class="text-2xl sm:text-3xl font-bold break-words">
                                {{ $child->name }}
                            </h2>

                            <span class="px-3 py-1
                                         bg-white/80
                                         text-[#438F83]
                                         rounded-full
                                         text-xs font-semibold">

                                Aktif

                            </span>

                        </div>


                        <div class="flex flex-wrap
                                    gap-x-6 gap-y-2
                                    mt-3
                                    text-sm text-gray-500">

                            <span class="flex items-center gap-2">

                                <i data-lucide="cake"
                                   class="w-4 h-4"></i>

                                {{ $child->birth_date
                                    ? \Carbon\Carbon::parse($child->birth_date)->format('d M Y')
                                    : '-' }}

                            </span>


                            <span class="flex items-center gap-2">

                                <i data-lucide="baby"
                                   class="w-4 h-4"></i>

                                {{ $child->gender === 'P'
                                    ? 'Perempuan'
                                    : 'Laki-laki' }}

                            </span>


                            <span class="flex items-center gap-2">

                                <i data-lucide="calendar"
                                   class="w-4 h-4"></i>

                                @if($child->birth_date)

                                    @php
                                        $birthDate = \Carbon\Carbon::parse($child->birth_date);
                                        $age = $birthDate->diff(now());
                                    @endphp

                                    @if($age->y > 0)
                                        {{ $age->y }} tahun {{ $age->m }} bulan
                                    @else
                                        {{ $age->m }} bulan
                                    @endif

                                @else
                                    -
                                @endif

                            </span>

                        </div>


                        <p class="mt-5 max-w-2xl
                                  text-sm text-gray-500
                                  leading-relaxed">

                            Informasi profil dan tumbuh kembang
                            {{ $child->name }} dapat dipantau
                            melalui halaman ini.

                        </p>

                    </div>


                    {{-- SCORE DEMO --}}
                    <div class="bg-white/80
                                backdrop-blur
                                rounded-3xl p-5
                                w-full md:w-auto md:min-w-[190px]">

                        <p class="text-xs text-gray-400">
                            Status Pertumbuhan
                        </p>

                        <div class="flex items-end gap-1 mt-2">

                            <span class="text-4xl font-bold
                                         text-[#438F83]">
                                85
                            </span>

                            <span class="text-gray-400 mb-1">
                                /100
                            </span>

                        </div>

                        <div class="w-full h-2
                                    bg-stone-200
                                    rounded-full mt-4">

                            <div class="h-2
                                        bg-[#4B988D]
                                        rounded-full
                                        w-[85%]">
                            </div>

                        </div>

                        <p class="text-xs
                                  text-[#438F83]
                                  font-semibold mt-3">
                            Tumbuh Optimal
                        </p>

                    </div>

                </div>

            </div>


            {{-- ================= STATS ================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4
                        gap-4 mt-6">


                {{-- UMUR --}}
                <div class="bg-white
                            rounded-2xl
                            border border-stone-100 p-5">

                    <div class="flex items-center justify-between">

                        <span class="w-11 h-11
                                     rounded-xl
                                     bg-[#EDF5F2]
                                     text-[#438F83]
                                     flex items-center justify-center">

                            <i data-lucide="calendar-days"
                               class="w-5 h-5"></i>

                        </span>

                        <span class="text-xs text-gray-400">
                            Saat ini
                        </span>

                    </div>

                    <p class="text-sm text-gray-400 mt-5">
                        Usia
                    </p>

                    <h3 class="text-2xl font-bold mt-1">

                        @if($child->birth_date)

                            @php
                                $ageCard = \Carbon\Carbon::parse($child->birth_date)->diff(now());
                            @endphp

                            @if($ageCard->y > 0)
                                {{ $ageCard->y }}
                                <span class="text-sm
                                             font-medium
                                             text-gray-400">
                                    tahun
                                </span>

                                {{ $ageCard->m }}
                                <span class="text-sm
                                             font-medium
                                             text-gray-400">
                                    bulan
                                </span>
                            @else
                                {{ $ageCard->m }}
                                <span class="text-sm
                                             font-medium
                                             text-gray-400">
                                    bulan
                                </span>
                            @endif

                        @else
                            -
                        @endif

                    </h3>

                </div>


                {{-- BERAT LAHIR --}}
                <div class="bg-white
                            rounded-2xl
                            border border-stone-100 p-5">

                    <div class="flex items-center justify-between">

                        <span class="w-11 h-11
                                     rounded-xl
                                     bg-[#F7EFE3]
                                     text-[#B58A45]
                                     flex items-center justify-center">

                            <i data-lucide="weight"
                               class="w-5 h-5"></i>

                        </span>

                        <span class="text-xs text-gray-400">
                            Data lahir
                        </span>

                    </div>

                    <p class="text-sm text-gray-400 mt-5">
                        Berat Lahir
                    </p>

                    <h3 class="text-2xl font-bold mt-1">

                        @if($child->birth_weight)
                            {{ $child->birth_weight }}
                            <span class="text-sm
                                         font-medium
                                         text-gray-400">
                                kg
                            </span>
                        @else
                            -
                        @endif

                    </h3>

                </div>


                {{-- TINGGI LAHIR --}}
                <div class="bg-white
                            rounded-2xl
                            border border-stone-100 p-5">

                    <div class="flex items-center justify-between">

                        <span class="w-11 h-11
                                     rounded-xl
                                     bg-[#E9EFF8]
                                     text-[#6883A8]
                                     flex items-center justify-center">

                            <i data-lucide="ruler"
                               class="w-5 h-5"></i>

                        </span>

                        <span class="text-xs text-gray-400">
                            Data lahir
                        </span>

                    </div>

                    <p class="text-sm text-gray-400 mt-5">
                        Panjang Lahir
                    </p>

                    <h3 class="text-2xl font-bold mt-1">

                        @if($child->birth_height)
                            {{ $child->birth_height }}
                            <span class="text-sm
                                         font-medium
                                         text-gray-400">
                                cm
                            </span>
                        @else
                            -
                        @endif

                    </h3>

                </div>


                {{-- NUTRISI DEMO --}}
                <div class="bg-white
                            rounded-2xl
                            border border-stone-100 p-5">

                    <div class="flex items-center justify-between">

                        <span class="w-11 h-11
                                     rounded-xl
                                     bg-[#F8EAEF]
                                     text-[#B8758D]
                                     flex items-center justify-center">

                            <i data-lucide="apple"
                               class="w-5 h-5"></i>

                        </span>

                        <span class="text-xs
                                     bg-[#EDF5F2]
                                     text-[#438F83]
                                     px-2 py-1 rounded-full">
                            Baik
                        </span>

                    </div>

                    <p class="text-sm text-gray-400 mt-5">
                        Nutrisi Hari Ini
                    </p>

                    <h3 class="text-2xl font-bold mt-1">

                        520

                        <span class="text-sm
                                     font-medium
                                     text-gray-400">
                            / 850 kcal
                        </span>

                    </h3>

                </div>

            </div>


            {{-- ================= CONTENT ================= --}}
            <div class="grid grid-cols-1
                        xl:grid-cols-3
                        gap-6 mt-6">


                {{-- LEFT --}}
                <div class="xl:col-span-2 space-y-6">


                    {{-- GRAFIK --}}
                    <div class="bg-white
                                rounded-[26px]
                                border border-stone-100 p-4 sm:p-6">

                        <div class="flex flex-col sm:flex-row
                                    sm:items-center
                                    justify-between gap-4">

                            <div>

                                <h3 class="text-lg font-bold">
                                    Grafik Pertumbuhan
                                </h3>

                                <p class="text-sm
                                          text-gray-400 mt-1">
                                    Contoh perkembangan berat badan
                                    selama 6 bulan.
                                </p>

                            </div>


                            <span class="inline-flex
                                         items-center gap-2
                                         bg-[#EDF5F2]
                                         text-[#438F83]
                                         px-3 py-2
                                         rounded-xl
                                         text-xs font-semibold">

                                <span class="w-2 h-2
                                             rounded-full
                                             bg-[#4B988D]">
                                </span>

                                Berat Badan

                            </span>

                        </div>


                        <div class="mt-6 sm:mt-7 h-[230px] sm:h-[280px]">
                            <canvas id="growthChart"></canvas>
                        </div>

                    </div>


                    {{-- RIWAYAT --}}
                    <div class="bg-white
                                rounded-[26px]
                                border border-stone-100 p-4 sm:p-6">

                        <div class="flex items-center
                                    justify-between">

                            <div>

                                <h3 class="text-lg font-bold">
                                    Riwayat Pertumbuhan
                                </h3>

                                <p class="text-sm
                                          text-gray-400 mt-1">
                                    Data contoh untuk tampilan front-end.
                                </p>

                            </div>


                            <button type="button"
                                    onclick="showDemoNotice()"
                                    class="w-10 h-10
                                           rounded-xl
                                           bg-[#EDF5F2]
                                           text-[#438F83]
                                           hover:bg-[#DCEFEB]
                                           flex items-center
                                           justify-center">

                                <i data-lucide="plus"
                                   class="w-5 h-5"></i>

                            </button>

                        </div>


                        <div class="mt-6 space-y-3">

                            {{-- ITEM --}}
                            <div class="border border-stone-100
                                        rounded-2xl p-4
                                        flex items-center gap-3 sm:gap-4 min-w-0">

                                <span class="w-11 h-11
                                             bg-[#EDF5F2]
                                             rounded-xl
                                             text-[#438F83]
                                             flex items-center
                                             justify-center">

                                    <i data-lucide="activity"
                                       class="w-5 h-5"></i>

                                </span>

                                <div class="flex-1 min-w-0">

                                    <p class="font-semibold">
                                        Pemeriksaan Bulanan
                                    </p>

                                    <p class="text-xs
                                              text-gray-400 mt-1">
                                        Berat 9.5 kg • Tinggi 82 cm
                                    </p>

                                </div>

                                <span class="text-[10px] sm:text-xs text-gray-400 shrink-0 text-right">
                                    Bulan ini
                                </span>

                            </div>


                            {{-- ITEM --}}
                            <div class="border border-stone-100
                                        rounded-2xl p-4
                                        flex items-center gap-3 sm:gap-4 min-w-0">

                                <span class="w-11 h-11
                                             bg-[#F7EFE3]
                                             rounded-xl
                                             text-[#B58A45]
                                             flex items-center
                                             justify-center">

                                    <i data-lucide="scale"
                                       class="w-5 h-5"></i>

                                </span>

                                <div class="flex-1 min-w-0">

                                    <p class="font-semibold">
                                        Pengukuran Rutin
                                    </p>

                                    <p class="text-xs
                                              text-gray-400 mt-1">
                                        Berat 9.2 kg • Tinggi 81 cm
                                    </p>

                                </div>

                                <span class="text-[10px] sm:text-xs text-gray-400 shrink-0 text-right">
                                    1 bulan lalu
                                </span>

                            </div>


                            {{-- ITEM --}}
                            <div class="border border-stone-100
                                        rounded-2xl p-4
                                        flex items-center gap-3 sm:gap-4 min-w-0">

                                <span class="w-11 h-11
                                             bg-[#E9EFF8]
                                             rounded-xl
                                             text-[#6883A8]
                                             flex items-center
                                             justify-center">

                                    <i data-lucide="ruler"
                                       class="w-5 h-5"></i>

                                </span>

                                <div class="flex-1 min-w-0">

                                    <p class="font-semibold">
                                        Pengukuran Rutin
                                    </p>

                                    <p class="text-xs
                                              text-gray-400 mt-1">
                                        Berat 8.9 kg • Tinggi 80 cm
                                    </p>

                                </div>

                                <span class="text-[10px] sm:text-xs text-gray-400 shrink-0 text-right">
                                    2 bulan lalu
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- RIGHT --}}
                <div class="space-y-6">


                    {{-- ASSESSMENT --}}
                    <div class="bg-[#234D48]
                                text-white
                                rounded-[26px] p-6">

                        <span class="w-12 h-12
                                     rounded-2xl
                                     bg-white/10
                                     flex items-center
                                     justify-center">

                            <i data-lucide="sparkles"
                               class="w-6 h-6"></i>

                        </span>

                        <h3 class="text-xl font-bold mt-5">
                            Assessment Pertumbuhan
                        </h3>

                        <p class="text-sm
                                  text-white/70
                                  leading-relaxed mt-2">

                            Lihat ringkasan kondisi
                            pertumbuhan dan nutrisi
                            {{ $child->name }}.

                        </p>


                        <div class="bg-white/10
                                    rounded-2xl p-4 mt-5">

                            <div class="flex
                                        justify-between
                                        text-sm">

                                <span class="text-white/70">
                                    Pertumbuhan
                                </span>

                                <span class="font-semibold">
                                    Optimal
                                </span>

                            </div>


                            <div class="flex
                                        justify-between
                                        text-sm mt-3">

                                <span class="text-white/70">
                                    Nutrisi
                                </span>

                                <span class="font-semibold">
                                    Baik
                                </span>

                            </div>


                            <div class="flex
                                        justify-between
                                        text-sm mt-3">

                                <span class="text-white/70">
                                    Aktivitas
                                </span>

                                <span class="font-semibold">
                                    Normal
                                </span>

                            </div>

                        </div>


                        <button type="button"
                                onclick="showDemoNotice()"
                                class="w-full mt-5
                                       bg-white
                                       hover:bg-white/90
                                       text-[#234D48]
                                       rounded-xl py-3
                                       font-semibold transition">

                            Lihat Assessment

                        </button>

                    </div>


                    {{-- DOKTER --}}
                    <div class="bg-white
                                rounded-[26px]
                                border border-stone-100 p-4 sm:p-6">

                        <div class="flex items-center gap-3">

                            <span class="w-11 h-11
                                         rounded-xl
                                         bg-[#EDF5F2]
                                         text-[#438F83]
                                         flex items-center
                                         justify-center">

                                <i data-lucide="stethoscope"
                                   class="w-5 h-5"></i>

                            </span>

                            <div>

                                <p class="text-xs text-gray-400">
                                    Pendamping Kesehatan
                                </p>

                                <h3 class="font-bold">
                                    dr. Maya Putri, Sp.A
                                </h3>

                            </div>

                        </div>


                        <div class="border-t
                                    border-stone-100
                                    mt-5 pt-5">

                            <p class="text-sm
                                      text-gray-400
                                      leading-relaxed">

                                Konsultasikan pertanyaan
                                seputar tumbuh kembang
                                dan kebutuhan nutrisi anak.

                            </p>


                            <a href="{{ route('ai.chat') }}"
                               class="mt-4 w-full
                                      inline-flex
                                      items-center
                                      justify-center gap-2
                                      bg-[#EDF5F2]
                                      hover:bg-[#DCEFEB]
                                      text-[#438F83]
                                      rounded-xl py-3
                                      font-semibold transition">

                                <i data-lucide="message-circle"
                                   class="w-4 h-4"></i>

                                Konsultasi

                            </a>

                        </div>

                    </div>


                    {{-- QUICK ACTION --}}
                    <div class="bg-white
                                rounded-[26px]
                                border border-stone-100 p-4 sm:p-6">

                        <h3 class="font-bold">
                            Aksi Cepat
                        </h3>


                        <div class="space-y-2 mt-4">

                            <a href="{{ route('nutrition') }}"
                               class="flex items-center
                                      justify-between
                                      rounded-xl p-3
                                      hover:bg-[#F8F7F2]
                                      transition">

                                <span class="flex
                                             items-center gap-3">

                                    <i data-lucide="clipboard-list"
                                       class="w-5 h-5
                                              text-[#438F83]">
                                    </i>

                                    <span class="text-sm font-medium">
                                        Catat Nutrisi
                                    </span>

                                </span>

                                <i data-lucide="chevron-right"
                                   class="w-4 h-4
                                          text-gray-300">
                                </i>

                            </a>


                            <a href="{{ route('food.scan') }}"
                               class="flex items-center
                                      justify-between
                                      rounded-xl p-3
                                      hover:bg-[#F8F7F2]
                                      transition">

                                <span class="flex
                                             items-center gap-3">

                                    <i data-lucide="scan-line"
                                       class="w-5 h-5
                                              text-[#438F83]">
                                    </i>

                                    <span class="text-sm font-medium">
                                        Scan Makanan
                                    </span>

                                </span>

                                <i data-lucide="chevron-right"
                                   class="w-4 h-4
                                          text-gray-300">
                                </i>

                            </a>


                            <a href="{{ route('ai.chat') }}"
                               class="flex items-center
                                      justify-between
                                      rounded-xl p-3
                                      hover:bg-[#F8F7F2]
                                      transition">

                                <span class="flex
                                             items-center gap-3">

                                    <i data-lucide="message-circle"
                                       class="w-5 h-5
                                              text-[#438F83]">
                                    </i>

                                    <span class="text-sm font-medium">
                                        Tanya NutriBot
                                    </span>

                                </span>

                                <i data-lucide="chevron-right"
                                   class="w-4 h-4
                                          text-gray-300">
                                </i>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

</div>


{{-- ================= MOBILE BOTTOM NAVIGATION ================= --}}
<nav class="lg:hidden fixed bottom-3 left-3 right-3 z-40 rounded-[26px]
            bg-white/95 backdrop-blur-xl border border-white/80
            shadow-[0_14px_40px_rgba(46,88,80,0.18)] px-2 pt-2.5
            pb-[max(0.65rem,env(safe-area-inset-bottom))]">
    <div class="max-w-md mx-auto grid grid-cols-6 items-end">

        <a href="{{ route('dashboard') }}" class="group flex flex-col items-center gap-1.5 min-w-0 text-gray-400 hover:text-[#438F83] transition active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center group-hover:bg-[#EEF7F5]"><i data-lucide="house" class="w-[19px] h-[19px]"></i></span>
            <span class="text-[9px] sm:text-[10px] truncate w-full text-center">Beranda</span>
        </a>

        <a href="{{ route('nutrition') }}" class="group flex flex-col items-center gap-1.5 min-w-0 text-gray-400 hover:text-[#438F83] transition active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center group-hover:bg-[#EEF7F5]"><i data-lucide="clipboard-list" class="w-[19px] h-[19px]"></i></span>
            <span class="text-[9px] sm:text-[10px] truncate w-full text-center">Nutrisi</span>
        </a>

        <a href="{{ route('food.scan') }}" class="group flex flex-col items-center gap-1.5 min-w-0 text-gray-400 hover:text-[#438F83] transition active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center group-hover:bg-[#EEF7F5]"><i data-lucide="scan-line" class="w-[19px] h-[19px]"></i></span>
            <span class="text-[9px] sm:text-[10px] truncate w-full text-center">Scan</span>
        </a>

        <a href="{{ route('ai.chat') }}" class="group flex flex-col items-center gap-1.5 min-w-0 text-gray-400 hover:text-[#438F83] transition active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center group-hover:bg-[#EEF7F5]"><i data-lucide="message-circle" class="w-[19px] h-[19px]"></i></span>
            <span class="text-[9px] sm:text-[10px] truncate w-full text-center">Tanya AI</span>
        </a>

        {{-- DATA ANAK ACTIVE --}}
        <a href="{{ route('children.index') }}" class="group relative flex flex-col items-center gap-1.5 min-w-0 text-[#438F83] transition active:scale-90">
            <span class="absolute -top-2 w-7 h-1 rounded-full bg-[#4B988D] shadow-[0_2px_10px_rgba(75,152,141,0.45)]"></span>
            <span class="relative -mt-1 w-11 h-11 rounded-2xl
                         bg-gradient-to-br from-[#DDF1ED] to-[#CFE8E3]
                         ring-1 ring-[#BFDCD6] shadow-[0_8px_18px_rgba(75,152,141,0.20)]
                         flex items-center justify-center">
                <i data-lucide="baby" class="w-5 h-5"></i>
                <span class="absolute -right-0.5 -top-0.5 w-2.5 h-2.5 rounded-full bg-[#4B988D] border-2 border-white"></span>
            </span>
            <span class="text-[9px] sm:text-[10px] font-bold truncate w-full text-center">Anak</span>
        </a>

        <a href="{{ route('profile.edit') }}" class="group flex flex-col items-center gap-1.5 min-w-0 text-gray-400 hover:text-[#438F83] transition active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center group-hover:bg-[#EEF7F5]"><i data-lucide="user-round" class="w-[19px] h-[19px]"></i></span>
            <span class="text-[9px] sm:text-[10px] truncate w-full text-center">Profil</span>
        </a>

    </div>
</nav>

<script>
    lucide.createIcons();

    const ctx = document.getElementById('growthChart');

    if (ctx) {

        new Chart(ctx, {
            type: 'line',

            data: {
                labels: [
                    'Apr',
                    'Mei',
                    'Jun',
                    'Jul',
                    'Agu',
                    'Sep'
                ],

                datasets: [{
                    label: 'Berat Badan',

                    data: [
                        8.1,
                        8.4,
                        8.7,
                        8.9,
                        9.2,
                        9.5
                    ],

                    borderColor: '#4B988D',
                    backgroundColor: 'rgba(75, 152, 141, 0.10)',

                    borderWidth: 3,
                    tension: 0.4,

                    pointRadius: 4,
                    pointHoverRadius: 6,

                    pointBackgroundColor: '#4B988D',

                    fill: true
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {
                    x: {
                        grid: {
                            display: false
                        },

                        border: {
                            display: false
                        }
                    },

                    y: {
                        beginAtZero: false,

                        suggestedMin: 7,
                        suggestedMax: 11,

                        grid: {
                            color: '#F0EFEA'
                        },

                        border: {
                            display: false
                        },

                        ticks: {
                            callback: function(value) {
                                return value + ' kg';
                            }
                        }
                    }
                }
            }
        });

    }


    function showDemoNotice() {

        alert(
            'Fitur ini masih berupa demo front-end GrowCare.'
        );

    }
</script>

</body>
</html>