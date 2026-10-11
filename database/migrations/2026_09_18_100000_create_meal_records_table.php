<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_records', function (Blueprint $table) {
            $table->id();

            // Pemilik dan anak
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('child_id')
                ->constrained('children')
                ->cascadeOnDelete();

            // Referensi hasil scan Gemini (opsional, tahap berikutnya)
            // Unique untuk mencegah satu hasil analisis dicatat ganda
            $table->foreignId('food_analysis_id')
                ->nullable()
                ->unique()
                ->constrained('food_analyses')
                ->nullOnDelete();

            // Informasi makanan dan waktu konsumsi
            $table->string('food_name');
            $table->string('meal_type'); // sarapan, snack_pagi, makan_siang, snack_sore, makan_malam, snack, lainnya
            $table->string('portion_text')->nullable();
            $table->dateTime('consumed_at');

            // Nilai nutrisi (nullable: NULL berarti belum diketahui, bukan 0)
            $table->decimal('calories', 8, 2)->nullable();
            $table->decimal('protein', 8, 2)->nullable();
            $table->decimal('carbohydrates', 8, 2)->nullable();
            $table->decimal('fat', 8, 2)->nullable();
            $table->decimal('fiber', 8, 2)->nullable();

            // Asal data (manual atau scan)
            $table->string('source')->default('manual');
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indeks komposit untuk efisiensi query riwayat dan total harian
            $table->index(['child_id', 'consumed_at']);
            $table->index(['user_id', 'consumed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_records');
    }
};
