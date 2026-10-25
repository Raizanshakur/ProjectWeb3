<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konsultasi - GrowCare Dokter</title>
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
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.25s ease-out forwards;
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
            <div class="max-w-[1450px] mx-auto w-full min-w-0 px-4 sm:px-6 lg:px-10 py-6 lg:py-8 space-y-6">
                
                <!-- Back Link & Top Bar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <a href="{{ route('dokter.konsultasi') }}"
                       class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-[#548FB7] hover:text-[#427DA6] transition-colors bg-white px-4 py-2 rounded-xl border border-[#DFEBF5] shadow-xs w-fit">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span>Kembali ke Daftar Konsultasi</span>
                    </a>

                    @php
                        $statusKey = strtolower($consultation->status ?? '');
                        $statusClass = 'bg-stone-50 text-stone-600 border border-stone-200';
                        $statusLabel = ucfirst($consultation->status ?? 'Status');

                        if ($statusKey === 'pending') {
                            $statusClass = 'bg-[#FFF5E4] text-[#B45309] border border-[#FFE2B3]';
                            $statusLabel = 'Menunggu';
                        } elseif ($statusKey === 'active' || $statusKey === 'accepted') {
                            $statusClass = 'bg-[#EAF4FC] text-[#346D96] border border-[#DFEBF5]';
                            $statusLabel = 'Aktif / Diterima';
                        } elseif ($statusKey === 'completed') {
                            $statusClass = 'bg-[#EDF7F0] text-[#15803D] border border-[#C6E7D0]';
                            $statusLabel = 'Selesai';
                        } elseif ($statusKey === 'cancelled') {
                            $statusClass = 'bg-[#FFF1F2] text-[#BE4560] border border-[#FFE4E6]';
                            $statusLabel = 'Dibatalkan';
                        }
                    @endphp

                    <!-- Status Pill (Header Right) -->
                    <div class="flex items-center gap-2.5">
                        <span class="text-xs text-[#718096] font-medium hidden sm:inline">Status Konsultasi:</span>
                        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold {{ $statusClass }} shadow-xs">
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>

                <!-- Page Header Title Area -->
                <div class="bg-white rounded-[24px] sm:rounded-[28px] border border-[#DFEBF5] p-5 sm:p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-[#DCECF8] border border-[#DFEBF5] flex items-center justify-center text-3xl shrink-0 shadow-xs">
                            {{ strtolower($consultation->child_gender ?? '') === 'l' ? '👦' : '👧' }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 rounded-full bg-[#EAF4FC] text-[#346D96] border border-[#DFEBF5] text-[11px] font-bold uppercase tracking-wider">
                                    ID: #{{ $consultation->id }}
                                </span>
                                <span class="text-xs text-[#718096]">
                                    {{ \Carbon\Carbon::parse($consultation->consultation_date)->locale('id')->translatedFormat('d M Y, H:i') }} WIB
                                </span>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-[#24323D]">
                                Konsultasi {{ $consultation->child_name }}
                            </h1>
                            <p class="text-xs sm:text-sm text-[#718096]">
                                Diajukan oleh <span class="font-semibold text-[#24323D]">{{ $consultation->parent_name }}</span> • {{ \Carbon\Carbon::parse($consultation->consultation_date)->locale('id')->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 self-start md:self-center">
                        <div class="px-4 py-2 rounded-2xl bg-[#F3F8FD] border border-[#DFEBF5] text-left">
                            <span class="text-[11px] text-[#718096] block font-medium">Usia Anak</span>
                            <span class="text-sm font-bold text-[#24323D]">{{ $consultation->child_age }}</span>
                        </div>
                        <div class="px-4 py-2 rounded-2xl bg-[#F3F8FD] border border-[#DFEBF5] text-left">
                            <span class="text-[11px] text-[#718096] block font-medium">Jenis Kelamin</span>
                            <span class="text-sm font-bold text-[#24323D]">
                                {{ $consultation->child_gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Two-Column Responsive Layout -->
                <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-start">
                    
                    <!-- LEFT COLUMN: Interactive Chat Area (2/3) -->
                    <div class="w-full lg:w-7/12 xl:w-2/3 flex flex-col bg-white rounded-[28px] sm:rounded-[32px] border border-[#DFEBF5] shadow-sm overflow-hidden h-[560px] lg:h-[calc(100vh-250px)] min-h-[500px]">
                        
                        <!-- Chat Header -->
                        <div class="p-4 sm:p-5 border-b border-[#DFEBF5] flex items-center justify-between bg-white z-10 shrink-0">
                            <div class="flex items-center gap-3 sm:gap-3.5">
                                <div class="w-11 h-11 bg-[#DCECF8] text-[#548FB7] border border-[#DFEBF5] rounded-full flex items-center justify-center font-bold text-base sm:text-lg shrink-0 shadow-xs">
                                    {{ substr($consultation->parent_name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <h2 class="font-bold text-sm sm:text-base text-[#24323D] truncate">
                                        {{ $consultation->parent_name }}
                                    </h2>
                                    <p class="text-xs text-[#718096] truncate">
                                        Orang tua dari {{ $consultation->child_name }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full {{ $statusKey === 'completed' ? 'bg-stone-300' : 'bg-[#548FB7]' }}"></span>
                                <span class="text-xs font-semibold text-[#718096] hidden sm:inline">
                                    {{ $statusKey === 'completed' ? 'Selesai' : 'Sesi Pesan' }}
                                </span>
                            </div>
                        </div>

                        <!-- Messages Stream -->
                        <div id="chatMessages" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4 sm:space-y-5 bg-[#F8FAFD]">
                            @foreach($messages as $msg)
                                @if($msg->sender_type === 'parent')
                                    <!-- Parent Message (Right aligned) -->
                                    <div class="flex flex-col items-end">
                                        <div class="flex items-end gap-2 max-w-[85%] sm:max-w-[80%]">
                                            <div class="bg-white text-[#24323D] border border-[#DFEBF5] px-4 sm:px-5 py-3 sm:py-3.5 rounded-2xl rounded-br-none shadow-xs text-xs sm:text-[15px] leading-relaxed">
                                                {{ $msg->message }}
                                            </div>
                                        </div>
                                        <span class="text-[11px] text-[#718096] mt-1.5 font-medium">
                                            {{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}
                                        </span>
                                    </div>
                                @else
                                    <!-- Doctor Message (Left aligned) -->
                                    <div class="flex flex-col items-start">
                                        <div class="flex items-end gap-2 max-w-[85%] sm:max-w-[80%]">
                                            <div class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center shrink-0 border border-[#DFEBF5] mb-1 text-[#548FB7]">
                                                <i data-lucide="stethoscope" class="w-4 h-4"></i>
                                            </div>
                                            <div class="bg-[#548FB7] text-white px-4 sm:px-5 py-3 sm:py-3.5 rounded-2xl rounded-bl-none shadow-xs text-xs sm:text-[15px] leading-relaxed">
                                                {{ $msg->message }}
                                            </div>
                                        </div>
                                        <span class="text-[11px] text-[#718096] mt-1.5 ml-10 font-medium">
                                            {{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}
                                        </span>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Message Input Form -->
                        <div class="p-3.5 sm:p-4 bg-white border-t border-[#DFEBF5] shrink-0">
                            <form id="chatForm" class="flex items-center gap-2 sm:gap-3" onsubmit="event.preventDefault(); sendMessage();">
                                <button type="button"
                                        aria-label="Lampiran"
                                        class="p-2.5 sm:p-3 text-[#718096] hover:text-[#548FB7] bg-[#F3F8FD] hover:bg-[#EAF4FC] rounded-xl sm:rounded-2xl border border-[#DFEBF5] transition-colors shrink-0">
                                    <i data-lucide="paperclip" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                                </button>
                                <input 
                                    type="text" 
                                    id="messageInput"
                                    placeholder="{{ $statusKey === 'completed' ? 'Konsultasi ini telah selesai' : 'Ketik respon atau saran untuk pasien...' }}" 
                                    class="flex-1 bg-[#F8FAFD] border border-[#DFEBF5] rounded-xl sm:rounded-2xl px-4 py-3 text-xs sm:text-sm focus:ring-2 focus:ring-[#548FB7]/20 focus:border-[#548FB7] focus:bg-white transition-all text-[#24323D] placeholder-[#718096]/70 outline-none disabled:bg-stone-50 disabled:cursor-not-allowed"
                                    {{ ($statusKey === 'completed' || $statusKey === 'cancelled') ? 'disabled' : '' }}
                                    autocomplete="off"
                                >
                                <button 
                                    type="submit" 
                                    aria-label="Kirim Pesan"
                                    class="p-2.5 sm:p-3 bg-[#548FB7] hover:bg-[#427DA6] text-white rounded-xl sm:rounded-2xl transition-all shadow-xs hover:shadow-sm disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center shrink-0"
                                    {{ ($statusKey === 'completed' || $statusKey === 'cancelled') ? 'disabled' : '' }}
                                >
                                    <i data-lucide="send" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Patient, Parent, & Clinical Info (1/3) -->
                    <div class="w-full lg:w-5/12 xl:w-1/3 space-y-5 sm:space-y-6">
                        
                        <!-- Profil Anak Card (TASK 4.3) -->
                        <div class="bg-white rounded-[24px] sm:rounded-[28px] border border-[#DFEBF5] p-5 sm:p-6 shadow-sm">
                            <h3 class="font-bold text-base sm:text-lg text-[#24323D] mb-4 flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
                                    <i data-lucide="user-round" class="w-4 h-4"></i>
                                </span>
                                <span>Profil Anak</span>
                            </h3>
                            
                            <div class="space-y-3.5 text-xs sm:text-sm">
                                <div class="flex justify-between items-center pb-3 border-b border-[#DFEBF5]">
                                    <span class="text-[#718096]">Nama Lengkap</span>
                                    <span class="font-bold text-[#24323D]">{{ $consultation->child_name }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-3 border-b border-[#DFEBF5]">
                                    <span class="text-[#718096]">Jenis Kelamin</span>
                                    <span class="font-semibold text-[#24323D]">
                                        {{ $consultation->child_gender === 'L' ? 'Laki-laki 👦' : 'Perempuan 👧' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center pb-3 border-b border-[#DFEBF5]">
                                    <span class="text-[#718096]">Usia</span>
                                    <span class="font-semibold text-[#24323D]">{{ $consultation->child_age }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[#718096]">Tanggal Lahir</span>
                                    <span class="font-semibold text-[#24323D]">
                                        {{ \Carbon\Carbon::parse($consultation->child_birth_date)->locale('id')->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Data Pertumbuhan Card (TASK 4.3) -->
                        <div class="bg-white rounded-[24px] sm:rounded-[28px] border border-[#DFEBF5] p-5 sm:p-6 shadow-sm">
                            <h3 class="font-bold text-base sm:text-lg text-[#24323D] mb-4 flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
                                    <i data-lucide="activity" class="w-4 h-4"></i>
                                </span>
                                <span>Data Pertumbuhan</span>
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-3.5">
                                <div class="bg-[#F3F8FD] rounded-2xl p-4 border border-[#DFEBF5] text-center shadow-2xs">
                                    <span class="text-xs text-[#718096] block mb-1 font-medium">Berat Badan</span>
                                    <span class="font-bold text-xl sm:text-2xl text-[#24323D]">
                                        {{ trim(str_ireplace('kg', '', $consultation->child_weight ?? '—')) }}
                                        <span class="text-xs sm:text-sm font-semibold text-[#718096]">kg</span>
                                    </span>
                                </div>
                                <div class="bg-[#F3F8FD] rounded-2xl p-4 border border-[#DFEBF5] text-center shadow-2xs">
                                    <span class="text-xs text-[#718096] block mb-1 font-medium">Tinggi Badan</span>
                                    <span class="font-bold text-xl sm:text-2xl text-[#24323D]">
                                        {{ trim(str_ireplace('cm', '', $consultation->child_height ?? '—')) }}
                                        <span class="text-xs sm:text-sm font-semibold text-[#718096]">cm</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Informasi Orang Tua (TASK 4.4) -->
                        <div class="bg-white rounded-[24px] sm:rounded-[28px] border border-[#DFEBF5] p-5 sm:p-6 shadow-sm">
                            <h3 class="font-bold text-base sm:text-lg text-[#24323D] mb-4 flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
                                    <i data-lucide="users" class="w-4 h-4"></i>
                                </span>
                                <span>Informasi Orang Tua</span>
                            </h3>
                            
                            <div class="flex items-center gap-3.5 p-3.5 rounded-2xl bg-[#F3F8FD] border border-[#DFEBF5]">
                                <div class="w-11 h-11 rounded-full bg-[#DCECF8] border border-[#DFEBF5] text-[#548FB7] font-bold flex items-center justify-center text-base shrink-0 shadow-xs">
                                    {{ substr($consultation->parent_name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-sm sm:text-base text-[#24323D] truncate">
                                        {{ $consultation->parent_name }}
                                    </h4>
                                    <p class="text-xs text-[#718096] truncate">
                                        Orang tua / Wali dari {{ $consultation->child_name }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Keluhan Utama (TASK 4.5 & TASK 4.9) -->
                        <div class="bg-white rounded-[24px] sm:rounded-[28px] border border-[#DFEBF5] p-5 sm:p-6 shadow-sm">
                            <h3 class="font-bold text-base sm:text-lg text-[#24323D] mb-3 flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </span>
                                <span>Keluhan Utama</span>
                            </h3>
                            
                            <div class="bg-[#F3F8FD] p-4 rounded-2xl border border-[#DFEBF5] mb-3">
                                <p class="text-xs sm:text-sm text-[#52758F] leading-relaxed">
                                    "{{ $consultation->complaint }}"
                                </p>
                            </div>

                            <div class="flex items-center gap-1.5 text-xs text-[#718096] px-1">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-[#548FB7]"></i>
                                <span>Diajukan {{ \Carbon\Carbon::parse($consultation->consultation_date)->locale('id')->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Card Catatan Dokter & Form Tindakan (TASK 4.7 & TASK 4.8) -->
                        <div class="bg-white rounded-[24px] sm:rounded-[28px] border border-[#DFEBF5] p-5 sm:p-6 shadow-sm">
                            <h3 class="font-bold text-base sm:text-lg text-[#24323D] mb-4 flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center text-[#548FB7]">
                                    <i data-lucide="stethoscope" class="w-4 h-4"></i>
                                </span>
                                <span>Catatan & Tindakan Dokter</span>
                            </h3>
                            
                            <form action="#" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="doctorNotes" class="block text-xs font-semibold text-[#718096] mb-1.5">
                                        Catatan Medis / Rekomendasi
                                    </label>
                                    <textarea 
                                        id="doctorNotes"
                                        name="doctor_notes" 
                                        rows="3" 
                                        class="w-full bg-[#F8FAFD] border border-[#DFEBF5] rounded-2xl p-3.5 text-xs sm:text-sm focus:ring-2 focus:ring-[#548FB7]/20 focus:border-[#548FB7] transition-all resize-none text-[#24323D] placeholder-[#718096]/70 outline-none" 
                                        placeholder="Tambahkan catatan medis atau anjuran untuk orang tua di sini..."
                                    >{{ $consultation->doctor_notes ?? '' }}</textarea>
                                </div>
                                
                                @if($statusKey === 'pending')
                                    <button type="submit"
                                            class="w-full bg-[#548FB7] hover:bg-[#427DA6] text-white font-bold py-3.5 px-4 rounded-xl sm:rounded-2xl transition-all shadow-xs hover:shadow-sm flex items-center justify-center gap-2 text-xs sm:text-sm">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        <span>Terima Konsultasi</span>
                                    </button>
                                @elseif($statusKey === 'active' || $statusKey === 'accepted')
                                    <div class="flex gap-3">
                                        <button type="submit"
                                                class="flex-1 bg-white border border-[#DFEBF5] text-[#294E69] hover:bg-[#F3F8FD] font-bold py-3 px-4 rounded-xl sm:rounded-2xl transition-all text-xs sm:text-sm shadow-xs">
                                            Simpan Catatan
                                        </button>
                                        <button type="button"
                                                class="flex-1 bg-[#15803D] hover:bg-[#166534] text-white font-bold py-3 px-4 rounded-xl sm:rounded-2xl transition-all shadow-xs hover:shadow-sm flex items-center justify-center gap-2 text-xs sm:text-sm">
                                            <i data-lucide="check-square" class="w-4 h-4"></i>
                                            <span>Selesai</span>
                                        </button>
                                    </div>
                                @elseif($statusKey === 'completed')
                                    <div class="p-3.5 rounded-2xl bg-[#EDF7F0] border border-[#C6E7D0] text-xs sm:text-sm text-[#15803D] font-semibold flex items-center gap-2">
                                        <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
                                        <span>Konsultasi ini telah diselesaikan.</span>
                                    </div>
                                @elseif($statusKey === 'cancelled')
                                    <div class="p-3.5 rounded-2xl bg-[#FFF1F2] border border-[#FFE4E6] text-xs sm:text-sm text-[#BE4560] font-semibold flex items-center gap-2">
                                        <i data-lucide="x-circle" class="w-4 h-4 shrink-0"></i>
                                        <span>Konsultasi ini telah dibatalkan.</span>
                                    </div>
                                @endif
                            </form>
                        </div>

                    </div>
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

        // Chat functionality
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const text = input.value.trim();
            if (!text) return;

            const now = new Date();
            const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

            // Doctor message with soft blue theme
            const msgHtml = `
                <div class="flex flex-col items-start animate-fade-in">
                    <div class="flex items-end gap-2 max-w-[85%] sm:max-w-[80%]">
                        <div class="w-8 h-8 rounded-full bg-[#DCECF8] flex items-center justify-center shrink-0 border border-[#DFEBF5] mb-1 text-[#548FB7]">
                            <i data-lucide="stethoscope" class="w-4 h-4"></i>
                        </div>
                        <div class="bg-[#548FB7] text-white px-4 sm:px-5 py-3 sm:py-3.5 rounded-2xl rounded-bl-none shadow-xs text-xs sm:text-[15px] leading-relaxed">
                            ${text}
                        </div>
                    </div>
                    <span class="text-[11px] text-[#718096] mt-1.5 ml-10 font-medium">${timeStr}</span>
                </div>
            `;

            chatMessages.insertAdjacentHTML('beforeend', msgHtml);
            lucide.createIcons();
            
            input.value = '';
            chatMessages.scrollTo({ top: chatMessages.scrollHeight, behavior: 'smooth' });
        }
    </script>
</body>
</html>
