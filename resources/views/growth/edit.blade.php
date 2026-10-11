<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ubah Pengukuran {{ $child->name }} - GrowCare</title>

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
        <div class="max-w-[850px] mx-auto w-full min-w-0 px-4 sm:px-6 md:px-8 py-5 sm:py-7">

            {{-- BREADCRUMB --}}
            <a href="{{ route('children.growth-records.index', $child) }}"
               class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-[#438F83] transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Riwayat Pertumbuhan
            </a>

            <div class="mt-4">
                <h1 class="text-2xl sm:text-3xl font-bold">
                    Ubah Catatan Pertumbuhan
                </h1>
                <p class="text-gray-400 text-sm mt-1">
                    Perbarui data pengukuran anak untuk tanggal {{ $record->measurement_date ? $record->measurement_date->format('d M Y') : '' }}.
                </p>
            </div>

            {{-- CHILD INFO CARD --}}
            <div class="mt-6 bg-[#EAF5F2] border border-[#BFDCD6] rounded-2xl p-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-white text-[#438F83] flex items-center justify-center text-2xl font-bold shrink-0">
                    {{ $child->gender === 'P' ? '👧' : '👦' }}
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-[#234D48] text-base truncate">{{ $child->name }}</h3>
                    <p class="text-xs text-[#438F83] mt-0.5">
                        Lahir: {{ $child->birth_date ? $child->birth_date->format('d M Y') : '-' }} • 
                        Lahir: BB {{ $child->birth_weight ? $child->birth_weight . ' kg' : '-' }} / PB {{ $child->birth_height ? $child->birth_height . ' cm' : '-' }}
                    </p>
                </div>
            </div>

            {{-- FORM CARD --}}
            <div class="bg-white rounded-[26px] border border-stone-100 p-6 sm:p-8 mt-6">
                @if($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700">
                        <div class="flex items-center gap-2 font-semibold text-sm">
                            <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0 text-red-500"></i>
                            Terdapat beberapa kesalahan input:
                        </div>
                        <ul class="list-disc list-inside text-xs mt-2 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('children.growth-records.update', [$child, $record]) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- TANGGAL PENGUKURAN --}}
                    <div>
                        <label for="measurement_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Pengukuran <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="date"
                                   id="measurement_date"
                                   name="measurement_date"
                                   value="{{ old('measurement_date', $record->measurement_date ? $record->measurement_date->format('Y-m-d') : '') }}"
                                   min="{{ $child->birth_date ? $child->birth_date->format('Y-m-d') : '' }}"
                                   max="{{ now()->format('Y-m-d') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-2xl border @error('measurement_date') border-red-300 ring-1 ring-red-300 @else border-stone-200 @enderror focus:outline-none focus:ring-2 focus:ring-[#438F83] focus:border-transparent transition text-sm">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">
                            Tanggal pengukuran tidak boleh sebelum tanggal lahir ({{ $child->birth_date ? $child->birth_date->format('d/m/Y') : '-' }}) atau melebihi hari ini.
                        </p>
                        @error('measurement_date')
                            <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- BERAT & TINGGI GRID --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        {{-- BERAT BADAN --}}
                        <div>
                            <label for="weight" class="block text-sm font-semibold text-gray-700 mb-2">
                                Berat Badan (kg) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       id="weight"
                                       name="weight"
                                       step="0.01"
                                       min="0.1"
                                       max="200"
                                       placeholder="Contoh: 8.5"
                                       value="{{ old('weight', $record->weight) }}"
                                       required
                                       class="w-full px-4 py-3 rounded-2xl border @error('weight') border-red-300 ring-1 ring-red-300 @else border-stone-200 @enderror focus:outline-none focus:ring-2 focus:ring-[#438F83] focus:border-transparent transition text-sm pr-12">
                                <span class="absolute right-4 top-3.5 text-xs text-gray-400 font-medium">kg</span>
                            </div>
                            @error('weight')
                                <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- TINGGI BADAN --}}
                        <div>
                            <label for="height" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tinggi / Panjang Badan (cm) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       id="height"
                                       name="height"
                                       step="0.1"
                                       min="1"
                                       max="250"
                                       placeholder="Contoh: 75.0"
                                       value="{{ old('height', $record->height) }}"
                                       required
                                       class="w-full px-4 py-3 rounded-2xl border @error('height') border-red-300 ring-1 ring-red-300 @else border-stone-200 @enderror focus:outline-none focus:ring-2 focus:ring-[#438F83] focus:border-transparent transition text-sm pr-12">
                                <span class="absolute right-4 top-3.5 text-xs text-gray-400 font-medium">cm</span>
                            </div>
                            @error('height')
                                <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- LINGKAR KEPALA --}}
                    <div>
                        <label for="head_circumference" class="block text-sm font-semibold text-gray-700 mb-2">
                            Lingkar Kepala (cm) <span class="text-xs font-normal text-gray-400">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <input type="number"
                                   id="head_circumference"
                                   name="head_circumference"
                                   step="0.1"
                                   min="1"
                                   max="100"
                                   placeholder="Contoh: 43.0"
                                   value="{{ old('head_circumference', $record->head_circumference) }}"
                                   class="w-full px-4 py-3 rounded-2xl border @error('head_circumference') border-red-300 ring-1 ring-red-300 @else border-stone-200 @enderror focus:outline-none focus:ring-2 focus:ring-[#438F83] focus:border-transparent transition text-sm pr-12">
                            <span class="absolute right-4 top-3.5 text-xs text-gray-400 font-medium">cm</span>
                        </div>
                        @error('head_circumference')
                            <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- CATATAN --}}
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                            Catatan Tambahan <span class="text-xs font-normal text-gray-400">(Opsional)</span>
                        </label>
                        <textarea id="notes"
                                  name="notes"
                                  rows="3"
                                  placeholder="Contoh: Pengukuran di Posyandu Melati, kondisi anak aktif dan sehat."
                                  class="w-full px-4 py-3 rounded-2xl border @error('notes') border-red-300 ring-1 ring-red-300 @else border-stone-200 @enderror focus:outline-none focus:ring-2 focus:ring-[#438F83] focus:border-transparent transition text-sm">{{ old('notes', $record->notes) }}</textarea>
                        @error('notes')
                            <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- SUBMIT BUTTONS --}}
                    <div class="pt-4 flex flex-col sm:flex-row items-center gap-3">
                        <button type="submit"
                                class="w-full sm:w-auto px-8 py-3.5 bg-[#438F83] hover:bg-[#38786E] text-white font-semibold rounded-2xl shadow-sm transition flex items-center justify-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Perbarui Pengukuran
                        </button>

                        <a href="{{ route('children.growth-records.index', $child) }}"
                           class="w-full sm:w-auto px-6 py-3.5 bg-white border border-stone-200 text-gray-600 hover:bg-stone-50 font-semibold rounded-2xl transition text-center">
                            Batal
                        </a>
                    </div>
                </form>
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
