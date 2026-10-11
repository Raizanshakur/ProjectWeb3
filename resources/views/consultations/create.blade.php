<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Konsultasi Dokter - GrowCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#F8F7F2] text-[#202725] overflow-x-hidden min-h-screen">
<div class="min-h-screen flex">

    {{-- ================= MOBILE HEADER ================= --}}
    <header class="lg:hidden fixed top-0 left-0 right-0 z-40 h-16
                   bg-[#FBFAF6]/95 backdrop-blur-xl border-b border-stone-200
                   flex items-center justify-between px-4 sm:px-5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <span class="w-9 h-9 rounded-full bg-[#E0F0EB] text-[#438F83]
                         flex items-center justify-center">
                <i data-lucide="sprout" class="w-5 h-5"></i>
            </span>
            <span class="text-xl font-bold"><span class="text-[#438F83]">Grow</span>Care</span>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="w-10 h-10 rounded-full bg-[#DDF1EE] text-[#438F83]
                  flex items-center justify-center">
            <i data-lucide="user-round" class="w-5 h-5"></i>
        </a>
    </header>

    {{-- ================= SIDEBAR ================= --}}
    <x-growcare-sidebar active="consultations" />

    {{-- ================= MAIN ================= --}}
    <main class="w-full min-w-0 lg:ml-[285px] pt-20 lg:pt-8 pb-28 lg:pb-12 px-4 sm:px-6 md:px-10">
        <div class="max-w-[850px] mx-auto w-full">

            {{-- BREADCRUMB / BACK --}}
            <a href="{{ route('consultations.index') }}"
               class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-[#438F83] transition mb-4">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali ke Daftar Konsultasi</span>
            </a>

            {{-- HEADER --}}
            <div class="mb-7">
                <span class="text-xs uppercase tracking-wider font-semibold text-[#4B988D]">
                    Pengajuan Baru
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold mt-1 text-[#202725]">
                    Ajukan Konsultasi Dokter
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Pilih anak, dokter spesialis yang tersedia, dan sampaikan keluhan atau pertanyaan Anda.
                </p>
            </div>

            {{-- ERROR BANNER --}}
            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800">
                    <div class="flex items-center gap-2 font-semibold text-sm mb-1">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-red-600"></i>
                        <span>Mohon periksa formulir berikut:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('consultations.store') }}" class="space-y-6">
                @csrf

                {{-- 1. PILIH ANAK --}}
                <div class="bg-white rounded-3xl border border-stone-100 p-6 shadow-sm">
                    <label class="block text-sm font-bold text-gray-800 mb-2">
                        1. Pilih Anak <span class="text-red-500">*</span>
                    </label>

                    @if($children->isEmpty())
                        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-sm">
                            <p class="mb-2">Anda belum memiliki data anak yang terdaftar.</p>
                            <a href="{{ route('children.create') }}" class="inline-flex items-center gap-1.5 font-bold text-[#438F83] hover:underline">
                                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                <span>Tambah Data Anak Terlebih Dahulu</span>
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($children as $child)
                                <label class="relative flex items-center p-4 rounded-2xl border-2 cursor-pointer transition
                                              {{ old('child_id', $selectedChildId) == $child->id ? 'border-[#4B988D] bg-[#EFF7F4]' : 'border-stone-200 hover:border-stone-300 bg-stone-50/50' }}">
                                    <input type="radio" name="child_id" value="{{ $child->id }}" class="sr-only"
                                           {{ old('child_id', $selectedChildId) == $child->id ? 'checked' : '' }}
                                           onchange="this.form.querySelectorAll('.child-card').forEach(c => c.classList.remove('border-[#4B988D]', 'bg-[#EFF7F4]')); this.closest('label').classList.add('border-[#4B988D]', 'bg-[#EFF7F4]');">
                                    <span class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-[#438F83] shrink-0 mr-3">
                                        <i data-lucide="baby" class="w-5 h-5"></i>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="font-bold text-sm text-gray-800 truncate">{{ $child->name }}</p>
                                        <p class="text-xs text-gray-400">
                                            {{ $child->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} • {{ $child->birth_date ? \Carbon\Carbon::parse($child->birth_date)->age . ' tahun' : '' }}
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('child_id')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                {{-- 2. PILIH DOKTER --}}
                <div class="bg-white rounded-3xl border border-stone-100 p-6 shadow-sm">
                    <label class="block text-sm font-bold text-gray-800 mb-2">
                        2. Pilih Dokter Spesialis Anak <span class="text-red-500">*</span>
                    </label>

                    @if($doctors->isEmpty())
                        <div class="p-6 rounded-2xl bg-amber-50/70 border border-amber-200 text-center">
                            <div class="w-12 h-12 mx-auto rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mb-2">
                                <i data-lucide="user-x" class="w-6 h-6"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 text-sm mb-1">
                                Belum Ada Dokter Tersedia
                            </h3>
                            <p class="text-xs text-gray-500 mb-4">
                                Saat ini tidak ada dokter yang aktif dengan status online/tersedia.
                            </p>
                            <div class="p-3 bg-white rounded-xl border border-amber-200 text-xs text-amber-800 text-left font-mono">
                                <strong>💡 Petunjuk Lingkungan Lokal:</strong><br>
                                Jalankan <code class="bg-amber-100 px-1 py-0.5 rounded font-bold">php artisan db:seed</code> di terminal Anda untuk menambahkan profil dokter spesialis anak.
                            </div>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($doctors as $doctor)
                                <label class="relative flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition
                                              {{ old('doctor_id', $selectedDoctorId) == $doctor->id ? 'border-[#4B988D] bg-[#EFF7F4]' : 'border-stone-200 hover:border-stone-300 bg-stone-50/50' }}">
                                    <div class="flex items-center gap-3.5 mb-2 sm:mb-0">
                                        <input type="radio" name="doctor_id" value="{{ $doctor->id }}" class="sr-only"
                                               {{ old('doctor_id', $selectedDoctorId) == $doctor->id ? 'checked' : '' }}>
                                        <span class="w-12 h-12 rounded-2xl bg-[#E8F4F0] text-[#438F83] flex items-center justify-center shrink-0">
                                            <i data-lucide="stethoscope" class="w-6 h-6"></i>
                                        </span>
                                        <div>
                                            <h4 class="font-bold text-sm sm:text-base text-gray-800">{{ $doctor->name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $doctor->specialization ?? 'Dokter Spesialis Anak' }}</p>
                                            @if($doctor->practice_days)
                                                <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                                    <i data-lucide="calendar" class="w-3 h-3"></i>
                                                    {{ $doctor->practice_days }} ({{ \Illuminate\Support\Str::substr($doctor->start_time ?? '08:00', 0, 5) }} - {{ \Illuminate\Support\Str::substr($doctor->end_time ?? '16:00', 0, 5) }})
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 self-start sm:self-center">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span class="text-xs font-semibold text-emerald-700">Tersedia</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('doctor_id')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                {{-- 3. KELUHAN --}}
                <div class="bg-white rounded-3xl border border-stone-100 p-6 shadow-sm">
                    <label for="complaint" class="block text-sm font-bold text-gray-800 mb-1">
                        3. Keluhan / Pertanyaan Medis <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-500 mb-3">
                        Ceritakan secara jelas gejala, kondisi makan, berat badan, atau keluhan kesehatan si kecil (minimal 10 karakter).
                    </p>
                    <textarea id="complaint" name="complaint" rows="5"
                              class="w-full rounded-2xl border-stone-200 focus:border-[#4B988D] focus:ring focus:ring-[#4B988D]/20 text-sm text-gray-800 p-4 transition placeholder-gray-400"
                              placeholder="Contoh: Anak saya berusia 14 bulan, nafsu makan menurun drastis sejak 3 hari lalu dan berat badannya turun 300 gram...">{{ old('complaint') }}</textarea>
                    @error('complaint')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 4. JADWAL KONSULTASI TENTATIF (OPSIONAL) --}}
                <div class="bg-white rounded-3xl border border-stone-100 p-6 shadow-sm">
                    <label for="consultation_date" class="block text-sm font-bold text-gray-800 mb-1">
                        4. Rencana Waktu Konsultasi (Opsional)
                    </label>
                    <p class="text-xs text-gray-500 mb-3">
                        Waktu tentatif yang Anda harapkan. Dokter akan meninjau dan menerima permintaan saat online.
                    </p>
                    <input type="datetime-local" id="consultation_date" name="consultation_date"
                           value="{{ old('consultation_date') }}"
                           min="{{ now()->format('Y-m-d\TH:i') }}"
                           class="w-full max-w-sm rounded-2xl border-stone-200 focus:border-[#4B988D] focus:ring focus:ring-[#4B988D]/20 text-sm text-gray-800 p-3.5 transition">
                    @error('consultation_date')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SUBMIT ACTIONS --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('consultations.index') }}"
                       class="px-6 py-3.5 rounded-2xl border border-stone-200 text-gray-600 hover:bg-stone-50 font-semibold text-sm transition">
                        Batal
                    </a>
                    <button type="submit"
                            {{ $children->isEmpty() || $doctors->isEmpty() ? 'disabled' : '' }}
                            class="px-7 py-3.5 rounded-2xl bg-[#4B988D] hover:bg-[#3E8379] disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold text-sm shadow-sm transition flex items-center gap-2">
                        <i data-lucide="send" class="w-4 h-4"></i>
                        <span>Kirim Permintaan Konsultasi</span>
                    </button>
                </div>
            </form>

        </div>
    </main>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
