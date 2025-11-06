<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('doctor_no')->nullable();
            $table->string('degree')->nullable();
            $table->string('specialty')->nullable();
            $table->string('designation')->nullable();
            $table->string('gender')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('experience_years')->nullable();
            $table->decimal('first_visit_fee', 10, 2)->default(0);
            $table->decimal('follow_up_fee', 10, 2)->default(0);
            $table->integer('follow_up_validity_days')->default(7);
            $table->string('location')->nullable();
            $table->string('chamber_address')->nullable();
            $table->integer('avg_duration')->default(10); // minutes
            $table->integer('avg_load')->default(0);
            $table->integer('reserved')->default(0);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('specialization_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->json('opening_hours')->nullable(); // Spatie OpeningHours JSON
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
