<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien - GrowCare Dokter</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F7F2; }
    </style>
</head>
<body class="bg-[#F8FAFD] text-[#24323D] antialiased overflow-x-hidden">

<div class="min-h-screen flex">

    <!-- Mobile Header -->
    <header class="lg:hidden fixed top-0 left-0 right-0 z-40
                   h-16 bg-[#FBFAF6]/95 backdrop-blur
                   border-b border-[#DFEBF5]
                   flex items-center justify-between px-4 sm:px-6">
        <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-2">
            <span class="w-9 h-9 rounded-full bg-[#DCECF8] text-[#548FB7] flex items-center justify-center flex-shrink-0">
                <i data-lucide="sprout" class="w-5 h-5"></i>
            </span>
            <span class="text-xl font-bold tracking-tight text-[#24323D]">
                <span class="text-[#548FB7]">Grow</span>Care
            </span>
            <span class="text-[10px] font-bold text-[#548FB7] tracking-wider uppercase ml-1">DOKTER</span>
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('dokter.profil') }}"
               class="w-10 h-10 rounded-full bg-[#DCECF8] text-[#548FB7] flex items-center justify-center overflow-hidden border border-[#DFEBF5]">
                @if(Auth::user()?->doctor?->photo)
                    <img src="{{ asset('storage/' . Auth::user()->doctor->photo) }}" class="w-full h-full object-cover">
                @else
                    <i data-lucide="user-round" class="w-5 h-5"></i>
                @endif
            </a>
        </div>
    </header>

    <!-- Sidebar -->
    <x-growcare-doctor-sidebar active="patients" />

    <!-- Main Content -->
    <main class="w-full min-w-0 lg:ml-[285px] pt-16 lg:pt-0 pb-24 lg:pb-12">
        <div class="max-w-[1450px] mx-auto w-full min-w-0 px-4 sm:px-6 lg:px-10 py-6 lg:py-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-100 mb-4">
                    <i data-lucide="users" class="w-4 h-4 text-blue-600"></i>
                    <span class="text-xs font-semibold text-blue-600 tracking-wide uppercase">DATA PASIEN</span>
                </div>
                <h1 class="text-3xl font-bold mb-2">Data Pasien Anak</h1>
                <p class="text-stone-500">Lihat data perkembangan pasien anak yang telah berkonsultasi.</p>
            </div>

            <!-- Search Bar -->
            <form method="GET" action="{{ route('dokter.pasien') }}" class="bg-white rounded-2xl shadow-sm border border-stone-100 p-2 mb-8 flex items-center">
                <div class="pl-4 pr-2">
                    <i data-lucide="search" class="w-5 h-5 text-stone-400"></i>
                </div>
                <input 
                    type="text" 
                    name="search"
                    id="searchInput" 
                    value="{{ $search }}"
                    placeholder="Cari nama pasien anak atau orang tua..." 
                    class="w-full bg-transparent border-none outline-none py-2 px-2 text-[#202725] placeholder:text-stone-400"
                >
                @if($search !== '')
                    <a href="{{ route('dokter.pasien') }}" class="px-3 py-1 text-xs font-semibold text-stone-400 hover:text-stone-600 transition-colors shrink-0">
                        Reset
                    </a>
                @endif
                <button type="submit" class="hidden">Cari</button>
            </form>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-[24px] p-6 shadow-sm border border-stone-100">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                        <i data-lucide="users" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <div class="text-stone-500 text-sm mb-1 font-medium">Total Pasien</div>
                    <div class="text-2xl font-bold">{{ $counts['total'] }} Anak</div>
                </div>
                <div class="bg-white rounded-[24px] p-6 shadow-sm border border-stone-100">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center mb-4">
                        <i data-lucide="activity" class="w-5 h-5 text-emerald-600"></i>
                    </div>
                    <div class="text-stone-500 text-sm mb-1 font-medium">Aktif</div>
                    <div class="text-2xl font-bold">{{ $counts['active'] }} Anak</div>
                </div>
                <div class="bg-white rounded-[24px] p-6 shadow-sm border border-stone-100">
                    <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center mb-4">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-amber-600"></i>
                    </div>
                    <div class="text-stone-500 text-sm mb-1 font-medium">Perlu Perhatian</div>
                    <div class="text-2xl font-bold">{{ $counts['attention'] }}</div>
                </div>
            </div>

            <!-- Patient Cards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="patientsGrid">
                @forelse($patients as $patient)
                    @php
                        $latestGrowth = $patient->latestGrowthRecord;
                        $latestConsultation = $patient->consultations->first();
                        $isMale = (strtolower($patient->gender ?? '') === 'l' || strtolower($patient->gender ?? '') === 'male');
                        $genderEmoji = $isMale ? '👦' : '👧';
                        $genderText = $isMale ? 'Laki-laki' : 'Perempuan';
                        $genderBg = $isMale ? 'bg-blue-50 border-blue-100 text-blue-600' : 'bg-pink-50 border-pink-100 text-pink-600';
                    @endphp
                    <div class="patient-card bg-white rounded-[28px] p-6 shadow-sm border border-stone-100 flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between mb-6 gap-3">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-14 h-14 rounded-2xl {{ $genderBg }} flex items-center justify-center text-2xl border shrink-0">
                                        {{ $genderEmoji }}
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-bold text-lg text-[#24323D] patient-name truncate">{{ $patient->name }}</h3>
                                        <div class="flex flex-wrap items-center gap-2 mt-1">
                                            <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 text-xs font-medium">{{ $genderText }}</span>
                                            <span class="text-sm text-stone-500 parent-name truncate">Orang tua: {{ $patient->user?->name ?? '—' }}</span>
                                        </div>
                                    </div>
                                </div>
                                @if($latestGrowth?->nutrition_status)
                                    <div class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold border border-emerald-100 shrink-0">
                                        {{ $latestGrowth->nutrition_status }}
                                    </div>
                                @else
                                    <div class="px-3 py-1 bg-stone-50 text-stone-500 rounded-full text-xs font-semibold border border-stone-200 shrink-0">
                                        Belum dinilai
                                    </div>
                                @endif
                            </div>

                            <div class="grid grid-cols-3 gap-3 mb-6 p-4 bg-[#F8F7F2] rounded-2xl text-center">
                                <div>
                                    <div class="text-stone-500 text-xs mb-1">Usia</div>
                                    <div class="font-bold text-sm text-[#24323D]">{{ $patient->formatted_age ?: '—' }}</div>
                                </div>
                                <div>
                                    <div class="text-stone-500 text-xs mb-1">Berat</div>
                                    <div class="font-bold text-sm text-[#24323D]">
                                        @if($latestGrowth && $latestGrowth->weight !== null)
                                            {{ (float) $latestGrowth->weight }} kg
                                        @else
                                            —
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <div class="text-stone-500 text-xs mb-1">Tinggi</div>
                                    <div class="font-bold text-sm text-[#24323D]">
                                        @if($latestGrowth && $latestGrowth->height !== null)
                                            {{ (float) $latestGrowth->height }} cm
                                        @else
                                            —
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6 p-3.5 rounded-2xl bg-[#F8FAFD] border border-[#DFEBF5] space-y-2">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-[#718096] font-medium flex items-center gap-1.5">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-[#548FB7]"></i>
                                        Pengukuran Terakhir
                                    </span>
                                    <span class="font-semibold text-[#24323D]">
                                        @if($latestGrowth?->measurement_date)
                                            {{ \Carbon\Carbon::parse($latestGrowth->measurement_date)->locale('id')->translatedFormat('d M Y') }}
                                        @else
                                            Belum ada data pertumbuhan
                                        @endif
                                    </span>
                                </div>
                                <div class="pt-2 border-t border-[#DFEBF5] flex items-center justify-between text-xs">
                                    <span class="text-[#718096] font-medium flex items-center gap-1.5">
                                        <i data-lucide="message-square" class="w-3.5 h-3.5 text-[#548FB7]"></i>
                                        Total Konsultasi
                                    </span>
                                    <span class="font-bold text-[#548FB7]">
                                        {{ $patient->consultations->count() }} Sesi
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($latestConsultation)
                            <a href="{{ route('dokter.konsultasi.detail', $latestConsultation->id) }}"
                               class="w-full py-3.5 bg-blue-50 text-blue-600 font-semibold rounded-2xl hover:bg-blue-100 transition-colors flex items-center justify-center gap-2 text-xs sm:text-sm">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                <span>Lihat Detail Konsultasi</span>
                            </a>
                        @else
                            <a href="{{ route('dokter.konsultasi', ['search' => $patient->name]) }}"
                               class="w-full py-3.5 bg-blue-50 text-blue-600 font-semibold rounded-2xl hover:bg-blue-100 transition-colors flex items-center justify-center gap-2 text-xs sm:text-sm">
                                <i data-lucide="message-square" class="w-4 h-4"></i>
                                <span>Riwayat Konsultasi</span>
                            </a>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-[28px] border border-stone-100 p-8 shadow-sm">
                        <div class="w-16 h-16 bg-[#DCECF8] text-[#548FB7] rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="users" class="w-8 h-8"></i>
                        </div>
                        @if($search !== '')
                            <h3 class="text-lg font-bold text-[#24323D] mb-1">Tidak ada pasien yang sesuai dengan pencarian</h3>
                            <p class="text-stone-500 text-sm mb-4">Tidak ditemukan pasien dengan kata kunci "{{ $search }}".</p>
                            <a href="{{ route('dokter.pasien') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 font-semibold rounded-xl text-xs hover:bg-blue-100 transition">
                                Reset Pencarian
                            </a>
                        @else
                            <h3 class="text-lg font-bold text-[#24323D] mb-1">Belum ada data pasien</h3>
                            <p class="text-stone-500 text-sm">Pasien yang pernah berkonsultasi dengan Anda akan otomatis muncul di sini.</p>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Client-side filter fallback empty state (hidden by default) -->
            <div id="emptyState" class="hidden col-span-full py-12 text-center bg-white rounded-[28px] border border-stone-100 p-8 shadow-sm mt-6">
                <div class="w-16 h-16 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="users" class="w-8 h-8 text-stone-400"></i>
                </div>
                <h3 class="text-lg font-bold text-[#24323D] mb-1">Tidak ada pasien ditemukan</h3>
                <p class="text-stone-500 text-sm">Coba sesuaikan kata kunci pencarian Anda.</p>
            </div>

            @if($patients->hasPages())
                <div class="mt-8">
                    {{ $patients->links() }}
                </div>
            @endif

        </div>
    </main>
</div>

    <!-- Mobile Bottom Navigation -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-[#DFEBF5] flex items-center justify-around px-2 py-3 z-30 pb-safe">
        <a href="{{ route('dokter.dashboard') }}" class="flex flex-col items-center gap-1 p-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-[#718096]">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            </div>
            <span class="text-[10px] font-semibold text-[#718096]">Beranda</span>
        </a>
        <a href="{{ route('dokter.konsultasi') }}" class="flex flex-col items-center gap-1 p-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-[#718096]">
                <i data-lucide="message-square" class="w-5 h-5"></i>
            </div>
            <span class="text-[10px] font-semibold text-[#718096]">Konsultasi</span>
        </a>
        <a href="{{ route('dokter.pasien') }}" class="flex flex-col items-center gap-1 p-2">
            <div class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
                <i data-lucide="users" class="w-4 h-4"></i>
            </div>
            <span class="text-[10px] font-bold text-[#548FB7]">Pasien</span>
        </a>
        <a href="{{ route('dokter.profil') }}" class="flex flex-col items-center gap-1 p-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-[#718096]">
                <i data-lucide="user-round" class="w-5 h-5"></i>
            </div>
            <span class="text-[10px] font-semibold text-[#718096]">Profil</span>
        </a>
    </nav>

    <script>
        lucide.createIcons();

        // Instant client-side search filtering on loaded cards
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                const cards = document.querySelectorAll('.patient-card');
                let hasVisibleCards = false;

                cards.forEach(card => {
                    const childNameEl = card.querySelector('.patient-name');
                    const parentNameEl = card.querySelector('.parent-name');
                    const childName = childNameEl ? childNameEl.textContent.toLowerCase() : '';
                    const parentName = parentNameEl ? parentNameEl.textContent.toLowerCase() : '';
                    
                    if (childName.includes(searchTerm) || parentName.includes(searchTerm)) {
                        card.style.display = 'flex';
                        hasVisibleCards = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                const emptyState = document.getElementById('emptyState');
                if (emptyState) {
                    if (!hasVisibleCards && cards.length > 0) {
                        emptyState.classList.remove('hidden');
                    } else {
                        emptyState.classList.add('hidden');
                    }
                }
            });
        }
    </script>
</body>
</html>
