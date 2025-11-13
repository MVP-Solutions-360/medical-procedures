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
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->nullable(); // corporal, facial, mamaria, no quirúrgica
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('anesthesia')->nullable();
            $table->integer('surgery_time_min')->nullable();
            $table->integer('surgery_time_max')->nullable();
            $table->string('hospitalization')->nullable();
            $table->integer('initial_recovery_weeks')->nullable();
            $table->integer('final_results_weeks')->nullable();
            $table->enum('risk_level', ['bajo','medio','alto'])->default('medio');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
