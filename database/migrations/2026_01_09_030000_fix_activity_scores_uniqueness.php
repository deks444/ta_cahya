<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activity_scores', function (Blueprint $table) {
            // Drop unique constraint that prevents multiple scores for the same activity
            $table->dropUnique(['user_id', 'activity_id']);

            // Add missing columns if they don't exist
            if (!Schema::hasColumn('activity_scores', 'points')) {
                $table->integer('points')->default(0)->after('score');
            }
            if (!Schema::hasColumn('activity_scores', 'date')) {
                $table->date('date')->nullable()->after('points');
            }
            if (!Schema::hasColumn('activity_scores', 'time')) {
                $table->time('time')->nullable()->after('date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_scores', function (Blueprint $table) {
            $table->unique(['user_id', 'activity_id']);
            $table->dropColumn(['points', 'date', 'time']);
        });
    }
};
