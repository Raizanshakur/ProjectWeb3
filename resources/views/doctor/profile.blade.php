{{-- Doctor Profile — placeholder view --}}
{{-- TODO: Build full doctor profile UI in a future task --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Dokter - GrowCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Profil Dokter</h1>
                <a href="{{ route('dokter.dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800">← Kembali</a>
            </div>

            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Nama</p>
                    <p class="font-medium text-gray-900">{{ $doctor->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Spesialisasi</p>
                    <p class="font-medium text-gray-900">{{ $doctor->specialization ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">No. STR</p>
                    <p class="font-medium text-gray-900">{{ $doctor->str_number ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium text-gray-900">{{ $doctor->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Telepon</p>
                    <p class="font-medium text-gray-900">{{ $doctor->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jadwal Praktik</p>
                    <p class="font-medium text-gray-900">{{ $doctor->practice_days ?? '-' }} ({{ $doctor->start_time ?? '?' }} - {{ $doctor->end_time ?? '?' }})</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-medium {{ $doctor->is_available ? 'text-green-600' : 'text-red-600' }}">
                        {{ $doctor->is_available ? 'Online' : 'Offline' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
