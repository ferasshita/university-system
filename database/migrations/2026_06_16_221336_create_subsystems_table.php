<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subsystems', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('version')->default('1.0');
            $table->string('api_base_url')->nullable();
            $table->json('config')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreignUuid('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('modified_by')->nullable()->constrained('users')->nullOnDelete();

            $table->index('slug');
            $table->index('is_active');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('subsystems');
    }
};
