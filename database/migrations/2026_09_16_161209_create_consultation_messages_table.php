<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultation_messages', function (Blueprint $table) {
            $table->id();

            // Konsultasi yang sedang berlangsung
            $table->foreignId('consultation_id')
                ->constrained('consultations')
                ->cascadeOnDelete();

            // Pengirim pesan: user atau dokter
            $table->enum('sender_type', ['user', 'doctor']);

            // Isi pesan
            $table->text('message');

            // Opsional jika nanti ingin kirim gambar/file
            $table->string('attachment')->nullable();

            // Menandai pesan sudah dibaca atau belum
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_messages');
    }
};