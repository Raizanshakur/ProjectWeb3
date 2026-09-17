<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('specialization')->nullable();
            $table->string('str_number')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('photo')->nullable();

            // Jadwal singkat dokter
            $table->string('practice_days')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            // online / offline
            $table->boolean('is_available')->default(false);

            $table->text('bio')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};