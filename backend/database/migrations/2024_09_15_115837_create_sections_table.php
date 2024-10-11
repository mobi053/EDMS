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
        Schema::create('sections', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->string('name')->nullable(); // Name of the section
            $table->string('class_name')->nullable(); // Name of the class
            $table->integer('class_id')->default(0); // Foreign key to class table
            $table->integer('capacity')->nullable(); // Capacity of the section
            $table->string('campus_name')->nullable(); // Name of the campus
            $table->integer('campus_id')->default(0); // Foreign key to campus table
            $table->string('teacher_in_charge_name')->nullable(); // Name of the teacher in charge
            $table->integer('teacher_in_charge_id')->default(0); // Foreign key to teacher table
            $table->tinyInteger('is_deleted')->default(0); // Soft delete flag
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
