<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('growth_records', function (Blueprint $table) {
            $table->id();

            // Terhubung dengan data anak
            $table->foreignId('child_id')
                ->constrained('children')
                ->cascadeOnDelete();

            // Tanggal pengukuran
            $table->date('measurement_date');

            // Data pertumbuhan
            $table->decimal('weight', 5, 2); // kg
            $table->decimal('height', 5, 2); // cm
            $table->decimal('head_circumference', 5, 2)->nullable(); // cm

            // Hasil analisis
            $table->string('nutrition_status')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('growth_records');
    }
};