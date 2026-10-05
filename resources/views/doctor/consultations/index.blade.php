<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Konsultasi - GrowCare Dokter</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8F7F2;
            color: #202725;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .tab-btn.active {
            background-color: #2563EB;
            color: white;
            border-color: #2563EB;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar (Desktop) -->
        <aside class="hidden md:flex flex-col w-[285px] bg-[#FBFAF6] border-r border-stone-200 shrink-0">
            <!-- Logo -->
            <div class="p-8">
                <a href="{{ route('dokter.dashboard') }}" class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <i data-lucide="stethoscope" class="w-8 h-8 text-blue-600"></i>
                        <span class="text-2xl font-bold tracking-tight">
                            <span class="text-blue-600">Grow</span>Care
                        </span>
                    </div>
                    <span class="text-xs font-bold text-stone-400 tracking-wider mt-1 ml-10">DOKTER</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 space-y-2 mt-4">
                <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 text-stone-500 hover:bg-stone-100 rounded-2xl transition-all font-medium">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('dokter.konsultasi') }}" class="flex items-center gap-3 px-4 py-3.5 bg-blue-50 text-blue-600 rounded-2xl transition-all font-medium shadow-sm border border-blue-100/50">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                    <span>Konsultasi</span>
                </a>
                
                <a href="{{ route('dokter.pasien') }}" class="flex items-center gap-3 px-4 py-3.5 text-stone-500 hover:bg-stone-100 rounded-2xl transition-all font-medium">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span>Pasien</span>
                </a>

                <a href="{{ route('dokter.profil') }}" class="flex items-center gap-3 px-4 py-3.5 text-stone-500 hover:bg-stone-100 rounded-2xl transition-all font-medium">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <span>Profil</span>
                </a>
            </nav>

            <!-- Bottom Action -->
            <div class="p-4 border-t border-stone-200">
                <form method="POST" action="{{ route('dokter.logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3.5 w-full text-red-500 hover:bg-red-50 rounded-2xl transition-all font-medium">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Mobile Header -->
            <div class="md:hidden flex items-center justify-between px-6 py-4 bg-white border-b border-stone-200">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <i data-lucide="stethoscope" class="w-6 h-6 text-blue-600"></i>
                        <span class="text-xl font-bold tracking-tight">
                            <span class="text-blue-600">Grow</span>Care
                        </span>
                    </div>
                    <span class="text-[10px] font-bold text-stone-400 tracking-wider ml-8">DOKTER</span>
                </div>
                <button class="p-2 text-stone-400 hover:text-stone-600 hover:bg-stone-100 rounded-full transition-colors">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                </button>
            </div>

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto p-6 md:p-10 pb-32 md:pb-10">
                <div class="max-w-5xl mx-auto space-y-8">
                    
                    <!-- Page Header -->
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-100 mb-4">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span class="text-xs font-semibold text-blue-700 tracking-wide">KONSULTASI</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold mb-2">Daftar Konsultasi</h1>
                        <p class="text-stone-500 text-sm md:text-base">Kelola semua permintaan dan riwayat konsultasi pasien Anda.</p>
                    </div>

                    @php
                        $total = $consultations->count();
                        $pending = $consultations->where('status', 'pending')->count();
                        $active = $consultations->where('status', 'accepted')->count();
                        $completed = $consultations->where('status', 'completed')->count();
                    @endphp

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-full bg-stone-100 flex items-center justify-center text-stone-500">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                                <span class="text-sm font-medium text-stone-500">Total</span>
                            </div>
                            <span class="text-2xl font-bold">{{ $total }}</span>
                        </div>
                        
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center text-amber-500">
                                    <i data-lucide="clock" class="w-4 h-4"></i>
                                </div>
                                <span class="text-sm font-medium text-stone-500">Pending</span>
                            </div>
                            <span class="text-2xl font-bold">{{ $pending }}</span>
                        </div>

                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                                </div>
                                <span class="text-sm font-medium text-stone-500">Aktif</span>
                            </div>
                            <span class="text-2xl font-bold">{{ $active }}</span>
                        </div>

                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-stone-100 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center text-green-500">
                                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                                </div>
                                <span class="text-sm font-medium text-stone-500">Selesai</span>
                            </div>
                            <span class="text-2xl font-bold">{{ $completed }}</span>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex items-center gap-2 overflow-x-auto hide-scrollbar pb-2">
                        <button onclick="filterStatus('all')" class="tab-btn active px-5 py-2.5 rounded-full text-sm font-medium border border-stone-200 bg-white text-stone-600 hover:bg-stone-50 transition-colors whitespace-nowrap" data-target="all">
                            Semua
                        </button>
                        <button onclick="filterStatus('pending')" class="tab-btn px-5 py-2.5 rounded-full text-sm font-medium border border-stone-200 bg-white text-stone-600 hover:bg-stone-50 transition-colors whitespace-nowrap" data-target="pending">
                            Pending
                        </button>
                        <button onclick="filterStatus('accepted')" class="tab-btn px-5 py-2.5 rounded-full text-sm font-medium border border-stone-200 bg-white text-stone-600 hover:bg-stone-50 transition-colors whitespace-nowrap" data-target="accepted">
                            Diterima / Aktif
                        </button>
                        <button onclick="filterStatus('completed')" class="tab-btn px-5 py-2.5 rounded-full text-sm font-medium border border-stone-200 bg-white text-stone-600 hover:bg-stone-50 transition-colors whitespace-nowrap" data-target="completed">
                            Selesai
                        </button>
                        <button onclick="filterStatus('cancelled')" class="tab-btn px-5 py-2.5 rounded-full text-sm font-medium border border-stone-200 bg-white text-stone-600 hover:bg-stone-50 transition-colors whitespace-nowrap" data-target="cancelled">
                            Dibatalkan
                        </button>
                    </div>

                    <!-- Consultation List -->
                    <div class="grid gap-4">
                        @forelse($consultations as $consultation)
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                    'accepted' => 'bg-blue-50 text-blue-600 border-blue-200',
                                    'completed' => 'bg-green-50 text-green-600 border-green-200',
                                    'cancelled' => 'bg-red-50 text-red-600 border-red-200',
                                ];
                                $statusLabels = [
                                    'pending' => 'Pending',
                                    'accepted' => 'Aktif',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ];
                                $colorClass = $statusColors[$consultation->status] ?? 'bg-stone-100 text-stone-600 border-stone-200';
                                $label = $statusLabels[$consultation->status] ?? ucfirst($consultation->status);
                                $emoji = strtolower($consultation->child_gender) === 'l' ? '👦' : '👧';
                            @endphp
                            
                            <div class="consultation-card bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-stone-100 hover:shadow-md transition-shadow group" data-status="{{ $consultation->status }}">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    
                                    <div class="flex items-start gap-4">
                                        <!-- Avatar / Emoji -->
                                        <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-2xl shrink-0 mt-1 md:mt-0">
                                            {{ $emoji }}
                                        </div>
                                        
                                        <!-- Info -->
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                                <h3 class="font-bold text-lg">{{ $consultation->child_name }}</h3>
                                                <span class="text-stone-400 text-sm">•</span>
                                                <span class="text-stone-500 text-sm">{{ $consultation->child_age }} tahun</span>
                                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $colorClass }} ml-2">
                                                    {{ $label }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-stone-500 mb-2">Orang tua: <span class="font-medium text-stone-700">{{ $consultation->parent_name }}</span></p>
                                            
                                            <!-- Complaint Snippet -->
                                            <div class="bg-[#F8F7F2] p-3 rounded-xl border border-stone-100">
                                                <p class="text-sm text-stone-600 line-clamp-2">"{{ $consultation->complaint }}"</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action -->
                                    <div class="flex flex-row md:flex-col items-center md:items-end justify-between mt-2 md:mt-0 gap-3 min-w-[120px]">
                                        <div class="text-xs text-stone-400 font-medium flex items-center gap-1.5">
                                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                            {{ \Carbon\Carbon::parse($consultation->consultation_date)->diffForHumans() }}
                                        </div>
                                        <a href="{{ route('dokter.konsultasi.detail', $consultation->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                                            Lihat Detail
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-3xl p-10 border border-stone-100 flex flex-col items-center justify-center text-center">
                                <div class="w-20 h-20 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                                    <i data-lucide="inbox" class="w-10 h-10 text-blue-300"></i>
                                </div>
                                <h3 class="text-xl font-bold mb-2">Belum ada konsultasi</h3>
                                <p class="text-stone-500 max-w-sm">Anda belum memiliki riwayat konsultasi saat ini.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </main>

        <!-- Mobile Bottom Nav -->
        <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-stone-200 z-50">
            <div class="flex items-center justify-around px-2 py-3">
                <a href="{{ route('dokter.dashboard') }}" class="flex flex-col items-center gap-1 p-2 text-stone-400">
                    <i data-lucide="layout-dashboard" class="w-6 h-6"></i>
                    <span class="text-[10px] font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('dokter.konsultasi') }}" class="flex flex-col items-center gap-1 p-2 text-blue-600">
                    <div class="relative">
                        <i data-lucide="message-square" class="w-6 h-6"></i>
                    </div>
                    <span class="text-[10px] font-medium">Konsultasi</span>
                </a>
                
                <a href="{{ route('dokter.pasien') }}" class="flex flex-col items-center gap-1 p-2 text-stone-400">
                    <i data-lucide="users" class="w-6 h-6"></i>
                    <span class="text-[10px] font-medium">Pasien</span>
                </a>
                
                <a href="{{ route('dokter.profil') }}" class="flex flex-col items-center gap-1 p-2 text-stone-400">
                    <i data-lucide="user" class="w-6 h-6"></i>
                    <span class="text-[10px] font-medium">Profil</span>
                </a>
            </div>
        </nav>
    </div>

    <script>
        lucide.createIcons();

        function filterStatus(status) {
            // Update active tab
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white', 'border-blue-600');
                btn.classList.add('bg-white', 'text-stone-600', 'border-stone-200');
                
                if(btn.dataset.target === status) {
                    btn.classList.remove('bg-white', 'text-stone-600', 'border-stone-200');
                    btn.classList.add('active', 'bg-blue-600', 'text-white', 'border-blue-600');
                }
            });

            // Filter cards
            const cards = document.querySelectorAll('.consultation-card');
            let hasVisibleCards = false;

            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                    hasVisibleCards = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // If you want to show an empty state when filter matches nothing, you can implement it here.
            // For simplicity, we just hide the cards.
        }
        
        // Initialize active state on 'Semua' tab
        document.addEventListener('DOMContentLoaded', () => {
            const allBtn = document.querySelector('[data-target="all"]');
            if (allBtn) {
                allBtn.classList.remove('bg-white', 'text-stone-600', 'border-stone-200');
                allBtn.classList.add('active', 'bg-blue-600', 'text-white', 'border-blue-600');
            }
        });
    </script>
</body>
</html>
