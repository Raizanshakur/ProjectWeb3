<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_analyses', function (Blueprint $table) {
            $table->id();

            // User yang melakukan analisis
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Anak yang akan mengonsumsi makanan
            $table->foreignId('child_id')
                ->nullable()
                ->constrained('children')
                ->nullOnDelete();

            // Informasi makanan
            $table->string('food_name')->nullable();
            $table->string('food_image')->nullable();

            // Hasil estimasi AI
            $table->decimal('calories', 8, 2)->nullable();
            $table->decimal('protein', 8, 2)->nullable();
            $table->decimal('carbohydrates', 8, 2)->nullable();
            $table->decimal('fat', 8, 2)->nullable();
            $table->decimal('fiber', 8, 2)->nullable();

            // Penjelasan/rekomendasi dari Gemini
            $table->text('ai_analysis')->nullable();
            $table->text('recommendation')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_analyses');
    }
};