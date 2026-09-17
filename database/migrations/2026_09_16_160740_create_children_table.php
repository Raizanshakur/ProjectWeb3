<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();

            // Anak dimiliki oleh user/orang tua
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->date('birth_date');

            $table->decimal('birth_weight', 5, 2)->nullable();
            $table->decimal('birth_height', 5, 2)->nullable();

            $table->string('photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};