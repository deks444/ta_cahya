<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing users to have proper roles
        // Set admin users
        DB::table('users')
            ->where('is_admin', true)
            ->whereNull('role')
            ->update(['role' => 'admin']);

        // Set non-admin users to atlit by default
        DB::table('users')
            ->where('is_admin', false)
            ->whereNull('role')
            ->update(['role' => 'atlit']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse
    }
};
