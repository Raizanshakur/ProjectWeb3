@php
    $activeMenu = $active ?? '';
@endphp

<aside class="hidden lg:flex fixed left-0 top-0 h-screen
              w-[285px] bg-[#FBFAF6]
              border-r border-stone-200
              flex-col z-40">

    {{-- LOGO --}}
    <div class="h-28 flex items-center px-9">

        <a href="{{ route('dashboard') }}"
           class="flex items-center">

            <div class="w-10 h-10 rounded-full
                        bg-[#E0F0EB] text-[#438F83]
                        flex items-center justify-center">

                <i data-lucide="sprout"
                   class="w-5 h-5"></i>

            </div>

            <div class="ml-3 text-2xl font-bold">
                <span class="text-[#438F83]">Grow</span>Care
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

            {{-- BERANDA --}}
            <a href="{{ route('dashboard') }}"
               class="relative flex items-center gap-4
                      px-4 py-4 rounded-2xl transition
                      {{ $activeMenu === 'dashboard'
                            ? 'bg-[#DCEFEB] text-[#438F83] font-semibold'
                            : 'text-gray-600 hover:bg-white' }}">

                @if($activeMenu === 'dashboard')
                    <span class="absolute left-0
                                 w-1 h-9
                                 bg-[#4DA397]
                                 rounded-r-full">
                    </span>
                @endif

                <span class="w-10 h-10 rounded-full
                             flex items-center justify-center
                             {{ $activeMenu === 'dashboard'
                                ? 'bg-[#4B988D] text-white'
                                : 'bg-white' }}">

                    <i data-lucide="house"
                       class="w-5 h-5"></i>

                </span>

                Beranda

            </a>


            {{-- NUTRISI --}}
            <a href="{{ route('nutrition') }}"
               class="relative flex items-center gap-4
                      px-4 py-4 rounded-2xl transition
                      {{ $activeMenu === 'nutrition'
                            ? 'bg-[#DCEFEB] text-[#438F83] font-semibold'
                            : 'text-gray-600 hover:bg-white' }}">

                @if($activeMenu === 'nutrition')
                    <span class="absolute left-0
                                 w-1 h-9
                                 bg-[#4DA397]
                                 rounded-r-full">
                    </span>
                @endif

                <span class="w-10 h-10 rounded-full
                             flex items-center justify-center
                             {{ $activeMenu === 'nutrition'
                                ? 'bg-[#4B988D] text-white'
                                : 'bg-white' }}">

                    <i data-lucide="clipboard-list"
                       class="w-5 h-5"></i>

                </span>

                Nutrisi

            </a>


            {{-- AI FOOD SCAN --}}
            <a href="{{ route('food.scan') }}"
               class="relative flex items-center gap-4
                      px-4 py-4 rounded-2xl transition
                      {{ $activeMenu === 'food-scan'
                            ? 'bg-[#DCEFEB] text-[#438F83] font-semibold'
                            : 'text-gray-600 hover:bg-white' }}">

                @if($activeMenu === 'food-scan')
                    <span class="absolute left-0
                                 w-1 h-9
                                 bg-[#4DA397]
                                 rounded-r-full">
                    </span>
                @endif

                <span class="w-10 h-10 rounded-full
                             flex items-center justify-center
                             {{ $activeMenu === 'food-scan'
                                ? 'bg-[#4B988D] text-white'
                                : 'bg-white' }}">

                    <i data-lucide="scan-line"
                       class="w-5 h-5"></i>

                </span>

                AI Food Scan

            </a>


            {{-- TANYA AI --}}
            <a href="{{ route('ai.chat') }}"
               class="relative flex items-center gap-4
                      px-4 py-4 rounded-2xl transition
                      {{ $activeMenu === 'ai'
                            ? 'bg-[#DCEFEB] text-[#438F83] font-semibold'
                            : 'text-gray-600 hover:bg-white' }}">

                @if($activeMenu === 'ai')
                    <span class="absolute left-0
                                 w-1 h-9
                                 bg-[#4DA397]
                                 rounded-r-full">
                    </span>
                @endif

                <span class="w-10 h-10 rounded-full
                             flex items-center justify-center
                             {{ $activeMenu === 'ai'
                                ? 'bg-[#4B988D] text-white'
                                : 'bg-white' }}">

                    <i data-lucide="message-circle"
                       class="w-5 h-5"></i>

                </span>

                Tanya AI

            </a>


            {{-- DATA ANAK --}}
            <a href="{{ route('children.index') }}"
               class="relative flex items-center gap-4
                      px-4 py-4 rounded-2xl transition
                      {{ $activeMenu === 'children'
                            ? 'bg-[#DCEFEB] text-[#438F83] font-semibold'
                            : 'text-gray-600 hover:bg-white' }}">

                @if($activeMenu === 'children')
                    <span class="absolute left-0
                                 w-1 h-9
                                 bg-[#4DA397]
                                 rounded-r-full">
                    </span>
                @endif

                <span class="w-10 h-10 rounded-full
                             flex items-center justify-center
                             {{ $activeMenu === 'children'
                                ? 'bg-[#4B988D] text-white'
                                : 'bg-white' }}">

                    <i data-lucide="baby"
                       class="w-5 h-5"></i>

                </span>

                Data Anak

            </a>


            {{-- PROFIL --}}
            <a href="{{ route('profile.edit') }}"
               class="relative flex items-center gap-4
                      px-4 py-4 rounded-2xl transition
                      {{ $activeMenu === 'profile'
                            ? 'bg-[#DCEFEB] text-[#438F83] font-semibold'
                            : 'text-gray-600 hover:bg-white' }}">

                @if($activeMenu === 'profile')
                    <span class="absolute left-0
                                 w-1 h-9
                                 bg-[#4DA397]
                                 rounded-r-full">
                    </span>
                @endif

                <span class="w-10 h-10 rounded-full
                             flex items-center justify-center
                             {{ $activeMenu === 'profile'
                                ? 'bg-[#4B988D] text-white'
                                : 'bg-white' }}">

                    <i data-lucide="user-round"
                       class="w-5 h-5"></i>

                </span>

                Profil

            </a>

        </nav>

    </div>


    {{-- USER BOTTOM --}}
    <div class="mt-auto p-6">

        <div class="flex items-center gap-3
                    p-3 rounded-2xl bg-white">

            <div class="w-11 h-11 rounded-full
                        bg-[#D9F0ED]
                        flex items-center justify-center
                        font-bold text-[#438F83]">

                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

            </div>


            <div class="min-w-0 flex-1">

                <p class="font-semibold truncate">
                    {{ Auth::user()->name }}
                </p>

                <p class="text-xs text-gray-400">
                    Orang Tua Aktif
                </p>

            </div>


            <form method="POST"
                  action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                        title="Logout"
                        class="w-10 h-10 rounded-xl
                               bg-red-50 text-red-400
                               flex items-center justify-center
                               hover:bg-red-100 transition">

                    <i data-lucide="log-out"
                       class="w-5 h-5"></i>

                </button>

            </form>

        </div>

    </div>

</aside>