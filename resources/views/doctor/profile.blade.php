<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Dokter - GrowCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8F7F2] text-[#202725] flex h-screen overflow-hidden">
    <!-- Desktop Sidebar (Doctor Blue Theme) -->
    <aside class="hidden md:flex flex-col w-[285px] bg-[#FBFAF6] border-r border-stone-200 h-full fixed left-0 top-0 z-20">
        <!-- Logo -->
        <div class="h-20 flex items-center px-8 border-b border-stone-100">
            <div class="flex items-center gap-2">
                <i data-lucide="leaf" class="w-6 h-6 text-blue-600"></i>
                <div class="flex flex-col">
                    <span class="text-xl font-bold tracking-tight">
                        <span class="text-blue-600">Grow</span>Care
                    </span>
                    <span class="text-[10px] font-semibold text-blue-600 tracking-wider">DOKTER</span>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto py-6 px-4">
            <div class="space-y-1.5">
                <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 text-stone-500 hover:text-blue-600 hover:bg-blue-50 rounded-[20px] transition-all duration-200 group font-medium">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    Dashboard
                </a>

                <a href="{{ route('dokter.konsultasi') }}" class="flex items-center gap-3 px-4 py-3.5 text-stone-500 hover:text-blue-600 hover:bg-blue-50 rounded-[20px] transition-all duration-200 group font-medium">
                    <i data-lucide="message-square" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    Konsultasi
                </a>

                <a href="{{ route('dokter.pasien') }}" class="flex items-center gap-3 px-4 py-3.5 text-stone-500 hover:text-blue-600 hover:bg-blue-50 rounded-[20px] transition-all duration-200 group font-medium">
                    <i data-lucide="users" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    Pasien
                </a>
                
                <a href="{{ route('dokter.profil') }}" class="flex items-center gap-3 px-4 py-3.5 text-blue-600 bg-blue-50 rounded-[20px] transition-all duration-200 group font-medium">
                    <i data-lucide="user-round" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    Profil
                </a>
            </div>
        </div>

        <!-- Logout -->
        <div class="p-4 border-t border-stone-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 text-red-600 bg-red-50 hover:bg-red-100 rounded-2xl transition-all font-semibold">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Header -->
    <header class="md:hidden fixed top-0 left-0 right-0 h-16 bg-white border-b border-stone-100 z-30 px-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i data-lucide="leaf" class="w-6 h-6 text-blue-600"></i>
            <div class="flex flex-col">
                <span class="text-xl font-bold tracking-tight">
                    <span class="text-blue-600">Grow</span>Care
                </span>
                <span class="text-[10px] font-semibold text-blue-600 tracking-wider">DOKTER</span>
            </div>
        </div>
        <button class="w-10 h-10 flex items-center justify-center rounded-full bg-stone-50 text-stone-600">
            <i data-lucide="bell" class="w-5 h-5"></i>
        </button>
    </header>

    <!-- Main Content -->
    <main class="flex-1 md:ml-[285px] h-screen overflow-y-auto pt-16 md:pt-0 pb-24 md:pb-0">
        <div class="max-w-4xl mx-auto px-4 md:px-8 py-8 space-y-6">
            
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl flex items-center gap-3">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Header -->
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider rounded-full mb-3">
                    <i data-lucide="settings" class="w-3.5 h-3.5"></i>
                    Pengaturan
                </span>
                <h1 class="text-3xl font-bold mb-1">Profil Dokter</h1>
                <p class="text-stone-500">Kelola informasi profil dan jadwal praktik Anda</p>
            </div>

            <!-- Hero Profile Card -->
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-stone-100 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-blue-400 via-transparent to-transparent"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- Avatar -->
                    <div class="relative">
                        <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden border-4 border-white shadow-md text-blue-600 text-2xl font-bold">
                            @if(isset($doctor->photo) && $doctor->photo)
                                <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name }}" class="w-full h-full object-cover">
                            @else
                                {{ collect(explode(' ', $doctor->name))->map(fn($n) => substr($n, 0, 1))->take(2)->join('') }}
                            @endif
                        </div>
                        @if($doctor->is_available ?? false)
                        <div class="absolute bottom-1 right-1 w-5 h-5 bg-green-500 border-2 border-white rounded-full flex items-center justify-center" title="Tersedia">
                        </div>
                        @else
                        <div class="absolute bottom-1 right-1 w-5 h-5 bg-stone-300 border-2 border-white rounded-full flex items-center justify-center" title="Tidak Tersedia">
                        </div>
                        @endif
                    </div>
                    
                    <!-- Info -->
                    <div class="text-center md:text-left flex-1">
                        <h2 class="text-2xl font-bold mb-1">{{ $doctor->name ?? 'Dr. Name' }}</h2>
                        <p class="text-blue-600 font-medium mb-3">{{ $doctor->specialization ?? 'Dokter Anak' }}</p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-2">
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-stone-100 text-stone-600 text-sm font-medium rounded-full">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                STR: {{ $doctor->str_number ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Form -->
            <form action="{{ route('dokter.profil.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="bg-white rounded-[30px] p-6 shadow-sm border border-stone-100 space-y-8">
                    <!-- Informasi Pribadi -->
                    <section>
                        <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-blue-500"></i>
                            Informasi Pribadi
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-stone-600">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $doctor->name ?? '') }}" class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-stone-600">Spesialisasi</label>
                                <input type="text" name="specialization" value="{{ old('specialization', $doctor->specialization ?? '') }}" class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-medium text-stone-600">Nomor STR</label>
                                <input type="text" name="str_number" value="{{ old('str_number', $doctor->str_number ?? '') }}" class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                        </div>
                    </section>

                    <hr class="border-stone-100">

                    <!-- Kontak -->
                    <section>
                        <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                            <i data-lucide="phone" class="w-5 h-5 text-blue-500"></i>
                            Kontak
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-stone-600">Email</label>
                                <input type="email" name="email" value="{{ old('email', $doctor->email ?? '') }}" class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-stone-600">No. Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $doctor->phone ?? '') }}" class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                        </div>
                    </section>

                    <hr class="border-stone-100">

                    <!-- Jadwal Praktik -->
                    <section>
                        <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                            <i data-lucide="calendar" class="w-5 h-5 text-blue-500"></i>
                            Jadwal Praktik
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-medium text-stone-600">Hari Praktik (Contoh: Senin - Jumat)</label>
                                <input type="text" name="practice_days" value="{{ old('practice_days', $doctor->practice_days ?? '') }}" class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-stone-600">Jam Mulai</label>
                                <input type="time" name="start_time" value="{{ old('start_time', $doctor->start_time ?? '') }}" class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-stone-600">Jam Selesai</label>
                                <input type="time" name="end_time" value="{{ old('end_time', $doctor->end_time ?? '') }}" class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                        </div>
                    </section>

                    <hr class="border-stone-100">

                    <!-- Bio -->
                    <section>
                        <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                            <i data-lucide="align-left" class="w-5 h-5 text-blue-500"></i>
                            Biografi
                        </h3>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-stone-600">Deskripsi Singkat</label>
                            <textarea name="bio" rows="4" class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all resize-none">{{ old('bio', $doctor->bio ?? '') }}</textarea>
                        </div>
                    </section>
                    
                    <hr class="border-stone-100">

                    <!-- Ketersediaan -->
                    <section class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold flex items-center gap-2">
                                <i data-lucide="power" class="w-5 h-5 text-blue-500"></i>
                                Status Ketersediaan
                            </h3>
                            <p class="text-sm text-stone-500 mt-1">Tampilkan status Anda tersedia untuk konsultasi baru</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_available" value="0">
                            <input type="checkbox" name="is_available" value="1" class="sr-only peer" {{ old('is_available', $doctor->is_available ?? false) ? 'checked' : '' }}>
                            <div class="w-14 h-7 bg-stone-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </section>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-blue-500/30 flex items-center gap-2 transition-all hover:scale-[1.02]">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-stone-100 z-30 px-6 py-3 flex justify-between items-center pb-safe">
        <a href="{{ route('dokter.dashboard') }}" class="flex flex-col items-center gap-1 text-stone-400 hover:text-blue-600 transition-colors">
            <i data-lucide="layout-dashboard" class="w-6 h-6"></i>
            <span class="text-[10px] font-semibold">Beranda</span>
        </a>
        <a href="{{ route('dokter.konsultasi') }}" class="flex flex-col items-center gap-1 text-stone-400 hover:text-blue-600 transition-colors">
            <i data-lucide="message-square" class="w-6 h-6"></i>
            <span class="text-[10px] font-semibold">Konsultasi</span>
        </a>
        <a href="{{ route('dokter.pasien') }}" class="flex flex-col items-center gap-1 text-stone-400 hover:text-blue-600 transition-colors">
            <i data-lucide="users" class="w-6 h-6"></i>
            <span class="text-[10px] font-semibold">Pasien</span>
        </a>
        <a href="{{ route('dokter.profil') }}" class="flex flex-col items-center gap-1 text-blue-600 transition-colors">
            <i data-lucide="user-round" class="w-6 h-6"></i>
            <span class="text-[10px] font-semibold">Profil</span>
        </a>
    </nav>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
