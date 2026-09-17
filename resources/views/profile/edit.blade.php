<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil - GrowCare</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
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

        <span class="w-10 h-10 rounded-full bg-[#4B988D] text-white
                     flex items-center justify-center font-bold">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </span>
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


                {{-- PROFIL ACTIVE --}}
                <a href="{{ route('profile.edit') }}"
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
            <div class="mb-8">

                <p class="text-xs
                          tracking-[0.18em]
                          text-[#4B988D]
                          font-semibold">
                    AKUN
                </p>

                <h1 class="text-2xl sm:text-3xl font-bold mt-2">
                    Profil Saya
                </h1>

                <p class="text-gray-500 mt-2">
                    Kelola informasi akun dan preferensi GrowCare.
                </p>

            </div>


            {{-- ================= PROFILE HERO ================= --}}
            <div class="relative overflow-hidden
                        bg-gradient-to-br
                        from-[#D8EFE8]
                        via-[#E7F4EF]
                        to-[#F4EFE4]
                        rounded-[26px] sm:rounded-[32px]
                        border border-[#D6E7E1]
                        p-5 sm:p-7 md:p-9">


                <div class="absolute -right-16 -top-20
                            w-64 h-64
                            rounded-full bg-white/30">
                </div>


                <div class="relative
                            flex flex-col md:flex-row
                            md:items-center
                            justify-between gap-7">


                    <div class="flex flex-col sm:flex-row
                                sm:items-center gap-5">


                        {{-- AVATAR --}}
                        <div class="relative">

                            <div class="w-24 h-24 sm:w-28 sm:h-28
                                        rounded-[26px] sm:rounded-[30px]
                                        bg-white
                                        border-4 border-white
                                        shadow-md
                                        flex items-center justify-center
                                        text-[#438F83]
                                        text-4xl font-bold">

                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                            </div>


                            <button type="button"
                                    class="absolute
                                           -right-2 -bottom-2
                                           w-10 h-10
                                           bg-[#4B988D]
                                           text-white
                                           rounded-full
                                           border-4 border-[#E4F2ED]
                                           flex items-center justify-center">

                                <i data-lucide="camera"
                                   class="w-4 h-4"></i>

                            </button>

                        </div>


                        <div>

                            <div class="flex flex-wrap
                                        items-center gap-3">

                                <h2 class="text-2xl sm:text-3xl font-bold break-words">
                                    {{ Auth::user()->name }}
                                </h2>


                                <span class="inline-flex
                                             items-center gap-1
                                             px-3 py-1
                                             bg-white/70
                                             text-[#438F83]
                                             rounded-full
                                             text-xs font-semibold">

                                    <i data-lucide="badge-check"
                                       class="w-3 h-3"></i>

                                    Aktif

                                </span>

                            </div>


                            <p class="text-gray-600 mt-2">
                                {{ Auth::user()->email }}
                            </p>


                            <div class="flex flex-wrap
                                        gap-4 mt-4
                                        text-sm text-gray-500">

                                <span class="flex items-center gap-2">

                                    <i data-lucide="baby"
                                       class="w-4 h-4 text-[#438F83]"></i>

                                    Data Anak

                                </span>


                                <span class="flex items-center gap-2">

                                    <i data-lucide="calendar"
                                       class="w-4 h-4 text-[#438F83]"></i>

                                    GrowCare 2026

                                </span>

                            </div>

                        </div>

                    </div>


                    <button type="button"
                            onclick="toggleEdit()"
                            class="w-full md:w-auto flex items-center
                                   justify-center gap-2
                                   px-5 py-3
                                   bg-white/80
                                   hover:bg-white
                                   rounded-full
                                   text-[#438F83]
                                   font-semibold
                                   shadow-sm transition">

                        <i data-lucide="pencil"
                           class="w-4 h-4"></i>

                        Edit Profil

                    </button>

                </div>

            </div>


            {{-- ================= STATS ================= --}}
            <div class="grid grid-cols-1 min-[520px]:grid-cols-3 gap-4 mt-5">


                {{-- DATA ANAK --}}
                <a href="{{ route('children.index') }}"
                   class="bg-white
                          border border-stone-100
                          rounded-2xl p-5
                          shadow-sm
                          flex items-center gap-4
                          hover:-translate-y-1
                          hover:shadow-md
                          transition">

                    <span class="w-12 h-12
                                 rounded-2xl
                                 bg-[#E5F3EF]
                                 text-[#438F83]
                                 flex items-center justify-center">

                        <i data-lucide="baby"
                           class="w-5 h-5"></i>

                    </span>

                    <div>

                        <p class="text-lg font-bold">
                            Data Anak
                        </p>

                        <p class="text-xs text-gray-400">
                            Kelola profil anak
                        </p>

                    </div>

                </a>


                {{-- ASSESSMENT --}}
                <div class="bg-white
                            border border-stone-100
                            rounded-2xl p-5
                            shadow-sm
                            flex items-center gap-4">

                    <span class="w-12 h-12
                                 rounded-2xl
                                 bg-[#F1F5E9]
                                 text-[#779E69]
                                 flex items-center justify-center">

                        <i data-lucide="clipboard-check"
                           class="w-5 h-5"></i>

                    </span>

                    <div>

                        <p class="text-2xl font-bold">
                            12
                        </p>

                        <p class="text-xs text-gray-400">
                            Assessment
                        </p>

                    </div>

                </div>


                {{-- FOOD SCAN --}}
                <a href="{{ route('food.scan') }}"
                   class="bg-white
                          border border-stone-100
                          rounded-2xl p-5
                          shadow-sm
                          flex items-center gap-4
                          hover:-translate-y-1
                          hover:shadow-md
                          transition">

                    <span class="w-12 h-12
                                 rounded-2xl
                                 bg-[#FBF2E3]
                                 text-[#C49B50]
                                 flex items-center justify-center">

                        <i data-lucide="scan-line"
                           class="w-5 h-5"></i>

                    </span>

                    <div>

                        <p class="text-2xl font-bold">
                            24
                        </p>

                        <p class="text-xs text-gray-400">
                            Food Scan
                        </p>

                    </div>

                </a>

            </div>


            {{-- ================= CONTENT GRID ================= --}}
            <div class="grid grid-cols-1
                        xl:grid-cols-12
                        gap-6 mt-6">


                {{-- ================= INFORMASI AKUN ================= --}}
                <div class="xl:col-span-7
                            bg-white
                            rounded-[30px]
                            border border-stone-100
                            shadow-sm p-5 sm:p-7">


                    <div class="flex items-center
                                justify-between">

                        <div>

                            <h2 class="text-xl font-bold">
                                Informasi Akun
                            </h2>

                            <p class="text-sm
                                      text-gray-400 mt-1">
                                Informasi dasar akun GrowCare.
                            </p>

                        </div>


                        <span class="w-10 h-10
                                     rounded-full
                                     bg-[#E7F4F0]
                                     text-[#438F83]
                                     flex items-center justify-center">

                            <i data-lucide="user-round"
                               class="w-5 h-5"></i>

                        </span>

                    </div>


                    {{-- ================= VIEW MODE ================= --}}
                    <div id="profileView"
                         class="mt-7 space-y-3">


                        {{-- NAME --}}
                        <div class="flex flex-col min-[430px]:flex-row min-[430px]:items-center
                                    justify-between gap-3 min-[430px]:gap-5
                                    p-4
                                    bg-[#F8F7F3]
                                    rounded-2xl">

                            <div class="flex items-center gap-3 sm:gap-4 min-w-0">

                                <span class="w-10 h-10
                                             rounded-xl bg-white
                                             text-gray-400
                                             flex items-center justify-center">

                                    <i data-lucide="user"
                                       class="w-4 h-4"></i>

                                </span>


                                <div class="min-w-0">

                                    <p class="text-xs text-gray-400">
                                        Nama Lengkap
                                    </p>

                                    <p class="font-semibold mt-1 break-words">
                                        {{ Auth::user()->name }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- EMAIL --}}
                        <div class="flex flex-col min-[430px]:flex-row min-[430px]:items-center
                                    justify-between gap-3 min-[430px]:gap-5
                                    p-4
                                    bg-[#F8F7F3]
                                    rounded-2xl">

                            <div class="flex items-center gap-3 sm:gap-4 min-w-0">

                                <span class="w-10 h-10
                                             rounded-xl bg-white
                                             text-gray-400
                                             flex items-center justify-center">

                                    <i data-lucide="mail"
                                       class="w-4 h-4"></i>

                                </span>


                                <div class="min-w-0">

                                    <p class="text-xs text-gray-400">
                                        Email
                                    </p>

                                    <p class="font-semibold mt-1 break-words">
                                        {{ Auth::user()->email }}
                                    </p>

                                </div>

                            </div>


                            <span class="text-xs
                                         text-green-600
                                         bg-green-50
                                         rounded-full
                                         px-3 py-1">
                                Terverifikasi
                            </span>

                        </div>


                        {{-- PHONE --}}
                        <div class="flex flex-col min-[430px]:flex-row min-[430px]:items-center
                                    justify-between gap-3 min-[430px]:gap-5
                                    p-4
                                    bg-[#F8F7F3]
                                    rounded-2xl">

                            <div class="flex items-center gap-3 sm:gap-4 min-w-0">

                                <span class="w-10 h-10
                                             rounded-xl bg-white
                                             text-gray-400
                                             flex items-center justify-center">

                                    <i data-lucide="phone"
                                       class="w-4 h-4"></i>

                                </span>


                                <div class="min-w-0">

                                    <p class="text-xs text-gray-400">
                                        Nomor Telepon
                                    </p>

                                    <p class="font-semibold mt-1 break-words">
                                        Belum ditambahkan
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ================= EDIT MODE ================= --}}
                    <div id="profileEdit"
                         class="hidden mt-7">

                        <form method="POST"
                              action="{{ route('profile.update') }}">

                            @csrf
                            @method('patch')


                            <div>

                                <label class="block
                                              text-sm
                                              font-semibold mb-2">
                                    Nama Lengkap
                                </label>

                                <input type="text"
                                       name="name"
                                       value="{{ old('name', Auth::user()->name) }}"
                                       required
                                       class="w-full
                                              rounded-2xl
                                              border-stone-200
                                              bg-[#F8F7F3]
                                              px-5 py-3.5
                                              focus:border-[#4B988D]
                                              focus:ring-[#4B988D]">

                            </div>


                            <div class="mt-4">

                                <label class="block
                                              text-sm
                                              font-semibold mb-2">
                                    Email
                                </label>

                                <input type="email"
                                       name="email"
                                       value="{{ old('email', Auth::user()->email) }}"
                                       required
                                       class="w-full
                                              rounded-2xl
                                              border-stone-200
                                              bg-[#F8F7F3]
                                              px-5 py-3.5
                                              focus:border-[#4B988D]
                                              focus:ring-[#4B988D]">

                            </div>


                            <div class="flex flex-col min-[400px]:flex-row gap-3 mt-6">

                                <button type="button"
                                        onclick="toggleEdit()"
                                        class="flex-1
                                               border border-stone-200
                                               rounded-2xl
                                               py-3
                                               font-semibold
                                               hover:bg-gray-50">

                                    Batal

                                </button>


                                <button type="submit"
                                        class="flex-1
                                               bg-[#4B988D]
                                               hover:bg-[#3D8379]
                                               text-white
                                               rounded-2xl
                                               py-3
                                               font-semibold">

                                    Simpan Perubahan

                                </button>

                            </div>

                        </form>

                    </div>

                </div>


                {{-- ================= RIGHT SIDE ================= --}}
                <div class="xl:col-span-5 space-y-6">


                    {{-- SETTINGS --}}
                    <div class="bg-white
                                rounded-[30px]
                                border border-stone-100
                                shadow-sm p-5 sm:p-7">

                        <h2 class="text-xl font-bold">
                            Pengaturan
                        </h2>

                        <p class="text-sm text-gray-400 mt-1">
                            Atur preferensi aplikasi.
                        </p>


                        <div class="mt-6 space-y-3">


                            {{-- NOTIFICATION --}}
                            <div class="flex items-center gap-3 sm:gap-4
                                        p-4 rounded-2xl
                                        hover:bg-[#F8F7F3]">

                                <span class="w-11 h-11
                                             rounded-xl
                                             bg-[#EAF5F2]
                                             text-[#438F83]
                                             flex items-center justify-center">

                                    <i data-lucide="bell"
                                       class="w-5 h-5"></i>

                                </span>


                                <div class="flex-1 min-w-0">

                                    <p class="font-semibold text-sm">
                                        Notifikasi
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        Pengingat nutrisi & assessment
                                    </p>

                                </div>


                                <label class="relative
                                              inline-flex
                                              items-center
                                              cursor-pointer">

                                    <input type="checkbox"
                                           checked
                                           class="sr-only peer">

                                    <div class="w-11 h-6
                                                bg-gray-200
                                                rounded-full
                                                peer
                                                peer-checked:bg-[#4B988D]
                                                after:content-['']
                                                after:absolute
                                                after:top-[2px]
                                                after:left-[2px]
                                                after:bg-white
                                                after:rounded-full
                                                after:h-5
                                                after:w-5
                                                after:transition-all
                                                peer-checked:after:translate-x-full">
                                    </div>

                                </label>

                            </div>


                            {{-- LANGUAGE --}}
                            <div class="flex items-center gap-3 sm:gap-4
                                        p-4 rounded-2xl
                                        hover:bg-[#F8F7F3]
                                        cursor-pointer">

                                <span class="w-11 h-11
                                             rounded-xl
                                             bg-[#F6F0E5]
                                             text-[#B48D4A]
                                             flex items-center justify-center">

                                    <i data-lucide="languages"
                                       class="w-5 h-5"></i>

                                </span>


                                <div class="flex-1 min-w-0">

                                    <p class="font-semibold text-sm">
                                        Bahasa
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        Bahasa Indonesia
                                    </p>

                                </div>


                                <i data-lucide="chevron-right"
                                   class="w-4 h-4 text-gray-300"></i>

                            </div>


                            {{-- SECURITY --}}
                            <div class="flex items-center gap-3 sm:gap-4
                                        p-4 rounded-2xl
                                        hover:bg-[#F8F7F3]
                                        cursor-pointer">

                                <span class="w-11 h-11
                                             rounded-xl
                                             bg-[#F0EDF7]
                                             text-purple-500
                                             flex items-center justify-center">

                                    <i data-lucide="shield-check"
                                       class="w-5 h-5"></i>

                                </span>


                                <div class="flex-1 min-w-0">

                                    <p class="font-semibold text-sm">
                                        Keamanan Akun
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        Password dan keamanan
                                    </p>

                                </div>


                                <i data-lucide="chevron-right"
                                   class="w-4 h-4 text-gray-300"></i>

                            </div>

                        </div>

                    </div>


                    {{-- ================= DATA ANAK ================= --}}
                    <div class="bg-[#DCEFE9]
                                rounded-[30px]
                                border border-[#CCE3DC]
                                p-5 sm:p-7">

                        <div class="flex items-start
                                    justify-between">

                            <span class="w-12 h-12
                                         rounded-2xl
                                         bg-white/70
                                         text-[#438F83]
                                         flex items-center justify-center">

                                <i data-lucide="baby"
                                   class="w-6 h-6"></i>

                            </span>


                            <span class="text-xs
                                         bg-white/60
                                         text-[#438F83]
                                         px-3 py-1
                                         rounded-full">

                                PROFIL ANAK

                            </span>

                        </div>


                        <h2 class="text-xl font-bold mt-5">
                            Data Anak
                        </h2>


                        <p class="text-sm
                                  text-gray-500
                                  leading-6 mt-2">

                            Kelola profil anak dan informasi
                            tumbuh kembangnya melalui halaman Data Anak.

                        </p>


                        <a href="{{ route('children.index') }}"
                           class="mt-5
                                  bg-white/80
                                  hover:bg-white
                                  text-[#438F83]
                                  rounded-full
                                  px-5 py-3
                                  font-semibold
                                  flex items-center
                                  justify-center gap-2
                                  transition">

                            Kelola Data Anak

                            <i data-lucide="arrow-right"
                               class="w-4 h-4"></i>

                        </a>

                    </div>

                </div>

            </div>


            {{-- MOBILE LOGOUT --}}
            <div class="mt-6 lg:hidden">

                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            class="w-full
                                   bg-red-50
                                   text-red-500
                                   rounded-2xl
                                   py-4
                                   font-semibold
                                   flex items-center
                                   justify-center gap-2">

                        <i data-lucide="log-out"
                           class="w-5 h-5"></i>

                        Keluar dari Akun

                    </button>

                </form>

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
        <a href="{{ route('children.index') }}" class="group flex flex-col items-center gap-1.5 min-w-0 text-gray-400 hover:text-[#438F83] transition active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center group-hover:bg-[#EEF7F5]"><i data-lucide="baby" class="w-[19px] h-[19px]"></i></span>
            <span class="text-[9px] sm:text-[10px] truncate w-full text-center">Anak</span>
        </a>

        {{-- PROFIL ACTIVE --}}
        <a href="{{ route('profile.edit') }}" class="group relative flex flex-col items-center gap-1.5 min-w-0 text-[#438F83] transition active:scale-90">
            <span class="absolute -top-2 w-7 h-1 rounded-full bg-[#4B988D] shadow-[0_2px_10px_rgba(75,152,141,0.45)]"></span>
            <span class="relative -mt-1 w-11 h-11 rounded-2xl
                         bg-gradient-to-br from-[#DDF1ED] to-[#CFE8E3]
                         ring-1 ring-[#BFDCD6]
                         shadow-[0_8px_18px_rgba(75,152,141,0.20)]
                         flex items-center justify-center">
                <i data-lucide="user-round" class="w-5 h-5"></i>
                <span class="absolute -right-0.5 -top-0.5 w-2.5 h-2.5 rounded-full bg-[#4B988D] border-2 border-white"></span>
            </span>
            <span class="text-[9px] sm:text-[10px] font-bold truncate w-full text-center">Profil</span>
        </a>

    </div>
</nav>

<script>

    lucide.createIcons();

    function toggleEdit() {

        const view =
            document.getElementById('profileView');

        const edit =
            document.getElementById('profileEdit');

        view.classList.toggle('hidden');

        edit.classList.toggle('hidden');

    }

</script>

</body>
</html>