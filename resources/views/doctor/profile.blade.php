<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Dokter - GrowCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
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
    <x-growcare-doctor-sidebar active="profile" />

    <!-- Main Content -->
    <main class="w-full min-w-0 lg:ml-[285px] pt-16 lg:pt-0 pb-24 lg:pb-12">
        <div class="max-w-[1450px] mx-auto w-full min-w-0 px-4 sm:px-6 lg:px-10 py-6 lg:py-8 space-y-6 sm:space-y-8">
            
            <!-- Success Notification -->
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3 shadow-xs">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                    <p class="text-sm font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center gap-3 shadow-xs">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 shrink-0"></i>
                    <div class="text-sm font-medium space-y-0.5">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Header -->
            <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-[#346D96] border border-[#DFEBF5] shadow-xs mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#548FB7]"></span>
                        <span class="text-xs font-bold tracking-wider uppercase">PENGATURAN PROFIL</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#24323D]">
                        Profil Dokter
                    </h1>
                    <p class="text-sm sm:text-base text-[#718096] mt-1">
                        Kelola informasi profil profesional, kontak, dan jadwal praktik Anda.
                    </p>
                </div>
            </header>

            <!-- Hero Profile Card (Soft Blue Pastel) -->
            <div class="relative overflow-hidden rounded-[28px] sm:rounded-[32px] p-6 sm:p-8 bg-gradient-to-br from-[#EAF4FC] via-[#EDF5FC] to-[#DCECF8] border border-[#DFEBF5] shadow-sm">
                <!-- Decorative blobs -->
                <div class="pointer-events-none absolute -top-12 -right-12 w-64 h-64 rounded-full bg-white/60 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-10 -left-10 w-52 h-52 rounded-full bg-[#BEDAF0]/30 blur-2xl"></div>
                <div class="pointer-events-none absolute right-8 top-1/2 -translate-y-1/2 opacity-10 hidden sm:block">
                    <i data-lucide="stethoscope" class="w-48 h-48 text-[#548FB7]"></i>
                </div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- Avatar Frame with Status Dot -->
                    <div class="relative shrink-0">
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-[#DCECF8] flex items-center justify-center overflow-hidden border-4 border-white shadow-md text-[#548FB7] text-2xl font-bold">
                            @if(isset($doctor->photo) && $doctor->photo)
                                <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name }}" class="w-full h-full object-cover">
                            @else
                                {{ collect(explode(' ', $doctor->name ?? 'D'))->map(fn($n) => substr($n, 0, 1))->take(2)->join('') }}
                            @endif
                        </div>
                        
                        @if($doctor->is_available ?? false)
                            <div class="absolute bottom-1 right-1 w-6 h-6 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center shadow-xs" title="Tersedia">
                                <span class="w-2 h-2 rounded-full bg-white"></span>
                            </div>
                        @else
                            <div class="absolute bottom-1 right-1 w-6 h-6 bg-stone-300 border-2 border-white rounded-full flex items-center justify-center shadow-xs" title="Tidak Tersedia">
                            </div>
                        @endif
                    </div>
                    
                    <!-- Doctor Identity Info -->
                    <div class="text-center md:text-left flex-1 min-w-0">
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mb-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/80 text-[#346D96] border border-[#DFEBF5] rounded-full text-xs font-bold uppercase tracking-wider shadow-2xs backdrop-blur-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#548FB7]"></span>
                                {{ $doctor->specialization ?? 'Dokter Spesialis' }}
                            </span>
                            
                            @if($doctor->is_available ?? false)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 rounded-full text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    Tidak Tersedia
                                </span>
                            @endif
                        </div>
                        
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#294E69] mb-1.5 tracking-tight truncate">
                            {{ $doctor->name ?? 'Dr. Name' }}
                        </h2>
                        
                        <p class="text-xs sm:text-sm text-[#52758F] mb-4 max-w-2xl leading-relaxed">
                            {{ $doctor->bio ?? 'Belum ada biografi singkat.' }}
                        </p>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-2.5">
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white/70 text-[#24323D] border border-[#DFEBF5] text-xs font-medium rounded-full shadow-2xs">
                                <i data-lucide="file-badge" class="w-3.5 h-3.5 text-[#548FB7]"></i>
                                STR: <span class="font-semibold">{{ $doctor->str_number ?? '-' }}</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white/70 text-[#24323D] border border-[#DFEBF5] text-xs font-medium rounded-full shadow-2xs">
                                <i data-lucide="mail" class="w-3.5 h-3.5 text-[#548FB7]"></i>
                                <span>{{ $doctor->email ?? '-' }}</span>
                            </span>
                            @if(isset($doctor->practice_days))
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white/70 text-[#24323D] border border-[#DFEBF5] text-xs font-medium rounded-full shadow-2xs">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-[#548FB7]"></i>
                                    <span>{{ $doctor->practice_days }} ({{ $doctor->start_time ?? '-' }} - {{ $doctor->end_time ?? '-' }} WIB)</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Form -->
            <form action="{{ route('dokter.profil.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="bg-white rounded-[28px] sm:rounded-[32px] p-6 sm:p-8 shadow-sm border border-[#DFEBF5] space-y-8">
                    
                    <!-- Section 1: Informasi Pribadi & Profesi -->
                    <section>
                        <h3 class="text-base sm:text-lg font-bold mb-4 flex items-center gap-2.5 text-[#24323D]">
                            <span class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
                                <i data-lucide="user" class="w-4 h-4"></i>
                            </span>
                            <span>Informasi Pribadi & Profesi</span>
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label for="doctorName" class="text-xs sm:text-sm font-semibold text-[#24323D]">
                                    Nama Lengkap Beserta Gelar
                                </label>
                                <input type="text"
                                       id="doctorName"
                                       name="name"
                                       value="{{ old('name', $doctor->name ?? '') }}"
                                       placeholder="Contoh: Dr. Anisa Rahma, Sp.A"
                                       class="w-full px-4 py-3 bg-[#F8FAFD] border border-[#DFEBF5] rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#548FB7]/20 focus:border-[#548FB7] focus:bg-white transition-all text-sm text-[#24323D] placeholder-[#718096]/70 shadow-2xs">
                                @error('name')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="doctorSpecialization" class="text-xs sm:text-sm font-semibold text-[#24323D]">
                                    Spesialisasi
                                </label>
                                <input type="text"
                                       id="doctorSpecialization"
                                       name="specialization"
                                       value="{{ old('specialization', $doctor->specialization ?? '') }}"
                                       placeholder="Contoh: Dokter Spesialis Anak"
                                       class="w-full px-4 py-3 bg-[#F8FAFD] border border-[#DFEBF5] rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#548FB7]/20 focus:border-[#548FB7] focus:bg-white transition-all text-sm text-[#24323D] placeholder-[#718096]/70 shadow-2xs">
                                @error('specialization')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5 md:col-span-2">
                                <label for="doctorStr" class="text-xs sm:text-sm font-semibold text-[#24323D]">
                                    Nomor STR (Surat Tanda Registrasi)
                                </label>
                                <input type="text"
                                       id="doctorStr"
                                       name="str_number"
                                       value="{{ old('str_number', $doctor->str_number ?? '') }}"
                                       placeholder="Contoh: STR-3120-1234-5678"
                                       class="w-full px-4 py-3 bg-[#F8FAFD] border border-[#DFEBF5] rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#548FB7]/20 focus:border-[#548FB7] focus:bg-white transition-all text-sm text-[#24323D] placeholder-[#718096]/70 shadow-2xs">
                                @error('str_number')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <hr class="border-[#DFEBF5]">

                    <!-- Section 2: Kontak & Komunikasi -->
                    <section>
                        <h3 class="text-base sm:text-lg font-bold mb-4 flex items-center gap-2.5 text-[#24323D]">
                            <span class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </span>
                            <span>Kontak & Komunikasi</span>
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label for="doctorEmail" class="text-xs sm:text-sm font-semibold text-[#24323D]">
                                    Alamat Email
                                </label>
                                <input type="email"
                                       id="doctorEmail"
                                       name="email"
                                       value="{{ old('email', $doctor->email ?? '') }}"
                                       placeholder="dokter@growcare.id"
                                       class="w-full px-4 py-3 bg-[#F8FAFD] border border-[#DFEBF5] rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#548FB7]/20 focus:border-[#548FB7] focus:bg-white transition-all text-sm text-[#24323D] placeholder-[#718096]/70 shadow-2xs">
                                @error('email')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="doctorPhone" class="text-xs sm:text-sm font-semibold text-[#24323D]">
                                    Nomor Telepon / WhatsApp
                                </label>
                                <input type="text"
                                       id="doctorPhone"
                                       name="phone"
                                       value="{{ old('phone', $doctor->phone ?? '') }}"
                                       placeholder="Contoh: 0812-3456-7890"
                                       class="w-full px-4 py-3 bg-[#F8FAFD] border border-[#DFEBF5] rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#548FB7]/20 focus:border-[#548FB7] focus:bg-white transition-all text-sm text-[#24323D] placeholder-[#718096]/70 shadow-2xs">
                                @error('phone')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <hr class="border-[#DFEBF5]">

                    <!-- Section 3: Jadwal Praktik -->
                    <section>
                        <h3 class="text-base sm:text-lg font-bold mb-1 flex items-center gap-2.5 text-[#24323D]">
                            <span class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </span>
                            <span>Jadwal Praktik Konsultasi</span>
                        </h3>
                        <p class="text-xs text-[#718096] mb-4 ml-10">
                            Tentukan hari dan jam konsultasi aktif Anda agar pasien dapat mengetahui ketersediaan jadwal.
                        </p>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="space-y-1.5 md:col-span-2">
                                <label for="doctorPracticeDays" class="text-xs sm:text-sm font-semibold text-[#24323D]">
                                    Hari Praktik
                                </label>
                                <input type="text"
                                       id="doctorPracticeDays"
                                       name="practice_days"
                                       value="{{ old('practice_days', $doctor->practice_days ?? '') }}"
                                       placeholder="Contoh: Senin - Jumat"
                                       class="w-full px-4 py-3 bg-[#F8FAFD] border border-[#DFEBF5] rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#548FB7]/20 focus:border-[#548FB7] focus:bg-white transition-all text-sm text-[#24323D] placeholder-[#718096]/70 shadow-2xs">
                                @error('practice_days')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="doctorStartTime" class="text-xs sm:text-sm font-semibold text-[#24323D]">
                                    Jam Mulai Praktik
                                </label>
                                <input type="time"
                                       id="doctorStartTime"
                                       name="start_time"
                                       value="{{ old('start_time', $doctor->start_time ?? '') }}"
                                       class="w-full px-4 py-3 bg-[#F8FAFD] border border-[#DFEBF5] rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#548FB7]/20 focus:border-[#548FB7] focus:bg-white transition-all text-sm text-[#24323D] shadow-2xs">
                                @error('start_time')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="doctorEndTime" class="text-xs sm:text-sm font-semibold text-[#24323D]">
                                    Jam Selesai Praktik
                                </label>
                                <input type="time"
                                       id="doctorEndTime"
                                       name="end_time"
                                       value="{{ old('end_time', $doctor->end_time ?? '') }}"
                                       class="w-full px-4 py-3 bg-[#F8FAFD] border border-[#DFEBF5] rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#548FB7]/20 focus:border-[#548FB7] focus:bg-white transition-all text-sm text-[#24323D] shadow-2xs">
                                @error('end_time')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <hr class="border-[#DFEBF5]">

                    <!-- Section 4: Biografi & Deskripsi Profesional -->
                    <section>
                        <h3 class="text-base sm:text-lg font-bold mb-1 flex items-center gap-2.5 text-[#24323D]">
                            <span class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
                                <i data-lucide="align-left" class="w-4 h-4"></i>
                            </span>
                            <span>Biografi & Pengalaman Medis</span>
                        </h3>
                        <p class="text-xs text-[#718096] mb-4 ml-10">
                            Deskripsi pengalaman atau keahlian klinis Anda yang dapat dibaca oleh pasien.
                        </p>

                        <div class="space-y-1.5">
                            <label for="doctorBio" class="text-xs sm:text-sm font-semibold text-[#24323D]">
                                Ringkasan Profil
                            </label>
                            <textarea id="doctorBio"
                                      name="bio"
                                      rows="4"
                                      placeholder="Tuliskan pengalaman medis, riwayat pendidikan, atau fokus layanan tumbuh kembang anak Anda..."
                                      class="w-full px-4 py-3 bg-[#F8FAFD] border border-[#DFEBF5] rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#548FB7]/20 focus:border-[#548FB7] focus:bg-white transition-all text-sm text-[#24323D] placeholder-[#718096]/70 resize-none shadow-2xs">{{ old('bio', $doctor->bio ?? '') }}</textarea>
                            @error('bio')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>
                    
                    <hr class="border-[#DFEBF5]">

                    <!-- Section 5: Status Ketersediaan Konsultasi -->
                    <section class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-2xl bg-[#F8FAFD] border border-[#DFEBF5]">
                        <div class="flex items-start gap-3">
                            <span class="w-9 h-9 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7] shrink-0 mt-0.5">
                                <i data-lucide="power" class="w-4 h-4"></i>
                            </span>
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-[#24323D]">
                                    Status Ketersediaan Konsultasi
                                </h3>
                                <p class="text-xs text-[#718096] mt-0.5">
                                    Aktifkan status ini agar orang tua dapat mengajukan konsultasi online dengan Anda.
                                </p>
                            </div>
                        </div>

                        <label class="relative inline-flex items-center cursor-pointer shrink-0 self-end sm:self-center">
                            <input type="hidden" name="is_available" value="0">
                            <input type="checkbox"
                                   name="is_available"
                                   value="1"
                                   class="sr-only peer"
                                   {{ old('is_available', $doctor->is_available ?? false) ? 'checked' : '' }}>
                            <div class="w-14 h-7 bg-stone-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#548FB7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#548FB7]"></div>
                        </label>
                    </section>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-2">
                    <button type="submit"
                            class="bg-[#548FB7] hover:bg-[#427DA6] text-white px-8 py-3.5 sm:py-4 rounded-xl sm:rounded-2xl font-bold shadow-sm hover:shadow transition-all duration-200 flex items-center gap-2 text-sm sm:text-base">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
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
        <div class="w-8 h-8 rounded-full flex items-center justify-center text-[#718096]">
            <i data-lucide="users" class="w-5 h-5"></i>
        </div>
        <span class="text-[10px] font-semibold text-[#718096]">Pasien</span>
    </a>
    <a href="{{ route('dokter.profil') }}" class="flex flex-col items-center gap-1 p-2">
        <div class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
            <i data-lucide="user-round" class="w-4 h-4"></i>
        </div>
        <span class="text-[10px] font-bold text-[#548FB7]">Profil</span>
    </a>
</nav>

<script>
    lucide.createIcons();
</script>
</body>
</html>
