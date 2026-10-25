<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nutrisi - GrowCare</title>

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
    <x-growcare-sidebar active="nutrition" />


    {{-- ================= MAIN ================= --}}
    <main class="w-full min-w-0 lg:ml-[285px] pt-16 lg:pt-0 pb-28 lg:pb-0">

        <div class="max-w-[1450px] mx-auto w-full min-w-0
                    px-4 sm:px-5 md:px-8 lg:px-10
                    py-5 sm:py-8">


            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row
                        md:items-center justify-between
                        gap-5 mb-8">

                <div>
                    <p class="text-sm text-[#4B988D]
                              font-semibold mb-2">
                        NUTRISI HARIAN
                    </p>

                    <h1 class="text-2xl sm:text-3xl font-bold">
                        Log Nutrisi Anak
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Pantau asupan makanan dan kebutuhan nutrisi si kecil.
                    </p>
                </div>

                @if ($children->isNotEmpty())
                    <form method="GET" action="{{ route('nutrition') }}" class="flex flex-wrap items-center gap-3">
                        <div class="flex items-center gap-2 bg-white border border-stone-200 rounded-full py-1.5 pl-3 pr-2 shadow-sm">
                            <span class="w-8 h-8 rounded-full bg-[#E2F1ED] text-[#438F83] flex items-center justify-center shrink-0">
                                <i data-lucide="baby" class="w-4 h-4"></i>
                            </span>
                            <select name="child_id" onchange="this.form.submit()" class="border-0 bg-transparent text-sm font-semibold text-stone-800 focus:ring-0 cursor-pointer pr-8 py-1">
                                @foreach ($children as $child)
                                    <option value="{{ $child->id }}" {{ $selectedChild?->id === $child->id ? 'selected' : '' }}>
                                        {{ $child->name }} ({{ in_array($child->gender, ['L', 'male']) ? 'L' : 'P' }}{{ $child->birth_date ? ', ' . $child->age_in_months . ' bln' : '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-2 bg-white border border-stone-200 rounded-full py-1.5 px-3 shadow-sm">
                            <span class="w-8 h-8 rounded-full bg-[#E2F1ED] text-[#438F83] flex items-center justify-center shrink-0">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </span>
                            <input type="date" name="date" value="{{ $selectedDate }}" max="{{ now()->format('Y-m-d') }}" onchange="this.form.submit()" class="border-0 bg-transparent text-sm font-semibold text-stone-800 focus:ring-0 cursor-pointer py-1">
                        </div>
                    </form>
                @else
                    <a href="{{ route('children.create') }}" class="inline-flex items-center gap-2 bg-[#4B988D] text-white px-5 py-2.5 rounded-full text-sm font-semibold shadow-sm hover:bg-[#3D8379] transition">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Data Anak
                    </a>
                @endif

            </div>

            {{-- ALERT MESSAGES --}}
            @if (session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-[#E8F5F1] border border-[#C2E5DC] text-[#286358] flex items-center gap-3">
                    <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0 text-[#438F83]"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700">
                    <div class="flex items-center gap-2 mb-1 font-semibold text-sm">
                        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                        <span>Terjadi kesalahan pada input:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ================= MACRO CARDS ================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-2
                        xl:grid-cols-4 gap-5">

                {{-- KALORI --}}
                <div class="bg-[#DCEFE9] rounded-[28px]
                            p-5 sm:p-6 border border-[#C9E2DB]">

                    <div class="flex items-center justify-between">
                        <span class="w-11 h-11 bg-white/70
                                     rounded-full
                                     flex items-center justify-center
                                     text-[#438F83]">
                            <i data-lucide="flame"
                               class="w-5 h-5"></i>
                        </span>

                        <span class="text-xs text-[#438F83]
                                     bg-white/70 px-3 py-1
                                     rounded-full font-semibold">
                            {{ $dailyTotals['count'] }} Catatan
                        </span>
                    </div>

                    <p class="text-sm text-gray-500 mt-5">
                        Total Kalori {{ \Carbon\Carbon::parse($selectedDate)->isToday() ? 'Hari Ini' : 'Tanggal Ini' }}
                    </p>

                    <div class="flex items-end gap-2 mt-1">
                        <h2 class="text-3xl font-bold">
                            {{ round($dailyTotals['calories']) }}
                        </h2>
                        <span class="text-sm text-gray-500 mb-1">
                            kkal
                        </span>
                    </div>

                    <p class="text-xs text-[#438F83] mt-4 font-medium">
                        @if (($dailyTotals['target_calories'] ?? 0) > 0)
                            {{ $dailyTotals['calorie_percentage'] }}% dari target rujukan AKG ({{ $dailyTotals['target_calories'] }} kkal)
                        @else
                            Akumulasi makanan yang dikonsumsi
                        @endif
                    </p>
                    @if ($dailyTotals['has_unspecified_calories'])
                        <p class="text-[11px] text-amber-700 mt-1">
                            *Sebagian makanan tidak mencantumkan kalori
                        </p>
                    @endif
                </div>

                {{-- PROTEIN --}}
                <div class="bg-white rounded-[28px]
                            p-5 sm:p-6 border border-stone-100 shadow-sm">

                    <div class="flex items-center justify-between">
                        <span class="w-11 h-11
                                     bg-[#EAF6F3]
                                     text-[#438F83]
                                     rounded-full
                                     flex items-center justify-center">
                            <i data-lucide="drumstick"
                               class="w-5 h-5"></i>
                        </span>

                        <span class="text-xs text-gray-400">
                            Makronutrien
                        </span>
                    </div>

                    <p class="text-sm text-gray-500 mt-5">
                        Total Protein
                    </p>

                    <h2 class="text-3xl font-bold mt-1">
                        {{ round($dailyTotals['protein'], 1) }}
                        <span class="text-sm font-normal
                                     text-gray-500 ml-1">
                            g
                        </span>
                    </h2>

                    <p class="text-xs text-gray-400 mt-4">
                        Tercatat pada {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M Y') }}
                    </p>
                </div>

                {{-- LEMAK --}}
                <div class="bg-white rounded-[28px]
                            p-5 sm:p-6 border border-stone-100 shadow-sm">

                    <div class="flex items-center justify-between">
                        <span class="w-11 h-11
                                     bg-[#EFF5E8]
                                     text-[#7FA56E]
                                     rounded-full
                                     flex items-center justify-center">
                            <i data-lucide="droplets"
                               class="w-5 h-5"></i>
                        </span>

                        <span class="text-xs text-gray-400">
                            Makronutrien
                        </span>
                    </div>

                    <p class="text-sm text-gray-500 mt-5">
                        Total Lemak
                    </p>

                    <h2 class="text-3xl font-bold mt-1">
                        {{ round($dailyTotals['fat'], 1) }}
                        <span class="text-sm font-normal
                                     text-gray-500 ml-1">
                            g
                        </span>
                    </h2>

                    <p class="text-xs text-gray-400 mt-4">
                        Tercatat pada {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M Y') }}
                    </p>
                </div>

                {{-- KARBO --}}
                <div class="bg-white rounded-[28px]
                            p-5 sm:p-6 border border-stone-100 shadow-sm">

                    <div class="flex items-center justify-between">
                        <span class="w-11 h-11
                                     bg-[#FBF3E5]
                                     text-[#C49B50]
                                     rounded-full
                                     flex items-center justify-center">
                            <i data-lucide="wheat"
                               class="w-5 h-5"></i>
                        </span>

                        <span class="text-xs text-gray-400">
                            Makronutrien
                        </span>
                    </div>

                    <p class="text-sm text-gray-500 mt-5">
                        Total Karbohidrat
                    </p>

                    <h2 class="text-3xl font-bold mt-1">
                        {{ round($dailyTotals['carbohydrates'], 1) }}
                        <span class="text-sm font-normal
                                     text-gray-500 ml-1">
                            g
                        </span>
                    </h2>

                    <p class="text-xs text-gray-400 mt-4">
                        Tercatat pada {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M Y') }}
                    </p>
                </div>

            </div>


            {{-- ================= CONTENT ================= --}}
            <div class="grid grid-cols-1 xl:grid-cols-12
                        gap-6 mt-6">


                {{-- RIWAYAT MAKANAN --}}
                <div class="xl:col-span-8
                            bg-white rounded-[30px]
                            border border-stone-100
                            shadow-sm p-5 sm:p-7">

                    <div class="flex flex-col md:flex-row
                                md:items-center
                                justify-between gap-4">

                        <div>
                            <h2 class="text-2xl font-bold">
                                Riwayat Makanan
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Makanan yang dikonsumsi pada {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}
                            </p>
                        </div>

                        @if ($selectedChild)
                            <button type="button" onclick="openFoodModal()"
                                    class="flex items-center justify-center
                                           gap-2 bg-[#4B988D]
                                           hover:bg-[#3D8379]
                                           text-white rounded-full
                                           px-5 py-3 font-semibold transition">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                Tambah Makanan
                            </button>
                        @endif

                    </div>

                    {{-- SEARCH FORM --}}
                    <form method="GET" action="{{ route('nutrition') }}"
                          class="mt-6 flex items-center gap-3
                                 bg-[#F8F7F3]
                                 border border-stone-200
                                 rounded-2xl px-4 py-2.5">
                        @if ($selectedChild)
                            <input type="hidden" name="child_id" value="{{ $selectedChild->id }}">
                        @endif
                        <input type="hidden" name="date" value="{{ $selectedDate }}">

                        <i data-lucide="search" class="w-5 h-5 text-gray-400 shrink-0"></i>

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari makanan yang tercatat hari ini..."
                               class="w-full border-0 bg-transparent p-0 focus:ring-0 text-sm">

                        @if (request('search'))
                            <a href="{{ route('nutrition', ['child_id' => $selectedChild?->id, 'date' => $selectedDate]) }}"
                               class="text-xs text-stone-500 hover:text-stone-700 px-2 py-1 shrink-0">
                                Reset
                            </a>
                        @endif

                        <button type="submit"
                                class="text-xs bg-[#4B988D] text-white rounded-xl px-3.5 py-1.5 font-semibold hover:bg-[#3D8379] transition shrink-0">
                            Cari
                        </button>
                    </form>

                    {{-- MEALS LIST --}}
                    @if (! $selectedChild)
                        <div class="text-center py-12 border border-dashed border-stone-200 rounded-3xl mt-6">
                            <div class="w-14 h-14 mx-auto rounded-full bg-[#EAF6F3] text-[#438F83] flex items-center justify-center mb-3">
                                <i data-lucide="baby" class="w-7 h-7"></i>
                            </div>
                            <p class="font-semibold text-stone-700 text-base">Belum ada anak terdaftar</p>
                            <p class="text-sm text-stone-500 mt-1 max-w-sm mx-auto">
                                Daftarkan data anak Anda terlebih dahulu untuk mulai mencatat riwayat makan dan nutrisi.
                            </p>
                            <a href="{{ route('children.create') }}" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-[#4B988D] text-white text-sm font-semibold rounded-full hover:bg-[#3D8379] transition">
                                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Data Anak
                            </a>
                        </div>
                    @elseif ($meals->isEmpty())
                        <div class="text-center py-12 border border-dashed border-stone-200 rounded-3xl mt-6">
                            <div class="w-14 h-14 mx-auto rounded-full bg-[#EAF6F3] text-[#438F83] flex items-center justify-center mb-3">
                                <i data-lucide="utensils" class="w-7 h-7"></i>
                            </div>
                            <p class="font-semibold text-stone-700 text-base">Belum ada catatan makanan</p>
                            <p class="text-sm text-stone-500 mt-1 max-w-sm mx-auto">
                                @if (request('search'))
                                    Tidak ada makanan dengan kata kunci "{{ request('search') }}" pada tanggal ini.
                                @else
                                    Belum ada makanan yang dicatat untuk {{ $selectedChild->name }} pada tanggal ini.
                                @endif
                            </p>
                            <button type="button" onclick="openFoodModal()"
                                    class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-[#4B988D] text-white text-sm font-semibold rounded-full hover:bg-[#3D8379] transition">
                                <i data-lucide="plus" class="w-4 h-4"></i> Catat Makanan Sekarang
                            </button>
                        </div>
                    @else
                        <div class="mt-6 space-y-4">
                            @foreach ($meals as $meal)
                                <div class="border border-stone-100 hover:border-stone-200 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition bg-white">
                                    <div class="flex items-start sm:items-center gap-3 sm:gap-4 min-w-0">
                                        <div class="w-12 h-12 rounded-2xl bg-[#F5EFE3] flex items-center justify-center text-xl shrink-0">
                                            @if ($meal->meal_type === 'Sarapan') ☀️
                                            @elseif ($meal->meal_type === 'Snack Pagi') 🍎
                                            @elseif ($meal->meal_type === 'Makan Siang') 🍽️
                                            @elseif ($meal->meal_type === 'Snack Sore') 🥪
                                            @elseif ($meal->meal_type === 'Makan Malam') 🌙
                                            @else 🥣 @endif
                                        </div>

                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h4 class="font-semibold text-stone-900 text-base">
                                                    {{ $meal->food_name }}
                                                </h4>
                                                <span class="text-xs px-2.5 py-0.5 rounded-full font-medium {{ $meal->source === 'scan' ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'bg-stone-100 text-stone-600' }}">
                                                    {{ $meal->source === 'scan' ? 'Scan AI' : 'Manual' }}
                                                </span>
                                            </div>

                                            <p class="text-xs text-stone-400 mt-1">
                                                <span class="font-medium text-stone-600">{{ $meal->meal_type }}</span>
                                                • {{ \Carbon\Carbon::parse($meal->consumed_at)->format('H:i') }}
                                                @if ($meal->portion_text)
                                                    • {{ $meal->portion_text }}
                                                @endif
                                            </p>

                                            <div class="flex items-center gap-3 text-xs text-stone-500 mt-2 flex-wrap">
                                                <span>P: <strong class="text-stone-700">{{ $meal->protein !== null ? $meal->protein . 'g' : '-' }}</strong></span>
                                                <span>L: <strong class="text-stone-700">{{ $meal->fat !== null ? $meal->fat . 'g' : '-' }}</strong></span>
                                                <span>K: <strong class="text-stone-700">{{ $meal->carbohydrates !== null ? $meal->carbohydrates . 'g' : '-' }}</strong></span>
                                                @if ($meal->fiber !== null)
                                                    <span>Serat: <strong class="text-stone-700">{{ $meal->fiber }}g</strong></span>
                                                @endif
                                            </div>

                                            @if ($meal->notes)
                                                <p class="text-xs text-stone-400 italic mt-1.5">
                                                    Catatan: {{ $meal->notes }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center shrink-0 border-t sm:border-t-0 pt-3 sm:pt-0 border-stone-100">
                                        <div class="text-left sm:text-right">
                                            <p class="font-bold text-lg text-stone-900">
                                                {{ $meal->calories !== null ? round($meal->calories) : '-' }}
                                            </p>
                                            <p class="text-xs text-stone-400">
                                                {{ $meal->calories !== null ? 'kkal' : 'tanpa data kkal' }}
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-1 mt-2">
                                            <button type="button"
                                                    onclick="editMeal({{ json_encode($meal) }})"
                                                    class="p-1.5 text-stone-400 hover:text-[#438F83] rounded-lg hover:bg-stone-50 transition"
                                                    title="Ubah">
                                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                            </button>

                                            <form method="POST"
                                                  action="{{ route('nutrition.meals.destroy', $meal) }}"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan makanan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="p-1.5 text-stone-400 hover:text-red-500 rounded-lg hover:bg-red-50 transition"
                                                        title="Hapus">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $meals->withQueryString()->links() }}
                        </div>
                    @endif

                </div>


                {{-- ================= RIGHT ================= --}}
                <div class="xl:col-span-4 space-y-6">

                    {{-- AI FOOD SCAN --}}
                    <div class="relative overflow-hidden
                                bg-gradient-to-br
                                from-[#4B988D]
                                to-[#33746C]
                                text-white rounded-[30px] p-5 sm:p-7">

                        <div class="absolute
                                    w-40 h-40
                                    bg-white/10 rounded-full
                                    -right-12 -top-14">
                        </div>

                        <div class="relative">

                            <div class="w-12 h-12
                                        bg-white/15
                                        rounded-2xl
                                        flex items-center justify-center">

                                <i data-lucide="scan-line"
                                   class="w-6 h-6"></i>

                            </div>

                            <p class="text-xs tracking-[0.2em]
                                      text-white/70 mt-6">
                                AI VISION
                            </p>

                            <h2 class="text-2xl font-bold mt-2">
                                AI Food Scan
                            </h2>

                            <p class="text-white/75
                                      text-sm leading-6 mt-2">

                                Foto makanan dan biarkan AI
                                membantu mengenali estimasi
                                nutrisi secara otomatis.

                            </p>


                            <a href="{{ route('food.scan') }}"
                               class="mt-6 w-fit
                                      bg-white text-[#3F887E]
                                      rounded-full px-5 py-3
                                      font-semibold
                                      flex items-center gap-2">

                                <i data-lucide="camera"
                                   class="w-4 h-4"></i>

                                Scan Makanan

                            </a>

                        </div>

                    </div>


                    {{-- REKOMENDASI --}}
                    <div class="bg-white rounded-[30px]
                                border border-stone-100
                                shadow-sm p-5 sm:p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-xs text-[#4B988D]
                                          font-semibold">
                                    REKOMENDASI
                                </p>

                                <h2 class="font-bold text-xl mt-1">
                                    Menu Hari Ini
                                </h2>

                            </div>

                            <span class="w-10 h-10
                                         bg-[#EAF6F3]
                                         text-[#438F83]
                                         rounded-full
                                         flex items-center justify-center">

                                <i data-lucide="sparkles"
                                   class="w-5 h-5"></i>

                            </span>

                        </div>


                        <div class="mt-6
                                    bg-[#F8F7F3]
                                    rounded-2xl p-4">

                            <div class="flex gap-4">

                                <div class="w-12 h-12 sm:w-14 sm:h-14 shrink-0
                                            bg-[#E8F1E7]
                                            rounded-2xl
                                            flex items-center justify-center
                                            text-2xl">
                                    🥣
                                </div>

                                <div>

                                    <h3 class="font-semibold">
                                        Sup Kentang Ayam
                                    </h3>

                                    <p class="text-xs
                                              text-gray-400 mt-1">
                                        Tinggi protein & mudah dicerna
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="mt-3
                                    bg-[#F8F7F3]
                                    rounded-2xl p-4">

                            <div class="flex gap-4">

                                <div class="w-12 h-12 sm:w-14 sm:h-14 shrink-0
                                            bg-[#F6F0E4]
                                            rounded-2xl
                                            flex items-center justify-center
                                            text-2xl">
                                    🥑
                                </div>

                                <div>

                                    <h3 class="font-semibold">
                                        Alpukat Pisang
                                    </h3>

                                    <p class="text-xs
                                              text-gray-400 mt-1">
                                        Lemak sehat & energi tambahan
                                    </p>

                                </div>

                            </div>

                        </div>

                        <p class="text-[11px] text-gray-400 mt-4 leading-relaxed italic">
                            *Rekomendasi umum bernutrisi seimbang sebagai referensi harian keluarga. Bukan merupakan resep medis atau diagnosis individual.
                        </p>

                    </div>

                </div>

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

        {{-- BERANDA --}}
        <a href="{{ route('dashboard') }}"
           class="group flex flex-col items-center justify-center gap-1.5
                  min-w-0 text-gray-400 hover:text-[#438F83]
                  transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="house" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">
                Beranda
            </span>
        </a>

        {{-- NUTRISI ACTIVE --}}
        <a href="{{ route('nutrition') }}"
           class="group relative flex flex-col items-center justify-center gap-1.5
                  min-w-0 text-[#438F83] transition duration-200 active:scale-90">

            <span class="absolute -top-2 w-7 h-1 rounded-full bg-[#4B988D]
                         shadow-[0_2px_10px_rgba(75,152,141,0.45)]"></span>

            <span class="relative -mt-1 w-11 h-11 rounded-2xl
                         bg-gradient-to-br from-[#DDF1ED] to-[#CFE8E3]
                         ring-1 ring-[#BFDCD6]
                         shadow-[0_8px_18px_rgba(75,152,141,0.20)]
                         flex items-center justify-center
                         transition duration-200 group-hover:-translate-y-0.5">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                <span class="absolute -right-0.5 -top-0.5 w-2.5 h-2.5 rounded-full
                             bg-[#4B988D] border-2 border-white"></span>
            </span>

            <span class="text-[9px] sm:text-[10px] font-bold truncate w-full text-center">
                Nutrisi
            </span>
        </a>

        {{-- FOOD SCAN --}}
        <a href="{{ route('food.scan') }}"
           class="group flex flex-col items-center justify-center gap-1.5
                  min-w-0 text-gray-400 hover:text-[#438F83]
                  transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="scan-line" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">
                Scan
            </span>
        </a>

        {{-- TANYA AI --}}
        <a href="{{ route('ai.chat') }}"
           class="group flex flex-col items-center justify-center gap-1.5
                  min-w-0 text-gray-400 hover:text-[#438F83]
                  transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="message-circle" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">
                Tanya AI
            </span>
        </a>

        {{-- DATA ANAK --}}
        <a href="{{ route('children.index') }}"
           class="group flex flex-col items-center justify-center gap-1.5
                  min-w-0 text-gray-400 hover:text-[#438F83]
                  transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="baby" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">
                Anak
            </span>
        </a>

        {{-- PROFIL --}}
        <a href="{{ route('profile.edit') }}"
           class="group flex flex-col items-center justify-center gap-1.5
                  min-w-0 text-gray-400 hover:text-[#438F83]
                  transition duration-200 active:scale-90">
            <span class="w-10 h-10 rounded-2xl flex items-center justify-center
                         group-hover:bg-[#EEF7F5] transition duration-200
                         group-hover:-translate-y-0.5">
                <i data-lucide="user-round" class="w-[19px] h-[19px]"></i>
            </span>
            <span class="text-[9px] sm:text-[10px] font-medium truncate w-full text-center">
                Profil
            </span>
        </a>

    </div>
</nav>

{{-- ================= MODAL TAMBAH MAKANAN ================= --}}
<div id="foodModal"
     class="hidden fixed inset-0 z-50
            bg-black/30 backdrop-blur-sm
            items-end sm:items-center justify-center
            p-0 sm:p-5">

    <div class="bg-white w-full max-w-lg
                rounded-t-[28px] sm:rounded-[28px]
                p-5 sm:p-7 shadow-xl
                max-h-[90vh] overflow-y-auto">

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">
                    Tambah Makanan
                </h2>
                <p class="text-sm text-gray-400 mt-1">
                    Catat asupan yang dikonsumsi {{ $selectedChild?->name ?? 'anak' }}
                </p>
            </div>

            <button type="button"
                    onclick="closeFoodModal()"
                    class="w-10 h-10 rounded-full
                           bg-gray-100
                           flex items-center justify-center hover:bg-gray-200 transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('nutrition.meals.store') }}" class="mt-6 space-y-4">
            @csrf
            @if ($selectedChild)
                <input type="hidden" name="child_id" value="{{ $selectedChild->id }}">
            @else
                <div>
                    <label class="text-sm font-semibold">Pilih Anak</label>
                    <select name="child_id" required class="mt-2 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] focus:border-[#4B988D] focus:ring-[#4B988D]">
                        @foreach ($children as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div>
                <label class="text-sm font-semibold">Nama Makanan <span class="text-red-500">*</span></label>
                <input type="text"
                       name="food_name"
                       required
                       placeholder="Contoh: Bubur Tim Ayam & Brokoli"
                       class="mt-2 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] focus:border-[#4B988D] focus:ring-[#4B988D] text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold">Waktu / Jenis Makan <span class="text-red-500">*</span></label>
                    <select name="meal_type" required class="mt-2 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] focus:border-[#4B988D] focus:ring-[#4B988D] text-sm">
                        <option value="Sarapan">Sarapan</option>
                        <option value="Snack Pagi">Snack Pagi</option>
                        <option value="Makan Siang">Makan Siang</option>
                        <option value="Snack Sore">Snack Sore</option>
                        <option value="Makan Malam">Makan Malam</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold">Porsi</label>
                    <input type="text"
                       name="portion_text"
                       placeholder="Contoh: 1 mangkuk kecil"
                       class="mt-2 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] focus:border-[#4B988D] focus:ring-[#4B988D] text-sm">
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold">Waktu Konsumsi <span class="text-red-500">*</span></label>
                <input type="datetime-local"
                       name="consumed_at"
                       required
                       value="{{ $selectedDate }}T{{ now()->format('H:i') }}"
                       max="{{ now()->format('Y-m-d\TH:i') }}"
                       min="{{ $selectedChild?->birth_date ? $selectedChild->birth_date->format('Y-m-d\T00:00') : '' }}"
                       class="mt-2 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] focus:border-[#4B988D] focus:ring-[#4B988D] text-sm">
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div class="col-span-2 sm:col-span-1">
                    <label class="text-xs font-semibold text-stone-600">Kalori (kkal)</label>
                    <input type="number"
                           step="any"
                           min="0"
                           name="calories"
                           placeholder="Contoh: 250"
                           class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-600">Protein (g)</label>
                    <input type="number"
                           step="any"
                           min="0"
                           name="protein"
                           placeholder="0.0"
                           class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-600">Lemak (g)</label>
                    <input type="number"
                           step="any"
                           min="0"
                           name="fat"
                           placeholder="0.0"
                           class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-600">Karbohidrat (g)</label>
                    <input type="number"
                           step="any"
                           min="0"
                           name="carbohydrates"
                           placeholder="0.0"
                           class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-600">Serat (g)</label>
                    <input type="number"
                           step="any"
                           min="0"
                           name="fiber"
                           placeholder="0.0"
                           class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold">Catatan Tambahan (Opsional)</label>
                <textarea name="notes"
                          rows="2"
                          placeholder="Reaksi anak, habis / sisa, dsb."
                          class="mt-2 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm"></textarea>
            </div>

            <button type="submit"
                    class="mt-6 w-full py-3.5
                           bg-[#4B988D] hover:bg-[#3F847B]
                           text-white font-semibold rounded-2xl transition">
                Simpan Catatan Makanan
            </button>
        </form>
    </div>
</div>

{{-- ================= MODAL UBAH MAKANAN ================= --}}
<div id="editFoodModal"
     class="hidden fixed inset-0 z-50
            bg-black/30 backdrop-blur-sm
            items-end sm:items-center justify-center
            p-0 sm:p-5">

    <div class="bg-white w-full max-w-lg
                rounded-t-[28px] sm:rounded-[28px]
                p-5 sm:p-7 shadow-xl
                max-h-[90vh] overflow-y-auto">

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">
                    Ubah Makanan
                </h2>
                <p class="text-sm text-gray-400 mt-1">
                    Perbarui data catatan makanan anak
                </p>
            </div>

            <button type="button"
                    onclick="closeEditFoodModal()"
                    class="w-10 h-10 rounded-full
                           bg-gray-100
                           flex items-center justify-center hover:bg-gray-200 transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="editFoodForm" method="POST" action="" class="mt-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="text-sm font-semibold">Nama Makanan <span class="text-red-500">*</span></label>
                <input type="text"
                       id="edit_food_name"
                       name="food_name"
                       required
                       class="mt-2 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] focus:border-[#4B988D] focus:ring-[#4B988D] text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold">Waktu / Jenis Makan <span class="text-red-500">*</span></label>
                    <select id="edit_meal_type" name="meal_type" required class="mt-2 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] focus:border-[#4B988D] focus:ring-[#4B988D] text-sm">
                        <option value="Sarapan">Sarapan</option>
                        <option value="Snack Pagi">Snack Pagi</option>
                        <option value="Makan Siang">Makan Siang</option>
                        <option value="Snack Sore">Snack Sore</option>
                        <option value="Makan Malam">Makan Malam</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold">Porsi</label>
                    <input type="text"
                           id="edit_portion_text"
                           name="portion_text"
                           class="mt-2 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] focus:border-[#4B988D] focus:ring-[#4B988D] text-sm">
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold">Waktu Konsumsi <span class="text-red-500">*</span></label>
                <input type="datetime-local"
                       id="edit_consumed_at"
                       name="consumed_at"
                       required
                       max="{{ now()->format('Y-m-d\TH:i') }}"
                       min="{{ $selectedChild?->birth_date ? $selectedChild->birth_date->format('Y-m-d\T00:00') : '' }}"
                       class="mt-2 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] focus:border-[#4B988D] focus:ring-[#4B988D] text-sm">
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div class="col-span-2 sm:col-span-1">
                    <label class="text-xs font-semibold text-stone-600">Kalori (kkal)</label>
                    <input type="number"
                           step="any"
                           min="0"
                           id="edit_calories"
                           name="calories"
                           class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-600">Protein (g)</label>
                    <input type="number"
                           step="any"
                           min="0"
                           id="edit_protein"
                           name="protein"
                           class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-600">Lemak (g)</label>
                    <input type="number"
                           step="any"
                           min="0"
                           id="edit_fat"
                           name="fat"
                           class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-600">Karbohidrat (g)</label>
                    <input type="number"
                           step="any"
                           min="0"
                           id="edit_carbohydrates"
                           name="carbohydrates"
                           class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-600">Serat (g)</label>
                    <input type="number"
                           step="any"
                           min="0"
                           id="edit_fiber"
                           name="fiber"
                           class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold">Catatan Tambahan (Opsional)</label>
                <textarea id="edit_notes"
                          name="notes"
                          rows="2"
                          class="mt-2 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm"></textarea>
            </div>

            <button type="submit"
                    class="mt-6 w-full py-3.5
                           bg-[#4B988D] hover:bg-[#3F847B]
                           text-white font-semibold rounded-2xl transition">
                Perbarui Catatan Makanan
            </button>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();

    function openFoodModal() {
        const modal = document.getElementById('foodModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeFoodModal() {
        const modal = document.getElementById('foodModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openEditFoodModal() {
        const modal = document.getElementById('editFoodModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditFoodModal() {
        const modal = document.getElementById('editFoodModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function editMeal(meal) {
        const form = document.getElementById('editFoodForm');
        form.action = '{{ url("/nutrition/meals") }}/' + meal.id;

        document.getElementById('edit_food_name').value = meal.food_name || '';
        document.getElementById('edit_meal_type').value = meal.meal_type || 'Sarapan';
        document.getElementById('edit_portion_text').value = meal.portion_text || '';

        if (meal.consumed_at) {
            const d = new Date(meal.consumed_at);
            const pad = (n) => String(n).padStart(2, '0');
            const formatted = `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
            document.getElementById('edit_consumed_at').value = formatted;
        }

        document.getElementById('edit_calories').value = meal.calories !== null ? meal.calories : '';
        document.getElementById('edit_protein').value = meal.protein !== null ? meal.protein : '';
        document.getElementById('edit_fat').value = meal.fat !== null ? meal.fat : '';
        document.getElementById('edit_carbohydrates').value = meal.carbohydrates !== null ? meal.carbohydrates : '';
        document.getElementById('edit_fiber').value = meal.fiber !== null ? meal.fiber : '';
        document.getElementById('edit_notes').value = meal.notes || '';

        openEditFoodModal();
    }
</script>

</body>
</html>