<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Anak - GrowCare</title>

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
                            title="Keluar"
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

        <div class="max-w-[1100px]
                    mx-auto w-full min-w-0
                    px-4 sm:px-5 md:px-8 lg:px-10
                    py-5 sm:py-7">


            {{-- HEADER --}}
            <div>

                <a href="{{ route('children.index') }}"
                   class="inline-flex items-center gap-2
                          text-sm text-gray-400
                          hover:text-[#438F83]
                          transition">

                    <i data-lucide="arrow-left"
                       class="w-4 h-4"></i>

                    Kembali ke Data Anak

                </a>


                <p class="text-xs
                          tracking-[0.18em]
                          text-[#4B988D]
                          font-semibold mt-5">
                    PROFIL ANAK
                </p>

                <h1 class="text-2xl sm:text-3xl font-bold mt-2">
                    Tambah Anak
                </h1>

                <p class="text-gray-400 mt-1">
                    Tambahkan profil si kecil ke GrowCare.
                </p>

            </div>


            {{-- ================= CARD ================= --}}
            <div class="bg-white
                        rounded-[26px] sm:rounded-[32px]
                        border border-stone-100
                        shadow-sm
                        mt-7 overflow-hidden">


                {{-- ================= PROGRESS ================= --}}
                <div class="bg-gradient-to-r
                            from-[#E8F4F0]
                            via-[#F2F7F4]
                            to-[#F6F2E8]
                            px-3 sm:px-5 md:px-12
                            pt-6 sm:pt-8 pb-5 sm:pb-7 overflow-x-auto">

                    <div class="flex items-center justify-center min-w-[315px]">

                        {{-- STEP 1 --}}
                        <div class="flex flex-col items-center">

                            <div id="circle1"
                                 class="w-9 h-9 sm:w-11 sm:h-11
                                        rounded-full
                                        bg-[#4B988D]
                                        text-white
                                        flex items-center
                                        justify-center
                                        font-bold">
                                1
                            </div>

                            <span id="label1"
                                  class="text-[10px] sm:text-xs mt-2
                                         font-semibold
                                         text-[#438F83]">
                                Profil Anak
                            </span>

                        </div>


                        <div id="line1"
                             class="w-7 min-[380px]:w-10 sm:w-20 md:w-32
                                    h-[2px]
                                    bg-stone-200
                                    mb-5 mx-2">
                        </div>


                        {{-- STEP 2 --}}
                        <div class="flex flex-col items-center">

                            <div id="circle2"
                                 class="w-9 h-9 sm:w-11 sm:h-11
                                        rounded-full
                                        bg-[#F1F1EC]
                                        text-gray-400
                                        flex items-center
                                        justify-center
                                        font-bold">
                                2
                            </div>

                            <span id="label2"
                                  class="text-[10px] sm:text-xs mt-2
                                         font-semibold
                                         text-gray-400">
                                Jenis Kelamin
                            </span>

                        </div>


                        <div id="line2"
                             class="w-7 min-[380px]:w-10 sm:w-20 md:w-32
                                    h-[2px]
                                    bg-stone-200
                                    mb-5 mx-2">
                        </div>


                        {{-- STEP 3 --}}
                        <div class="flex flex-col items-center">

                            <div id="circle3"
                                 class="w-9 h-9 sm:w-11 sm:h-11
                                        rounded-full
                                        bg-[#F1F1EC]
                                        text-gray-400
                                        flex items-center
                                        justify-center
                                        font-bold">
                                3
                            </div>

                            <span id="label3"
                                  class="text-[10px] sm:text-xs mt-2
                                         font-semibold
                                         text-gray-400">
                                Pendamping
                            </span>

                        </div>

                    </div>

                </div>


                {{-- ================= ERROR LARAVEL ================= --}}
                @if ($errors->any())

                    <div class="mx-4 sm:mx-6 md:mx-12 mt-6 sm:mt-7
                                bg-red-50
                                border border-red-100
                                rounded-2xl px-5 py-4">

                        <div class="flex items-start gap-3">

                            <i data-lucide="circle-alert"
                               class="w-5 h-5
                                      text-red-500 mt-0.5">
                            </i>

                            <div>

                                <p class="font-semibold text-red-600">
                                    Data belum bisa disimpan
                                </p>

                                <ul class="text-sm
                                           text-red-500
                                           mt-2 space-y-1">

                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- ================= FORM ================= --}}
                <form method="POST"
                      action="{{ route('children.store') }}"
                      id="childForm">

                    @csrf


                    {{-- ================================================= --}}
                    {{-- STEP 1 --}}
                    {{-- ================================================= --}}
                    <div id="step1"
                         class="px-6 md:px-12
                                pt-9 pb-11">


                        <div class="max-w-2xl mx-auto">

                            <div class="text-center">

                                <span class="w-14 h-14 sm:w-16 sm:h-16 mx-auto
                                             rounded-2xl
                                             bg-[#E5F3EF]
                                             text-[#438F83]
                                             flex items-center
                                             justify-center">

                                    <i data-lucide="baby"
                                       class="w-8 h-8"></i>

                                </span>


                                <h2 class="text-xl sm:text-2xl md:text-3xl
                                           font-bold mt-5">

                                    Kenalan dengan si kecil

                                </h2>


                                <p class="text-gray-400 mt-2">
                                    Masukkan informasi dasar anak
                                    terlebih dahulu.
                                </p>

                            </div>


                            {{-- NAME --}}
                            <div class="mt-9">

                                <label for="childName"
                                       class="block
                                              font-semibold mb-2">
                                    Nama Anak
                                </label>


                                <div class="relative">

                                    <i data-lucide="user-round"
                                       class="absolute left-4 sm:left-5
                                              top-1/2
                                              -translate-y-1/2
                                              w-5 h-5
                                              text-gray-400">
                                    </i>

                                    <input
                                        type="text"
                                        name="name"
                                        id="childName"
                                        value="{{ old('name') }}"
                                        placeholder="Contoh: Adam"
                                        autocomplete="off"

                                        class="w-full
                                               pl-12 sm:pl-14 pr-4 sm:pr-5 py-3.5 sm:py-4
                                               rounded-2xl
                                               border border-stone-200
                                               bg-[#FAF9F5]
                                               focus:border-[#4B988D]
                                               focus:ring-[#4B988D]"

                                        required
                                    >

                                </div>

                            </div>


                            {{-- DATE --}}
                            <div class="mt-5">

                                <label for="birthDate"
                                       class="block
                                              font-semibold mb-2">
                                    Tanggal Lahir
                                </label>


                                <div class="relative">

                                    <i data-lucide="calendar-days"
                                       class="absolute left-4 sm:left-5
                                              top-1/2
                                              -translate-y-1/2
                                              w-5 h-5
                                              text-gray-400
                                              pointer-events-none">
                                    </i>

                                    <input
                                        type="date"
                                        name="birth_date"
                                        id="birthDate"
                                        value="{{ old('birth_date') }}"
                                        max="{{ date('Y-m-d') }}"

                                        class="w-full
                                               pl-12 sm:pl-14 pr-4 sm:pr-5 py-3.5 sm:py-4
                                               rounded-2xl
                                               border border-stone-200
                                               bg-[#FAF9F5]
                                               focus:border-[#4B988D]
                                               focus:ring-[#4B988D]"

                                        required
                                    >

                                </div>

                            </div>


                            {{-- WEIGHT + HEIGHT --}}
                            <div class="grid grid-cols-1
                                        sm:grid-cols-2
                                        gap-4 mt-5">

                                {{-- WEIGHT --}}
                                <div>

                                    <label for="birthWeight"
                                           class="block
                                                  font-semibold mb-2">
                                        Berat Lahir
                                    </label>

                                    <div class="relative">

                                        <i data-lucide="weight"
                                           class="absolute left-4 sm:left-5
                                                  top-1/2
                                                  -translate-y-1/2
                                                  w-5 h-5
                                                  text-gray-400
                                                  pointer-events-none">
                                        </i>

                                        <input
                                            type="number"
                                            name="birth_weight"
                                            id="birthWeight"
                                            value="{{ old('birth_weight') }}"
                                            min="0"
                                            max="99.99"
                                            step="0.01"
                                            placeholder="3.2"

                                            class="w-full
                                                   pl-12 sm:pl-14 pr-11 sm:pr-12 py-3.5 sm:py-4
                                                   rounded-2xl
                                                   border border-stone-200
                                                   bg-[#FAF9F5]
                                                   focus:border-[#4B988D]
                                                   focus:ring-[#4B988D]"
                                        >

                                        <span class="absolute right-4 sm:right-5
                                                     top-1/2
                                                     -translate-y-1/2
                                                     text-sm
                                                     text-gray-400">
                                            kg
                                        </span>

                                    </div>

                                </div>


                                {{-- HEIGHT --}}
                                <div>

                                    <label for="birthHeight"
                                           class="block
                                                  font-semibold mb-2">
                                        Panjang Lahir
                                    </label>

                                    <div class="relative">

                                        <i data-lucide="ruler"
                                           class="absolute left-4 sm:left-5
                                                  top-1/2
                                                  -translate-y-1/2
                                                  w-5 h-5
                                                  text-gray-400
                                                  pointer-events-none">
                                        </i>

                                        <input
                                            type="number"
                                            name="birth_height"
                                            id="birthHeight"
                                            value="{{ old('birth_height') }}"
                                            min="0"
                                            max="99.99"
                                            step="0.01"
                                            placeholder="49"

                                            class="w-full
                                                   pl-12 sm:pl-14 pr-11 sm:pr-12 py-3.5 sm:py-4
                                                   rounded-2xl
                                                   border border-stone-200
                                                   bg-[#FAF9F5]
                                                   focus:border-[#4B988D]
                                                   focus:ring-[#4B988D]"
                                        >

                                        <span class="absolute right-4 sm:right-5
                                                     top-1/2
                                                     -translate-y-1/2
                                                     text-sm
                                                     text-gray-400">
                                            cm
                                        </span>

                                    </div>

                                </div>

                            </div>


                            {{-- ERROR --}}
                            <div id="step1Error"
                                 class="hidden mt-4
                                        bg-red-50
                                        text-red-500
                                        border border-red-100
                                        rounded-xl
                                        px-4 py-3
                                        text-sm">

                                Nama dan tanggal lahir harus diisi.

                            </div>


                            <button
                                type="button"
                                onclick="nextStep(2)"

                                class="mt-7 w-full
                                       bg-[#4B988D]
                                       hover:bg-[#3E8379]
                                       text-white
                                       rounded-2xl py-4
                                       font-semibold
                                       flex items-center
                                       justify-center gap-2
                                       transition">

                                Lanjutkan

                                <i data-lucide="arrow-right"
                                   class="w-5 h-5"></i>

                            </button>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- STEP 2 --}}
                    {{-- ================================================= --}}
                    <div id="step2"
                         class="hidden
                                px-6 md:px-12
                                pt-9 pb-11">


                        <div class="text-center">

                            <span class="w-14 h-14 sm:w-16 sm:h-16 mx-auto
                                         rounded-2xl
                                         bg-[#F7EFE3]
                                         flex items-center
                                         justify-center
                                         text-3xl">
                                🧸
                            </span>


                            <h2 class="text-xl sm:text-2xl md:text-3xl
                                       font-bold mt-5">

                                Si kecil laki-laki atau perempuan?

                            </h2>


                            <p class="text-gray-400 mt-2">
                                Pilih jenis kelamin anak.
                            </p>

                        </div>


                        <div class="grid grid-cols-1 min-[420px]:grid-cols-2
                                    gap-4 sm:gap-5 max-w-xl
                                    mx-auto mt-9">


                            {{-- MALE --}}
                            <button
                                type="button"
                                id="maleCard"
                                onclick="selectGender('L')"

                                class="gender-card
                                       border-2 border-stone-100
                                       bg-[#FAF9F5]
                                       rounded-[24px] sm:rounded-[28px] p-5 sm:p-7
                                       hover:border-[#4B988D]
                                       transition">

                                <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto
                                            rounded-full
                                            bg-[#E5F3F5]
                                            flex items-center
                                            justify-center
                                            text-4xl">
                                    👦
                                </div>

                                <h3 class="font-bold text-lg mt-4">
                                    Laki-laki
                                </h3>

                                <p class="text-xs text-gray-400 mt-1">
                                    Anak laki-laki
                                </p>

                            </button>


                            {{-- FEMALE --}}
                            <button
                                type="button"
                                id="femaleCard"
                                onclick="selectGender('P')"

                                class="gender-card
                                       border-2 border-stone-100
                                       bg-[#FAF9F5]
                                       rounded-[24px] sm:rounded-[28px] p-5 sm:p-7
                                       hover:border-[#4B988D]
                                       transition">

                                <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto
                                            rounded-full
                                            bg-[#F8EAEF]
                                            flex items-center
                                            justify-center
                                            text-4xl">
                                    👧
                                </div>

                                <h3 class="font-bold text-lg mt-4">
                                    Perempuan
                                </h3>

                                <p class="text-xs text-gray-400 mt-1">
                                    Anak perempuan
                                </p>

                            </button>

                        </div>


                        {{-- VALUE SENT TO LARAVEL --}}
                        <input
                            type="hidden"
                            name="gender"
                            id="gender"
                            value="{{ old('gender') }}"
                        >


                        <div id="genderError"
                             class="hidden
                                    max-w-xl mx-auto mt-4
                                    bg-red-50
                                    text-red-500
                                    border border-red-100
                                    rounded-xl
                                    px-4 py-3
                                    text-sm text-center">

                            Pilih jenis kelamin terlebih dahulu.

                        </div>


                        <div class="max-w-xl mx-auto
                                    grid grid-cols-1 min-[380px]:grid-cols-2
                                    gap-3 mt-8">

                            <button
                                type="button"
                                onclick="showStep(1)"

                                class="border border-stone-200
                                       hover:bg-stone-50
                                       rounded-2xl py-4
                                       font-semibold
                                       transition">

                                Kembali

                            </button>


                            <button
                                type="button"
                                onclick="nextStep(3)"

                                class="bg-[#4B988D]
                                       hover:bg-[#3E8379]
                                       text-white
                                       rounded-2xl py-4
                                       font-semibold
                                       transition">

                                Lanjutkan

                            </button>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- STEP 3 --}}
                    {{-- ================================================= --}}
                    <div id="step3"
                         class="hidden
                                px-6 md:px-12
                                pt-9 pb-11">


                        <div class="text-center">

                            <span class="w-14 h-14 sm:w-16 sm:h-16 mx-auto
                                         rounded-2xl
                                         bg-[#E5F3EF]
                                         text-[#438F83]
                                         flex items-center
                                         justify-center">

                                <i data-lucide="stethoscope"
                                   class="w-8 h-8"></i>

                            </span>


                            <h2 class="text-xl sm:text-2xl md:text-3xl
                                       font-bold mt-5">

                                Pilih pendamping kesehatan

                            </h2>


                            <p class="text-gray-400 mt-2">
                                Pilihan ini masih berupa tampilan
                                front-end GrowCare.
                            </p>

                        </div>


                        <div class="max-w-xl mx-auto
                                    mt-8 space-y-3">


                            {{-- DOCTOR 1 --}}
                            <button
                                type="button"
                                id="doctor1"
                                onclick="selectDoctor(
                                    'dr. Maya Putri, Sp.A',
                                    'doctor1'
                                )"

                                class="doctor-card
                                       w-full text-left
                                       border-2 border-stone-100
                                       bg-[#FAF9F5]
                                       rounded-2xl p-3.5 sm:p-4
                                       flex items-center gap-3 sm:gap-4
                                       hover:border-[#4B988D]
                                       transition">

                                <span class="w-12 h-12 sm:w-14 sm:h-14 shrink-0
                                             rounded-2xl
                                             bg-[#E5F3EF]
                                             text-[#438F83]
                                             flex items-center
                                             justify-center">

                                    <i data-lucide="stethoscope"
                                       class="w-6 h-6"></i>

                                </span>


                                <div class="flex-1 min-w-0">

                                    <h3 class="font-bold break-words">
                                        dr. Maya Putri, Sp.A
                                    </h3>

                                    <p class="text-xs
                                              text-gray-400 mt-1">
                                        Spesialis Anak • Tersedia
                                    </p>

                                </div>


                                <span class="doctor-radio
                                             w-6 h-6
                                             border-2
                                             border-stone-200
                                             rounded-full">
                                </span>

                            </button>


                            {{-- DOCTOR 2 --}}
                            <button
                                type="button"
                                id="doctor2"
                                onclick="selectDoctor(
                                    'dr. Andi Pratama, Sp.A',
                                    'doctor2'
                                )"

                                class="doctor-card
                                       w-full text-left
                                       border-2 border-stone-100
                                       bg-[#FAF9F5]
                                       rounded-2xl p-3.5 sm:p-4
                                       flex items-center gap-3 sm:gap-4
                                       hover:border-[#4B988D]
                                       transition">

                                <span class="w-12 h-12 sm:w-14 sm:h-14 shrink-0
                                             rounded-2xl
                                             bg-[#F6F0E5]
                                             text-[#B08A48]
                                             flex items-center
                                             justify-center">

                                    <i data-lucide="stethoscope"
                                       class="w-6 h-6"></i>

                                </span>


                                <div class="flex-1 min-w-0">

                                    <h3 class="font-bold break-words">
                                        dr. Andi Pratama, Sp.A
                                    </h3>

                                    <p class="text-xs
                                              text-gray-400 mt-1">
                                        Spesialis Anak • Tersedia
                                    </p>

                                </div>


                                <span class="doctor-radio
                                             w-6 h-6
                                             border-2
                                             border-stone-200
                                             rounded-full">
                                </span>

                            </button>


                            {{-- SKIP --}}
                            <button
                                type="button"
                                id="doctorSkip"
                                onclick="selectDoctor(
                                    '',
                                    'doctorSkip'
                                )"

                                class="doctor-card
                                       w-full text-left
                                       border-2
                                       border-dashed
                                       border-stone-200
                                       bg-white
                                       rounded-2xl p-3.5 sm:p-4
                                       flex items-center gap-3 sm:gap-4
                                       hover:border-[#4B988D]
                                       transition">

                                <span class="w-12 h-12 sm:w-14 sm:h-14 shrink-0
                                             rounded-2xl
                                             bg-gray-100
                                             text-gray-400
                                             flex items-center
                                             justify-center">

                                    <i data-lucide="user-x"
                                       class="w-6 h-6"></i>

                                </span>


                                <div class="flex-1 min-w-0">

                                    <h3 class="font-semibold break-words">
                                        Pilih Nanti
                                    </h3>

                                    <p class="text-xs
                                              text-gray-400 mt-1">
                                        Dokter dapat dipilih
                                        setelah profil dibuat.
                                    </p>

                                </div>

                            </button>

                        </div>


                        {{-- Tidak memakai name karena dokter belum ada di DB --}}
                        <input
                            type="hidden"
                            id="doctor"
                            value=""
                        >


                        <div class="max-w-xl mx-auto
                                    grid grid-cols-1 min-[380px]:grid-cols-2
                                    gap-3 mt-8">

                            <button
                                type="button"
                                onclick="showStep(2)"

                                class="border border-stone-200
                                       hover:bg-stone-50
                                       rounded-2xl py-4
                                       font-semibold
                                       transition">

                                Kembali

                            </button>


                            <button
                                type="submit"
                                id="submitButton"

                                class="bg-[#4B988D]
                                       hover:bg-[#3E8379]
                                       text-white
                                       rounded-2xl py-4
                                       font-semibold
                                       flex items-center
                                       justify-center gap-2
                                       transition">

                                <i data-lucide="check"
                                   class="w-5 h-5"></i>

                                Simpan Anak

                            </button>

                        </div>

                    </div>

                </form>

            </div>


            <p class="text-center
                      text-xs
                      text-gray-400 mt-5">

                Data anak digunakan untuk membantu
                pemantauan tumbuh kembang di GrowCare.

            </p>

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

    let selectedGender =
        document.getElementById('gender').value || '';

    let selectedDoctor = '';


    // ==============================
    // PINDAH STEP
    // ==============================
    function showStep(step) {

        document.getElementById('step1')
            .classList.add('hidden');

        document.getElementById('step2')
            .classList.add('hidden');

        document.getElementById('step3')
            .classList.add('hidden');


        document.getElementById('step' + step)
            .classList.remove('hidden');


        updateProgress(step);

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        lucide.createIcons();

    }


    // ==============================
    // VALIDASI NEXT
    // ==============================
    function nextStep(step) {

        if (step === 2) {

            const name =
                document.getElementById('childName')
                    .value.trim();

            const birthDate =
                document.getElementById('birthDate')
                    .value;


            if (!name || !birthDate) {

                document.getElementById('step1Error')
                    .classList.remove('hidden');

                return;

            }


            document.getElementById('step1Error')
                .classList.add('hidden');

        }


        if (step === 3) {

            if (!selectedGender) {

                document.getElementById('genderError')
                    .classList.remove('hidden');

                return;

            }


            document.getElementById('genderError')
                .classList.add('hidden');

        }


        showStep(step);

    }


    // ==============================
    // GENDER
    // ==============================
    function selectGender(gender) {

        selectedGender = gender;

        document.getElementById('gender').value = gender;


        const male =
            document.getElementById('maleCard');

        const female =
            document.getElementById('femaleCard');


        male.classList.remove(
            'border-[#4B988D]',
            'bg-[#EFF7F4]'
        );


        female.classList.remove(
            'border-[#4B988D]',
            'bg-[#EFF7F4]'
        );


        if (gender === 'L') {

            male.classList.add(
                'border-[#4B988D]',
                'bg-[#EFF7F4]'
            );

        } else {

            female.classList.add(
                'border-[#4B988D]',
                'bg-[#EFF7F4]'
            );

        }


        document.getElementById('genderError')
            .classList.add('hidden');

    }


    // ==============================
    // DOCTOR
    // ==============================
    function selectDoctor(doctor, id) {

        selectedDoctor = doctor;

        document.getElementById('doctor').value = doctor;


        document.querySelectorAll('.doctor-card')
            .forEach(function(card) {

                card.classList.remove(
                    'border-[#4B988D]',
                    'bg-[#EFF7F4]'
                );

            });


        document.querySelectorAll('.doctor-radio')
            .forEach(function(radio) {

                radio.classList.remove(
                    'border-[#4B988D]',
                    'bg-[#4B988D]'
                );

                radio.innerHTML = '';

            });


        const selectedCard =
            document.getElementById(id);

        selectedCard.classList.add(
            'border-[#4B988D]',
            'bg-[#EFF7F4]'
        );


        const radio =
            selectedCard.querySelector('.doctor-radio');

        if (radio) {

            radio.classList.add(
                'border-[#4B988D]',
                'bg-[#4B988D]'
            );

            radio.innerHTML =
                '<span class="block w-2 h-2 bg-white rounded-full m-auto mt-[6px]"></span>';

        }

    }


    // ==============================
    // PROGRESS
    // ==============================
    function updateProgress(step) {

        for (let i = 1; i <= 3; i++) {

            const circle =
                document.getElementById('circle' + i);

            const label =
                document.getElementById('label' + i);


            if (i <= step) {

                circle.className =
                    'w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-[#4B988D] text-white flex items-center justify-center font-bold';

                label.className =
                    'text-[10px] sm:text-xs mt-2 font-semibold text-[#438F83]';

            } else {

                circle.className =
                    'w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-[#F1F1EC] text-gray-400 flex items-center justify-center font-bold';

                label.className =
                    'text-[10px] sm:text-xs mt-2 font-semibold text-gray-400';

            }

        }


        document.getElementById('line1').className =
            step >= 2
                ? 'w-7 min-[380px]:w-10 sm:w-20 md:w-32 h-[2px] bg-[#4B988D] mb-5 mx-1.5 sm:mx-2'
                : 'w-7 min-[380px]:w-10 sm:w-20 md:w-32 h-[2px] bg-stone-200 mb-5 mx-1.5 sm:mx-2';


        document.getElementById('line2').className =
            step >= 3
                ? 'w-7 min-[380px]:w-10 sm:w-20 md:w-32 h-[2px] bg-[#4B988D] mb-5 mx-1.5 sm:mx-2'
                : 'w-7 min-[380px]:w-10 sm:w-20 md:w-32 h-[2px] bg-stone-200 mb-5 mx-1.5 sm:mx-2';

    }


    // ==============================
    // SUBMIT LOADING
    // ==============================
    document.getElementById('childForm')
        .addEventListener('submit', function () {

            const button =
                document.getElementById('submitButton');

            button.disabled = true;

            button.innerHTML = `
                <span class="w-5 h-5
                             border-2 border-white
                             border-t-transparent
                             rounded-full animate-spin">
                </span>

                Menyimpan...
            `;

        });


    // ==============================
    // OLD VALUE
    // ==============================
    if (selectedGender === 'L') {

        selectGender('L');

    } else if (selectedGender === 'P') {

        selectGender('P');

    }

</script>

</body>
</html>6