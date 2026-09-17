<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            // Orang tua / pengguna
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Anak yang dikonsultasikan
            $table->foreignId('child_id')
                ->constrained('children')
                ->cascadeOnDelete();

            // Dokter
            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained('doctors')
                ->nullOnDelete();

            // Keluhan awal
            $table->text('complaint');

            // Jadwal konsultasi
            $table->dateTime('consultation_date')->nullable();

            // Status konsultasi
            $table->enum('status', [
                'pending',
                'accepted',
                'completed',
                'cancelled'
            ])->default('pending');

            // Catatan dari dokter
            $table->text('doctor_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};