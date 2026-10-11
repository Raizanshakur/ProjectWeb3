<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Pertumbuhan {{ $child->name }} - GrowCare</title>

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
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-[#E0F0EB] text-[#438F83] flex items-center justify-center">
                    <i data-lucide="sprout" class="w-5 h-5"></i>
                </div>
                <div class="ml-3 text-2xl font-bold">
                    <span class="text-[#438F83]">Grow</span>Care
                </div>
            </a>
        </div>

        {{-- MENU --}}
        <div class="px-5">
            <p class="px-4 mb-4 text-xs tracking-[0.2em] text-gray-400 font-semibold">
                MENU
            </p>

            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-4 px-4 py-4 rounded-2xl text-gray-600 hover:bg-white transition">
                    <span class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                        <i data-lucide="house" class="w-5 h-5"></i>
                    </span>
                    Beranda
                </a>

                <a href="{{ route('nutrition') }}"
                   class="flex items-center gap-4 px-4 py-4 rounded-2xl text-gray-600 hover:bg-white transition">
                    <span class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                        <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                    </span>
                    Nutrisi
                </a>

                <a href="{{ route('food.scan') }}"
                   class="flex items-center gap-4 px-4 py-4 rounded-2xl text-gray-600 hover:bg-white transition">
                    <span class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                        <i data-lucide="scan-line" class="w-5 h-5"></i>
                    </span>
                    AI Food Scan
                </a>

                <a href="{{ route('ai.chat') }}"
                   class="flex items-center gap-4 px-4 py-4 rounded-2xl text-gray-600 hover:bg-white transition">
                    <span class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                    </span>
                    Tanya AI
                </a>

                <a href="{{ route('children.index') }}"
                   class="flex items-center gap-4 px-4 py-4 rounded-2xl bg-[#E0F0EB] text-[#438F83] font-semibold transition">
                    <span class="w-10 h-10 rounded-full bg-white text-[#438F83] flex items-center justify-center">
                        <i data-lucide="baby" class="w-5 h-5"></i>
                    </span>
                    Data Anak
                </a>
            </nav>
        </div>

        {{-- BOTTOM PROFILE --}}
        <div class="mt-auto p-5">
            <div class="bg-white rounded-2xl p-4 border border-stone-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#E0F0EB] text-[#438F83] flex items-center justify-center font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">Orang Tua</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-3 pt-3 border-t border-stone-100">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 text-xs text-red-500 hover:text-red-600 transition">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ================= MAIN ================= --}}
    <main class="w-full min-w-0 lg:ml-[285px] pt-16 lg:pt-0 pb-28 lg:pb-0">
        <div class="max-w-[1450px] mx-auto w-full min-w-0 px-4 sm:px-5 md:px-8 lg:px-10 py-5 sm:py-7">

            {{-- TOP BREADCRUMB & ACTIONS --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <a href="{{ route('children.show', $child) }}"
                       class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-[#438F83] transition">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Kembali ke Detail {{ $child->name }}
                    </a>
                    <h1 class="text-2xl sm:text-3xl font-bold mt-2">
                        Riwayat Pertumbuhan
                    </h1>
                    <p class="text-gray-400 text-sm mt-1">
                        Daftar lengkap catatan tinggi, berat badan, dan lingkar kepala si kecil.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('children.show', $child) }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-stone-200 text-gray-600 rounded-xl text-sm font-semibold hover:bg-stone-50 transition">
                        <i data-lucide="line-chart" class="w-4 h-4"></i>
                        Lihat Grafik
                    </a>

                    <a href="{{ route('children.growth-records.create', $child) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#438F83] hover:bg-[#38786E] text-white rounded-xl text-sm font-semibold shadow-sm transition">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Tambah Pengukuran
                    </a>
                </div>
            </div>

            {{-- FLASH MESSAGE --}}
            @if(session('success'))
                <div class="mt-5 p-4 rounded-2xl bg-[#EAF5F2] border border-[#BFDCD6] text-[#234D48] flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-[#438F83] shrink-0"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            {{-- SUMMARY STATS --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                {{-- CARD 1: DATA LAHIR --}}
                <div class="bg-white rounded-2xl border border-stone-100 p-5">
                    <span class="text-xs text-gray-400 font-medium">Data Saat Lahir</span>
                    <h4 class="text-xl font-bold mt-2">
                        {{ $child->birth_weight ? $child->birth_weight . ' kg' : '-' }}
                        <span class="text-sm font-normal text-gray-400">• {{ $child->birth_height ? $child->birth_height . ' cm' : '-' }}</span>
                    </h4>
                    <p class="text-xs text-gray-400 mt-1">
                        Lahir: {{ $child->birth_date ? $child->birth_date->format('d M Y') : '-' }}
                    </p>
                </div>

                {{-- CARD 2: PENGUKURAN TERAKHIR --}}
                <div class="bg-white rounded-2xl border border-stone-100 p-5">
                    <span class="text-xs text-[#438F83] font-medium">Pengukuran Terakhir</span>
                    <h4 class="text-xl font-bold mt-2">
                        @if($latestRecord)
                            {{ $latestRecord->weight }} kg
                            <span class="text-sm font-normal text-gray-400">• {{ $latestRecord->height }} cm</span>
                        @else
                            <span class="text-base text-gray-400 font-normal">Belum ada data</span>
                        @endif
                    </h4>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $latestRecord ? 'Tanggal: ' . $latestRecord->measurement_date->format('d M Y') : 'Silakan catat pengukuran pertama' }}
                    </p>
                </div>

                {{-- CARD 3: TOTAL PENGUKURAN --}}
                <div class="bg-white rounded-2xl border border-stone-100 p-5">
                    <span class="text-xs text-gray-400 font-medium">Total Pengukuran</span>
                    <h4 class="text-xl font-bold mt-2">
                        {{ $records->count() }} <span class="text-sm font-normal text-gray-400">kali dicatat</span>
                    </h4>
                    <p class="text-xs text-gray-400 mt-1">
                        Urutan dari pengukuran terbaru
                    </p>
                </div>
            </div>

            {{-- DATA TABLE / LIST --}}
            <div class="bg-white rounded-[26px] border border-stone-100 p-4 sm:p-6 mt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Semua Catatan Pertumbuhan</h3>
                    <span class="text-xs text-gray-400 font-medium">Total: {{ $records->count() }} data</span>
                </div>

                @if($records->isEmpty())
                    <div class="text-center py-12 border-2 border-dashed border-stone-200 rounded-2xl bg-[#FBFAF6]">
                        <span class="w-14 h-14 rounded-full bg-[#EDF5F2] text-[#438F83] inline-flex items-center justify-center mb-3">
                            <i data-lucide="scale" class="w-7 h-7"></i>
                        </span>
                        <h4 class="text-base font-bold text-gray-700">Belum Ada Catatan Pertumbuhan</h4>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto">
                            Catat pertumbuhan berat dan tinggi badan si kecil secara rutin untuk memantau perkembangannya.
                        </p>
                        <a href="{{ route('children.growth-records.create', $child) }}"
                           class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-[#438F83] hover:bg-[#38786E] text-white text-xs font-semibold rounded-xl transition">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Tambah Pengukuran Pertama
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-stone-100 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    <th class="py-3 px-4">Tanggal</th>
                                    <th class="py-3 px-4">Berat Badan</th>
                                    <th class="py-3 px-4">Tinggi Badan</th>
                                    <th class="py-3 px-4">Lingkar Kepala</th>
                                    <th class="py-3 px-4">Catatan</th>
                                    <th class="py-3 px-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-50">
                                @foreach($records as $record)
                                    <tr class="hover:bg-stone-50/70 transition">
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <div class="font-semibold text-gray-800">
                                                {{ $record->measurement_date->translatedFormat('d F Y') }}
                                            </div>
                                            <div class="text-xs font-normal text-gray-400 mt-0.5">
                                                Usia: {{ $record->age_at_measurement_formatted }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <span class="font-bold text-[#438F83]">{{ $record->weight }}</span> kg
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <span class="font-bold text-[#438F83]">{{ $record->height }}</span> cm
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap text-gray-600">
                                            {{ $record->head_circumference ? $record->head_circumference . ' cm' : '-' }}
                                        </td>
                                        <td class="py-4 px-4 text-xs text-gray-500 max-w-xs">
                                            @if($record->nutrition_status)
                                                <span class="inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold bg-[#EAF5F2] text-[#438F83] mb-1">
                                                    {{ $record->nutrition_status }}
                                                </span>
                                            @endif
                                            <p class="truncate">{{ $record->notes ?? '-' }}</p>
                                        </td>
                                        <td class="py-4 px-4 text-right whitespace-nowrap">
                                            <div class="inline-flex items-center gap-1">
                                                <a href="{{ route('children.growth-records.edit', [$child, $record]) }}"
                                                   class="p-2 text-gray-400 hover:text-[#438F83] hover:bg-stone-100 rounded-lg transition"
                                                   title="Ubah Catatan">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </a>

                                                <form action="{{ route('children.growth-records.destroy', [$child, $record]) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pengukuran ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="p-2 text-gray-400 hover:text-red-500 hover:bg-stone-100 rounded-lg transition"
                                                            title="Hapus Catatan">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </main>

    {{-- ================= MOBILE BOTTOM NAV ================= --}}
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-xl border-t border-stone-200 px-3 py-2">
        <div class="flex items-center justify-around max-w-md mx-auto">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-[#438F83]">
                <i data-lucide="house" class="w-5 h-5"></i>
                <span class="text-[10px]">Beranda</span>
            </a>
            <a href="{{ route('nutrition') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-[#438F83]">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                <span class="text-[10px]">Nutrisi</span>
            </a>
            <a href="{{ route('food.scan') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-[#438F83]">
                <i data-lucide="scan-line" class="w-5 h-5"></i>
                <span class="text-[10px]">Scan</span>
            </a>
            <a href="{{ route('ai.chat') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-[#438F83]">
                <i data-lucide="message-circle" class="w-5 h-5"></i>
                <span class="text-[10px]">Tanya AI</span>
            </a>
            <a href="{{ route('children.index') }}" class="flex flex-col items-center gap-1 text-[#438F83] font-bold">
                <i data-lucide="baby" class="w-5 h-5"></i>
                <span class="text-[10px]">Anak</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-[#438F83]">
                <i data-lucide="user-round" class="w-5 h-5"></i>
                <span class="text-[10px]">Profil</span>
            </a>
        </div>
    </nav>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>
