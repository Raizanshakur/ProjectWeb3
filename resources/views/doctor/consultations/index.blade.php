{{-- Doctor Consultations List — placeholder view --}}
{{-- TODO: Build full consultation list UI in a future task --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Konsultasi - GrowCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Daftar Konsultasi</h1>
                <a href="{{ route('dokter.dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800">← Kembali</a>
            </div>

            @forelse ($consultations as $consultation)
                <div class="border-b border-gray-100 py-4 last:border-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-900">{{ $consultation->parent_name }} — {{ $consultation->child_name }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $consultation->complaint }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($consultation->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($consultation->status === 'accepted') bg-blue-100 text-blue-800
                            @elseif($consultation->status === 'completed') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($consultation->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">Belum ada konsultasi.</p>
            @endforelse
        </div>
    </div>
</body>
</html>
