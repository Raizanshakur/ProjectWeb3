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
<body class="bg-[#F8F7F2] text-[#202725] antialiased">

    <!-- Mobile Header -->
    <div class="lg:hidden bg-white px-6 py-4 flex items-center justify-between shadow-sm sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                <i data-lucide="sprout" class="w-6 h-6 text-blue-600"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold"><span class="text-blue-600">Grow</span>Care</h1>
                <p class="text-[10px] font-bold text-blue-500 tracking-wider">DOKTER</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="relative">
                <i data-lucide="bell" class="w-6 h-6 text-gray-600"></i>
                <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
            </button>
            <div class="w-10 h-10 rounded-full bg-blue-100 overflow-hidden border-2 border-white shadow-sm">
                @if(isset($doctor->photo) && $doctor->photo)
                    <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name ?? 'Dokter' }}" class="w-full h-full object-cover">
                @else
                    <i data-lucide="user" class="w-full h-full p-2 text-blue-600"></i>
                @endif
            </div>
        </div>
    </div>

    <!-- Layout Container -->
    <div class="flex min-h-screen">
        
        <!-- Sidebar (Desktop) -->
        <aside class="hidden lg:flex w-[285px] bg-[#FBFAF6] border-r border-stone-200 flex-col h-screen sticky top-0">
            <!-- Logo -->
            <div class="p-8">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i data-lucide="sprout" class="w-7 h-7 text-blue-600"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold"><span class="text-blue-600">Grow</span>Care</h1>
                        <p class="text-xs font-bold text-blue-500 tracking-wider uppercase">Dokter</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 space-y-2">
                <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl bg-blue-50 text-blue-600 font-semibold transition-all">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('dokter.konsultasi') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-stone-500 hover:bg-stone-100 hover:text-stone-700 font-medium transition-all">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                    <span>Konsultasi</span>
                    @if(isset($stats['pending_consultations']) && $stats['pending_consultations'] > 0)
                        <span class="ml-auto bg-blue-100 text-blue-600 text-xs font-bold px-2 py-0.5 rounded-full">{{ $stats['pending_consultations'] }}</span>
                    @endif
                </a>
                
                <a href="{{ route('dokter.pasien') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-stone-500 hover:bg-stone-100 hover:text-stone-700 font-medium transition-all">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span>Data Pasien</span>
                </a>
                
                <a href="{{ route('dokter.profil') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-stone-500 hover:bg-stone-100 hover:text-stone-700 font-medium transition-all">
                    <i data-lucide="user-round" class="w-5 h-5"></i>
                    <span>Profil Saya</span>
                </a>
            </nav>

            <!-- Bottom Profile / Logout -->
            <div class="p-4">
                <div class="bg-white rounded-[24px] p-4 shadow-sm border border-stone-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 overflow-hidden flex-shrink-0">
                            @if(isset($doctor->photo) && $doctor->photo)
                                <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name ?? 'Dokter' }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="user" class="w-full h-full p-2 text-blue-600"></i>
                            @endif
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-sm truncate">{{ $doctor->name ?? 'Dr. Anak' }}</h4>
                            <p class="text-xs text-stone-500 truncate">{{ $doctor->specialization ?? 'Dokter Spesialis Anak' }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-red-500 hover:bg-red-50 font-semibold text-sm transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0 flex flex-col lg:h-screen lg:overflow-y-auto no-scrollbar">
            
            <!-- Desktop Header -->
            <header class="hidden lg:flex items-center justify-between px-10 py-8">
                <div>
                    <h2 class="text-3xl font-bold mb-1">Halo, {{ $doctor->name ?? 'Dokter' }} 👋</h2>
                    <p class="text-stone-500">Berikut adalah ringkasan jadwal dan konsultasi Anda hari ini.</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3 bg-white px-4 py-2.5 rounded-2xl shadow-sm border border-stone-100">
                        <span class="text-sm font-semibold">Status:</span>
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full {{ (isset($doctor->is_available) && $doctor->is_available) ? 'bg-green-500' : 'bg-red-500' }}"></div>
                            <span class="text-sm font-bold {{ (isset($doctor->is_available) && $doctor->is_available) ? 'text-green-600' : 'text-red-600' }}">{{ (isset($doctor->is_available) && $doctor->is_available) ? 'Tersedia' : 'Sibuk' }}</span>
                        </div>
                    </div>
                    
                    <div class="relative w-64">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-stone-400"></i>
                        <input type="text" placeholder="Cari pasien..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-stone-200 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all text-sm">
                    </div>
                    
                    <button class="relative p-2.5 bg-white rounded-2xl shadow-sm border border-stone-100 hover:border-blue-200 hover:bg-blue-50 transition-all">
                        <i data-lucide="bell" class="w-5 h-5 text-stone-600"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                </div>
            </header>

            <div class="px-6 lg:px-10 pb-24 lg:pb-10 flex-1 grid grid-cols-1 xl:grid-cols-3 gap-8">
                
                <!-- Left Column (Wider) -->
                <div class="xl:col-span-2 space-y-8">
                    
                    <!-- Stats Row -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Stat 1 -->
                        <div class="bg-white p-5 rounded-[24px] shadow-sm border border-stone-100">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mb-4">
                                <i data-lucide="message-square" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            <h3 class="text-3xl font-bold mb-1">{{ $stats['total_consultations'] ?? 0 }}</h3>
                            <p class="text-sm text-stone-500 font-medium">Total Konsultasi</p>
                        </div>
                        <!-- Stat 2 -->
                        <div class="bg-white p-5 rounded-[24px] shadow-sm border border-stone-100">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center mb-4">
                                <i data-lucide="users" class="w-5 h-5 text-indigo-600"></i>
                            </div>
                            <h3 class="text-3xl font-bold mb-1">{{ $stats['today_patients'] ?? 0 }}</h3>
                            <p class="text-sm text-stone-500 font-medium">Pasien Hari Ini</p>
                        </div>
                        <!-- Stat 3 -->
                        <div class="bg-white p-5 rounded-[24px] shadow-sm border border-stone-100">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-4">
                                <i data-lucide="clock" class="w-5 h-5 text-amber-600"></i>
                            </div>
                            <h3 class="text-3xl font-bold mb-1">{{ $stats['pending_consultations'] ?? 0 }}</h3>
                            <p class="text-sm text-stone-500 font-medium">Menunggu</p>
                        </div>
                        <!-- Stat 4 -->
                        <div class="bg-white p-5 rounded-[24px] shadow-sm border border-stone-100">
                            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center mb-4">
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                            </div>
                            <h3 class="text-3xl font-bold mb-1">{{ $stats['completed_today'] ?? 0 }}</h3>
                            <p class="text-sm text-stone-500 font-medium">Selesai Hari Ini</p>
                        </div>
                    </div>

                    <!-- Hero Overview Card -->
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[30px] p-8 text-white shadow-lg relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-400/20 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold tracking-wider uppercase backdrop-blur-sm">Overview</span>
                                <span class="text-sm text-blue-100">{{ date('d M Y') }}</span>
                            </div>
                            
                            <h3 class="text-2xl font-bold mb-2">Semangat melayani hari ini, Dok! 🌟</h3>
                            <p class="text-blue-100 mb-8 max-w-md">Ada {{ $stats['pending_consultations'] ?? 0 }} konsultasi yang menunggu respon Anda dan {{ $stats['today_patients'] ?? 0 }} pasien terjadwal hari ini.</p>
                            
                            <div class="flex flex-wrap gap-4">
                                <a href="{{ route('dokter.konsultasi') }}" class="px-6 py-3 bg-white text-blue-600 rounded-xl font-bold text-sm shadow-sm hover:bg-blue-50 transition-colors flex items-center gap-2">
                                    <i data-lucide="message-square" class="w-4 h-4"></i>
                                    Lihat Konsultasi
                                </a>
                                <a href="{{ route('dokter.pasien') }}" class="px-6 py-3 bg-white/10 text-white border border-white/20 rounded-xl font-bold text-sm hover:bg-white/20 transition-colors flex items-center gap-2 backdrop-blur-sm">
                                    <i data-lucide="users" class="w-4 h-4"></i>
                                    Data Pasien
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Consultations -->
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold">Konsultasi Terbaru</h3>
                            <a href="{{ route('dokter.konsultasi') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                        
                        <div class="bg-white rounded-[28px] p-6 shadow-sm border border-stone-100">
                            @if(isset($recentConsultations) && count($recentConsultations) > 0)
                                <div class="space-y-4">
                                    @foreach($recentConsultations as $consultation)
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-2xl border border-stone-100 hover:border-blue-100 hover:bg-blue-50/50 transition-all gap-4">
                                            <div class="flex items-start gap-4">
                                                <div class="w-12 h-12 rounded-full bg-stone-100 flex items-center justify-center flex-shrink-0">
                                                    <i data-lucide="user" class="w-6 h-6 text-stone-500"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-gray-900">{{ $consultation->parent_name ?? 'Nama Orangtua' }}</h4>
                                                    <p class="text-sm text-stone-500 mb-1">Anak: {{ $consultation->child_name ?? 'Nama Anak' }} ({{ $consultation->child_age ?? 'Usia' }})</p>
                                                    <p class="text-xs text-stone-400 line-clamp-1">{{ $consultation->complaint ?? 'Keluhan' }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center justify-between sm:flex-col sm:items-end gap-2">
                                                @php
                                                    $statusColor = 'bg-stone-100 text-stone-600';
                                                    if(($consultation->status ?? '') == 'pending') $statusColor = 'bg-amber-100 text-amber-700';
                                                    elseif(($consultation->status ?? '') == 'accepted') $statusColor = 'bg-blue-100 text-blue-700';
                                                    elseif(($consultation->status ?? '') == 'completed') $statusColor = 'bg-green-100 text-green-700';
                                                    elseif(($consultation->status ?? '') == 'cancelled') $statusColor = 'bg-red-100 text-red-700';
                                                @endphp
                                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColor }}">
                                                    {{ ucfirst($consultation->status ?? 'Status') }}
                                                </span>
                                                <a href="{{ route('dokter.konsultasi.detail', ['id' => $consultation->id ?? 1]) }}" class="text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition-colors">
                                                    Respon
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-10">
                                    <div class="w-16 h-16 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i data-lucide="inbox" class="w-8 h-8 text-stone-400"></i>
                                    </div>
                                    <h4 class="font-bold text-gray-500 mb-1">Belum Ada Konsultasi</h4>
                                    <p class="text-sm text-gray-400">Konsultasi baru akan muncul di sini.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Right Column (Sidebar) -->
                <div class="xl:col-span-1 space-y-8">
                    
                    <!-- Today Schedule -->
                    <div class="bg-white rounded-[28px] p-6 shadow-sm border border-stone-100">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold">Jadwal Hari Ini</h3>
                            <button class="w-8 h-8 rounded-full bg-stone-50 flex items-center justify-center hover:bg-stone-100">
                                <i data-lucide="calendar" class="w-4 h-4 text-stone-600"></i>
                            </button>
                        </div>

                        @if(isset($todaySchedule) && count($todaySchedule) > 0)
                            <div class="relative border-l-2 border-stone-100 ml-3 space-y-6">
                                @foreach($todaySchedule as $schedule)
                                    <div class="relative pl-6">
                                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-white border-4 border-blue-500"></div>
                                        <div class="bg-stone-50 rounded-2xl p-4 border border-stone-100">
                                            <div class="text-xs font-bold text-blue-600 mb-1 flex items-center gap-1">
                                                <i data-lucide="clock" class="w-3 h-3"></i>
                                                {{ $schedule->time ?? 'Waktu' }}
                                            </div>
                                            <h4 class="font-bold text-sm">{{ $schedule->parent_name ?? 'Nama' }}</h4>
                                            <p class="text-xs text-stone-500">{{ $schedule->type ?? 'Tipe' }} - {{ $schedule->child_name ?? 'Anak' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i data-lucide="calendar-x" class="w-10 h-10 text-stone-300 mx-auto mb-3"></i>
                                <p class="text-sm text-stone-500 font-medium">Tidak ada jadwal tersisa hari ini</p>
                            </div>
                        @endif
                        
                        <a href="{{ route('dokter.pasien') }}" class="mt-6 block w-full py-3 text-center rounded-xl bg-blue-50 text-blue-600 font-bold text-sm hover:bg-blue-100 transition-colors">
                            Lihat Kalender Penuh
                        </a>
                    </div>
                    
                </div>

            </div>
        </main>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-stone-200 flex items-center justify-around px-2 py-3 z-30 pb-safe">
        <a href="{{ route('dokter.dashboard') }}" class="flex flex-col items-center gap-1 p-2">
            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                <i data-lucide="layout-dashboard" class="w-4 h-4 text-blue-600"></i>
            </div>
            <span class="text-[10px] font-bold text-blue-600">Beranda</span>
        </a>
        
        <a href="{{ route('dokter.konsultasi') }}" class="flex flex-col items-center gap-1 p-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center relative text-stone-400">
                <i data-lucide="message-square" class="w-5 h-5"></i>
                @if(isset($stats['pending_consultations']) && $stats['pending_consultations'] > 0)
                    <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-blue-500 rounded-full border-2 border-white"></span>
                @endif
            </div>
            <span class="text-[10px] font-semibold text-stone-500">Konsultasi</span>
        </a>
        
        <a href="{{ route('dokter.pasien') }}" class="flex flex-col items-center gap-1 p-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-stone-400">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <span class="text-[10px] font-semibold text-stone-500">Pasien</span>
        </a>
        
        <a href="{{ route('dokter.profil') }}" class="flex flex-col items-center gap-1 p-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-stone-400">
                <i data-lucide="user-round" class="w-5 h-5"></i>
            </div>
            <span class="text-[10px] font-semibold text-stone-500">Profil</span>
        </a>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>
