{{-- Doctor Consultation Detail — placeholder view --}}
{{-- TODO: Build full consultation chat UI in a future task --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Konsultasi - GrowCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Detail Konsultasi #{{ $consultation->id }}</h1>
                <a href="{{ route('dokter.consultations') }}" class="text-sm text-blue-600 hover:text-blue-800">← Kembali</a>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <p class="font-medium">{{ $consultation->parent_name }} — {{ $consultation->child_name }} ({{ $consultation->child_age }})</p>
                <p class="text-sm text-gray-600 mt-1">{{ $consultation->complaint }}</p>
                <p class="text-xs text-gray-400 mt-2">Status: {{ ucfirst($consultation->status) }}</p>
            </div>

            <h2 class="font-semibold text-gray-900 mb-4">Pesan</h2>
            <div class="space-y-3">
                @foreach ($messages as $msg)
                    <div class="p-3 rounded-lg {{ $msg->sender_type === 'doctor' ? 'bg-blue-50 ml-8' : 'bg-gray-50 mr-8' }}">
                        <p class="text-xs font-medium text-gray-500 mb-1">{{ ucfirst($msg->sender_type) }}</p>
                        <p class="text-sm text-gray-800">{{ $msg->message }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
