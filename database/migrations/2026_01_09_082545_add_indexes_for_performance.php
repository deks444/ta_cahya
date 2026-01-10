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
        // Index untuk activity_schedules
        Schema::table('activity_schedules', function (Blueprint $table) {
            $table->index('date', 'idx_activity_schedules_date');
            $table->index('coach_id', 'idx_activity_schedules_coach_id');
            $table->index(['date', 'coach_id'], 'idx_activity_schedules_date_coach');
        });

        // Index untuk activity_participants
        Schema::table('activity_participants', function (Blueprint $table) {
            $table->index('user_id', 'idx_activity_participants_user_id');
            $table->index('activity_schedule_id', 'idx_activity_participants_schedule_id');
        });

        // Index untuk activity_scores
        Schema::table('activity_scores', function (Blueprint $table) {
            $table->index('user_id', 'idx_activity_scores_user_id');
        });

        // Index untuk users
        Schema::table('users', function (Blueprint $table) {
            $table->index('role', 'idx_users_role');
            $table->index(['role', 'is_active'], 'idx_users_role_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_schedules', function (Blueprint $table) {
            $table->dropIndex('idx_activity_schedules_date');
            $table->dropIndex('idx_activity_schedules_coach_id');
            $table->dropIndex('idx_activity_schedules_date_coach');
        });

        Schema::table('activity_participants', function (Blueprint $table) {
            $table->dropIndex('idx_activity_participants_user_id');
            $table->dropIndex('idx_activity_participants_schedule_id');
        });

        Schema::table('activity_scores', function (Blueprint $table) {
            $table->dropIndex('idx_activity_scores_user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_role');
            $table->dropIndex('idx_users_role_active');
        });
    }
};
