<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Activity;
use App\Models\ActivityScore;
use App\Models\UserPoint;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create Default Activities
        $strength = Activity::create(['name' => 'Strength', 'description' => 'Kekuatan fisik', 'icon' => null]);
        $endurance = Activity::create(['name' => 'Endurance', 'description' => 'Ketahanan fisik', 'icon' => null]);
        $agility = Activity::create(['name' => 'Agility', 'description' => 'Kelincahan', 'icon' => null]);

        // 2. Migrate Data from user_points table
        // Check if user_points table exists and calculate migration
        if (Schema::hasTable('user_points')) {
            $userPoints = DB::table('user_points')->get();

            foreach ($userPoints as $point) {
                // Strength
                if ($point->strength > 0) {
                    DB::table('activity_scores')->insert([
                        'user_id' => $point->user_id,
                        'activity_id' => $strength->id,
                        'score' => $point->strength,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Endurance
                if ($point->endurance > 0) {
                    DB::table('activity_scores')->insert([
                        'user_id' => $point->user_id,
                        'activity_id' => $endurance->id,
                        'score' => $point->endurance,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Agility
                if ($point->agility > 0) {
                    DB::table('activity_scores')->insert([
                        'user_id' => $point->user_id,
                        'activity_id' => $agility->id,
                        'score' => $point->agility,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Truncate tables on rollback
        DB::table('activity_scores')->truncate();
        DB::table('activities')->truncate();
    }
};
