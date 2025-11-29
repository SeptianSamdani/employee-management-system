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
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->enum('type', [
                'ktp',
                'kk',
                'npwp',
                'diploma',
                'certificate',
                'contract',
                'bpjs_kesehatan',
                'bpjs_ketenagakerjaan',
                'medical',
                'other'
            ]);
            $table->string('title');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type')->nullable(); // pdf, jpg, png
            $table->integer('file_size')->nullable(); // in bytes
            $table->text('description')->nullable();
            $table->date('expiry_date')->nullable(); // untuk dokumen yang ada masa berlaku
            $table->boolean('is_verified')->default(false);
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Index untuk performa
            $table->index(['employee_id', 'type']);
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
    }
};