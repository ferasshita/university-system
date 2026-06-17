<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('building_id')->constrained('buildings')->cascadeOnDelete();
            $table->string('room_number');
            $table->string('name')->nullable();
            $table->integer('capacity')->nullable();
            $table->json('equipment')->nullable();
            $table->enum('status', ['active', 'under_maintenance', 'inactive'])->default('active');
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignUuid('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('modified_by')->nullable()->constrained('users')->nullOnDelete();

            $table->index(['building_id', 'status']);
            $table->index('room_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
