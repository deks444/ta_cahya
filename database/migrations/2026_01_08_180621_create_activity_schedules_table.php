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
        Schema::create('activity_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete(); // Relasi ke jenis kegiatan
            $table->foreignId('coach_id')->constrained('users')->cascadeOnDelete(); // Relasi ke user (pelatih)
            $table->date('date');
            $table->time('start_time');
            $table->string('location')->default('Lapangan Utama');
            $table->integer('quota')->nullable(); // Opsional, kalau mau dibatasi
            $table->enum('status', ['scheduled', 'cancelled', 'completed'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_schedules');
    }
};
