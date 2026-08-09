<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('code')->unique();

            // Foreign keys – use foreignUuid with nullable and constrained
            $table->foreignUuid('faculty_id')->nullable()->constrained('faculties')->nullOnDelete();
            $table->foreignUuid('parent_department_id')->nullable()->references('id')->on('departments')->nullOnDelete();
            $table->foreignUuid('head_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Audit columns
            $table->foreignUuid('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('modified_by')->nullable()->constrained('users')->nullOnDelete();

            $table->index(['faculty_id', 'parent_department_id']);
            $table->index('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
