<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('student_id')->unique();
            $table->foreignUuid('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->enum('academic_status', ['active', 'graduated', 'suspended', 'dropped'])->default('active');
            $table->date('enrollment_date')->nullable();
            $table->date('graduation_date')->nullable();
            $table->string('program')->nullable();
            $table->integer('current_year')->nullable();
            $table->json('additional_data')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignUuid('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('modified_by')->nullable()->constrained('users')->nullOnDelete();

            $table->index(['user_id', 'department_id']);
            $table->index('student_id');
            $table->index('academic_status');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
