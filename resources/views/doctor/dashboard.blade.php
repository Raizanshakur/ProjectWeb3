{{-- Doctor Dashboard — placeholder view --}}
{{-- TODO: Build full doctor dashboard UI in a future task --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Dokter - GrowCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Dashboard Dokter</h1>
            <p class="text-gray-600 mb-6">Selamat datang, {{ auth()->user()->name }}.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-sm text-green-600 font-medium">Total Konsultasi</p>
                    <p class="text-2xl font-bold text-green-700">{{ $stats['total_consultations'] ?? 0 }}</p>
                </div>
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-sm text-blue-600 font-medium">Pasien Hari Ini</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $stats['today_patients'] ?? 0 }}</p>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('dokter.consultations') }}" class="block bg-gray-50 hover:bg-gray-100 rounded-lg p-3 text-gray-700">
                    📋 Daftar Konsultasi
                </a>
                <a href="{{ route('dokter.profil') }}" class="block bg-gray-50 hover:bg-gray-100 rounded-lg p-3 text-gray-700">
                    👤 Profil Dokter
                </a>
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                    Logout
                </button>
            </form>
        </div>
    </div>
</body>
</html>
