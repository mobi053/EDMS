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
        Schema::create('classes', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name')->nullable(); // Class name (e.g., Grade 1, Grade 2)
            $table->integer('teacher_in_charge_id')->default(0);
            $table->string('teacher_in_charge_name')->nullable(); // Optional, could reference a teacher's name or ID
            $table->unsignedBigInteger('school_id')->default(0); // Foreign key to schools table
            $table->boolean('status')->default(0); // Status when soft delete the record change
            $table->boolean('is_deleted')->default(0);

            $table->timestamps(); // Created at and updated at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
