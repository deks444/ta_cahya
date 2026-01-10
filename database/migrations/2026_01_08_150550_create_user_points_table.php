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
        Schema::create('user_points', function (Blueprint $table) {
            if (DB::getDriverName() === 'pgsql') {
                $table->uuid('uuid')->primary()->default(DB::raw('gen_random_uuid()'));
            } else {
                $table->uuid('uuid')->primary();
            }

            // Matches users.id type (BigInt)
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');

            $table->integer('strength')->default(0);
            $table->integer('endurance')->default(0);
            $table->integer('agility')->default(0);

            $table->integer('total_point')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_points');
    }
};
