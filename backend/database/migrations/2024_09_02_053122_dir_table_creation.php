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
        Schema::create('dir', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('lead_id')->nullable();
            $table->string('observation_id')->nullable();
            $table->string('dir_number')->nullable();
            $table->string('camera_id')->nullable();
            $table->boolean('finding_status')->default(0);
            $table->text('finding_remarks')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('department_id')->default(0);
            $table->boolean('local_cameras_status')->default(0);
            $table->integer('total_cameras')->default(0);
            $table->boolean('dir_status')->default(0);
            $table->date('dir_date')->nullable();
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dir');
    }
};
