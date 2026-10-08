<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien - GrowCare Dokter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F7F2; }
    </style>
</head>
<body class="text-[#202725] min-h-screen flex flex-col md:flex-row">

    <!-- Mobile Header -->
    <div class="md:hidden bg-white border-b border-stone-200 px-6 py-4 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-blue-500 text-white flex items-center justify-center font-bold text-sm">
                GC
            </div>
            <div>
                <span class="font-bold text-xl text-blue-500 tracking-tight">Grow</span><span class="font-bold text-xl tracking-tight text-[#202725]">Care</span>
                <span class="text-[10px] font-bold text-blue-500 block -mt-1 tracking-wider">DOKTER</span>
            </div>
        </div>
        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
            <i data-lucide="user" class="w-4 h-4 text-blue-600"></i>
        </div>
    </div>

    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex flex-col w-[285px] bg-[#FBFAF6] border-r border-stone-100 h-screen sticky top-0 z-40 px-6 py-8">
        <div class="flex items-center gap-2 px-2 mb-12">
            <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center font-bold text-lg">
                GC
            </div>
            <div>
                <span class="font-bold text-2xl text-blue-500 tracking-tight">Grow</span><span class="font-bold text-2xl tracking-tight text-[#202725]">Care</span>
                <span class="text-xs font-bold text-blue-500 block -mt-1 tracking-wider">DOKTER</span>
            </div>
        </div>

        <nav class="flex-1 space-y-2">
            <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-stone-500 hover:bg-stone-50 hover:text-[#202725] transition-colors font-medium">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                Dashboard
            </a>
            <a href="{{ route('dokter.konsultasi') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-stone-500 hover:bg-stone-50 hover:text-[#202725] transition-colors font-medium">
                <i data-lucide="message-square" class="w-5 h-5"></i>
                Konsultasi
            </a>
            <a href="{{ route('dokter.pasien') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-blue-50 text-blue-600 font-semibold transition-colors">
                <i data-lucide="users" class="w-5 h-5"></i>
                Data Pasien
            </a>
            <a href="{{ route('dokter.profil') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-stone-500 hover:bg-stone-50 hover:text-[#202725] transition-colors font-medium">
                <i data-lucide="user" class="w-5 h-5"></i>
                Profil Saya
            </a>
        </nav>

        <div class="mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-red-500 hover:bg-red-50 transition-colors font-medium">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-10 pb-28 md:pb-10 max-w-[1200px] mx-auto w-full">
        <!-- Header -->
        <div class="mb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-100 mb-4">
                <i data-lucide="users" class="w-4 h-4 text-blue-600"></i>
                <span class="text-xs font-semibold text-blue-600 tracking-wide uppercase">DATA PASIEN</span>
            </div>
            <h1 class="text-3xl font-bold mb-2">Data Pasien Anak</h1>
            <p class="text-stone-500">Lihat data perkembangan pasien anak yang telah berkonsultasi.</p>
        </div>

        <!-- Search Bar -->
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-2 mb-8 flex items-center">
            <div class="pl-4 pr-2">
                <i data-lucide="search" class="w-5 h-5 text-stone-400"></i>
            </div>
            <input type="text" id="searchInput" placeholder="Cari nama pasien anak atau orang tua..." class="w-full bg-transparent border-none outline-none py-2 px-2 text-[#202725] placeholder:text-stone-400">
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-stone-100">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                    <i data-lucide="users" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div class="text-stone-500 text-sm mb-1 font-medium">Total Pasien</div>
                <div class="text-2xl font-bold">5 Anak</div>
            </div>
            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-stone-100">
                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center mb-4">
                    <i data-lucide="activity" class="w-5 h-5 text-emerald-600"></i>
                </div>
                <div class="text-stone-500 text-sm mb-1 font-medium">Aktif</div>
                <div class="text-2xl font-bold">5 Anak</div>
            </div>
            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-stone-100">
                <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center mb-4">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div class="text-stone-500 text-sm mb-1 font-medium">Perlu Perhatian</div>
                <div class="text-2xl font-bold">1 Anak</div>
            </div>
        </div>

        <!-- Patient Cards Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="patientsGrid">
            <!-- Patient 1 -->
            <div class="patient-card bg-white rounded-[28px] p-6 shadow-sm border border-stone-100 flex flex-col">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl border border-blue-100">
                            👦
                        </div>
                        <div>
                            <h3 class="font-bold text-lg patient-name">Ahmad</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 text-xs font-medium">Laki-laki</span>
                                <span class="text-sm text-stone-500 parent-name">Orang tua: Siti Nurhaliza</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold border border-emerald-100">
                        Tumbuh Optimal
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-6 p-4 bg-[#F8F7F2] rounded-2xl">
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Usia</div>
                        <div class="font-bold text-sm">14 Bulan</div>
                    </div>
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Berat</div>
                        <div class="font-bold text-sm">9.5 kg</div>
                    </div>
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Tinggi</div>
                        <div class="font-bold text-sm">76 cm</div>
                    </div>
                </div>

                <div class="mb-6 flex-1">
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-medium text-stone-600">Perkembangan (KMS)</span>
                        <span class="text-xs font-bold text-emerald-600">Aman</span>
                    </div>
                    <div class="w-full bg-stone-100 rounded-full h-2.5">
                        <div class="bg-emerald-500 h-2.5 rounded-full" style="width: 85%"></div>
                    </div>
                </div>

                <button class="w-full py-3.5 bg-blue-50 text-blue-600 font-semibold rounded-2xl hover:bg-blue-100 transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="line-chart" class="w-4 h-4"></i>
                    Lihat Perkembangan
                </button>
            </div>

            <!-- Patient 2 -->
            <div class="patient-card bg-white rounded-[28px] p-6 shadow-sm border border-stone-100 flex flex-col">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-pink-50 flex items-center justify-center text-2xl border border-pink-100">
                            👧
                        </div>
                        <div>
                            <h3 class="font-bold text-lg patient-name">Bella</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 text-xs font-medium">Perempuan</span>
                                <span class="text-sm text-stone-500 parent-name">Orang tua: Rina Wati</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold border border-emerald-100">
                        Tumbuh Optimal
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-6 p-4 bg-[#F8F7F2] rounded-2xl">
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Usia</div>
                        <div class="font-bold text-sm">8 Bulan</div>
                    </div>
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Berat</div>
                        <div class="font-bold text-sm">7.2 kg</div>
                    </div>
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Tinggi</div>
                        <div class="font-bold text-sm">68 cm</div>
                    </div>
                </div>

                <div class="mb-6 flex-1">
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-medium text-stone-600">Perkembangan (KMS)</span>
                        <span class="text-xs font-bold text-emerald-600">Aman</span>
                    </div>
                    <div class="w-full bg-stone-100 rounded-full h-2.5">
                        <div class="bg-emerald-500 h-2.5 rounded-full" style="width: 78%"></div>
                    </div>
                </div>

                <button class="w-full py-3.5 bg-blue-50 text-blue-600 font-semibold rounded-2xl hover:bg-blue-100 transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="line-chart" class="w-4 h-4"></i>
                    Lihat Perkembangan
                </button>
            </div>

            <!-- Patient 3 -->
            <div class="patient-card bg-white rounded-[28px] p-6 shadow-sm border border-stone-100 flex flex-col">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-pink-50 flex items-center justify-center text-2xl border border-pink-100">
                            👧
                        </div>
                        <div>
                            <h3 class="font-bold text-lg patient-name">Citra</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 text-xs font-medium">Perempuan</span>
                                <span class="text-sm text-stone-500 parent-name">Orang tua: Budi Santoso</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-xs font-semibold border border-amber-100">
                        Perlu Perhatian
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-6 p-4 bg-[#F8F7F2] rounded-2xl">
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Usia</div>
                        <div class="font-bold text-sm">24 Bulan</div>
                    </div>
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Berat</div>
                        <div class="font-bold text-sm text-amber-600">11 kg <i data-lucide="arrow-down" class="w-3 h-3 inline"></i></div>
                    </div>
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Tinggi</div>
                        <div class="font-bold text-sm">85 cm</div>
                    </div>
                </div>

                <div class="mb-6 flex-1">
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-medium text-stone-600">Perkembangan (KMS)</span>
                        <span class="text-xs font-bold text-amber-600">Kurang</span>
                    </div>
                    <div class="w-full bg-stone-100 rounded-full h-2.5">
                        <div class="bg-amber-500 h-2.5 rounded-full" style="width: 45%"></div>
                    </div>
                </div>

                <button class="w-full py-3.5 bg-blue-50 text-blue-600 font-semibold rounded-2xl hover:bg-blue-100 transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="line-chart" class="w-4 h-4"></i>
                    Lihat Perkembangan
                </button>
            </div>

            <!-- Patient 4 -->
            <div class="patient-card bg-white rounded-[28px] p-6 shadow-sm border border-stone-100 flex flex-col">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl border border-blue-100">
                            👦
                        </div>
                        <div>
                            <h3 class="font-bold text-lg patient-name">Dimas</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 text-xs font-medium">Laki-laki</span>
                                <span class="text-sm text-stone-500 parent-name">Orang tua: Dewi Lestari</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold border border-emerald-100">
                        Tumbuh Optimal
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-6 p-4 bg-[#F8F7F2] rounded-2xl">
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Usia</div>
                        <div class="font-bold text-sm">18 Bulan</div>
                    </div>
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Berat</div>
                        <div class="font-bold text-sm">10.1 kg</div>
                    </div>
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Tinggi</div>
                        <div class="font-bold text-sm">80 cm</div>
                    </div>
                </div>

                <div class="mb-6 flex-1">
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-medium text-stone-600">Perkembangan (KMS)</span>
                        <span class="text-xs font-bold text-emerald-600">Aman</span>
                    </div>
                    <div class="w-full bg-stone-100 rounded-full h-2.5">
                        <div class="bg-emerald-500 h-2.5 rounded-full" style="width: 82%"></div>
                    </div>
                </div>

                <button class="w-full py-3.5 bg-blue-50 text-blue-600 font-semibold rounded-2xl hover:bg-blue-100 transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="line-chart" class="w-4 h-4"></i>
                    Lihat Perkembangan
                </button>
            </div>

            <!-- Patient 5 -->
            <div class="patient-card bg-white rounded-[28px] p-6 shadow-sm border border-stone-100 flex flex-col">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-pink-50 flex items-center justify-center text-2xl border border-pink-100">
                            👧
                        </div>
                        <div>
                            <h3 class="font-bold text-lg patient-name">Farah</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 text-xs font-medium">Perempuan</span>
                                <span class="text-sm text-stone-500 parent-name">Orang tua: Eka Putri</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold border border-emerald-100">
                        Tumbuh Optimal
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-6 p-4 bg-[#F8F7F2] rounded-2xl">
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Usia</div>
                        <div class="font-bold text-sm">10 Bulan</div>
                    </div>
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Berat</div>
                        <div class="font-bold text-sm">8.0 kg</div>
                    </div>
                    <div>
                        <div class="text-stone-500 text-xs mb-1">Tinggi</div>
                        <div class="font-bold text-sm">72 cm</div>
                    </div>
                </div>

                <div class="mb-6 flex-1">
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-medium text-stone-600">Perkembangan (KMS)</span>
                        <span class="text-xs font-bold text-emerald-600">Aman</span>
                    </div>
                    <div class="w-full bg-stone-100 rounded-full h-2.5">
                        <div class="bg-emerald-500 h-2.5 rounded-full" style="width: 88%"></div>
                    </div>
                </div>

                <button class="w-full py-3.5 bg-blue-50 text-blue-600 font-semibold rounded-2xl hover:bg-blue-100 transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="line-chart" class="w-4 h-4"></i>
                    Lihat Perkembangan
                </button>
            </div>
        </div>

        <!-- Empty State (Hidden by default) -->
        <div id="emptyState" class="hidden text-center py-12">
            <div class="w-16 h-16 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="users" class="w-8 h-8 text-stone-400"></i>
            </div>
            <h3 class="text-lg font-bold mb-1">Tidak ada pasien ditemukan</h3>
            <p class="text-stone-500 text-sm">Coba sesuaikan kata kunci pencarian Anda.</p>
        </div>

    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 w-full bg-white border-t border-stone-200 px-6 py-4 z-50 flex justify-between items-center pb-safe">
        <a href="{{ route('dokter.dashboard') }}" class="flex flex-col items-center gap-1 text-stone-400">
            <i data-lucide="layout-dashboard" class="w-6 h-6"></i>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a href="{{ route('dokter.konsultasi') }}" class="flex flex-col items-center gap-1 text-stone-400">
            <i data-lucide="message-square" class="w-6 h-6"></i>
            <span class="text-[10px] font-medium">Chat</span>
        </a>
        <a href="{{ route('dokter.pasien') }}" class="flex flex-col items-center gap-1 text-blue-600">
            <div class="relative">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-medium">Pasien</span>
        </a>
        <a href="{{ route('dokter.profil') }}" class="flex flex-col items-center gap-1 text-stone-400">
            <i data-lucide="user" class="w-6 h-6"></i>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
    </nav>

    <script>
        lucide.createIcons();

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.patient-card');
            let hasVisibleCards = false;

            cards.forEach(card => {
                const childName = card.querySelector('.patient-name').textContent.toLowerCase();
                const parentName = card.querySelector('.parent-name').textContent.toLowerCase();
                
                if (childName.includes(searchTerm) || parentName.includes(searchTerm)) {
                    card.style.display = 'flex';
                    hasVisibleCards = true;
                } else {
                    card.style.display = 'none';
                }
            });

            const emptyState = document.getElementById('emptyState');
            if (hasVisibleCards) {
                emptyState.classList.add('hidden');
            } else {
                emptyState.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>
