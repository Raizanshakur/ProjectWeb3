<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AI Food Scan - GrowCare</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#101917] text-white overflow-x-hidden">

<div class="min-h-screen flex">

    {{-- MOBILE HEADER --}}
    <header class="lg:hidden fixed top-0 left-0 right-0 z-40 h-16
                   bg-[#101917]/90 backdrop-blur-xl border-b border-white/10
                   flex items-center justify-between px-4">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <span class="w-9 h-9 rounded-full bg-emerald-300/10 text-emerald-300
                         border border-emerald-300/10 flex items-center justify-center">
                <i data-lucide="sprout" class="w-5 h-5"></i>
            </span>
            <span class="text-xl font-bold text-white"><span class="text-emerald-300">Grow</span>Care</span>
        </a>
        <a href="{{ route('profile.edit') }}"
           class="w-10 h-10 rounded-full bg-white/10 border border-white/10
                  text-white/80 flex items-center justify-center">
            <i data-lucide="user-round" class="w-5 h-5"></i>
        </a>
    </header>

    {{-- ================= SIDEBAR ================= --}}
    <aside class="hidden lg:flex fixed left-0 top-0 h-screen
                  w-[285px] bg-[#FBFAF6]
                  border-r border-stone-200
                  flex-col z-40 text-[#202725]">

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


                {{-- AI FOOD SCAN ACTIVE --}}
                <a href="{{ route('food.scan') }}"
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


    {{-- ================= SCANNER AREA ================= --}}
    <main class="relative min-h-screen
                 w-full min-w-0 lg:ml-[285px]
                 pt-16 lg:pt-0 pb-28 lg:pb-0
                 overflow-hidden">

        {{-- BACKGROUND --}}
        <div class="absolute inset-0
                    bg-gradient-to-br
                    from-[#101917]
                    via-[#15231F]
                    to-[#0C1513]">
        </div>


        {{-- DEKORASI --}}
        <div class="absolute -top-40 -right-40
                    w-[500px] h-[500px]
                    rounded-full
                    bg-emerald-500/10 blur-3xl">
        </div>

        <div class="absolute -bottom-40 -left-40
                    w-[500px] h-[500px]
                    rounded-full
                    bg-teal-500/10 blur-3xl">
        </div>


        {{-- HEADER --}}
        <header class="relative z-20
                       flex items-center
                       justify-between
                       px-5 md:px-10 py-6">

            <a href="{{ route('nutrition') }}"
               class="flex items-center gap-3
                      text-white/70
                      hover:text-white transition">

                <span class="w-11 h-11
                             rounded-full bg-white/10
                             border border-white/10
                             flex items-center justify-center
                             backdrop-blur-md">

                    <i data-lucide="arrow-left"
                       class="w-5 h-5"></i>

                </span>

                <span class="hidden sm:block font-medium">
                    Kembali ke Nutrisi
                </span>

            </a>


            <div class="hidden md:flex
                        items-center gap-2
                        px-4 py-2
                        rounded-full
                        bg-white/5
                        border border-white/10">

                <span class="w-2 h-2
                             rounded-full
                             bg-emerald-400">
                </span>

                <span class="text-xs text-white/60">
                    GrowCare AI Vision
                </span>

            </div>


            <button type="button"
                    class="w-11 h-11
                           rounded-full bg-white/10
                           border border-white/10
                           flex items-center justify-center">

                <i data-lucide="circle-help"
                   class="w-5 h-5 text-white/80"></i>

            </button>

        </header>


        {{-- ================= CONTENT ================= --}}
        <div class="relative z-10
                    max-w-[1200px] mx-auto w-full min-w-0
                    px-4 sm:px-5 pb-8 sm:pb-12">


            {{-- TITLE --}}
            <div class="text-center mt-1 mb-7">

                <div class="inline-flex items-center gap-2
                            px-4 py-2 rounded-full
                            bg-emerald-400/10
                            border border-emerald-300/10
                            text-emerald-300
                            text-xs font-semibold
                            tracking-[0.15em]">

                    <i data-lucide="sparkles"
                       class="w-4 h-4"></i>

                    AI VISION SCAN

                </div>


                <h1 class="text-2xl sm:text-3xl md:text-4xl
                           font-bold mt-4">

                    Scan Makanan

                </h1>


                <p class="text-white/50
                          mt-2 text-sm md:text-base">

                    Arahkan kamera ke makanan untuk
                    mengenali estimasi nutrisinya.

                </p>

            </div>


            {{-- ================= CAMERA ================= --}}
            <div class="relative mx-auto
                        w-full max-w-[850px]
                        aspect-[4/5] sm:aspect-[16/10] lg:aspect-[16/9]
                        min-h-0 lg:min-h-[430px]
                        rounded-[26px] sm:rounded-[35px]
                        overflow-hidden
                        border border-white/10
                        bg-[#17231F]
                        shadow-2xl">


                {{-- PLACEHOLDER --}}
                <div id="cameraPlaceholder"
                     class="absolute inset-0
                            flex flex-col
                            items-center justify-center
                            text-center p-8">

                    <div class="w-24 h-24
                                rounded-full
                                bg-white/5
                                border border-white/10
                                flex items-center justify-center">

                        <i data-lucide="camera"
                           class="w-10 h-10
                                  text-white/40"></i>

                    </div>


                    <h2 class="text-xl
                               font-semibold mt-5">

                        Kamera Siap Digunakan

                    </h2>


                    <p class="text-white/40
                              text-sm max-w-md mt-2">

                        Tekan tombol kamera untuk
                        memulai simulasi pemindaian makanan.

                    </p>

                </div>


                {{-- SCANNER CORNERS --}}
                <div class="absolute inset-[12%]
                            pointer-events-none">

                    <span class="absolute top-0 left-0
                                 w-16 h-16
                                 border-t-4 border-l-4
                                 border-emerald-300
                                 rounded-tl-2xl">
                    </span>

                    <span class="absolute top-0 right-0
                                 w-16 h-16
                                 border-t-4 border-r-4
                                 border-emerald-300
                                 rounded-tr-2xl">
                    </span>

                    <span class="absolute bottom-0 left-0
                                 w-16 h-16
                                 border-b-4 border-l-4
                                 border-emerald-300
                                 rounded-bl-2xl">
                    </span>

                    <span class="absolute bottom-0 right-0
                                 w-16 h-16
                                 border-b-4 border-r-4
                                 border-emerald-300
                                 rounded-br-2xl">
                    </span>

                </div>


                {{-- SCAN LINE --}}
                <div id="scanLine"
                     class="hidden absolute
                            left-[12%] right-[12%]
                            top-1/2 h-[2px]
                            bg-emerald-300
                            shadow-[0_0_18px_rgba(110,231,183,0.8)]">
                </div>


                {{-- STATUS --}}
                <div class="absolute top-5 left-5
                            flex items-center gap-2
                            px-4 py-2
                            rounded-full
                            bg-black/30
                            backdrop-blur-md
                            text-xs text-white/70">

                    <span class="w-2 h-2
                                 bg-emerald-400
                                 rounded-full">
                    </span>

                    AI Camera Ready

                </div>


                {{-- FLASH --}}
                <button type="button"
                        class="absolute top-5 right-5
                               w-10 h-10 rounded-full
                               bg-black/30
                               backdrop-blur-md
                               flex items-center justify-center">

                    <i data-lucide="zap"
                       class="w-4 h-4 text-white/70"></i>

                </button>

            </div>


            {{-- INSTRUCTION --}}
            <div class="flex items-center
                        justify-center gap-2
                        mt-6 text-white/50 text-sm">

                <i data-lucide="scan"
                   class="w-4 h-4 text-emerald-300"></i>

                Pastikan seluruh makanan terlihat
                di dalam area pemindaian.

            </div>


            {{-- CAMERA BUTTONS --}}
            <div class="flex items-center
                        justify-center gap-7 mt-7">

                <button type="button"
                        class="w-14 h-14 rounded-full
                               bg-white/10
                               border border-white/10
                               flex items-center justify-center
                               hover:bg-white/15 transition">

                    <i data-lucide="image"
                       class="w-5 h-5 text-white/70"></i>

                </button>


                <button type="button"
                        onclick="startScan()"
                        class="relative w-20 h-20
                               rounded-full
                               border-4 border-white/20
                               flex items-center justify-center
                               hover:scale-105 transition">

                    <span class="w-16 h-16
                                 rounded-full
                                 bg-gradient-to-br
                                 from-emerald-300
                                 to-[#4B988D]
                                 flex items-center justify-center
                                 shadow-lg
                                 shadow-emerald-900/30">

                        <i data-lucide="camera"
                           class="w-7 h-7 text-white"></i>

                    </span>

                </button>


                <button type="button"
                        class="w-14 h-14 rounded-full
                               bg-white/10
                               border border-white/10
                               flex items-center justify-center
                               hover:bg-white/15 transition">

                    <i data-lucide="refresh-cw"
                       class="w-5 h-5 text-white/70"></i>

                </button>

            </div>

        </div>

    </main>

</div>


{{-- ================= MOBILE BOTTOM NAVIGATION ================= --}}
<nav class="lg:hidden fixed bottom-3 left-3 right-3 z-40 rounded-[26px]
            bg-[#16221F]/95 backdrop-blur-xl border border-white/10
            shadow-[0_14px_40px_rgba(0,0,0,0.35)] px-2 pt-2.5
            pb-[max(0.65rem,env(safe-area-inset-bottom))]">
    <div class="max-w-md mx-auto grid grid-cols-6 items-end">

        <a href="{{ route('dashboard') }}" class="group flex flex-col items-center gap-1.5 min-w-0 text-white/45 hover:text-emerald-300 transition active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center group-hover:bg-white/5"><i data-lucide="house" class="w-[19px] h-[19px]"></i></span>
            <span class="text-[9px] sm:text-[10px] truncate w-full text-center">Beranda</span>
        </a>

        <a href="{{ route('nutrition') }}" class="group flex flex-col items-center gap-1.5 min-w-0 text-white/45 hover:text-emerald-300 transition active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center group-hover:bg-white/5"><i data-lucide="clipboard-list" class="w-[19px] h-[19px]"></i></span>
            <span class="text-[9px] sm:text-[10px] truncate w-full text-center">Nutrisi</span>
        </a>

        <a href="{{ route('food.scan') }}" class="group relative flex flex-col items-center gap-1.5 min-w-0 text-emerald-300 transition active:scale-90">
            <span class="absolute -top-2 w-7 h-1 rounded-full bg-emerald-300 shadow-[0_2px_12px_rgba(110,231,183,0.55)]"></span>
            <span class="relative -mt-1 w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-300/20 to-[#4B988D]/30
                         ring-1 ring-emerald-300/20 shadow-[0_8px_20px_rgba(16,185,129,0.15)]
                         flex items-center justify-center">
                <i data-lucide="scan-line" class="w-5 h-5"></i>
                <span class="absolute -right-0.5 -top-0.5 w-2.5 h-2.5 rounded-full bg-emerald-300 border-2 border-[#16221F]"></span>
            </span>
            <span class="text-[9px] sm:text-[10px] font-bold truncate w-full text-center">Scan</span>
        </a>

        <a href="{{ route('ai.chat') }}" class="group flex flex-col items-center gap-1.5 min-w-0 text-white/45 hover:text-emerald-300 transition active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center group-hover:bg-white/5"><i data-lucide="message-circle" class="w-[19px] h-[19px]"></i></span>
            <span class="text-[9px] sm:text-[10px] truncate w-full text-center">Tanya AI</span>
        </a>

        <a href="{{ route('children.index') }}" class="group flex flex-col items-center gap-1.5 min-w-0 text-white/45 hover:text-emerald-300 transition active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center group-hover:bg-white/5"><i data-lucide="baby" class="w-[19px] h-[19px]"></i></span>
            <span class="text-[9px] sm:text-[10px] truncate w-full text-center">Anak</span>
        </a>

        <a href="{{ route('profile.edit') }}" class="group flex flex-col items-center gap-1.5 min-w-0 text-white/45 hover:text-emerald-300 transition active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center group-hover:bg-white/5"><i data-lucide="user-round" class="w-[19px] h-[19px]"></i></span>
            <span class="text-[9px] sm:text-[10px] truncate w-full text-center">Profil</span>
        </a>
    </div>
</nav>

{{-- ================= LOADING ================= --}}
<div id="scanLoading"
     class="hidden fixed inset-0 z-50
            bg-[#0D1614]/90
            backdrop-blur-md
            items-center justify-center">

    <div class="text-center px-6 text-white">

        <div class="relative
                    w-24 h-24 mx-auto">

            <div class="absolute inset-0
                        rounded-full
                        border-4 border-white/10">
            </div>

            <div class="absolute inset-0
                        rounded-full
                        border-4 border-transparent
                        border-t-emerald-300
                        animate-spin">
            </div>

            <div class="absolute inset-0
                        flex items-center justify-center">

                <i data-lucide="sparkles"
                   class="w-8 h-8
                          text-emerald-300"></i>

            </div>

        </div>


        <h2 class="text-2xl font-bold mt-7">
            Menganalisis Makanan...
        </h2>

        <p class="text-white/50 mt-2">
            AI GrowCare sedang menghitung estimasi nutrisi.
        </p>

    </div>

</div>


{{-- ================= RESULT ================= --}}
<div id="scanResult"
     class="hidden fixed inset-0 z-50
            bg-black/50 backdrop-blur-md
            items-end sm:items-center justify-center p-0 sm:p-5">

    <div class="bg-[#FBFAF6]
                text-[#202725]
                w-full max-w-lg
                rounded-t-[30px] sm:rounded-[32px]
                p-5 sm:p-7 shadow-2xl max-h-[92vh] overflow-y-auto">

        <div class="flex items-start justify-between">

            <div>

                <span class="inline-flex
                             items-center gap-2
                             bg-[#E0F0EB]
                             text-[#438F83]
                             rounded-full
                             px-3 py-1
                             text-xs font-semibold">

                    <i data-lucide="sparkles"
                       class="w-3 h-3"></i>

                    HASIL AI

                </span>


                <h2 class="text-2xl font-bold mt-3">
                    Nasi Ayam & Sayur
                </h2>

                <p class="text-gray-400 text-sm mt-1">
                    Estimasi 1 porsi
                </p>

            </div>


            <button type="button"
                    onclick="closeResult()"
                    class="w-10 h-10
                           rounded-full bg-gray-100
                           flex items-center justify-center">

                <i data-lucide="x"
                   class="w-5 h-5"></i>

            </button>

        </div>


        {{-- KALORI --}}
        <div class="mt-6
                    bg-[#DCEFE9]
                    rounded-2xl p-5">

            <p class="text-sm text-gray-500">
                Estimasi Kalori
            </p>

            <div class="flex items-end gap-2 mt-1">

                <h3 class="text-4xl font-bold">
                    325
                </h3>

                <span class="text-gray-500 mb-1">
                    kkal
                </span>

            </div>

        </div>


        {{-- MACRO --}}
        <div class="grid grid-cols-3 gap-3 mt-4">

            <div class="bg-white
                        border border-stone-100
                        rounded-2xl p-4 text-center">

                <span class="text-xs text-gray-400">
                    Protein
                </span>

                <p class="font-bold text-lg mt-1">
                    21g
                </p>

            </div>


            <div class="bg-white
                        border border-stone-100
                        rounded-2xl p-4 text-center">

                <span class="text-xs text-gray-400">
                    Lemak
                </span>

                <p class="font-bold text-lg mt-1">
                    9g
                </p>

            </div>


            <div class="bg-white
                        border border-stone-100
                        rounded-2xl p-4 text-center">

                <span class="text-xs text-gray-400">
                    Karbo
                </span>

                <p class="font-bold text-lg mt-1">
                    42g
                </p>

            </div>

        </div>


        {{-- INFO --}}
        <div class="flex gap-3
                    bg-amber-50
                    rounded-2xl p-4 mt-4">

            <i data-lucide="info"
               class="w-5 h-5
                      text-amber-600
                      flex-shrink-0 mt-0.5"></i>

            <p class="text-xs
                      leading-5 text-amber-800">

                Hasil ini merupakan simulasi estimasi AI
                dan bukan pengganti penilaian ahli gizi
                atau dokter.

            </p>

        </div>


        {{-- BUTTON --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-6">

            <button type="button"
                    onclick="closeResult()"
                    class="py-3
                           border border-stone-200
                           rounded-2xl font-semibold">

                Scan Ulang

            </button>


            <button type="button"
                    onclick="saveFood()"
                    class="py-3
                           bg-[#4B988D]
                           text-white
                           rounded-2xl font-semibold">

                Tambah ke Nutrisi

            </button>

        </div>

    </div>

</div>


<script>

    lucide.createIcons();


    function startScan() {

        const line =
            document.getElementById('scanLine');

        line.classList.remove('hidden');


        setTimeout(() => {

            const loading =
                document.getElementById('scanLoading');

            loading.classList.remove('hidden');
            loading.classList.add('flex');

        }, 400);


        setTimeout(() => {

            const loading =
                document.getElementById('scanLoading');

            loading.classList.add('hidden');
            loading.classList.remove('flex');

            line.classList.add('hidden');


            const result =
                document.getElementById('scanResult');

            result.classList.remove('hidden');
            result.classList.add('flex');

            lucide.createIcons();

        }, 2200);

    }


    function closeResult() {

        const result =
            document.getElementById('scanResult');

        result.classList.add('hidden');
        result.classList.remove('flex');

    }


    function saveFood() {

        window.location.href =
            "{{ route('nutrition') }}";

    }

</script>

</body>
</html>