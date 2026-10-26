<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Konsultasi - GrowCare Dokter</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
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

        <!-- Sidebar (Desktop) -->
        <x-growcare-doctor-sidebar active="consultations" />

        <!-- Main Content -->
        <main class="w-full min-w-0 lg:ml-[285px] pt-16 lg:pt-0 pb-24 lg:pb-12">
            
            <!-- Page Container -->
            <div class="max-w-[1450px] mx-auto w-full min-w-0 px-4 sm:px-6 lg:px-10 py-6 lg:py-8 space-y-6 sm:space-y-8">
                
                <!-- Page Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-[#346D96] border border-[#DFEBF5] shadow-sm mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#548FB7]"></span>
                            <span class="text-xs font-bold tracking-wider uppercase">KONSULTASI</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#24323D]">
                            Daftar Konsultasi
                        </h1>
                        <p class="text-sm sm:text-base text-[#718096] mt-1">
                            Kelola semua permintaan dan riwayat konsultasi pasien Anda.
                        </p>
                    </div>

                    <!-- Search Input (Form GET) -->
                    <form method="GET" action="{{ route('dokter.konsultasi') }}" class="relative w-full md:w-72">
                        @if($currentStatus && $currentStatus !== 'all')
                            <input type="hidden" name="status" value="{{ $currentStatus }}">
                        @endif
                        <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-[#718096]"></i>
                        <input type="text"
                               name="search"
                               value="{{ $search ?? '' }}"
                               placeholder="Cari pasien / keluhan..."
                               class="w-full pl-10 {{ !empty($search) ? 'pr-10' : 'pr-4' }} py-2.5 bg-white border border-[#DFEBF5] rounded-2xl focus:outline-none focus:border-[#548FB7] focus:ring-2 focus:ring-[#548FB7]/20 transition-all text-sm text-[#24323D] placeholder-[#718096]/70 shadow-sm">
                        @if(!empty($search))
                            <a href="{{ route('dokter.konsultasi', ($currentStatus && $currentStatus !== 'all') ? ['status' => $currentStatus] : []) }}"
                               class="absolute right-3 top-1/2 -translate-y-1/2 text-[#718096] hover:text-[#24323D] p-1 transition-colors"
                               title="Hapus pencarian">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Summary Cards (4 Cards - Soft Blue & Pastels) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3.5 sm:gap-4">
                    <!-- Total Konsultasi -->
                    <div class="bg-[#EAF4FC] p-4 sm:p-5 rounded-[24px] border border-[#DFEBF5] shadow-sm transition-transform duration-200 hover:-translate-y-0.5">
                        <div class="w-10 h-10 rounded-full bg-[#DCECF8] flex items-center justify-center mb-3 text-[#548FB7]">
                            <i data-lucide="message-square" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-[#24323D] mb-1 tracking-tight">{{ $counts['total'] ?? 0 }}</h3>
                        <p class="text-xs sm:text-sm text-[#718096] font-medium">Total Konsultasi</p>
                    </div>

                    <!-- Menunggu -->
                    <div class="bg-[#FFF5E4] p-4 sm:p-5 rounded-[24px] border border-[#FFE2B3] shadow-sm transition-transform duration-200 hover:-translate-y-0.5">
                        <div class="w-10 h-10 rounded-full bg-[#FEF3C7] flex items-center justify-center mb-3 text-[#B45309]">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-[#24323D] mb-1 tracking-tight">{{ $counts['pending'] ?? 0 }}</h3>
                        <p class="text-xs sm:text-sm text-[#9A6700] font-medium">Menunggu</p>
                    </div>

                    <!-- Diterima / Aktif -->
                    <div class="bg-white p-4 sm:p-5 rounded-[24px] border border-[#DFEBF5] shadow-sm transition-transform duration-200 hover:-translate-y-0.5">
                        <div class="w-10 h-10 rounded-full bg-[#DCECF8] flex items-center justify-center mb-3 text-[#548FB7]">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-[#24323D] mb-1 tracking-tight">{{ $counts['accepted'] ?? 0 }}</h3>
                        <p class="text-xs sm:text-sm text-[#718096] font-medium">Diterima / Aktif</p>
                    </div>

                    <!-- Selesai -->
                    <div class="bg-[#EDF7F0] p-4 sm:p-5 rounded-[24px] border border-[#C6E7D0] shadow-sm transition-transform duration-200 hover:-translate-y-0.5">
                        <div class="w-10 h-10 rounded-full bg-[#DCFCE7] flex items-center justify-center mb-3 text-[#15803D]">
                            <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-[#24323D] mb-1 tracking-tight">{{ $counts['completed'] ?? 0 }}</h3>
                        <p class="text-xs sm:text-sm text-[#1B6C3B] font-medium">Selesai</p>
                    </div>
                </div>

                <!-- Filters & Tabs -->
                <div class="flex items-center gap-2 overflow-x-auto hide-scrollbar pb-1">
                    <a href="{{ route('dokter.konsultasi', array_filter(['search' => $search])) }}"
                       class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all duration-200 whitespace-nowrap shadow-sm {{ $currentStatus === 'all' ? 'bg-[#EAF4FC] text-[#294E69] border border-[#BEDAF0]' : 'bg-white text-[#718096] border border-[#DFEBF5] hover:bg-[#F3F8FD] hover:text-[#24323D]' }}">
                        Semua ({{ $counts['total'] ?? 0 }})
                    </a>
                    <a href="{{ route('dokter.konsultasi', array_filter(['status' => 'pending', 'search' => $search])) }}"
                       class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all duration-200 whitespace-nowrap shadow-sm {{ $currentStatus === 'pending' ? 'bg-[#EAF4FC] text-[#294E69] border border-[#BEDAF0]' : 'bg-white text-[#718096] border border-[#DFEBF5] hover:bg-[#F3F8FD] hover:text-[#24323D]' }}">
                        Menunggu ({{ $counts['pending'] ?? 0 }})
                    </a>
                    <a href="{{ route('dokter.konsultasi', array_filter(['status' => 'accepted', 'search' => $search])) }}"
                       class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all duration-200 whitespace-nowrap shadow-sm {{ $currentStatus === 'accepted' ? 'bg-[#EAF4FC] text-[#294E69] border border-[#BEDAF0]' : 'bg-white text-[#718096] border border-[#DFEBF5] hover:bg-[#F3F8FD] hover:text-[#24323D]' }}">
                        Diterima / Aktif ({{ $counts['accepted'] ?? 0 }})
                    </a>
                    <a href="{{ route('dokter.konsultasi', array_filter(['status' => 'completed', 'search' => $search])) }}"
                       class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all duration-200 whitespace-nowrap shadow-sm {{ $currentStatus === 'completed' ? 'bg-[#EAF4FC] text-[#294E69] border border-[#BEDAF0]' : 'bg-white text-[#718096] border border-[#DFEBF5] hover:bg-[#F3F8FD] hover:text-[#24323D]' }}">
                        Selesai ({{ $counts['completed'] ?? 0 }})
                    </a>
                    <a href="{{ route('dokter.konsultasi', array_filter(['status' => 'cancelled', 'search' => $search])) }}"
                       class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all duration-200 whitespace-nowrap shadow-sm {{ $currentStatus === 'cancelled' ? 'bg-[#EAF4FC] text-[#294E69] border border-[#BEDAF0]' : 'bg-white text-[#718096] border border-[#DFEBF5] hover:bg-[#F3F8FD] hover:text-[#24323D]' }}">
                        Dibatalkan ({{ $counts['cancelled'] ?? 0 }})
                    </a>
                </div>

                <!-- Consultation List -->
                <div class="space-y-4" id="consultationList">
                    @forelse($consultations as $consultation)
                        @php
                            $statusKey = strtolower($consultation->status ?? '');
                            $statusBadgeClass = 'bg-stone-50 text-stone-600 border border-stone-200';
                            $statusText = ucfirst($consultation->status ?? 'Status');

                            if ($statusKey === 'pending') {
                                $statusBadgeClass = 'bg-[#FFF5E4] text-[#B45309] border border-[#FFE2B3]';
                                $statusText = 'Menunggu';
                            } elseif ($statusKey === 'accepted') {
                                $statusBadgeClass = 'bg-[#EAF4FC] text-[#346D96] border border-[#DFEBF5]';
                                $statusText = 'Diterima / Aktif';
                            } elseif ($statusKey === 'completed') {
                                $statusBadgeClass = 'bg-[#EDF7F0] text-[#15803D] border border-[#C6E7D0]';
                                $statusText = 'Selesai';
                            } elseif ($statusKey === 'cancelled') {
                                $statusBadgeClass = 'bg-[#FFF1F2] text-[#BE4560] border border-[#FFE4E6]';
                                $statusText = 'Dibatalkan';
                            }

                            $childGender = strtolower($consultation->child?->gender ?? '');
                            $emoji = $childGender === 'l' ? '👦' : ($childGender === 'p' ? '👧' : '👶');
                            $childName = $consultation->child?->name ?? 'Pasien Anak';
                            $childAge = $consultation->child?->formatted_age ?? '-';
                            $parentName = $consultation->user?->name ?? 'Orang Tua';
                            $consultationDate = $consultation->consultation_date ?? $consultation->created_at;
                        @endphp
                        
                        <div class="consultation-card bg-white p-5 sm:p-6 rounded-[24px] sm:rounded-[28px] border border-[#DFEBF5] shadow-sm hover:border-[#BEDAF0] hover:shadow transition-all duration-200">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                
                                <div class="flex items-start gap-4">
                                    <!-- Avatar / Emoji -->
                                    <div class="w-12 h-12 rounded-full bg-[#DCECF8] border border-[#DFEBF5] flex items-center justify-center text-2xl shrink-0 mt-0.5">
                                        {{ $emoji }}
                                    </div>
                                    
                                    <!-- Info -->
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <h2 class="font-bold text-base sm:text-lg text-[#24323D]">
                                                {{ $childName }}
                                            </h2>
                                            <span class="text-[#718096]/50 text-sm">•</span>
                                            <span class="text-[#718096] text-xs sm:text-sm font-medium">
                                                {{ $childAge }}
                                            </span>
                                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold {{ $statusBadgeClass }} ml-1">
                                                {{ $statusText }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-xs sm:text-sm text-[#718096] mb-2.5">
                                            Orang tua: <span class="font-semibold text-[#24323D]">{{ $parentName }}</span>
                                        </p>
                                        
                                        <!-- Complaint Snippet -->
                                        <div class="bg-[#F3F8FD] p-3.5 rounded-2xl border border-[#DFEBF5]">
                                            <p class="text-xs sm:text-sm text-[#52758F] line-clamp-2 leading-relaxed">
                                                "{{ $consultation->complaint ?? 'Tidak ada catatan keluhan.' }}"
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action & Timestamp -->
                                <div class="flex flex-row md:flex-col items-center md:items-end justify-between pt-3 md:pt-0 border-t md:border-t-0 border-[#DFEBF5] gap-3 shrink-0 md:min-w-[140px]">
                                    <div class="text-xs text-[#718096] font-medium flex items-center gap-1.5">
                                        <i data-lucide="clock" class="w-3.5 h-3.5 text-[#548FB7]"></i>
                                        <span>{{ $consultationDate ? \Carbon\Carbon::parse($consultationDate)->locale('id')->diffForHumans() : '-' }}</span>
                                    </div>
                                    <a href="{{ route('dokter.konsultasi.detail', $consultation->id) }}"
                                       class="inline-flex items-center justify-center gap-1.5 px-4 py-2 sm:px-5 sm:py-2.5 bg-[#548FB7] hover:bg-[#427DA6] text-white text-xs sm:text-sm font-bold rounded-xl sm:rounded-2xl shadow-sm hover:shadow transition-all duration-200">
                                        <span>Lihat Detail</span>
                                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    @empty
                        @if(!empty($search))
                            <!-- Empty State: Pencarian tidak menemukan hasil -->
                            <div class="bg-white rounded-[28px] p-10 sm:p-12 border border-[#DFEBF5] shadow-sm flex flex-col items-center justify-center text-center">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#F3F8FD] border border-[#DFEBF5] flex items-center justify-center mb-4 text-[#548FB7]">
                                    <i data-lucide="search-x" class="w-8 h-8 sm:w-10 sm:h-10"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#24323D] mb-1.5">Tidak ada konsultasi yang sesuai dengan pencarian</h3>
                                <p class="text-sm text-[#718096] max-w-sm mb-4">
                                    Tidak ditemukan konsultasi untuk kata kunci "<span class="font-semibold text-[#24323D]">{{ $search }}</span>".
                                </p>
                                <a href="{{ route('dokter.konsultasi', ($currentStatus && $currentStatus !== 'all') ? ['status' => $currentStatus] : []) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#EAF4FC] text-[#346D96] border border-[#DFEBF5] text-xs font-bold hover:bg-[#DCECF8] transition-colors">
                                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                    Reset Pencarian
                                </a>
                            </div>
                        @elseif($currentStatus !== 'all')
                            <!-- Empty State: Filter status tidak memiliki hasil -->
                            <div class="bg-white rounded-[28px] p-10 sm:p-12 border border-[#DFEBF5] shadow-sm flex flex-col items-center justify-center text-center">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#F3F8FD] border border-[#DFEBF5] flex items-center justify-center mb-4 text-[#548FB7]">
                                    <i data-lucide="filter-x" class="w-8 h-8 sm:w-10 sm:h-10"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#24323D] mb-1.5">Belum ada konsultasi dengan status ini</h3>
                                <p class="text-sm text-[#718096] max-w-sm mb-4">
                                    Tidak ada data konsultasi pada kategori filter yang dipilih.
                                </p>
                                <a href="{{ route('dokter.konsultasi') }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#EAF4FC] text-[#346D96] border border-[#DFEBF5] text-xs font-bold hover:bg-[#DCECF8] transition-colors">
                                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                    Lihat Semua Konsultasi
                                </a>
                            </div>
                        @else
                            <!-- Empty State: Dokter belum memiliki konsultasi sama sekali -->
                            <div class="bg-white rounded-[28px] p-10 sm:p-12 border border-[#DFEBF5] shadow-sm flex flex-col items-center justify-center text-center">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#F3F8FD] border border-[#DFEBF5] flex items-center justify-center mb-4 text-[#548FB7]">
                                    <i data-lucide="inbox" class="w-8 h-8 sm:w-10 sm:h-10"></i>
                                </div>
                                <h3 class="text-xl font-bold text-[#24323D] mb-1.5">Belum ada konsultasi</h3>
                                <p class="text-sm text-[#718096] max-w-sm">Anda belum memiliki riwayat atau permintaan konsultasi saat ini. Konsultasi baru dari orang tua akan muncul di sini.</p>
                            </div>
                        @endif
                    @endforelse

                    @if(method_exists($consultations, 'links'))
                        <div class="pt-4">
                            {{ $consultations->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </main>
    </div>

    <!-- Mobile Bottom Nav -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-[#DFEBF5] z-30 pb-safe">
        <div class="flex items-center justify-around px-2 py-3">
            <a href="{{ route('dokter.dashboard') }}" class="flex flex-col items-center gap-1 p-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-[#718096]">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-semibold text-[#718096]">Beranda</span>
            </a>
            
            <a href="{{ route('dokter.konsultasi') }}" class="flex flex-col items-center gap-1 p-2">
                <div class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                </div>
                <span class="text-[10px] font-bold text-[#548FB7]">Konsultasi</span>
            </a>
            
            <a href="{{ route('dokter.pasien') }}" class="flex flex-col items-center gap-1 p-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-[#718096]">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-semibold text-[#718096]">Pasien</span>
            </a>
            
            <a href="{{ route('dokter.profil') }}" class="flex flex-col items-center gap-1 p-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-[#718096]">
                    <i data-lucide="user-round" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-semibold text-[#718096]">Profil</span>
            </a>
        </div>
    </nav>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
