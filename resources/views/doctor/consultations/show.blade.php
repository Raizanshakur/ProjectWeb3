<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konsultasi - GrowCare Dokter</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
    </style>
</head>
<body class="bg-[#F8F7F2] text-[#202725]">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="hidden md:flex flex-col w-[285px] bg-[#FBFAF6] border-r border-stone-200 fixed h-full z-10">
            <div class="p-8">
                <a href="{{ route('dokter.dashboard') }}" class="flex flex-col">
                    <span class="text-2xl font-bold tracking-tight text-[#202725]">
                        <span class="text-blue-600">Grow</span>Care
                    </span>
                    <span class="text-xs font-semibold text-blue-600 tracking-widest mt-1">DOKTER</span>
                </a>
            </div>

            <nav class="flex-1 px-4 space-y-2 mt-4">
                <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 text-stone-600 rounded-2xl hover:bg-stone-50 transition-colors font-medium">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    Dashboard
                </a>
                <a href="{{ route('dokter.konsultasi') }}" class="flex items-center gap-3 px-4 py-3.5 bg-blue-50 text-blue-600 rounded-2xl font-medium">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                    Konsultasi
                </a>
                <a href="{{ route('dokter.pasien') }}" class="flex items-center gap-3 px-4 py-3.5 text-stone-600 rounded-2xl hover:bg-stone-50 transition-colors font-medium">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    Pasien
                </a>
                <a href="{{ route('dokter.profil') }}" class="flex items-center gap-3 px-4 py-3.5 text-stone-600 rounded-2xl hover:bg-stone-50 transition-colors font-medium">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    Profil
                </a>
            </nav>

            <div class="p-4 mb-4">
                <form action="{{ route('dokter.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3.5 text-red-600 rounded-2xl hover:bg-red-50 transition-colors font-medium w-full text-left">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-[285px] p-4 md:p-8">
            <!-- Mobile Header -->
            <div class="md:hidden flex items-center justify-between bg-white p-4 rounded-2xl shadow-sm mb-4">
                <a href="{{ route('dokter.dashboard') }}" class="flex flex-col">
                    <span class="text-xl font-bold tracking-tight text-[#202725]">
                        <span class="text-blue-600">Grow</span>Care
                    </span>
                    <span class="text-[10px] font-semibold text-blue-600 tracking-widest mt-0.5">DOKTER</span>
                </a>
                <button id="mobileMenuBtn" class="p-2 text-stone-600 bg-stone-100 rounded-xl">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Back Button -->
            <a href="{{ route('dokter.konsultasi') }}" class="inline-flex items-center gap-2 text-stone-500 hover:text-blue-600 transition-colors mb-6 font-medium">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Daftar Konsultasi
            </a>

            <!-- Two Columns -->
            <div class="flex flex-col lg:flex-row gap-6">
                
                <!-- LEFT COLUMN: Chat Area (2/3) -->
                <div class="lg:w-2/3 flex flex-col bg-white rounded-[30px] border border-stone-100 shadow-sm overflow-hidden h-[calc(100vh-140px)]">
                    
                    <!-- Chat Header -->
                    <div class="p-6 border-b border-stone-100 flex items-center justify-between bg-white z-10 shrink-0">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-lg">
                                {{ substr($consultation->parent_name, 0, 1) }}
                            </div>
                            <div>
                                <h2 class="font-bold text-lg text-[#202725]">{{ $consultation->parent_name }}</h2>
                                <p class="text-sm text-stone-500">Orang tua dari {{ $consultation->child_name }}</p>
                            </div>
                        </div>
                        <div>
                            @if($consultation->status === 'pending')
                                <span class="px-4 py-1.5 bg-amber-100 text-amber-700 rounded-full text-sm font-semibold border border-amber-200">Menunggu</span>
                            @elseif($consultation->status === 'active')
                                <span class="px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold border border-blue-200">Aktif</span>
                            @else
                                <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold border border-emerald-200">Selesai</span>
                            @endif
                        </div>
                    </div>

                    <!-- Messages Area -->
                    <div id="chatMessages" class="flex-1 overflow-y-auto p-6 space-y-6 bg-stone-50/50">
                        @foreach($messages as $msg)
                            @if($msg->sender_type === 'parent')
                                <!-- Parent Message (Right aligned, gray bg) -->
                                <div class="flex flex-col items-end">
                                    <div class="flex items-end gap-2 max-w-[80%]">
                                        <div class="bg-stone-200 text-[#202725] px-5 py-3.5 rounded-2xl rounded-br-none shadow-sm text-[15px] leading-relaxed">
                                            {{ $msg->message }}
                                        </div>
                                    </div>
                                    <span class="text-xs text-stone-400 mt-2 font-medium">{{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}</span>
                                </div>
                            @else
                                <!-- Doctor Message (Left aligned, blue bg) -->
                                <div class="flex flex-col items-start">
                                    <div class="flex items-end gap-2 max-w-[80%]">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0 border border-blue-200 mb-1">
                                            <i data-lucide="stethoscope" class="w-4 h-4 text-blue-600"></i>
                                        </div>
                                        <div class="bg-blue-600 text-white px-5 py-3.5 rounded-2xl rounded-bl-none shadow-sm text-[15px] leading-relaxed">
                                            {{ $msg->message }}
                                        </div>
                                    </div>
                                    <span class="text-xs text-stone-400 mt-2 ml-10 font-medium">{{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Message Input -->
                    <div class="p-5 bg-white border-t border-stone-100 shrink-0">
                        <form id="chatForm" class="flex items-center gap-3" onsubmit="event.preventDefault(); sendMessage();">
                            <button type="button" class="p-3 text-stone-400 hover:text-blue-600 transition-colors bg-stone-50 hover:bg-blue-50 rounded-xl">
                                <i data-lucide="paperclip" class="w-5 h-5"></i>
                            </button>
                            <input 
                                type="text" 
                                id="messageInput"
                                placeholder="Ketik pesan..." 
                                class="flex-1 bg-stone-50 border-none rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-blue-100 focus:bg-white transition-all text-[#202725] placeholder:text-stone-400 outline-none"
                                {{ $consultation->status === 'completed' ? 'disabled' : '' }}
                                autocomplete="off"
                            >
                            <button 
                                type="submit" 
                                class="p-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                                {{ $consultation->status === 'completed' ? 'disabled' : '' }}
                            >
                                <i data-lucide="send" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Patient Info (1/3) -->
                <div class="lg:w-1/3 space-y-6">
                    
                    <!-- Patient Profile Card -->
                    <div class="bg-white rounded-[28px] border border-stone-100 p-6 shadow-sm">
                        <h3 class="font-bold text-[#202725] mb-5 flex items-center gap-2">
                            <i data-lucide="user-circle" class="w-5 h-5 text-blue-500"></i>
                            Profil Anak
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-3 border-b border-stone-100">
                                <span class="text-stone-500 text-sm">Nama Lengkap</span>
                                <span class="font-semibold text-[#202725]">{{ $consultation->child_name }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-stone-100">
                                <span class="text-stone-500 text-sm">Jenis Kelamin</span>
                                <span class="font-semibold text-[#202725]">{{ $consultation->child_gender === 'L' ? 'Laki-laki 👦' : 'Perempuan 👧' }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-stone-100">
                                <span class="text-stone-500 text-sm">Usia</span>
                                <span class="font-semibold text-[#202725]">{{ $consultation->child_age }} Bulan</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-stone-500 text-sm">Tanggal Lahir</span>
                                <span class="font-semibold text-[#202725]">{{ \Carbon\Carbon::parse($consultation->child_birth_date)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Growth Data Card -->
                    <div class="bg-white rounded-[28px] border border-stone-100 p-6 shadow-sm">
                        <h3 class="font-bold text-[#202725] mb-5 flex items-center gap-2">
                            <i data-lucide="activity" class="w-5 h-5 text-blue-500"></i>
                            Data Pertumbuhan
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-stone-50 rounded-2xl p-4 border border-stone-100 text-center">
                                <span class="text-stone-500 text-xs block mb-1">Berat Badan</span>
                                <span class="font-bold text-xl text-[#202725]">{{ $consultation->child_weight }} <span class="text-sm font-medium text-stone-500">kg</span></span>
                            </div>
                            <div class="bg-stone-50 rounded-2xl p-4 border border-stone-100 text-center">
                                <span class="text-stone-500 text-xs block mb-1">Tinggi Badan</span>
                                <span class="font-bold text-xl text-[#202725]">{{ $consultation->child_height }} <span class="text-sm font-medium text-stone-500">cm</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Complaint Summary -->
                    <div class="bg-white rounded-[28px] border border-stone-100 p-6 shadow-sm">
                        <h3 class="font-bold text-[#202725] mb-3 flex items-center gap-2">
                            <i data-lucide="file-text" class="w-5 h-5 text-blue-500"></i>
                            Keluhan Utama
                        </h3>
                        <p class="text-stone-600 text-sm leading-relaxed bg-amber-50/50 p-4 rounded-2xl border border-amber-100">
                            {{ $consultation->complaint }}
                        </p>
                    </div>

                    <!-- Doctor Notes & Actions -->
                    <div class="bg-white rounded-[28px] border border-stone-100 p-6 shadow-sm">
                        <h3 class="font-bold text-[#202725] mb-4 flex items-center gap-2">
                            <i data-lucide="edit-3" class="w-5 h-5 text-blue-500"></i>
                            Catatan Dokter
                        </h3>
                        
                        <form action="#" method="POST" class="space-y-4">
                            @csrf
                            <textarea 
                                name="doctor_notes" 
                                rows="3" 
                                class="w-full bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition-all resize-none text-[#202725] outline-none" 
                                placeholder="Tambahkan catatan medis di sini..."
                            >{{ $consultation->doctor_notes ?? '' }}</textarea>
                            
                            @if($consultation->status === 'pending')
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                                    Terima Konsultasi
                                </button>
                            @elseif($consultation->status === 'active')
                                <div class="flex gap-3">
                                    <button type="submit" class="flex-1 bg-white border border-stone-200 text-[#202725] font-semibold py-3.5 rounded-xl hover:bg-stone-50 transition-colors">
                                        Simpan
                                    </button>
                                    <button type="button" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                                        <i data-lucide="check-square" class="w-5 h-5"></i>
                                        Selesai
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <!-- Mobile Navigation Overlay -->
    <div id="mobileNav" class="fixed inset-0 bg-[#202725]/50 z-40 hidden md:hidden opacity-0 transition-opacity duration-300">
        <div class="bg-[#FBFAF6] w-[280px] h-full transform -translate-x-full transition-transform duration-300 flex flex-col" id="mobileNavContent">
            <div class="p-6 flex justify-between items-center border-b border-stone-200">
                <a href="{{ route('dokter.dashboard') }}" class="flex flex-col">
                    <span class="text-xl font-bold tracking-tight text-[#202725]">
                        <span class="text-blue-600">Grow</span>Care
                    </span>
                    <span class="text-[10px] font-semibold text-blue-600 tracking-widest mt-0.5">DOKTER</span>
                </a>
                <button id="closeMobileNavBtn" class="p-2 text-stone-500 bg-stone-100 rounded-xl">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <nav class="flex-1 px-4 space-y-2 mt-6">
                <a href="{{ route('dokter.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 text-stone-600 rounded-2xl hover:bg-stone-50 font-medium">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    Dashboard
                </a>
                <a href="{{ route('dokter.konsultasi') }}" class="flex items-center gap-3 px-4 py-3.5 bg-blue-50 text-blue-600 rounded-2xl font-medium">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                    Konsultasi
                </a>
                <a href="{{ route('dokter.pasien') }}" class="flex items-center gap-3 px-4 py-3.5 text-stone-600 rounded-2xl hover:bg-stone-50 font-medium">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    Pasien
                </a>
                <a href="{{ route('dokter.profil') }}" class="flex items-center gap-3 px-4 py-3.5 text-stone-600 rounded-2xl hover:bg-stone-50 font-medium">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    Profil
                </a>
            </nav>

            <div class="p-4 mb-4">
                <form action="{{ route('dokter.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3.5 text-red-600 rounded-2xl hover:bg-red-50 font-medium w-full text-left">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeMobileNavBtn = document.getElementById('closeMobileNavBtn');
        const mobileNav = document.getElementById('mobileNav');
        const mobileNavContent = document.getElementById('mobileNavContent');

        function openMobileNav() {
            mobileNav.classList.remove('hidden');
            // Trigger reflow
            void mobileNav.offsetWidth;
            mobileNav.classList.remove('opacity-0');
            mobileNavContent.classList.remove('-translate-x-full');
        }

        function closeMobileNav() {
            mobileNav.classList.add('opacity-0');
            mobileNavContent.classList.add('-translate-x-full');
            setTimeout(() => {
                mobileNav.classList.add('hidden');
            }, 300);
        }

        mobileMenuBtn?.addEventListener('click', openMobileNav);
        closeMobileNavBtn?.addEventListener('click', closeMobileNav);
        mobileNav?.addEventListener('click', (e) => {
            if (e.target === mobileNav) closeMobileNav();
        });

        // Chat functionality demo
        const chatMessages = document.getElementById('chatMessages');
        
        // Scroll to bottom on load
        if(chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const text = input.value.trim();
            if (!text) return;

            const now = new Date();
            const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

            // Add doctor message (left aligned, blue bg)
            const msgHtml = \`
                <div class="flex flex-col items-start animate-fade-in">
                    <div class="flex items-end gap-2 max-w-[80%]">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0 border border-blue-200 mb-1">
                            <i data-lucide="stethoscope" class="w-4 h-4 text-blue-600"></i>
                        </div>
                        <div class="bg-blue-600 text-white px-5 py-3.5 rounded-2xl rounded-bl-none shadow-sm text-[15px] leading-relaxed">
                            \${text}
                        </div>
                    </div>
                    <span class="text-xs text-stone-400 mt-2 ml-10 font-medium">\${timeStr}</span>
                </div>
            \`;

            chatMessages.insertAdjacentHTML('beforeend', msgHtml);
            lucide.createIcons();
            
            input.value = '';
            chatMessages.scrollTo({ top: chatMessages.scrollHeight, behavior: 'smooth' });
        }
    </script>
</body>
</html>
