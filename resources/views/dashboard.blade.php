<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - GrowCare</title>

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

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-2">

            <span class="w-9 h-9 rounded-full
                         bg-[#E0F0EB] text-[#438F83]
                         flex items-center justify-center">

                <i data-lucide="sprout" class="w-5 h-5"></i>

            </span>

            <span class="text-xl font-bold">
                <span class="text-[#438F83]">Grow</span>Care
            </span>

        </a>

        <a href="{{ route('profile.edit') }}"
           class="w-10 h-10 rounded-full
                  bg-[#DDF1EE] text-[#438F83]
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

            <div class="w-10 h-10 rounded-full
                        bg-[#E0F0EB] text-[#438F83]
                        flex items-center justify-center">

                <i data-lucide="sprout" class="w-5 h-5"></i>

            </div>

            <div class="ml-3 text-2xl font-bold">
                <span class="text-[#438F83]">Grow</span>Care
            </div>

        </div>


        {{-- MENU --}}
        <div class="px-5">

            <p class="px-4 mb-4 text-xs
                      tracking-[0.2em]
                      text-gray-400 font-semibold">
                MENU
            </p>

            <nav class="space-y-2">

                {{-- BERANDA ACTIVE --}}
                <a href="{{ route('dashboard') }}"
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

                        <i data-lucide="house"
                           class="w-5 h-5"></i>

                    </span>

                    Beranda

                </a>


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
    <main class="w-full min-w-0 lg:ml-[285px] pt-16 lg:pt-0 pb-24 lg:pb-0">

        <div class="max-w-[1450px] mx-auto
                    w-full min-w-0
                    px-4 sm:px-5 md:px-8 lg:px-10
                    py-5 sm:py-8">


            {{-- HEADER --}}
            <div class="flex items-center
                        justify-between gap-3 sm:gap-5 mb-6">

                <div class="flex items-center gap-4">

                    <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-full
                                bg-[#DDF1EE]
                                border-4 border-white
                                shadow-sm
                                flex items-center justify-center">

                        <i data-lucide="user-round"
                           class="w-6 h-6 text-[#438F83]"></i>

                    </div>


                    <div>

                        <p class="text-sm text-gray-500">
                            Halo,
                        </p>

                        <h1 class="font-bold text-lg sm:text-xl truncate max-w-[160px] sm:max-w-none">
                            {{ Auth::user()->name }}
                        </h1>

                    </div>

                </div>


                <div class="flex items-center gap-3">

                    <div class="hidden md:flex
                                items-center gap-2
                                bg-white rounded-full
                                px-5 py-3
                                border border-stone-200
                                shadow-sm">

                        <i data-lucide="search"
                           class="w-4 h-4 text-gray-400"></i>

                        <input type="text"
                               placeholder="Cari..."
                               class="border-0 p-0
                                      w-28 focus:ring-0
                                      bg-transparent text-sm">

                    </div>


                    <button type="button"
                            class="w-11 h-11
                                   bg-white border
                                   border-stone-200
                                   rounded-full
                                   flex items-center
                                   justify-center shadow-sm">

                        <i data-lucide="bell"
                           class="w-5 h-5"></i>

                    </button>

                </div>

            </div>



            {{-- ================= PILIH ANAK ================= --}}
            <div class="flex gap-3
                        overflow-x-auto
                        pb-3 mb-2">

                @forelse($children as $child)

                    <a href="{{ route('children.show', $child) }}"
                       class="flex-shrink-0
                              flex items-center gap-3
                              {{ $selectedChild && $selectedChild->id === $child->id
                                  ? 'bg-[#4B988D] text-white'
                                  : 'bg-white text-gray-700 border border-stone-100' }}
                              rounded-full py-2 pl-2 pr-5
                              transition">

                        <span class="w-10 h-10
                                     bg-white rounded-full
                                     flex items-center
                                     justify-center text-xl">

                            {{ $child->gender === 'P' ? '👧' : '👦' }}

                        </span>


                        <span class="font-semibold">
                            {{ $child->name }}
                        </span>


                        <span class="text-sm
                                     {{ $selectedChild && $selectedChild->id === $child->id
                                         ? 'text-white/70'
                                         : 'text-gray-400' }}">

                            {{ \Carbon\Carbon::parse($child->birth_date)
                                ->diffInMonths(now()) }} bln

                        </span>

                    </a>

                @empty

                    <div class="flex items-center gap-2
                                text-gray-400
                                bg-white rounded-full
                                px-5 py-3">

                        <i data-lucide="baby"
                           class="w-4 h-4"></i>

                        Belum ada data anak

                    </div>

                @endforelse


                <a href="{{ route('children.create') }}"
                   class="flex-shrink-0
                          flex items-center gap-2
                          border border-dashed
                          border-gray-300
                          rounded-full
                          px-5 py-3
                          text-gray-400
                          hover:border-[#4B988D]
                          hover:text-[#438F83]
                          transition">

                    <i data-lucide="plus"
                       class="w-4 h-4"></i>

                    Tambah

                </a>

            </div>



            @if($selectedChild)

                {{-- CHILD INFO --}}
                <div class="flex items-center
                            justify-between gap-3 mt-3 mb-5">

                    <div>

                        <p class="text-sm text-gray-400">
                            Sedang melihat
                        </p>

                        <h2 class="text-xl font-bold">
                            {{ $selectedChild->name }}
                        </h2>

                    </div>


                    <a href="{{ route('children.show', $selectedChild) }}"
                       class="text-sm font-semibold
                              text-[#438F83]
                              flex items-center gap-1">

                        Profil lengkap

                        <i data-lucide="arrow-up-right"
                           class="w-4 h-4"></i>

                    </a>

                </div>



                {{-- ================= CARD UTAMA ================= --}}
                <div class="grid grid-cols-1
                            xl:grid-cols-12 gap-5">


                    {{-- TUMBUH --}}
                    <div class="xl:col-span-5
                                bg-gradient-to-br
                                from-[#D5F1E8]
                                to-[#C5E8D7]
                                rounded-[28px]
                                p-5 sm:p-7
                                border border-[#B9DED1]">

                        <div class="flex
                                    justify-between items-start gap-4 sm:gap-6">

                            <div>

                                <span class="inline-flex
                                             items-center gap-2
                                             bg-white/70
                                             text-[#438F83]
                                             rounded-full
                                             px-3 py-1
                                             text-xs font-semibold">

                                    <i data-lucide="trending-up"
                                       class="w-3 h-3"></i>

                                    DEMO

                                </span>


                                <h2 class="text-4xl sm:text-5xl
                                           font-bold mt-4">
                                    85%
                                </h2>

                                <p class="text-gray-600 mt-1">
                                    Tumbuh Optimal
                                </p>

                            </div>


                            <div class="w-20 h-20 sm:w-24 sm:h-24
                                        shrink-0 rounded-full
                                        border-[7px]
                                        border-[#4B988D]
                                        flex items-center
                                        justify-center
                                        bg-white/30">

                                <div class="text-center">

                                    <p class="font-bold text-lg">
                                        85%
                                    </p>

                                    <p class="text-[10px]
                                              text-gray-500">
                                        status
                                    </p>

                                </div>

                            </div>

                        </div>


                        <a href="{{ route('children.show', $selectedChild) }}"
                           class="mt-6 w-full
                                  bg-white/75
                                  rounded-full py-3
                                  flex items-center
                                  justify-center gap-2
                                  text-[#438F83]
                                  font-semibold">

                            Lihat Detail

                            <i data-lucide="chevron-right"
                               class="w-4 h-4"></i>

                        </a>

                    </div>



                    {{-- BERAT LAHIR --}}
                    <div class="xl:col-span-2
                                bg-white rounded-[28px]
                                p-6 border
                                border-stone-100
                                shadow-sm">

                        <div class="flex justify-between">

                            <span class="w-10 h-10
                                         rounded-full
                                         bg-[#E7F5F2]
                                         text-[#438F83]
                                         flex items-center
                                         justify-center">

                                <i data-lucide="weight"
                                   class="w-5 h-5"></i>

                            </span>


                            <span class="text-xs
                                         bg-green-50
                                         text-green-700
                                         rounded-full
                                         px-2 py-1 h-fit">

                                Data lahir

                            </span>

                        </div>


                        <p class="text-xs
                                  text-gray-500
                                  mt-5 tracking-wide">

                            BERAT LAHIR

                        </p>


                        <h3 class="text-3xl
                                   font-bold mt-1">

                            @if($selectedChild->birth_weight)

                                {{ $selectedChild->birth_weight }}

                                <span class="text-base
                                             font-normal ml-1">
                                    kg
                                </span>

                            @else

                                <span class="text-gray-300">
                                    -
                                </span>

                            @endif

                        </h3>


                        <div class="flex items-end
                                    gap-1.5 mt-7 h-8">

                            <span class="h-2 w-full
                                         bg-[#DDEBE8]
                                         rounded-full"></span>

                            <span class="h-3 w-full
                                         bg-[#BFD9D4]
                                         rounded-full"></span>

                            <span class="h-4 w-full
                                         bg-[#9BC7BF]
                                         rounded-full"></span>

                            <span class="h-5 w-full
                                         bg-[#72ADA3]
                                         rounded-full"></span>

                            <span class="h-7 w-full
                                         bg-[#4B988D]
                                         rounded-full"></span>

                        </div>

                    </div>



                    {{-- TINGGI LAHIR --}}
                    <div class="xl:col-span-2
                                bg-white rounded-[28px]
                                p-6 border
                                border-stone-100
                                shadow-sm">

                        <div class="flex justify-between">

                            <span class="w-10 h-10
                                         rounded-full
                                         bg-[#FBF4E8]
                                         text-[#C49B50]
                                         flex items-center
                                         justify-center">

                                <i data-lucide="ruler"
                                   class="w-5 h-5"></i>

                            </span>


                            <span class="text-xs
                                         bg-amber-50
                                         text-amber-700
                                         rounded-full
                                         px-2 py-1 h-fit">

                                Data lahir

                            </span>

                        </div>


                        <p class="text-xs
                                  text-gray-500 mt-5">

                            TINGGI LAHIR

                        </p>


                        <h3 class="text-3xl
                                   font-bold mt-1">

                            @if($selectedChild->birth_height)

                                {{ $selectedChild->birth_height }}

                                <span class="text-base
                                             font-normal ml-1">
                                    cm
                                </span>

                            @else

                                <span class="text-gray-300">
                                    -
                                </span>

                            @endif

                        </h3>


                        <div class="flex items-end
                                    gap-1.5 mt-7 h-8">

                            <span class="h-2 w-full
                                         bg-[#F4ECDC]
                                         rounded-full"></span>

                            <span class="h-3 w-full
                                         bg-[#EADBBE]
                                         rounded-full"></span>

                            <span class="h-4 w-full
                                         bg-[#DFC995]
                                         rounded-full"></span>

                            <span class="h-5 w-full
                                         bg-[#D5B96E]
                                         rounded-full"></span>

                            <span class="h-7 w-full
                                         bg-[#C8A14C]
                                         rounded-full"></span>

                        </div>

                    </div>



                    {{-- NUTRISI --}}
                    <div class="xl:col-span-3
                                bg-white rounded-[28px]
                                p-6 border
                                border-stone-100
                                shadow-sm">

                        <div class="flex items-center
                                    justify-between">

                            <div class="flex
                                        items-center gap-3">

                                <span class="w-10 h-10
                                             rounded-full
                                             bg-[#E7F5F2]
                                             text-[#438F83]
                                             flex items-center
                                             justify-center">

                                    <i data-lucide="utensils"
                                       class="w-5 h-5"></i>

                                </span>

                                <span class="text-xs
                                             text-gray-500">
                                    NUTRISI
                                </span>

                            </div>


                            <a href="{{ route('nutrition') }}"
                               class="w-8 h-8
                                      rounded-full
                                      bg-[#4B988D]
                                      text-white
                                      flex items-center
                                      justify-center">

                                <i data-lucide="plus"
                                   class="w-4 h-4"></i>

                            </a>

                        </div>


                        <div class="flex
                                    justify-between mt-5">

                            <span class="font-bold">
                                520
                            </span>

                            <span class="text-sm
                                         text-gray-500">
                                /850 kkal
                            </span>

                        </div>


                        <div class="h-2 bg-gray-100
                                    rounded-full mt-2
                                    overflow-hidden">

                            <div class="w-[61%]
                                        h-full
                                        bg-[#4B988D]
                                        rounded-full">
                            </div>

                        </div>


                        <div class="grid grid-cols-3
                                    mt-6 text-center">

                            <div>

                                <span class="block w-2 h-2
                                             bg-[#4B988D]
                                             rounded-full mx-auto">
                                </span>

                                <strong class="block
                                               mt-2 text-xs">
                                    18g
                                </strong>

                                <span class="text-[10px]
                                             text-gray-400">
                                    Protein
                                </span>

                            </div>


                            <div>

                                <span class="block w-2 h-2
                                             bg-[#7FAF70]
                                             rounded-full mx-auto">
                                </span>

                                <strong class="block
                                               mt-2 text-xs">
                                    15g
                                </strong>

                                <span class="text-[10px]
                                             text-gray-400">
                                    Lemak
                                </span>

                            </div>


                            <div>

                                <span class="block w-2 h-2
                                             bg-[#C9A454]
                                             rounded-full mx-auto">
                                </span>

                                <strong class="block
                                               mt-2 text-xs">
                                    62g
                                </strong>

                                <span class="text-[10px]
                                             text-gray-400">
                                    Karbo
                                </span>

                            </div>

                        </div>


                        <p class="text-[10px]
                                  text-gray-400 mt-5">
                            * Data nutrisi masih tampilan demo.
                        </p>

                    </div>

                </div>



                {{-- ================= STATISTIK ================= --}}
                <div class="grid grid-cols-1
                            sm:grid-cols-2
                            lg:grid-cols-4
                            gap-4 mt-5">

                    <div class="bg-[#F0F5F2]
                                border border-[#DFE9E4]
                                rounded-2xl p-5">

                        <p class="text-sm text-gray-600">
                            Usia Anak
                        </p>

                        <h3 class="text-2xl font-bold mt-1">

                            {{ \Carbon\Carbon::parse($selectedChild->birth_date)
                                ->diffInMonths(now()) }}

                        </h3>

                        <p class="text-xs text-gray-400">
                            bulan
                        </p>

                    </div>


                    <div class="bg-[#F2F5EC]
                                border border-[#E3E8DA]
                                rounded-2xl p-5">

                        <p class="text-sm text-gray-600">
                            Jenis Kelamin
                        </p>

                        <h3 class="text-xl font-bold mt-1">

                            {{ $selectedChild->gender === 'L'
                                ? 'Laki-laki'
                                : 'Perempuan' }}

                        </h3>

                        <p class="text-xs text-gray-400">
                            profil anak
                        </p>

                    </div>


                    <div class="bg-[#F8F3EA]
                                border border-[#EEE5D7]
                                rounded-2xl p-5">

                        <p class="text-sm text-gray-600">
                            Nutrisi Hari Ini
                        </p>

                        <h3 class="text-2xl font-bold mt-1">
                            61%
                        </h3>

                        <p class="text-xs text-gray-400">
                            demo
                        </p>

                    </div>


                    <div class="bg-[#F8F2E7]
                                border border-[#ECE2D2]
                                rounded-2xl p-5">

                        <p class="text-sm text-gray-600">
                            Status Pertumbuhan
                        </p>

                        <h3 class="text-xl font-bold mt-1">
                            Optimal
                        </h3>

                        <p class="text-xs text-gray-400">
                            demo
                        </p>

                    </div>

                </div>



                {{-- ================= ASSESSMENT ================= --}}
                <a href="{{ route('children.show', $selectedChild) }}"
                   class="mt-5 bg-white
                          rounded-2xl
                          border border-stone-100
                          shadow-sm p-5
                          flex items-center
                          justify-between
                          hover:border-[#4B988D]
                          transition">

                    <div class="flex items-center gap-3 sm:gap-4 min-w-0">

                        <span class="w-11 h-11 sm:w-12 sm:h-12 shrink-0
                                     rounded-full
                                     bg-[#4B988D]
                                     text-white
                                     flex items-center
                                     justify-center">

                            <i data-lucide="calendar-days"
                               class="w-5 h-5"></i>

                        </span>


                        <div>

                            <h3 class="font-semibold">
                                Lihat Perkembangan
                                {{ $selectedChild->name }}
                            </h3>

                            <p class="text-sm text-gray-500">
                                Pantau profil dan tumbuh kembang anak.
                            </p>

                        </div>

                    </div>


                    <i data-lucide="chevron-right"
                       class="w-5 h-5 text-gray-400"></i>

                </a>



                {{-- ================= BOTTOM ================= --}}
                <div class="grid grid-cols-1
                            xl:grid-cols-2
                            gap-5 mt-6">


                    {{-- PENGINGAT --}}
                    <div class="bg-white
                                rounded-[28px]
                                border border-stone-100
                                p-5 sm:p-7 shadow-sm">

                        <div class="flex
                                    justify-between
                                    items-start">

                            <div>

                                <h2 class="text-2xl font-bold">
                                    Pengingat
                                </h2>

                                <p class="text-gray-500
                                          text-sm mt-1">
                                    Tugas & jadwal yang perlu perhatian
                                </p>

                            </div>

                            <button type="button"
                                    class="text-[#438F83]
                                           text-sm font-semibold">
                                Lihat semua →
                            </button>

                        </div>


                        <div class="mt-7
                                    flex items-center gap-4
                                    border-t
                                    border-stone-100 pt-5">

                            <span class="w-11 h-11
                                         rounded-full
                                         bg-green-50
                                         text-green-500
                                         flex items-center
                                         justify-center">

                                <i data-lucide="calendar-check"
                                   class="w-5 h-5"></i>

                            </span>


                            <div class="flex-1">

                                <h3 class="font-semibold">
                                    Assessment Bulan Ini
                                </h3>

                                <p class="text-sm text-gray-400">
                                    Lengkapi pemantauan
                                    {{ $selectedChild->name }}
                                </p>

                            </div>


                            <span class="text-xs
                                         bg-gray-100
                                         rounded-full
                                         px-3 py-1">

                                Hari ini

                            </span>

                        </div>

                    </div>



                    {{-- AKTIVITAS --}}
                    <div class="bg-white
                                rounded-[28px]
                                border border-stone-100
                                p-5 sm:p-7 shadow-sm">

                        <div class="flex items-center
                                    justify-between">

                            <div>

                                <h2 class="text-2xl font-bold">
                                    Aktivitas
                                </h2>

                                <p class="text-gray-500
                                          text-sm mt-1">
                                    Aktivitas terbaru untuk
                                    {{ $selectedChild->name }}.
                                </p>

                            </div>


                            <a href="{{ route('children.show', $selectedChild) }}"
                               class="w-10 h-10
                                      rounded-full
                                      border border-gray-200
                                      flex items-center
                                      justify-center
                                      text-[#438F83]">

                                <i data-lucide="arrow-up-right"
                                   class="w-5 h-5"></i>

                            </a>

                        </div>


                        <div class="mt-7
                                    flex gap-4
                                    items-center
                                    border-t
                                    border-stone-100 pt-5">

                            <span class="w-11 h-11
                                         rounded-full
                                         bg-[#E7F5F2]
                                         text-[#438F83]
                                         flex items-center
                                         justify-center">

                                <i data-lucide="activity"
                                   class="w-5 h-5"></i>

                            </span>


                            <div>

                                <h3 class="font-semibold">
                                    Profil Anak Tersedia
                                </h3>

                                <p class="text-sm text-gray-400">

                                    {{ $selectedChild->name }}
                                    berusia
                                    {{ \Carbon\Carbon::parse($selectedChild->birth_date)
                                        ->diffInMonths(now()) }}
                                    bulan

                                </p>

                            </div>

                        </div>

                    </div>

                </div>


            @else

                {{-- ================= BELUM ADA ANAK ================= --}}
                <div class="bg-white
                            border border-stone-100
                            rounded-[30px]
                            min-h-[450px]
                            flex items-center
                            justify-center
                            mt-5">

                    <div class="text-center
                                max-w-md px-6">

                        <div class="w-24 h-24
                                    mx-auto
                                    rounded-[30px]
                                    bg-[#E5F3EF]
                                    flex items-center
                                    justify-center">

                            <i data-lucide="baby"
                               class="w-11 h-11
                                      text-[#438F83]"></i>

                        </div>


                        <h2 class="text-2xl
                                   font-bold mt-6">

                            Belum Ada Data Anak

                        </h2>


                        <p class="text-gray-400
                                  mt-2 leading-relaxed">

                            Tambahkan profil anak untuk mulai
                            melihat informasi tumbuh kembang
                            di dashboard GrowCare.

                        </p>


                        <a href="{{ route('children.create') }}"
                           class="inline-flex
                                  items-center gap-2
                                  bg-[#4B988D]
                                  hover:bg-[#3E8379]
                                  text-white
                                  px-6 py-3
                                  rounded-xl
                                  font-semibold mt-6
                                  transition">

                            <i data-lucide="plus"
                               class="w-5 h-5"></i>

                            Tambah Anak

                        </a>

                    </div>

                </div>

            @endif

        </div>

    </main>

</div>


{{-- ================= MOBILE BOTTOM NAVIGATION ================= --}}
<nav class="lg:hidden fixed bottom-3 left-3 right-3 z-50
            rounded-[26px]
            bg-white/95 backdrop-blur-xl
            border border-white/80
            shadow-[0_14px_40px_rgba(46,88,80,0.18)]
            px-2 pt-2.5
            pb-[max(0.65rem,env(safe-area-inset-bottom))]">

    <div class="max-w-md mx-auto grid grid-cols-6 items-end">

        {{-- BERANDA ACTIVE --}}
        <a href="{{ route('dashboard') }}"
           class="group relative flex flex-col items-center justify-center
                  gap-1.5 min-w-0 text-[#438F83]
                  transition duration-200 active:scale-90">

            <span class="absolute -top-2 w-7 h-1
                         rounded-full bg-[#4B988D]
                         shadow-[0_2px_10px_rgba(75,152,141,0.45)]"></span>

            <span class="relative -mt-1 w-11 h-11 rounded-2xl
                         bg-gradient-to-br from-[#DDF1ED] to-[#CFE8E3]
                         ring-1 ring-[#BFDCD6]
                         shadow-[0_8px_18px_rgba(75,152,141,0.20)]
                         flex items-center justify-center
                         transition duration-200
                         group-hover:-translate-y-0.5">

                <i data-lucide="house" class="w-5 h-5"></i>

                <span class="absolute -right-0.5 -top-0.5
                             w-2.5 h-2.5 rounded-full
                             bg-[#4B988D] border-2 border-white"></span>
            </span>

            <span class="text-[9px] sm:text-[10px] font-bold
                         truncate w-full text-center">
                Beranda
            </span>
        </a>


        {{-- NUTRISI --}}
        <a href="{{ route('nutrition') }}"
           class="group flex flex-col items-center justify-center
                  gap-1.5 min-w-0 text-gray-400
                  hover:text-[#438F83]
                  transition duration-200 active:scale-90">

            <span class="w-10 h-10 rounded-2xl
                         flex items-center justify-center
                         group-hover:bg-[#EEF7F5]
                         transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="clipboard-list" class="w-[19px] h-[19px]"></i>
            </span>

            <span class="text-[9px] sm:text-[10px] font-medium
                         truncate w-full text-center">
                Nutrisi
            </span>
        </a>


        {{-- FOOD SCAN --}}
        <a href="{{ route('food.scan') }}"
           class="group flex flex-col items-center justify-center
                  gap-1.5 min-w-0 text-gray-400
                  hover:text-[#438F83]
                  transition duration-200 active:scale-90">

            <span class="w-10 h-10 rounded-2xl
                         flex items-center justify-center
                         group-hover:bg-[#EEF7F5]
                         transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="scan-line" class="w-[19px] h-[19px]"></i>
            </span>

            <span class="text-[9px] sm:text-[10px] font-medium
                         truncate w-full text-center">
                Scan
            </span>
        </a>


        {{-- TANYA AI --}}
        <a href="{{ route('ai.chat') }}"
           class="group flex flex-col items-center justify-center
                  gap-1.5 min-w-0 text-gray-400
                  hover:text-[#438F83]
                  transition duration-200 active:scale-90">

            <span class="w-10 h-10 rounded-2xl
                         flex items-center justify-center
                         group-hover:bg-[#EEF7F5]
                         transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="message-circle" class="w-[19px] h-[19px]"></i>
            </span>

            <span class="text-[9px] sm:text-[10px] font-medium
                         truncate w-full text-center">
                Tanya AI
            </span>
        </a>


        {{-- DATA ANAK --}}
        <a href="{{ route('children.index') }}"
           class="group flex flex-col items-center justify-center
                  gap-1.5 min-w-0 text-gray-400
                  hover:text-[#438F83]
                  transition duration-200 active:scale-90">

            <span class="w-10 h-10 rounded-2xl
                         flex items-center justify-center
                         group-hover:bg-[#EEF7F5]
                         transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="baby" class="w-[19px] h-[19px]"></i>
            </span>

            <span class="text-[9px] sm:text-[10px] font-medium
                         truncate w-full text-center">
                Anak
            </span>
        </a>


        {{-- PROFIL --}}
        <a href="{{ route('profile.edit') }}"
           class="group flex flex-col items-center justify-center
                  gap-1.5 min-w-0 text-gray-400
                  hover:text-[#438F83]
                  transition duration-200 active:scale-90">

            <span class="w-10 h-10 rounded-2xl
                         flex items-center justify-center
                         group-hover:bg-[#EEF7F5]
                         transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="user-round" class="w-[19px] h-[19px]"></i>
            </span>

            <span class="text-[9px] sm:text-[10px] font-medium
                         truncate w-full text-center">
                Profil
            </span>
        </a>

    </div>

</nav>

<script>
    lucide.createIcons();
</script>

</body>
</html>