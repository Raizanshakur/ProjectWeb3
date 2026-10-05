<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dokter - GrowCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-[#F8F7F2] text-[#202725] antialiased min-h-screen flex">

    <!-- Left Side: Branding (Hidden on mobile) -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#1E40AF] via-[#2563EB] to-[#3B82F6] flex-col justify-between p-12 relative overflow-hidden">
        <!-- Abstract Circles Background -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[70%] h-[70%] rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute -bottom-[20%] -right-[10%] w-[60%] h-[60%] rounded-full bg-blue-400/20 blur-3xl"></div>
        </div>

        <div class="relative z-10">
            <a href="/" class="flex items-center gap-2 mb-12">
                <div class="bg-white p-2 rounded-xl shadow-sm">
                    <i data-lucide="activity" class="w-6 h-6 text-blue-600"></i>
                </div>
                <span class="text-2xl font-bold text-white tracking-tight">Grow<span class="text-blue-100">Care</span></span>
            </a>
            
            <div class="space-y-6">
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-900/30 border border-blue-400/30 backdrop-blur-sm">
                    <span class="text-sm font-medium text-blue-50 tracking-wider">PORTAL DOKTER</span>
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-white leading-tight">
                    Dedikasi untuk <br>Tumbuh Kembang <br>Anak Indonesia.
                </h1>
                <p class="text-blue-100 text-lg max-w-md leading-relaxed mt-4">
                    Pantau kesehatan pasien, kelola jadwal konsultasi, dan berikan panduan medis terbaik dalam satu platform terpadu.
                </p>
            </div>
        </div>
        
        <div class="relative z-10 flex items-center gap-4 text-blue-100/80 text-sm">
            <span>&copy; {{ date('Y') }} GrowCare. All rights reserved.</span>
            <span class="w-1 h-1 rounded-full bg-blue-400/50"></span>
            <a href="#" class="hover:text-white transition-colors">Bantuan</a>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-md space-y-8">
            <!-- Mobile Header Logo -->
            <div class="lg:hidden flex items-center justify-center mb-8">
                <a href="/" class="flex items-center gap-2">
                    <div class="bg-blue-600 p-2 rounded-xl shadow-md">
                        <i data-lucide="activity" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-2xl font-bold text-[#202725] tracking-tight">Grow<span class="text-blue-600">Care</span></span>
                </a>
            </div>

            <div class="text-center lg:text-left space-y-2">
                <div class="inline-block lg:hidden mb-2 px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full tracking-wide">DOKTER</div>
                <h2 class="text-3xl font-bold text-[#202725] tracking-tight">Selamat Datang, Dokter</h2>
                <p class="text-stone-500">Masuk ke dashboard untuk mengelola konsultasi anak.</p>
            </div>

            <div class="bg-white p-8 rounded-[30px] shadow-sm border border-stone-100 mt-8">
                <form action="{{ route('dokter.login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-stone-700">Email Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="mail" class="w-5 h-5 text-stone-400 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <input type="email" name="email" id="email" required
                                class="w-full pl-11 pr-4 py-3 bg-[#F8F7F2] border border-stone-200 rounded-2xl text-stone-700 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                placeholder="dokter@growcare.id">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label for="password" class="block text-sm font-medium text-stone-700">Password</label>
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">Lupa Password?</a>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="lock" class="w-5 h-5 text-stone-400 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                class="w-full pl-11 pr-4 py-3 bg-[#F8F7F2] border border-stone-200 rounded-2xl text-stone-700 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-stone-300 rounded text-blue-500">
                        <label for="remember" class="ml-2 block text-sm text-stone-600">
                            Ingat Saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-medium rounded-2xl shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-200 flex items-center justify-center gap-2">
                        <span>Masuk ke Dashboard</span>
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>

            <!-- Back Link -->
            <div class="text-center mt-8">
                <a href="/" class="inline-flex items-center gap-2 text-sm font-medium text-stone-500 hover:text-blue-600 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
