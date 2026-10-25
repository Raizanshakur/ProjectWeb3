<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter - GrowCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
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
                @if(isset($doctor->photo) && $doctor->photo)
                    <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name ?? 'Dokter' }}" class="w-full h-full object-cover">
                @else
                    <i data-lucide="user-round" class="w-5 h-5"></i>
                @endif
            </a>
        </div>
    </header>

    <!-- Sidebar -->
    <x-growcare-doctor-sidebar active="dashboard" />

    <!-- Main Content -->
    <main class="w-full min-w-0 lg:ml-[285px] pt-16 lg:pt-0 pb-24 lg:pb-0">
            
            <!-- Header Dokter -->
            <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-4 sm:px-6 lg:px-10 pt-6 lg:pt-8 pb-4 lg:pb-6">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold tracking-tight text-[#24323D]">
                        Halo, {{ $doctor->name ?? 'Dokter' }} 👋
                    </h1>
                    <p class="text-sm lg:text-base text-[#718096] mt-1">
                        Berikut adalah ringkasan jadwal dan konsultasi Anda hari ini.
                    </p>
                </div>
                
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Status Ketersediaan -->
                    <div class="flex items-center gap-2.5 bg-white px-3.5 py-2 rounded-2xl shadow-sm border border-[#DFEBF5]">
                        <span class="text-xs font-semibold text-[#718096]">Status:</span>
                        <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold {{ (isset($doctor->is_available) && $doctor->is_available) ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' }}">
                            <span class="w-2 h-2 rounded-full {{ (isset($doctor->is_available) && $doctor->is_available) ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                            <span>{{ (isset($doctor->is_available) && $doctor->is_available) ? 'Tersedia' : 'Sibuk' }}</span>
                        </div>
                    </div>
                    
                    <!-- Search Input -->
                    <div class="relative hidden sm:block w-56 lg:w-64">
                        <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-[#718096]"></i>
                        <input type="text" placeholder="Cari pasien..." class="w-full pl-10 pr-4 py-2 bg-white border border-[#DFEBF5] rounded-2xl focus:outline-none focus:border-[#548FB7] focus:ring-2 focus:ring-[#548FB7]/20 transition-all text-sm text-[#24323D] placeholder-[#718096]/70 shadow-sm">
                    </div>
                    
                    <!-- Notifikasi Bell -->
                    <button type="button" aria-label="Notifikasi" class="relative p-2.5 bg-white rounded-2xl shadow-sm border border-[#DFEBF5] text-[#24323D] hover:text-[#548FB7] hover:border-[#BEDAF0] hover:bg-[#F3F8FD] transition-all">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-[#548FB7] rounded-full ring-2 ring-white"></span>
                    </button>
                </div>
            </header>

            <div class="px-4 sm:px-6 lg:px-10 pb-24 lg:pb-10 flex-1 grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
                
                <!-- Left Column (Wider) -->
                <div class="xl:col-span-2 space-y-6 lg:space-y-8">
                    
                    <!-- Stats Row -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3.5 sm:gap-4">
                        <!-- Stat 1: Total Konsultasi -->
                        <div class="bg-[#EAF4FC] p-4 sm:p-5 rounded-[24px] border border-[#DFEBF5] shadow-sm transition-transform duration-200 hover:-translate-y-0.5">
                            <div class="w-10 h-10 rounded-full bg-[#DCECF8] flex items-center justify-center mb-3 text-[#548FB7]">
                                <i data-lucide="message-square" class="w-5 h-5"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-bold text-[#24323D] mb-1 tracking-tight">{{ $stats['total_consultations'] ?? 0 }}</h3>
                            <p class="text-xs sm:text-sm text-[#718096] font-medium">Total Konsultasi</p>
                        </div>

                        <!-- Stat 2: Pasien Hari Ini -->
                        <div class="bg-white p-4 sm:p-5 rounded-[24px] border border-[#DFEBF5] shadow-sm transition-transform duration-200 hover:-translate-y-0.5">
                            <div class="w-10 h-10 rounded-full bg-[#DCECF8] flex items-center justify-center mb-3 text-[#548FB7]">
                                <i data-lucide="users" class="w-5 h-5"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-bold text-[#24323D] mb-1 tracking-tight">{{ $stats['today_patients'] ?? 0 }}</h3>
                            <p class="text-xs sm:text-sm text-[#718096] font-medium">Pasien Hari Ini</p>
                        </div>

                        <!-- Stat 3: Menunggu (Pending) -->
                        <div class="bg-[#FFF5E4] p-4 sm:p-5 rounded-[24px] border border-[#FFE2B3] shadow-sm transition-transform duration-200 hover:-translate-y-0.5">
                            <div class="w-10 h-10 rounded-full bg-[#FEF3C7] flex items-center justify-center mb-3 text-[#B45309]">
                                <i data-lucide="clock" class="w-5 h-5"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-bold text-[#24323D] mb-1 tracking-tight">{{ $stats['pending_consultations'] ?? 0 }}</h3>
                            <p class="text-xs sm:text-sm text-[#9A6700] font-medium">Menunggu</p>
                        </div>

                        <!-- Stat 4: Selesai Hari Ini -->
                        <div class="bg-[#EDF7F0] p-4 sm:p-5 rounded-[24px] border border-[#C6E7D0] shadow-sm transition-transform duration-200 hover:-translate-y-0.5">
                            <div class="w-10 h-10 rounded-full bg-[#DCFCE7] flex items-center justify-center mb-3 text-[#15803D]">
                                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-bold text-[#24323D] mb-1 tracking-tight">{{ $stats['completed_today'] ?? 0 }}</h3>
                            <p class="text-xs sm:text-sm text-[#1B6C3B] font-medium">Selesai Hari Ini</p>
                        </div>
                    </div>

                    <!-- Hero Overview Card (Soft Blue Pastel) -->
                    <div class="relative overflow-hidden rounded-[28px] sm:rounded-[32px] p-6 sm:p-8 bg-gradient-to-br from-[#EAF4FC] via-[#EDF5FC] to-[#DCECF8] border border-[#DFEBF5] shadow-sm">
                        <!-- Subtle pastel decorative blobs -->
                        <div class="pointer-events-none absolute -top-12 -right-12 w-64 h-64 rounded-full bg-white/60 blur-2xl"></div>
                        <div class="pointer-events-none absolute -bottom-10 -left-10 w-52 h-52 rounded-full bg-[#BEDAF0]/30 blur-2xl"></div>
                        <div class="pointer-events-none absolute right-8 top-1/2 -translate-y-1/2 opacity-10 hidden sm:block">
                            <i data-lucide="stethoscope" class="w-48 h-48 text-[#548FB7]"></i>
                        </div>
                        
                        <div class="relative z-10">
                            <!-- Badges -->
                            <div class="flex items-center gap-2.5 mb-5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/80 text-[#346D96] border border-[#DFEBF5] rounded-full text-xs font-bold tracking-wider uppercase shadow-sm backdrop-blur-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#548FB7]"></span>
                                    Overview
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/60 text-[#718096] border border-[#DFEBF5]/70 rounded-full text-xs font-semibold backdrop-blur-sm">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-[#548FB7]"></i>
                                    {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d M Y') }}
                                </span>
                            </div>
                            
                            <h2 class="text-2xl sm:text-3xl font-bold text-[#294E69] mb-2 tracking-tight">
                                Semangat melayani hari ini, Dok! 🌟
                            </h2>
                            <p class="text-sm sm:text-base text-[#52758F] mb-6 max-w-lg leading-relaxed">
                                Ada <span class="font-bold text-[#294E69]">{{ $stats['pending_consultations'] ?? 0 }}</span> konsultasi yang menunggu respon Anda dan <span class="font-bold text-[#294E69]">{{ $stats['today_patients'] ?? 0 }}</span> pasien terjadwal hari ini.
                            </p>
                            
                            <div class="flex flex-wrap items-center gap-3">
                                <a href="{{ route('dokter.konsultasi') }}" class="inline-flex items-center gap-2 px-5 py-2.5 sm:px-6 sm:py-3 bg-[#548FB7] hover:bg-[#427DA6] text-white rounded-xl sm:rounded-2xl font-bold text-sm shadow-sm hover:shadow transition-all duration-200">
                                    <i data-lucide="message-square" class="w-4 h-4"></i>
                                    Lihat Konsultasi
                                </a>
                                <a href="{{ route('dokter.pasien') }}" class="inline-flex items-center gap-2 px-5 py-2.5 sm:px-6 sm:py-3 bg-white hover:bg-[#F3F8FD] text-[#294E69] border border-[#DFEBF5] rounded-xl sm:rounded-2xl font-bold text-sm shadow-sm hover:shadow transition-all duration-200">
                                    <i data-lucide="users" class="w-4 h-4 text-[#548FB7]"></i>
                                    Data Pasien
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Consultations Section -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <h2 class="text-lg sm:text-xl font-bold text-[#24323D]">Konsultasi Terbaru</h2>
                                @if(isset($stats['pending_consultations']) && $stats['pending_consultations'] > 0)
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-[#FFF5E4] text-[#B45309] border border-[#FFE2B3]">
                                        {{ $stats['pending_consultations'] }} menunggu
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('dokter.konsultasi') }}" class="text-sm font-semibold text-[#548FB7] hover:text-[#427DA6] flex items-center gap-1 transition-colors">
                                Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                        
                        <div class="bg-white rounded-[28px] p-5 sm:p-6 shadow-sm border border-[#DFEBF5]">
                            @if(isset($recentConsultations) && count($recentConsultations) > 0)
                                <div class="space-y-3.5">
                                    @foreach($recentConsultations as $consultation)
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-2xl border border-[#DFEBF5] hover:border-[#BEDAF0] hover:bg-[#F3F8FD]/60 transition-all gap-4">
                                            <div class="flex items-start gap-3.5">
                                                <div class="w-11 h-11 rounded-full bg-[#DCECF8] flex items-center justify-center shrink-0 text-[#548FB7] border border-[#DFEBF5]">
                                                    <i data-lucide="user" class="w-5 h-5"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <h3 class="font-bold text-sm sm:text-base text-[#24323D] truncate">
                                                        {{ $consultation->parent_name ?? 'Nama Orangtua' }}
                                                    </h3>
                                                    <p class="text-xs sm:text-sm text-[#718096] mb-1">
                                                        Anak: <span class="font-medium text-[#24323D]">{{ $consultation->child_name ?? 'Nama Anak' }}</span>
                                                        @if(isset($consultation->child_age))
                                                            <span class="text-[#718096]/70">({{ $consultation->child_age }})</span>
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-[#8C9BA8] line-clamp-1">
                                                        {{ $consultation->complaint ?? 'Keluhan belum dicatat' }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center justify-between sm:flex-col sm:items-end gap-2 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-[#DFEBF5]">
                                                @php
                                                    $statusKey = strtolower($consultation->status ?? '');
                                                    $statusStyle = 'bg-stone-50 text-stone-600 border border-stone-200';
                                                    $statusLabel = ucfirst($consultation->status ?? 'Status');
                                                    
                                                    if($statusKey === 'pending') {
                                                        $statusStyle = 'bg-[#FFF5E4] text-[#B45309] border border-[#FFE2B3]';
                                                        $statusLabel = 'Menunggu';
                                                    } elseif($statusKey === 'accepted') {
                                                        $statusStyle = 'bg-[#EAF4FC] text-[#346D96] border border-[#DFEBF5]';
                                                        $statusLabel = 'Diterima';
                                                    } elseif($statusKey === 'completed') {
                                                        $statusStyle = 'bg-[#EDF7F0] text-[#15803D] border border-[#C6E7D0]';
                                                        $statusLabel = 'Selesai';
                                                    } elseif($statusKey === 'cancelled') {
                                                        $statusStyle = 'bg-rose-50 text-rose-700 border border-rose-100';
                                                        $statusLabel = 'Dibatalkan';
                                                    }
                                                @endphp
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $statusStyle }}">
                                                    {{ $statusLabel }}
                                                </span>
                                                <a href="{{ route('dokter.konsultasi.detail', ['id' => $consultation->id ?? 1]) }}" class="text-xs sm:text-sm font-semibold text-white bg-[#548FB7] hover:bg-[#427DA6] px-4 py-2 rounded-xl shadow-sm transition-colors flex items-center gap-1.5">
                                                    Respon
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-10">
                                    <div class="w-16 h-16 bg-[#F3F8FD] border border-[#DFEBF5] rounded-full flex items-center justify-center mx-auto mb-3 text-[#548FB7]">
                                        <i data-lucide="inbox" class="w-8 h-8"></i>
                                    </div>
                                    <h4 class="font-bold text-[#24323D] mb-1">Belum Ada Konsultasi</h4>
                                    <p class="text-sm text-[#718096]">Konsultasi baru dari orang tua akan muncul di sini.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Right Column (Sidebar) -->
                <div class="xl:col-span-1 space-y-6 lg:space-y-8">
                    
                    <!-- Today Schedule Card -->
                    <div class="bg-white rounded-[28px] p-5 sm:p-6 shadow-sm border border-[#DFEBF5]">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-lg sm:text-xl font-bold text-[#24323D]">Jadwal Hari Ini</h2>
                                <p class="text-xs text-[#718096] mt-0.5">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                            </div>
                            <button type="button" aria-label="Kalender" class="w-9 h-9 rounded-full bg-[#F3F8FD] border border-[#DFEBF5] flex items-center justify-center text-[#548FB7] hover:bg-[#EAF4FC] transition-colors shadow-sm">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </button>
                        </div>

                        @if(isset($todaySchedule) && count($todaySchedule) > 0)
                            <div class="relative border-l-2 border-[#DFEBF5] ml-3.5 space-y-5">
                                @foreach($todaySchedule as $schedule)
                                    <div class="relative pl-6">
                                        <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-white border-4 border-[#548FB7] shadow-sm"></div>
                                        <div class="bg-[#F3F8FD] rounded-2xl p-4 border border-[#DFEBF5] hover:border-[#BEDAF0] transition-colors">
                                            <div class="text-xs font-bold text-[#548FB7] mb-1 flex items-center gap-1.5">
                                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                                <span>{{ $schedule->time ?? 'Waktu' }} WIB</span>
                                            </div>
                                            <h3 class="font-bold text-sm text-[#24323D]">{{ $schedule->parent_name ?? 'Nama Orangtua' }}</h3>
                                            <p class="text-xs text-[#718096] mt-0.5">
                                                <span class="font-medium text-[#294E69]">{{ $schedule->type ?? 'Konsultasi' }}</span> • {{ $schedule->child_name ?? 'Anak' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-14 h-14 bg-[#F3F8FD] border border-[#DFEBF5] rounded-full flex items-center justify-center mx-auto mb-3 text-[#548FB7]">
                                    <i data-lucide="calendar-x" class="w-7 h-7"></i>
                                </div>
                                <p class="text-sm text-[#718096] font-medium">Tidak ada jadwal tersisa hari ini</p>
                                <p class="text-xs text-[#8C9BA8] mt-1">Jadwal baru akan terdaftar otomatis.</p>
                            </div>
                        @endif
                        
                        <a href="{{ route('dokter.pasien') }}" class="mt-6 block w-full py-3 text-center rounded-xl sm:rounded-2xl bg-[#EAF4FC] text-[#346D96] border border-[#DFEBF5] font-bold text-sm hover:bg-[#DCECF8] transition-colors shadow-sm">
                            Lihat Kalender Penuh
                        </a>
                    </div>
                    
                </div>

            </div>
        </main>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-[#DFEBF5] flex items-center justify-around px-2 py-3 z-30 pb-safe">
        <a href="{{ route('dokter.dashboard') }}" class="flex flex-col items-center gap-1 p-2">
            <div class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
            </div>
            <span class="text-[10px] font-bold text-[#548FB7]">Beranda</span>
        </a>
        
        <a href="{{ route('dokter.konsultasi') }}" class="flex flex-col items-center gap-1 p-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center relative text-[#718096]">
                <i data-lucide="message-square" class="w-5 h-5"></i>
                @if(isset($stats['pending_consultations']) && $stats['pending_consultations'] > 0)
                    <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-[#548FB7] rounded-full border-2 border-white"></span>
                @endif
            </div>
            <span class="text-[10px] font-semibold text-[#718096]">Konsultasi</span>
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

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>
