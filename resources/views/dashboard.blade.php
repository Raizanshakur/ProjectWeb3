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
    <x-growcare-sidebar active="dashboard" />



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


                    <!-- Notifikasi Bell Dropdown (Parent - Sage Green Theme) -->
                    @php
                        $parentUser = Auth::user();
                        $unreadParentNotifCount = $parentUser ? $parentUser->unreadNotifications()->count() : 0;
                        $parentNotifications = $parentUser ? $parentUser->notifications()->latest()->take(10)->get() : collect();
                    @endphp
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
                        <button type="button"
                                @click="open = !open"
                                aria-label="Notifikasi"
                                class="relative w-11 h-11 bg-white border border-stone-200 rounded-full flex items-center justify-center shadow-sm hover:border-[#438F83] hover:text-[#438F83] transition cursor-pointer">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span id="parentNotificationBadge"
                                  class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1.5 bg-[#438F83] text-white text-[11px] font-bold rounded-full flex items-center justify-center ring-2 ring-white shadow-xs {{ $unreadParentNotifCount > 0 ? '' : 'hidden' }}">
                                {{ $unreadParentNotifCount > 99 ? '99+' : $unreadParentNotifCount }}
                            </span>
                        </button>

                        <!-- Dropdown Panel (Parent) -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             class="absolute right-0 mt-2.5 w-80 sm:w-96 bg-white rounded-3xl shadow-xl border border-stone-200 z-50 overflow-hidden"
                             style="display: none;">
                            
                            <!-- Header -->
                            <div class="p-4 bg-[#F8F7F2] border-b border-stone-200 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-bold text-sm text-[#202725]">Notifikasi</h3>
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-[#E0F0EB] text-[#2D635B]">
                                        {{ $unreadParentNotifCount }} baru
                                    </span>
                                </div>
                                @if($unreadParentNotifCount > 0)
                                    <form action="{{ route('notifications.read-all') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs font-semibold text-[#438F83] hover:text-[#2D635B] hover:underline cursor-pointer">
                                            Tandai Semua Dibaca
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <!-- List -->
                            <div class="max-h-80 overflow-y-auto divide-y divide-stone-100">
                                @forelse($parentNotifications as $notif)
                                    @php
                                        $diffSec = abs(\Carbon\Carbon::now()->diffInSeconds($notif->created_at));
                                        $timeText = $diffSec < 60 ? 'Baru saja' : $notif->created_at->locale('id')->diffForHumans();
                                        $isUnread = $notif->unread();
                                    @endphp
                                    <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="w-full text-left p-3.5 flex items-start gap-3 transition-colors {{ $isUnread ? 'bg-[#F4FAF7] hover:bg-[#EAF5F0]' : 'bg-white hover:bg-stone-50' }} cursor-pointer">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mt-0.5 {{ $isUnread ? 'bg-[#E0F0EB] text-[#438F83]' : 'bg-stone-100 text-stone-500' }}">
                                                <i data-lucide="{{ $notif->data['icon'] ?? 'bell' }}" class="w-4 h-4"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between gap-2 mb-0.5">
                                                    <h4 class="text-xs font-bold truncate {{ $isUnread ? 'text-[#202725]' : 'text-stone-700' }}">
                                                        {{ $notif->data['title'] ?? 'Pemberitahuan' }}
                                                    </h4>
                                                    @if($isUnread)
                                                        <span class="w-2 h-2 rounded-full bg-[#438F83] shrink-0" title="Belum dibaca"></span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">
                                                    {{ $notif->data['message'] ?? '' }}
                                                </p>
                                                <span class="text-[10px] text-gray-400 mt-1 block">
                                                    {{ $timeText }}
                                                </span>
                                            </div>
                                        </button>
                                    </form>
                                @empty
                                    <div class="py-10 px-4 text-center">
                                        <div class="w-10 h-10 rounded-full bg-[#E0F0EB] text-[#438F83] flex items-center justify-center mx-auto mb-2.5">
                                            <i data-lucide="bell-off" class="w-5 h-5"></i>
                                        </div>
                                        <p class="text-xs font-bold text-gray-800">Belum ada notifikasi</p>
                                        <p class="text-[11px] text-gray-500 mt-0.5">Pemberitahuan aktivitas konsultasi dokter akan muncul di sini.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>

            </div>



            {{-- ================= PILIH ANAK ================= --}}
            <div class="flex gap-3
                        overflow-x-auto
                        pb-3 mb-2">

                @forelse($children as $child)

                    <a href="{{ route('dashboard', ['child_id' => $child->id]) }}"
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

                            {{ $child->age_in_months }} bln

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

                                    @if($latestGrowthRecord)
                                        Pertumbuhan
                                    @else
                                        Data belum cukup
                                    @endif

                                </span>


                                <h2 class="text-3xl sm:text-4xl
                                           font-bold mt-4">
                                    @if($latestGrowthRecord && $latestGrowthRecord->nutrition_status)
                                        {{ $latestGrowthRecord->nutrition_status }}
                                    @elseif($latestGrowthRecord)
                                        Tercatat
                                    @else
                                        Belum dinilai
                                    @endif
                                </h2>

                                <p class="text-gray-600 mt-1">
                                    @if($latestGrowthRecord)
                                        Berat {{ $latestGrowthRecord->weight }} kg • Tinggi {{ $latestGrowthRecord->height }} cm
                                    @else
                                        Belum ada catatan pengukuran
                                    @endif
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
                                        @if($latestGrowthRecord)
                                            {{ $latestGrowthRecord->weight }}
                                        @else
                                            -
                                        @endif
                                    </p>

                                    <p class="text-[10px]
                                              text-gray-500">
                                        @if($latestGrowthRecord)
                                            kg
                                        @else
                                            status
                                        @endif
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



                    {{-- BERAT LAHIR / TERKINI --}}
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
                                         {{ $latestGrowthRecord ? 'bg-green-50 text-green-700' : 'bg-stone-100 text-stone-600' }}
                                         rounded-full
                                         px-2 py-1 h-fit font-medium">

                                {{ $latestGrowthRecord ? 'Terkini' : 'Data lahir' }}

                            </span>

                        </div>


                        <p class="text-xs
                                  text-gray-500
                                  mt-5 tracking-wide">

                            {{ $latestGrowthRecord ? 'BERAT TERKINI' : 'BERAT LAHIR' }}

                        </p>


                        <h3 class="text-3xl
                                   font-bold mt-1">

                            @if($latestGrowthRecord)

                                {{ $latestGrowthRecord->weight }}

                                <span class="text-base
                                             font-normal ml-1">
                                    kg
                                </span>

                            @elseif($selectedChild->birth_weight)

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

                            @php
                                $wList = $growthChartData['weights'] ?? [];
                                $wCount = count($wList);
                            @endphp

                            @if($wCount > 0)
                                <span class="h-2 w-full bg-[#DDEBE8] rounded-full"></span>
                                <span class="h-3 w-full bg-[#BFD9D4] rounded-full"></span>
                                <span class="h-4 w-full bg-[#9BC7BF] rounded-full"></span>
                                <span class="h-5 w-full bg-[#72ADA3] rounded-full"></span>
                                <span class="h-7 w-full bg-[#4B988D] rounded-full"></span>
                            @else
                                <span class="h-1.5 w-full bg-stone-100 rounded-full"></span>
                                <span class="h-1.5 w-full bg-stone-100 rounded-full"></span>
                                <span class="h-1.5 w-full bg-stone-100 rounded-full"></span>
                                <span class="h-1.5 w-full bg-stone-100 rounded-full"></span>
                                <span class="h-1.5 w-full bg-stone-100 rounded-full"></span>
                            @endif

                        </div>

                    </div>



                    {{-- TINGGI LAHIR / TERKINI --}}
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
                                         {{ $latestGrowthRecord ? 'bg-amber-50 text-amber-700' : 'bg-stone-100 text-stone-600' }}
                                         rounded-full
                                         px-2 py-1 h-fit font-medium">

                                {{ $latestGrowthRecord ? 'Terkini' : 'Data lahir' }}

                            </span>

                        </div>


                        <p class="text-xs
                                  text-gray-500 mt-5">

                            {{ $latestGrowthRecord ? 'TINGGI TERKINI' : 'TINGGI LAHIR' }}

                        </p>


                        <h3 class="text-3xl
                                   font-bold mt-1">

                            @if($latestGrowthRecord)

                                {{ $latestGrowthRecord->height }}

                                <span class="text-base
                                             font-normal ml-1">
                                    cm
                                </span>

                            @elseif($selectedChild->birth_height)

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

                            @php
                                $hList = $growthChartData['heights'] ?? [];
                                $hCount = count($hList);
                            @endphp

                            @if($hCount > 0)
                                <span class="h-2 w-full bg-[#F4ECDC] rounded-full"></span>
                                <span class="h-3 w-full bg-[#EADBBE] rounded-full"></span>
                                <span class="h-4 w-full bg-[#DFC995] rounded-full"></span>
                                <span class="h-5 w-full bg-[#D5B96E] rounded-full"></span>
                                <span class="h-7 w-full bg-[#C8A14C] rounded-full"></span>
                            @else
                                <span class="h-1.5 w-full bg-stone-100 rounded-full"></span>
                                <span class="h-1.5 w-full bg-stone-100 rounded-full"></span>
                                <span class="h-1.5 w-full bg-stone-100 rounded-full"></span>
                                <span class="h-1.5 w-full bg-stone-100 rounded-full"></span>
                                <span class="h-1.5 w-full bg-stone-100 rounded-full"></span>
                            @endif

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
                                {{ number_format($dailyTotals['calories'], 0, ',', '.') }}
                            </span>

                            <span class="text-sm
                                         text-gray-500">
                                /{{ number_format($targetCalories, 0, ',', '.') }} kkal
                            </span>

                        </div>


                        <div class="h-2 bg-gray-100
                                    rounded-full mt-2
                                    overflow-hidden">

                            <div class="h-full bg-[#4B988D] rounded-full transition-all duration-300"
                                 style="width: {{ $progressBarWidth }}%;">
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
                                    {{ round($dailyTotals['protein'], 1) }}g
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
                                    {{ round($dailyTotals['fat'], 1) }}g
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
                                    {{ round($dailyTotals['carbohydrates'], 1) }}g
                                </strong>

                                <span class="text-[10px]
                                             text-gray-400">
                                    Karbo
                                </span>

                            </div>

                        </div>


                        <p class="text-[10px]
                                  text-gray-400 mt-5">
                            @if($dailyTotals['count'] > 0)
                                * Berdasarkan {{ $dailyTotals['count'] }} catatan makanan hari ini.
                            @else
                                * Belum ada catatan makanan untuk hari ini.
                            @endif
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
                            {{ $selectedChild->age_in_months }}
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
                            @if($dailyTotals['count'] > 0)
                                {{ $caloriePercentage }}%
                            @else
                                -
                            @endif
                        </h3>

                        <p class="text-xs text-gray-400">
                            @if($dailyTotals['count'] > 0)
                                terpenuhi
                            @else
                                belum ada data
                            @endif
                        </p>

                    </div>


                    <div class="bg-[#F8F2E7]
                                border border-[#ECE2D2]
                                rounded-2xl p-5">

                        <p class="text-sm text-gray-600">
                            Status Pertumbuhan
                        </p>

                        <h3 class="text-xl font-bold mt-1">
                            @if($latestGrowthRecord && $latestGrowthRecord->nutrition_status)
                                {{ $latestGrowthRecord->nutrition_status }}
                            @elseif($latestGrowthRecord)
                                Tercatat
                            @else
                                Belum dinilai
                            @endif
                        </h3>

                        <p class="text-xs text-gray-400">
                            @if($latestGrowthRecord)
                                data terkini
                            @else
                                belum ada data
                            @endif
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
                                         {{ $hasMonthlyRecord ? 'bg-green-50 text-green-500' : 'bg-amber-50 text-amber-500' }}
                                         flex items-center
                                         justify-center">

                                <i data-lucide="{{ $hasMonthlyRecord ? 'calendar-check' : 'calendar-clock' }}"
                                   class="w-5 h-5"></i>

                            </span>


                            <div class="flex-1">

                                <h3 class="font-semibold">
                                    Assessment Bulan Ini
                                </h3>

                                <p class="text-sm text-gray-400">
                                    @if($hasMonthlyRecord)
                                        Pengukuran {{ $selectedChild->name }} bulan ini sudah dicatat.
                                    @else
                                        Lengkapi pemantauan {{ $selectedChild->name }} bulan ini.
                                    @endif
                                </p>

                            </div>


                            <span class="text-xs
                                         {{ $hasMonthlyRecord ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}
                                         rounded-full
                                         px-3 py-1">

                                {{ $hasMonthlyRecord ? 'Selesai' : 'Belum diisi' }}

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


                        <div class="mt-7 divide-y divide-stone-100 border-t border-stone-100">
                            @forelse($recentActivities as $activity)
                                <div class="flex gap-4 items-center pt-4 pb-3 first:pt-4">
                                    <span class="w-11 h-11 shrink-0 rounded-full {{ $activity['icon_bg'] }} {{ $activity['icon_color'] }} flex items-center justify-center">
                                        <i data-lucide="{{ $activity['icon'] }}" class="w-5 h-5"></i>
                                    </span>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-sm truncate">
                                            {{ $activity['title'] }}
                                        </h3>
                                        <p class="text-xs text-gray-400 truncate mt-0.5">
                                            {{ $activity['description'] }}
                                        </p>
                                    </div>
                                    @if($activity['time_label'])
                                        <span class="text-[11px] text-gray-400 shrink-0">
                                            {{ $activity['time_label'] }}
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <div class="flex gap-4 items-center pt-5">
                                    <span class="w-11 h-11 rounded-full bg-[#E7F5F2] text-[#438F83] flex items-center justify-center">
                                        <i data-lucide="activity" class="w-5 h-5"></i>
                                    </span>
                                    <div>
                                        <h3 class="font-semibold">
                                            Profil Anak Tersedia
                                        </h3>
                                        <p class="text-sm text-gray-400">
                                            {{ $selectedChild->name }} berusia {{ $selectedChild->age_in_months }} bulan. Belum ada catatan aktivitas baru.
                                        </p>
                                    </div>
                                </div>
                            @endforelse
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
    window.growthChartData = @json($growthChartData ?? ['labels' => [], 'weights' => [], 'heights' => []]);
    lucide.createIcons();

    // Polling notifikasi berkala (setiap 45 detik) saat tab aktif
    setInterval(() => {
        if (document.visibilityState !== 'visible') return;
        fetch('{{ route('notifications.unread-count') }}', { credentials: 'same-origin' })
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById('parentNotificationBadge');
                if (badge) {
                    if (data.unread_count > 0) {
                        badge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }
            })
            .catch(() => {});
    }, 45000);
</script>

</body>
</html>