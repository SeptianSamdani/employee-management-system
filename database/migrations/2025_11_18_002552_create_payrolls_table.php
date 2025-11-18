<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_payrolls_table.php
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('period'); // format: YYYY-MM
            $table->decimal('basic_salary', 12, 2);
            $table->decimal('allowances', 12, 2)->default(0);
            $table->decimal('overtime_pay', 12, 2)->default(0);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('deductions', 12, 2)->default(0);
            $table->decimal('net_salary', 12, 2);
            $table->integer('total_working_days')->default(0);
            $table->integer('total_present_days')->default(0);
            $table->integer('total_absent_days')->default(0);
            $table->integer('total_late_days')->default(0);
            $table->enum('status', ['draft', 'finalized', 'paid'])->default('draft');
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('generated_by')->constrained('users')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['employee_id', 'period']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
