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
        Schema::create('campuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('campus_code')->unique();
            $table->text('location')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('principal')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('parent_school_id')->nullable();
            $table->string('campus_type')->nullable();
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        
            // Foreign key constraint
            // $table->foreign('parent_school_id')->references('id')->on('schools')->onDelete('set null');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campuses', function (Blueprint $table) {
           //
        });
    }
};
