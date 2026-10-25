@props(['active' => null])

@php
    $rawActive = $active ?? match(true) {
        request()->routeIs('dokter.dashboard') => 'dashboard',
        request()->routeIs('dokter.konsultasi*') => 'consultations',
        request()->routeIs('dokter.pasien*') => 'patients',
        request()->routeIs('dokter.profil*') => 'profile',
        default => '',
    };

    $activeMenu = match($rawActive) {
        'dashboard', 'beranda' => 'dashboard',
        'consultations', 'konsultasi' => 'consultations',
        'patients', 'pasien', 'data-pasien' => 'patients',
        'profile', 'profil', 'profil-saya' => 'profile',
        default => $rawActive,
    };

    $user = Auth::user();
    $doctorProfile = $user?->doctor;
    $doctorName = $doctorProfile?->name ?? $user?->name ?? 'Dokter';
    $doctorSpecialization = $doctorProfile?->specialization ?? 'Dokter Spesialis Anak';
    $doctorPhoto = $doctorProfile?->photo;
@endphp

<aside class="hidden lg:flex fixed left-0 top-0 h-screen
              w-[285px] bg-[#FBFAF6]
              border-r border-[#DFEBF5]
              flex-col z-40 text-[#24323D]">

    {{-- LOGO --}}
    <div class="h-28 flex items-center px-9">
        <a href="{{ route('dokter.dashboard') }}" class="flex items-center">
            <div class="w-10 h-10 rounded-full
                        bg-[#DCECF8] text-[#548FB7]
                        flex items-center justify-center flex-shrink-0">
                <i data-lucide="sprout" class="w-5 h-5"></i>
            </div>
            <div class="ml-3">
                <div class="text-2xl font-bold tracking-tight text-[#24323D] leading-none">
                    <span class="text-[#548FB7]">Grow</span>Care
                </div>
                <span class="text-[10px] font-bold text-[#548FB7] tracking-wider uppercase block mt-1">DOKTER</span>
            </div>
        </a>
    </div>

    {{-- MENU --}}
    <div class="px-5">
        <p class="px-4 mb-4 text-xs
                  tracking-[0.2em]
                  text-gray-400 font-semibold">
            MENU
        </p>

        <nav class="space-y-2">
            {{-- DASHBOARD --}}
            <a href="{{ route('dokter.dashboard') }}"
               class="relative flex items-center gap-4
                      px-4 py-4 rounded-2xl transition
                      {{ $activeMenu === 'dashboard'
                            ? 'bg-[#E4F1FA] text-[#346D96] font-semibold'
                            : 'text-gray-600 hover:bg-white' }}">

                @if($activeMenu === 'dashboard')
                    <span class="absolute left-0
                                 w-1 h-9
                                 bg-[#548FB7]
                                 rounded-r-full">
                    </span>
                @endif

                <span class="w-10 h-10 rounded-full
                             flex items-center justify-center
                             {{ $activeMenu === 'dashboard'
                                ? 'bg-[#548FB7] text-white'
                                : 'bg-white text-gray-500' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                </span>

                Dashboard
            </a>

            {{-- KONSULTASI --}}
            <a href="{{ route('dokter.konsultasi') }}"
               class="relative flex items-center gap-4
                      px-4 py-4 rounded-2xl transition
                      {{ $activeMenu === 'consultations'
                            ? 'bg-[#E4F1FA] text-[#346D96] font-semibold'
                            : 'text-gray-600 hover:bg-white' }}">

                @if($activeMenu === 'consultations')
                    <span class="absolute left-0
                                 w-1 h-9
                                 bg-[#548FB7]
                                 rounded-r-full">
                    </span>
                @endif

                <span class="w-10 h-10 rounded-full
                             flex items-center justify-center
                             {{ $activeMenu === 'consultations'
                                ? 'bg-[#548FB7] text-white'
                                : 'bg-white text-gray-500' }}">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                </span>

                Konsultasi
            </a>

            {{-- DATA PASIEN --}}
            <a href="{{ route('dokter.pasien') }}"
               class="relative flex items-center gap-4
                      px-4 py-4 rounded-2xl transition
                      {{ $activeMenu === 'patients'
                            ? 'bg-[#E4F1FA] text-[#346D96] font-semibold'
                            : 'text-gray-600 hover:bg-white' }}">

                @if($activeMenu === 'patients')
                    <span class="absolute left-0
                                 w-1 h-9
                                 bg-[#548FB7]
                                 rounded-r-full">
                    </span>
                @endif

                <span class="w-10 h-10 rounded-full
                             flex items-center justify-center
                             {{ $activeMenu === 'patients'
                                ? 'bg-[#548FB7] text-white'
                                : 'bg-white text-gray-500' }}">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </span>

                Data Pasien
            </a>

            {{-- PROFIL SAYA --}}
            <a href="{{ route('dokter.profil') }}"
               class="relative flex items-center gap-4
                      px-4 py-4 rounded-2xl transition
                      {{ $activeMenu === 'profile'
                            ? 'bg-[#E4F1FA] text-[#346D96] font-semibold'
                            : 'text-gray-600 hover:bg-white' }}">

                @if($activeMenu === 'profile')
                    <span class="absolute left-0
                                 w-1 h-9
                                 bg-[#548FB7]
                                 rounded-r-full">
                    </span>
                @endif

                <span class="w-10 h-10 rounded-full
                             flex items-center justify-center
                             {{ $activeMenu === 'profile'
                                ? 'bg-[#548FB7] text-white'
                                : 'bg-white text-gray-500' }}">
                    <i data-lucide="user-round" class="w-5 h-5"></i>
                </span>

                Profil Saya
            </a>
        </nav>
    </div>

    {{-- USER BOTTOM --}}
    <div class="mt-auto p-6">
        <div class="flex items-center gap-3
                    p-3 rounded-2xl bg-white border border-[#DFEBF5]">

            <div class="w-11 h-11 rounded-full
                        bg-[#DCECF8]
                        flex items-center justify-center
                        font-bold text-[#548FB7] overflow-hidden flex-shrink-0">
                @if($doctorPhoto)
                    <img src="{{ asset('storage/' . $doctorPhoto) }}" alt="{{ $doctorName }}" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr($doctorName, 0, 1)) }}
                @endif
            </div>

            <div class="min-w-0 flex-1">
                <p class="font-semibold text-sm text-[#24323D] truncate" title="{{ $doctorName }}">
                    {{ $doctorName }}
                </p>
                <p class="text-xs text-gray-400 truncate" title="{{ $doctorSpecialization }}">
                    {{ $doctorSpecialization }}
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        title="Keluar"
                        class="w-10 h-10 rounded-xl
                               bg-red-50 text-red-400
                               flex items-center justify-center
                               hover:bg-red-100 transition">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
