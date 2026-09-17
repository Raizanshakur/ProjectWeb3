<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Anak - GrowCare</title>

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

        <div class="max-w-[1400px]
                    mx-auto w-full min-w-0
                    px-4 sm:px-5 md:px-8 lg:px-10
                    py-5 sm:py-8">


            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row
                        md:items-center
                        justify-between gap-5">

                <div>

                    <p class="text-xs
                              tracking-[0.18em]
                              text-[#4B988D]
                              font-semibold">
                        TUMBUH KEMBANG
                    </p>

                    <h1 class="text-2xl sm:text-3xl font-bold mt-2">
                        Data Anak
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Kelola profil dan pantau perkembangan si kecil.
                    </p>

                </div>


                <a href="{{ route('children.create') }}"
                   class="w-full sm:w-auto flex items-center
                          justify-center gap-2
                          bg-[#4B988D]
                          hover:bg-[#3E8379]
                          text-white
                          px-6 py-3.5
                          rounded-full
                          font-semibold transition">

                    <i data-lucide="plus"
                       class="w-5 h-5"></i>

                    Tambah Anak

                </a>

            </div>


            {{-- ================= SUMMARY ================= --}}
            <div class="grid grid-cols-1
                        md:grid-cols-3
                        gap-4 mt-8">


                {{-- TOTAL --}}
                <div class="bg-[#DCEFE9]
                            rounded-[25px] p-4 sm:p-5
                            border border-[#CDE4DD]">

                    <div class="flex items-center gap-3 sm:gap-4 min-w-0">

                        <span class="w-12 h-12
                                     rounded-2xl
                                     bg-white/70
                                     text-[#438F83]
                                     flex items-center justify-center">

                            <i data-lucide="baby"
                               class="w-5 h-5"></i>

                        </span>

                        <div>

                            <p class="text-sm text-gray-500">
                                Total Anak
                            </p>

                            <p class="text-2xl font-bold">
                                {{ $children->count() }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- STATUS --}}
                <div class="bg-white
                            rounded-[25px] p-4 sm:p-5
                            border border-stone-100
                            shadow-sm">

                    <div class="flex items-center gap-4">

                        <span class="w-12 h-12
                                     rounded-2xl
                                     bg-[#EEF5E9]
                                     text-[#7CA16F]
                                     flex items-center justify-center">

                            <i data-lucide="activity"
                               class="w-5 h-5"></i>

                        </span>

                        <div>

                            <p class="text-sm text-gray-500">
                                Status Pemantauan
                            </p>

                            <p class="font-bold mt-1">
                                {{ $children->count() > 0 ? 'Aktif' : 'Belum Aktif' }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- ASSESSMENT --}}
                <div class="bg-white
                            rounded-[25px] p-4 sm:p-5
                            border border-stone-100
                            shadow-sm">

                    <div class="flex items-center gap-4">

                        <span class="w-12 h-12
                                     rounded-2xl
                                     bg-[#FBF2E4]
                                     text-[#C39A50]
                                     flex items-center justify-center">

                            <i data-lucide="calendar-check"
                               class="w-5 h-5"></i>

                        </span>

                        <div>

                            <p class="text-sm text-gray-500">
                                Assessment
                            </p>

                            <p class="font-bold mt-1">
                                Bulan Ini
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= CHILDREN ================= --}}
            <div class="mt-8">

                <div>

                    <h2 class="text-2xl font-bold">
                        Profil Anak
                    </h2>

                    <p class="text-sm text-gray-400 mt-1">
                        Pilih anak untuk melihat detailnya.
                    </p>

                </div>


                @if($children->count() > 0)

                    <div class="grid grid-cols-1
                                md:grid-cols-2
                                2xl:grid-cols-3
                                gap-5 mt-6">

                        @foreach($children as $child)

                            <div class="group
                                        bg-white
                                        rounded-[30px]
                                        border border-stone-100
                                        shadow-sm p-4 sm:p-6
                                        hover:-translate-y-1
                                        hover:shadow-md
                                        transition duration-300">


                                {{-- TOP --}}
                                <div class="flex items-start
                                            justify-between gap-3">

                                    <div class="flex items-center gap-4">

                                        <div class="w-14 h-14 sm:w-16 sm:h-16 shrink-0
                                                    rounded-[20px] sm:rounded-[22px]
                                                    {{ $child->gender === 'P' ? 'bg-[#FCE9EF]' : 'bg-[#E2F2ED]' }}
                                                    flex items-center
                                                    justify-center
                                                    text-3xl">

                                            @if($child->gender === 'P')
                                                👧
                                            @else
                                                👦
                                            @endif

                                        </div>


                                        <div class="min-w-0">

                                            <h3 class="text-lg sm:text-xl font-bold truncate">
                                                {{ $child->name }}
                                            </h3>

                                            <p class="text-sm
                                                      text-gray-400 mt-1">

                                                {{ $child->gender === 'P'
                                                    ? 'Perempuan'
                                                    : 'Laki-laki' }}

                                            </p>

                                        </div>

                                    </div>


                                    <span class="px-3 py-1
                                                 rounded-full
                                                 bg-green-50
                                                 text-green-600
                                                 text-xs font-semibold">

                                        Aktif

                                    </span>

                                </div>


                                {{-- INFO --}}
                                <div class="grid grid-cols-1 min-[380px]:grid-cols-2
                                            gap-3 mt-5 sm:mt-6">

                                    {{-- BIRTH DATE --}}
                                    <div class="bg-[#F8F7F3]
                                                rounded-2xl p-4">

                                        <div class="flex items-center
                                                    gap-2
                                                    text-gray-400">

                                            <i data-lucide="calendar-days"
                                               class="w-4 h-4"></i>

                                            <span class="text-xs">
                                                Tanggal Lahir
                                            </span>

                                        </div>

                                        <p class="font-semibold
                                                  text-sm mt-2">

                                            {{ $child->birth_date
                                                ? \Carbon\Carbon::parse($child->birth_date)->format('d/m/Y')
                                                : '-' }}

                                        </p>

                                    </div>


                                    {{-- AGE --}}
                                    <div class="bg-[#F8F7F3]
                                                rounded-2xl p-4">

                                        <div class="flex items-center
                                                    gap-2
                                                    text-gray-400">

                                            <i data-lucide="cake"
                                               class="w-4 h-4"></i>

                                            <span class="text-xs">
                                                Usia
                                            </span>

                                        </div>

                                        <p class="font-semibold
                                                  text-sm mt-2">

                                            @if($child->birth_date)

                                                @php
                                                    $birthDate = \Carbon\Carbon::parse($child->birth_date);
                                                    $age = $birthDate->diff(now());
                                                @endphp

                                                @if($age->y > 0)
                                                    {{ $age->y }} th {{ $age->m }} bln
                                                @else
                                                    {{ $age->m }} bulan
                                                @endif

                                            @else
                                                -
                                            @endif

                                        </p>

                                    </div>

                                </div>


                                {{-- BIRTH DATA --}}
                                <div class="grid grid-cols-1 min-[380px]:grid-cols-2
                                            gap-3 mt-3">

                                    {{-- WEIGHT --}}
                                    <div class="border border-stone-100
                                                rounded-2xl p-4">

                                        <div class="flex items-center
                                                    gap-2
                                                    text-gray-400">

                                            <i data-lucide="weight"
                                               class="w-4 h-4"></i>

                                            <span class="text-xs">
                                                Berat Lahir
                                            </span>

                                        </div>

                                        <p class="font-bold mt-2">

                                            {{ $child->birth_weight
                                                ? $child->birth_weight . ' kg'
                                                : '-' }}

                                        </p>

                                    </div>


                                    {{-- HEIGHT --}}
                                    <div class="border border-stone-100
                                                rounded-2xl p-4">

                                        <div class="flex items-center
                                                    gap-2
                                                    text-gray-400">

                                            <i data-lucide="ruler"
                                               class="w-4 h-4"></i>

                                            <span class="text-xs">
                                                Panjang Lahir
                                            </span>

                                        </div>

                                        <p class="font-bold mt-2">

                                            {{ $child->birth_height
                                                ? $child->birth_height . ' cm'
                                                : '-' }}

                                        </p>

                                    </div>

                                </div>


                                {{-- GROWTH --}}
                                <div class="mt-5
                                            bg-[#EAF5F2]
                                            rounded-2xl p-4">

                                    <div class="flex items-center
                                                justify-between">

                                        <div>

                                            <p class="text-xs
                                                      text-gray-500">
                                                Status Pertumbuhan
                                            </p>

                                            <p class="font-bold
                                                      text-[#438F83]
                                                      mt-1">
                                                Tumbuh Optimal
                                            </p>

                                        </div>

                                        <div class="w-11 h-11
                                                    rounded-full
                                                    bg-white
                                                    text-[#438F83]
                                                    flex items-center
                                                    justify-center">

                                            <i data-lucide="trending-up"
                                               class="w-5 h-5"></i>

                                        </div>

                                    </div>

                                </div>


                                {{-- ACTION --}}
                                <div class="flex gap-3 mt-5">

                                    <a href="{{ route('children.show', $child) }}"
                                       class="flex-1
                                              bg-[#4B988D]
                                              hover:bg-[#3D8379]
                                              text-white
                                              rounded-2xl
                                              py-3
                                              text-center
                                              text-sm
                                              font-semibold transition">

                                        Lihat Detail

                                    </a>


                                    <a href="{{ route('children.edit', $child) }}"
                                       title="Edit data anak"
                                       class="w-12
                                              border border-stone-200
                                              rounded-2xl
                                              flex items-center
                                              justify-center
                                              text-gray-500
                                              hover:text-[#438F83]
                                              hover:bg-[#F1F7F5]
                                              transition">

                                        <i data-lucide="pencil"
                                           class="w-4 h-4"></i>

                                    </a>

                                </div>

                            </div>

                        @endforeach


                        {{-- ADD CHILD CARD --}}
                        <a href="{{ route('children.create') }}"
                           class="min-h-[260px] sm:min-h-[320px] lg:min-h-[390px]
                                  rounded-[30px]
                                  border-2 border-dashed
                                  border-stone-200
                                  flex flex-col
                                  items-center justify-center
                                  text-center p-8
                                  hover:border-[#4B988D]
                                  hover:bg-[#F1F7F5]
                                  transition">

                            <span class="w-16 h-16
                                         rounded-full
                                         bg-[#E5F3EF]
                                         text-[#438F83]
                                         flex items-center justify-center">

                                <i data-lucide="plus"
                                   class="w-7 h-7"></i>

                            </span>

                            <h3 class="font-bold text-lg mt-5">
                                Tambah Anak
                            </h3>

                            <p class="text-sm
                                      text-gray-400
                                      mt-2 max-w-[220px]">

                                Tambahkan profil anak lain
                                untuk mulai memantau pertumbuhannya.

                            </p>

                        </a>

                    </div>


                @else

                    {{-- ================= EMPTY STATE ================= --}}
                    <div class="bg-white
                                rounded-[30px]
                                border border-stone-100
                                shadow-sm
                                mt-6 py-10 sm:py-16 px-5 sm:px-6
                                text-center">

                        <div class="w-24 h-24
                                    mx-auto
                                    rounded-[30px]
                                    bg-[#E5F3EF]
                                    text-[#438F83]
                                    flex items-center justify-center">

                            <i data-lucide="baby"
                               class="w-11 h-11"></i>

                        </div>

                        <h2 class="text-2xl font-bold mt-6">
                            Belum ada data anak
                        </h2>

                        <p class="text-gray-400
                                  mt-2 max-w-md mx-auto">

                            Tambahkan profil si kecil untuk mulai
                            memantau pertumbuhan dan nutrisinya.

                        </p>

                        <a href="{{ route('children.create') }}"
                           class="inline-flex
                                  items-center gap-2
                                  bg-[#4B988D]
                                  hover:bg-[#3D8379]
                                  text-white
                                  rounded-full
                                  px-6 py-3.5
                                  font-semibold
                                  mt-6 transition">

                            <i data-lucide="plus"
                               class="w-5 h-5"></i>

                            Tambah Anak Pertama

                        </a>

                    </div>

                @endif

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

        <a href="{{ route('ai.chat') }}"
           class="group flex flex-col items-center justify-center gap-1.5 min-w-0
                  text-gray-400 hover:text-[#438F83] transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition group-hover:-translate-y-0.5">
                <i data-lucide="message-circle" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">Tanya AI</span>
        </a>

        {{-- DATA ANAK ACTIVE --}}
        <a href="{{ route('children.index') }}"
           class="group relative flex flex-col items-center justify-center gap-1.5 min-w-0
                  text-[#438F83] transition duration-200 active:scale-90">

            <span class="absolute -top-2 w-7 h-1 rounded-full bg-[#4B988D]
                         shadow-[0_2px_10px_rgba(75,152,141,0.45)]"></span>

            <span class="relative -mt-1 w-11 h-11 rounded-2xl
                         bg-gradient-to-br from-[#DDF1ED] to-[#CFE8E3]
                         ring-1 ring-[#BFDCD6]
                         shadow-[0_8px_18px_rgba(75,152,141,0.20)]
                         flex items-center justify-center">
                <i data-lucide="baby" class="w-5 h-5"></i>
                <span class="absolute -right-0.5 -top-0.5 w-2.5 h-2.5 rounded-full
                             bg-[#4B988D] border-2 border-white"></span>
            </span>

            <span class="text-[9px] sm:text-[10px] font-bold truncate w-full text-center">Anak</span>
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
</script>

</body>
</html>