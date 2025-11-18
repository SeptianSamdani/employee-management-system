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
        // Create work_schedules table
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->time('check_in_start'); // 08:00
            $table->time('check_in_end');   // 09:00
            $table->time('check_out_start'); // 17:00
            $table->time('check_out_end');   // 18:00
            $table->integer('late_tolerance_minutes')->default(15);
            $table->json('work_days')->default('["monday","tuesday","wednesday","thursday","friday"]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_schedules');
    }
};
