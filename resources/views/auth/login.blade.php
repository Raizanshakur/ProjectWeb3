<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - GrowCare</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="m-0 bg-white">

<div class="min-h-screen flex">

    {{-- BAGIAN KIRI --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">

        <img
            src="{{ asset('images/login-doctor.png') }}"
            alt="Dokter bersama anak"
            class="absolute inset-0 w-full h-full object-cover"
        >

        {{-- Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t
                    from-emerald-950/80
                    via-emerald-950/20
                    to-black/10">
        </div>

        {{-- Logo --}}
        <div class="absolute top-12 left-14 flex items-center gap-3 text-white">

            <div class="w-11 h-11 rounded-full bg-white/20
                        backdrop-blur-md border border-white/30
                        flex items-center justify-center">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-6 h-6"
                >
                    <path d="M12 22c4-2 7-6 7-11V5l-7-3-7 3v6c0 5 3 9 7 11Z"/>
                    <path d="M9 12l2 2 4-4"/>
                </svg>

            </div>

            <span class="text-2xl font-bold">
                GrowCare
            </span>

        </div>

        {{-- Tulisan bawah --}}
        <div class="absolute bottom-16 left-14 right-14 text-white">

            <h1 class="text-4xl xl:text-5xl font-semibold leading-tight max-w-xl">
                Kami siap mendampingi
                tumbuh kembang si kecil
            </h1>

            <div class="flex items-center gap-3 mt-6">

                <div class="w-1 h-7 bg-emerald-300 rounded-full"></div>

                <p class="text-white/90 text-lg">
                    Pantau pertumbuhan dan nutrisi anak bersama GrowCare.
                </p>

            </div>

        </div>

    </div>


    {{-- BAGIAN KANAN --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center
                px-6 sm:px-10 lg:px-16 bg-white">

        <div class="w-full max-w-md">

            {{-- Logo mobile --}}
            <div class="lg:hidden flex items-center gap-3 mb-10">

                <div class="w-10 h-10 rounded-full bg-emerald-100
                            text-emerald-600 flex items-center justify-center">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        class="w-5 h-5"
                    >
                        <path d="M12 22c4-2 7-6 7-11V5l-7-3-7 3v6c0 5 3 9 7 11Z"/>
                        <path d="M9 12l2 2 4-4"/>
                    </svg>

                </div>

                <span class="text-2xl font-bold text-gray-800">
                    Grow<span class="text-emerald-600">Care</span>
                </span>

            </div>


            {{-- Heading --}}
            <div class="mb-9">

                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                    Selamat Datang Kembali
                </h2>

                <p class="text-gray-500 mt-2">
                    Masuk ke akun
                    <span class="text-emerald-600 font-semibold">
                        GrowCare
                    </span>
                    Anda
                </p>

            </div>


            {{-- Session Status --}}
            @if (session('status'))

                <div class="mb-5 p-4 rounded-xl
                            bg-emerald-50 text-emerald-700 text-sm">
                    {{ session('status') }}
                </div>

            @endif


            {{-- Error --}}
            @if ($errors->any())

                <div class="mb-5 p-4 rounded-xl
                            bg-red-50 text-red-600 text-sm">

                    {{ $errors->first() }}

                </div>

            @endif


            {{-- FORM --}}
            <form method="POST" action="{{ route('login') }}">

                @csrf


                {{-- Email --}}
                <div class="mb-6">

                    <label
                        for="email"
                        class="block text-gray-800 font-medium mb-2"
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="contoh@email.com"

                        class="w-full px-6 py-4
                               rounded-2xl
                               border border-stone-200
                               bg-[#FCFAF7]
                               text-gray-800
                               placeholder:text-gray-400
                               focus:border-emerald-500
                               focus:ring-2
                               focus:ring-emerald-100
                               transition"
                    >

                </div>


                {{-- Password --}}
                <div class="mb-3">

                    <label
                        for="password"
                        class="block text-gray-800 font-medium mb-2"
                    >
                        Password
                    </label>

                    <div class="relative">

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Minimal 8 karakter"

                            class="w-full px-6 py-4 pr-14
                                   rounded-2xl
                                   border border-stone-200
                                   bg-[#FCFAF7]
                                   text-gray-800
                                   placeholder:text-gray-400
                                   focus:border-emerald-500
                                   focus:ring-2
                                   focus:ring-emerald-100
                                   transition"
                        >

                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-5 top-1/2
                                   -translate-y-1/2
                                   text-gray-400
                                   hover:text-emerald-600"
                        >

                            <svg
                                id="eyeIcon"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="w-5 h-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 12s3.75-6.75
                                       9.75-6.75S21.75 12
                                       21.75 12 18 18.75
                                       12 18.75 2.25 12
                                       2.25 12Z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0
                                       3 3 0 0 1 6 0Z"
                                />
                            </svg>

                        </button>

                    </div>

                </div>


                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between mb-7">

                    <label class="flex items-center gap-2 text-sm text-gray-500">

                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300
                                   text-emerald-600
                                   focus:ring-emerald-500"
                        >

                        Ingat saya

                    </label>


                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm font-medium
                                   text-emerald-600
                                   hover:text-emerald-700"
                        >
                            Lupa password?
                        </a>

                    @endif

                </div>


                {{-- Login Button --}}
                <button
                    type="submit"
                    class="w-full py-4 rounded-2xl
                           bg-gradient-to-r
                           from-teal-600
                           to-emerald-400
                           hover:from-teal-700
                           hover:to-emerald-500
                           text-white
                           text-lg
                           font-semibold
                           shadow-lg
                           shadow-emerald-100
                           transition duration-300"
                >
                    Masuk
                </button>


                {{-- Register --}}
                <p class="text-center text-gray-500 mt-7">

                    Belum punya akun?

                    <a
                        href="{{ route('register') }}"
                        class="text-emerald-600
                               font-semibold
                               hover:text-emerald-700"
                    >
                        Daftar sekarang
                    </a>

                </p>

            </form>

        </div>

    </div>

</div>


<script>

    function togglePassword() {

        const password = document.getElementById('password');

        if (password.type === 'password') {
            password.type = 'text';
        } else {
            password.type = 'password';
        }

    }

</script>

</body>
</html>