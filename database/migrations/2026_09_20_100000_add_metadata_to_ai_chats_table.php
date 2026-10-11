<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ai_chats', function (Blueprint $table) {
            $table->string('model_used')->nullable()->after('topic');
            $table->index(['user_id', 'created_at']);
            $table->index(['child_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_chats', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'created_at']);
            $table->dropIndex(['child_id', 'created_at']);
            $table->dropColumn('model_used');
        });
    }
};
