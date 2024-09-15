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
            $table->id(); // Auto-incrementing primary key
            $table->string('name')->nullable(); // Section name (e.g., A, B, C)
            $table->integer('class_id')->default(0); // Foreign key to classes table
            $table->integer('capacity')->default(0); // Number of students allowed in the section
            $table->integer('teacher_in_charge_id')->default(0);
            $table->string('teacher_in_charge_name')->nullable(); // Optional field for teacher responsible for the section
            $table->boolean('status')->default(0);
            $table->timestamps(); // Created at and updated at columns
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
