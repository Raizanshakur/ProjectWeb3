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
        Schema::table('food_analyses', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('food_image');
            $table->string('model_used')->nullable()->after('status');
            $table->boolean('is_food')->default(true)->after('model_used');
            $table->string('portion_description')->nullable()->after('is_food');
            $table->json('visible_ingredients')->nullable()->after('portion_description');
            $table->text('uncertainty_note')->nullable()->after('recommendation');
            $table->text('error_message')->nullable()->after('uncertainty_note');
            $table->timestamp('analyzed_at')->nullable()->after('error_message');

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('food_analyses', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
            $table->dropColumn([
                'status',
                'model_used',
                'is_food',
                'portion_description',
                'visible_ingredients',
                'uncertainty_note',
                'error_message',
                'analyzed_at',
            ]);
        });
    }
};
