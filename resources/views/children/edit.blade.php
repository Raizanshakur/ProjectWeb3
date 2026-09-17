<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit {{ $child->name }} - GrowCare</title>

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

        <div class="max-w-[1100px] mx-auto w-full min-w-0
                    px-4 sm:px-5 md:px-8 lg:px-10 py-5 sm:py-7">


            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row
                        sm:items-center
                        justify-between gap-4">

                <div>

                    <a href="{{ route('children.show', $child) }}"
                       class="inline-flex items-center gap-2
                              text-sm text-gray-400
                              hover:text-[#438F83]
                              transition">

                        <i data-lucide="arrow-left"
                           class="w-4 h-4"></i>

                        Kembali ke Detail Anak

                    </a>


                    <p class="text-xs
                              tracking-[0.18em]
                              text-[#4B988D]
                              font-semibold mt-5">
                        PROFIL ANAK
                    </p>

                    <h1 class="text-2xl sm:text-3xl font-bold mt-2">
                        Edit Profil Anak
                    </h1>

                    <p class="text-gray-400 mt-1">
                        Perbarui informasi {{ $child->name }}.
                    </p>

                </div>

            </div>


            {{-- ERROR --}}
            @if ($errors->any())

                <div class="mt-6 bg-red-50
                            border border-red-100
                            rounded-2xl p-5">

                    <div class="flex items-start gap-3">

                        <i data-lucide="circle-alert"
                           class="w-5 h-5
                                  text-red-500 mt-0.5">
                        </i>

                        <div>

                            <p class="font-semibold text-red-600">
                                Data belum bisa disimpan
                            </p>

                            <ul class="mt-2 text-sm
                                       text-red-500 space-y-1">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        • {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- ================= CARD ================= --}}
            <div class="bg-white
                        rounded-[26px] sm:rounded-[30px]
                        border border-stone-100
                        shadow-sm
                        mt-7 overflow-hidden">


                {{-- PROFILE HEADER --}}
                <div class="bg-gradient-to-r
                            from-[#E1F0EB]
                            via-[#EAF5F1]
                            to-[#F4F1E7]
                            p-5 sm:p-7 md:p-9">

                    <div class="flex flex-col sm:flex-row
                                sm:items-center gap-5">

                        <div class="w-20 h-20 sm:w-24 sm:h-24 shrink-0
                                    bg-white
                                    rounded-[24px] sm:rounded-[28px]
                                    shadow-sm
                                    flex items-center
                                    justify-center
                                    text-5xl">

                            {{ $child->gender === 'P' ? '👧' : '👦' }}

                        </div>


                        <div>

                            <p class="text-sm
                                      text-[#438F83]
                                      font-semibold">
                                Profil Anak
                            </p>

                            <h2 class="text-xl sm:text-2xl
                                       font-bold mt-1 break-words">
                                {{ $child->name }}
                            </h2>

                            <p class="text-sm
                                      text-gray-500 mt-1">

                                {{ $child->gender === 'P'
                                    ? 'Perempuan'
                                    : 'Laki-laki' }}

                                •

                                @if($child->birth_date)

                                    @php
                                        $currentAge = \Carbon\Carbon::parse($child->birth_date)->diff(now());
                                    @endphp

                                    @if($currentAge->y > 0)
                                        {{ $currentAge->y }} tahun {{ $currentAge->m }} bulan
                                    @else
                                        {{ $currentAge->m }} bulan
                                    @endif

                                @else
                                    Usia belum tersedia
                                @endif

                            </p>

                        </div>

                    </div>

                </div>


                {{-- ================= FORM ================= --}}
                <form method="POST"
                      action="{{ route('children.update', $child) }}"
                      id="editChildForm"
                      class="p-4 sm:p-6 md:p-9">

                    @csrf
                    @method('PUT')


                    <div class="grid grid-cols-1
                                md:grid-cols-2 gap-6">


                        {{-- NAMA --}}
                        <div class="md:col-span-2">

                            <label for="name"
                                   class="block text-sm
                                          font-semibold mb-2">
                                Nama Anak
                            </label>


                            <div class="relative">

                                <i data-lucide="user-round"
                                   class="absolute left-4
                                          top-1/2
                                          -translate-y-1/2
                                          w-5 h-5
                                          text-gray-400">
                                </i>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name', $child->name) }}"
                                    class="w-full
                                           bg-[#FAF9F5]
                                           border border-stone-200
                                           rounded-2xl
                                           pl-11 sm:pl-12 pr-4 py-3.5 sm:py-4
                                           focus:border-[#4B988D]
                                           focus:ring-[#4B988D]"
                                    required
                                >

                            </div>

                        </div>


                        {{-- TANGGAL LAHIR --}}
                        <div>

                            <label for="birth_date"
                                   class="block text-sm
                                          font-semibold mb-2">
                                Tanggal Lahir
                            </label>


                            <div class="relative">

                                <i data-lucide="calendar-days"
                                   class="absolute left-4
                                          top-1/2
                                          -translate-y-1/2
                                          w-5 h-5
                                          text-gray-400
                                          pointer-events-none">
                                </i>


                                <input
                                    type="date"
                                    name="birth_date"
                                    id="birth_date"

                                    value="{{ old(
                                        'birth_date',
                                        $child->birth_date
                                            ? \Carbon\Carbon::parse($child->birth_date)->format('Y-m-d')
                                            : ''
                                    ) }}"

                                    max="{{ date('Y-m-d') }}"

                                    class="w-full
                                           bg-[#FAF9F5]
                                           border border-stone-200
                                           rounded-2xl
                                           pl-11 sm:pl-12 pr-4 py-3.5 sm:py-4
                                           focus:border-[#4B988D]
                                           focus:ring-[#4B988D]"

                                    required
                                >

                            </div>

                        </div>


                        {{-- JENIS KELAMIN --}}
                        <div>

                            <label class="block text-sm
                                          font-semibold mb-2">
                                Jenis Kelamin
                            </label>


                            <div class="grid grid-cols-1 min-[380px]:grid-cols-2 gap-3">

                                {{-- LAKI --}}
                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="gender"
                                        value="L"
                                        class="peer hidden"

                                        {{ old('gender', $child->gender) === 'L'
                                            ? 'checked'
                                            : '' }}
                                    >


                                    <div class="border-2
                                                border-stone-200
                                                bg-[#FAF9F5]
                                                rounded-2xl
                                                p-4
                                                text-center
                                                transition

                                                peer-checked:border-[#4B988D]
                                                peer-checked:bg-[#EDF5F2]">

                                        <span class="text-3xl">
                                            👦
                                        </span>

                                        <p class="font-semibold
                                                  text-sm mt-2">
                                            Laki-laki
                                        </p>

                                    </div>

                                </label>


                                {{-- PEREMPUAN --}}
                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="gender"
                                        value="P"
                                        class="peer hidden"

                                        {{ old('gender', $child->gender) === 'P'
                                            ? 'checked'
                                            : '' }}
                                    >


                                    <div class="border-2
                                                border-stone-200
                                                bg-[#FAF9F5]
                                                rounded-2xl
                                                p-4
                                                text-center
                                                transition

                                                peer-checked:border-[#4B988D]
                                                peer-checked:bg-[#EDF5F2]">

                                        <span class="text-3xl">
                                            👧
                                        </span>

                                        <p class="font-semibold
                                                  text-sm mt-2">
                                            Perempuan
                                        </p>

                                    </div>

                                </label>

                            </div>

                        </div>


                        {{-- BERAT LAHIR --}}
                        <div>

                            <label for="birth_weight"
                                   class="block text-sm
                                          font-semibold mb-2">
                                Berat Lahir
                            </label>


                            <div class="relative">

                                <i data-lucide="weight"
                                   class="absolute left-4
                                          top-1/2
                                          -translate-y-1/2
                                          w-5 h-5
                                          text-gray-400">
                                </i>


                                <input
                                    type="number"
                                    name="birth_weight"
                                    id="birth_weight"

                                    value="{{ old(
                                        'birth_weight',
                                        $child->birth_weight
                                    ) }}"

                                    min="0"
                                    max="99.99"
                                    step="0.01"
                                    placeholder="Contoh: 3.2"

                                    class="w-full
                                           bg-[#FAF9F5]
                                           border border-stone-200
                                           rounded-2xl
                                           pl-11 sm:pl-12 pr-12 sm:pr-14 py-3.5 sm:py-4
                                           focus:border-[#4B988D]
                                           focus:ring-[#4B988D]"
                                >


                                <span class="absolute right-4
                                             top-1/2
                                             -translate-y-1/2
                                             text-sm text-gray-400">
                                    kg
                                </span>

                            </div>

                        </div>


                        {{-- PANJANG LAHIR --}}
                        <div>

                            <label for="birth_height"
                                   class="block text-sm
                                          font-semibold mb-2">
                                Panjang Lahir
                            </label>


                            <div class="relative">

                                <i data-lucide="ruler"
                                   class="absolute left-4
                                          top-1/2
                                          -translate-y-1/2
                                          w-5 h-5
                                          text-gray-400">
                                </i>


                                <input
                                    type="number"
                                    name="birth_height"
                                    id="birth_height"

                                    value="{{ old(
                                        'birth_height',
                                        $child->birth_height
                                    ) }}"

                                    min="0"
                                    max="99.99"
                                    step="0.01"
                                    placeholder="Contoh: 49"

                                    class="w-full
                                           bg-[#FAF9F5]
                                           border border-stone-200
                                           rounded-2xl
                                           pl-11 sm:pl-12 pr-12 sm:pr-14 py-3.5 sm:py-4
                                           focus:border-[#4B988D]
                                           focus:ring-[#4B988D]"
                                >


                                <span class="absolute right-4
                                             top-1/2
                                             -translate-y-1/2
                                             text-sm text-gray-400">
                                    cm
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- INFO --}}
                    <div class="mt-7
                                bg-[#EDF5F2]
                                rounded-2xl p-4
                                flex items-start gap-3">

                        <i data-lucide="info"
                           class="w-5 h-5
                                  text-[#438F83]
                                  mt-0.5 shrink-0">
                        </i>

                        <p class="text-sm
                                  text-gray-500
                                  leading-relaxed">

                            Pastikan informasi anak sudah benar.
                            Data ini digunakan sebagai profil dasar
                            pada tampilan GrowCare.

                        </p>

                    </div>


                    {{-- BUTTON --}}
                    <div class="flex flex-col-reverse
                                sm:flex-row
                                sm:justify-end
                                gap-3 mt-8">

                        <a href="{{ route('children.show', $child) }}"
                           class="px-6 py-3.5
                                  border border-stone-200
                                  rounded-full
                                  text-center
                                  font-semibold
                                  hover:bg-stone-50
                                  transition">
                            Batal
                        </a>


                        <button
                            type="submit"
                            id="saveButton"

                            class="px-7 py-3.5
                                   bg-[#4B988D]
                                   hover:bg-[#3E8379]
                                   text-white
                                   rounded-full
                                   font-semibold
                                   flex items-center
                                   justify-center gap-2
                                   transition">

                            <i data-lucide="save"
                               class="w-5 h-5"></i>

                            Simpan Perubahan

                        </button>

                    </div>

                </form>

            </div>


            {{-- ================= HAPUS ================= --}}
            <div class="bg-white
                        rounded-[26px]
                        border border-red-100
                        p-5 sm:p-6 mt-6">

                <div class="flex flex-col md:flex-row
                            md:items-center
                            justify-between gap-5">

                    <div>

                        <div class="flex items-center gap-2">

                            <i data-lucide="triangle-alert"
                               class="w-5 h-5 text-red-500">
                            </i>

                            <h3 class="font-bold">
                                Hapus Data Anak
                            </h3>

                        </div>


                        <p class="text-sm
                                  text-gray-400 mt-2">

                            Data anak yang dihapus
                            tidak dapat dikembalikan.

                        </p>

                    </div>


                    <button
                        type="button"
                        onclick="openDeleteModal()"

                        class="w-full md:w-auto inline-flex
                               items-center
                               justify-center gap-2
                               px-5 py-3
                               bg-red-50
                               text-red-500
                               hover:bg-red-100
                               rounded-full
                               font-semibold
                               transition">

                        <i data-lucide="trash-2"
                           class="w-4 h-4"></i>

                        Hapus Anak

                    </button>

                </div>

            </div>

        </div>

    </main>

</div>


{{-- ================= DELETE MODAL ================= --}}
<div id="deleteModal"
     class="hidden fixed inset-0 z-50
            bg-black/30 backdrop-blur-sm
            items-center justify-center p-5">

    <div class="bg-white
                w-full max-w-md
                rounded-t-[28px] sm:rounded-[28px]
                p-5 sm:p-7 shadow-xl
                max-h-[90vh] overflow-y-auto">

        <div class="w-14 h-14
                    rounded-2xl
                    bg-red-50
                    text-red-500
                    flex items-center
                    justify-center">

            <i data-lucide="trash-2"
               class="w-6 h-6"></i>

        </div>


        <h2 class="text-xl font-bold mt-5">
            Hapus {{ $child->name }}?
        </h2>


        <p class="text-sm
                  text-gray-400
                  leading-relaxed mt-2">

            Apakah kamu yakin ingin menghapus
            data {{ $child->name }}?
            Tindakan ini tidak dapat dibatalkan.

        </p>


        <div class="grid grid-cols-1 min-[380px]:grid-cols-2
                    gap-3 mt-7">

            <button
                type="button"
                onclick="closeDeleteModal()"

                class="border
                       border-stone-200
                       rounded-xl py-3
                       font-semibold
                       hover:bg-stone-50">

                Batal

            </button>


            <form method="POST"
                  action="{{ route('children.destroy', $child) }}">

                @csrf
                @method('DELETE')


                <button
                    type="submit"

                    class="w-full
                           bg-red-500
                           hover:bg-red-600
                           text-white
                           rounded-xl py-3
                           font-semibold">

                    Ya, Hapus

                </button>

            </form>

        </div>

    </div>

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
            <span class="relative -mt-1 w-11 h-11 rounded-2xl bg-gradient-to-br from-[#DDF1ED] to-[#CFE8E3]
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


    function openDeleteModal() {

        const modal =
            document.getElementById('deleteModal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');

    }


    function closeDeleteModal() {

        const modal =
            document.getElementById('deleteModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');

    }


    // Klik area luar modal untuk menutup
    document.getElementById('deleteModal')
        .addEventListener('click', function(event) {

            if (event.target === this) {
                closeDeleteModal();
            }

        });


    // ESC untuk menutup modal
    document.addEventListener('keydown', function(event) {

        if (event.key === 'Escape') {
            closeDeleteModal();
        }

    });


    // Loading ketika simpan
    document.getElementById('editChildForm')
        .addEventListener('submit', function() {

            const button =
                document.getElementById('saveButton');

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

</script>

</body>
</html>