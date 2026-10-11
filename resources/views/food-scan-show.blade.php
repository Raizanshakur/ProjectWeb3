<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Analisis Makanan - GrowCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#F8F7F2] text-[#202725] min-h-screen">

<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('food.scan') }}" class="inline-flex items-center gap-2 text-stone-600 hover:text-stone-900 text-sm font-semibold">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Scanner
        </a>
        <span class="text-xs bg-[#E0F0EB] text-[#438F83] px-3 py-1 rounded-full font-semibold">
            Estimasi AI
        </span>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-[#E8F5F1] border border-[#C2E5DC] text-[#286358] flex items-center gap-3">
            <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0 text-[#438F83]"></i>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-stone-200">
        @if ($analysis->food_image)
            <div class="w-full h-64 rounded-2xl overflow-hidden bg-stone-100 mb-6 flex items-center justify-center">
                <img src="{{ route('food.scan.image', $analysis) }}" alt="Foto Makanan" class="w-full h-full object-cover">
            </div>
        @endif

        @if ($analysis->status === 'failed')
            <div class="p-5 rounded-2xl bg-red-50 border border-red-200 text-red-700">
                <div class="flex items-center gap-2 font-semibold">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    Analisis Gagal
                </div>
                <p class="text-sm mt-2">{{ $analysis->error_message ?? 'Terjadi kendala saat menganalisis foto makanan.' }}</p>
                <div class="mt-4">
                    <a href="{{ route('food.scan') }}" class="inline-block px-4 py-2 bg-red-600 text-white rounded-full text-xs font-semibold">Scan Ulang</a>
                </div>
            </div>
        @elseif (in_array($analysis->status, ['pending', 'processing']))
            <div class="p-5 rounded-2xl bg-blue-50 border border-blue-200 text-blue-800 text-center">
                <div class="flex items-center justify-center gap-2 font-semibold">
                    <i data-lucide="loader-2" class="w-5 h-5 animate-spin text-blue-600"></i>
                    Foto Sedang Dianalisis oleh AI
                </div>
                <p class="text-sm mt-2">Mohon tunggu beberapa saat, sistem antrean sedang memproses estimasi nutrisi dari foto makanan Anda.</p>
                <div class="mt-4">
                    <a href="{{ route('food.scan.show', $analysis) }}" class="inline-block px-4 py-2 bg-[#4B988D] text-white rounded-full text-xs font-semibold">Muat Ulang Status</a>
                </div>
            </div>
        @elseif (! $analysis->is_food)
            <div class="p-5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800">
                <div class="flex items-center gap-2 font-semibold">
                    <i data-lucide="help-circle" class="w-5 h-5"></i>
                    Foto Bukan Makanan
                </div>
                <p class="text-sm mt-2">{{ $analysis->uncertainty_note ?? 'Objek dalam foto tidak dapat dikenali sebagai makanan yang aman dikonsumsi anak.' }}</p>
                <div class="mt-4">
                    <a href="{{ route('food.scan') }}" class="inline-block px-4 py-2 bg-[#4B988D] text-white rounded-full text-xs font-semibold">Scan Makanan Lain</a>
                </div>
            </div>
        @else
            <form method="POST" action="{{ route('food.scan.confirm', $analysis) }}" class="space-y-5">
                @csrf

                <div>
                    <span class="text-xs text-[#438F83] font-semibold tracking-wider">HASIL ESTIMASI GEMINI</span>
                    <h1 class="text-2xl font-bold mt-1 text-stone-900">{{ $analysis->food_name ?? 'Makanan Terdeteksi' }}</h1>
                    <p class="text-xs text-stone-400 mt-0.5">Model: {{ $analysis->model_used ?? 'gemini-3.8-flash' }}</p>
                </div>

                @if ($analysis->visible_ingredients)
                    <div>
                        <label class="text-xs font-semibold text-stone-500">Bahan Terlihat:</label>
                        <div class="flex flex-wrap gap-1.5 mt-1.5">
                            @foreach ($analysis->visible_ingredients as $ing)
                                <span class="text-xs bg-stone-100 text-stone-700 px-2.5 py-1 rounded-full">{{ $ing }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-[#F8F7F3] p-4 rounded-2xl">
                    <div class="text-center p-2">
                        <span class="text-xs text-stone-400 block">Kalori</span>
                        <strong class="text-lg text-stone-800">{{ $analysis->calories !== null ? round($analysis->calories) : '-' }}</strong>
                        <span class="text-[11px] text-stone-400 block">kkal</span>
                    </div>
                    <div class="text-center p-2">
                        <span class="text-xs text-stone-400 block">Protein</span>
                        <strong class="text-lg text-stone-800">{{ $analysis->protein !== null ? $analysis->protein : '-' }}</strong>
                        <span class="text-[11px] text-stone-400 block">gram</span>
                    </div>
                    <div class="text-center p-2">
                        <span class="text-xs text-stone-400 block">Lemak</span>
                        <strong class="text-lg text-stone-800">{{ $analysis->fat !== null ? $analysis->fat : '-' }}</strong>
                        <span class="text-[11px] text-stone-400 block">gram</span>
                    </div>
                    <div class="text-center p-2">
                        <span class="text-xs text-stone-400 block">Karbo</span>
                        <strong class="text-lg text-stone-800">{{ $analysis->carbohydrates !== null ? $analysis->carbohydrates : '-' }}</strong>
                        <span class="text-[11px] text-stone-400 block">gram</span>
                    </div>
                </div>

                @if ($analysis->uncertainty_note)
                    <div class="p-3.5 bg-amber-50 rounded-xl text-xs text-amber-800 flex items-start gap-2">
                        <i data-lucide="info" class="w-4 h-4 shrink-0 mt-0.5 text-amber-600"></i>
                        <span>{{ $analysis->uncertainty_note }}</span>
                    </div>
                @endif

                <hr class="border-stone-200">

                <div class="pt-2">
                    <h3 class="font-bold text-base text-stone-900 mb-1">Koreksi & Konfirmasi Catatan Makan</h3>
                    <p class="text-xs text-stone-500 mb-4">Anda dapat menyesuaikan nama, porsi, atau nilai nutrisi sebelum menyimpannya ke buku catatan harian si kecil.</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-700">Untuk Anak <span class="text-red-500">*</span></label>
                    <select name="child_id" required class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                        @foreach ($children as $c)
                            <option value="{{ $c->id }}" {{ ($analysis->child_id === $c->id) ? 'selected' : '' }}>
                                {{ $c->name }} ({{ in_array($c->gender, ['L', 'male']) ? 'L' : 'P' }}{{ $c->birth_date ? ', ' . $c->age_in_months . ' bln' : '' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-stone-700">Nama Makanan <span class="text-red-500">*</span></label>
                        <input type="text" name="food_name" value="{{ old('food_name', $analysis->food_name) }}" required class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-stone-700">Waktu Makan <span class="text-red-500">*</span></label>
                        <select name="meal_type" required class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                            <option value="Sarapan">Sarapan</option>
                            <option value="Snack Pagi">Snack Pagi</option>
                            <option value="Makan Siang">Makan Siang</option>
                            <option value="Snack Sore">Snack Sore</option>
                            <option value="Makan Malam">Makan Malam</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-stone-700">Porsi</label>
                        <input type="text" name="portion_text" value="{{ old('portion_text', $analysis->portion_description) }}" class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-stone-700">Waktu Konsumsi <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="consumed_at" value="{{ now()->format('Y-m-d\TH:i') }}" max="{{ now()->format('Y-m-d\TH:i') }}" required class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div>
                        <label class="text-xs font-semibold text-stone-700">Kalori (kkal)</label>
                        <input type="number" step="any" min="0" name="calories" value="{{ old('calories', $analysis->calories) }}" class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-stone-700">Protein (g)</label>
                        <input type="number" step="any" min="0" name="protein" value="{{ old('protein', $analysis->protein) }}" class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-stone-700">Lemak (g)</label>
                        <input type="number" step="any" min="0" name="fat" value="{{ old('fat', $analysis->fat) }}" class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-stone-700">Karbohidrat (g)</label>
                        <input type="number" step="any" min="0" name="carbohydrates" value="{{ old('carbohydrates', $analysis->carbohydrates) }}" class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-700">Catatan Tambahan</label>
                    <textarea name="notes" rows="2" class="mt-1 w-full rounded-2xl border-stone-200 bg-[#F8F7F3] text-sm">{{ old('notes') }}</textarea>
                </div>

                <p class="text-[11px] text-stone-400 italic">
                    *Hasil ini merupakan estimasi AI dan bukan pengganti diagnosis medis/ahli gizi anak.
                </p>

                @if ($analysis->mealRecord)
                    <div class="p-3.5 bg-emerald-50 text-[#286358] rounded-2xl text-center text-sm font-semibold border border-emerald-200">
                        Makanan ini sudah dikonfirmasi ke riwayat nutrisi.
                    </div>
                @else
                    <button type="submit" class="w-full py-3.5 bg-[#4B988D] hover:bg-[#3D8379] text-white font-semibold rounded-2xl transition">
                        Konfirmasi & Catat ke Nutrisi
                    </button>
                @endif
            </form>
        @endif
    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
