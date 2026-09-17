<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_chats', function (Blueprint $table) {
            $table->id();

            // User yang menggunakan AI
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Anak yang sedang dibahas (opsional)
            $table->foreignId('child_id')
                ->nullable()
                ->constrained('children')
                ->nullOnDelete();

            // Pertanyaan user
            $table->text('user_message');

            // Jawaban Gemini
            $table->text('ai_response');

            // Jenis/topik pertanyaan
            $table->string('topic')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_chats');
    }
};