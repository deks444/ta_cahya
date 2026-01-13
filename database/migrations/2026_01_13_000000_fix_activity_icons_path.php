<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update paths from storage/activities to img/activities
        DB::table('activities')->where('icon', 'like', 'storage/activities/%')->get()->each(function ($activity) {
            $newPath = str_replace('storage/activities/', 'img/activities/', $activity->icon);
            DB::table('activities')->where('id', $activity->id)->update(['icon' => $newPath]);
        });

        // Also handle cases where it might be just 'activities/'
        DB::table('activities')->where('icon', 'like', 'activities/%')->get()->each(function ($activity) {
            $newPath = 'img/' . $activity->icon;
            DB::table('activities')->where('id', $activity->id)->update(['icon' => $newPath]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert paths back to storage/activities (approximate)
        DB::table('activities')->where('icon', 'like', 'img/activities/%')->get()->each(function ($activity) {
            $newPath = str_replace('img/activities/', 'storage/activities/', $activity->icon);
            DB::table('activities')->where('id', $activity->id)->update(['icon' => $newPath]);
        });
    }
};
