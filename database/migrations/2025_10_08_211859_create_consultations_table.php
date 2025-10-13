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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('reason');
            $table->text('notes')->nullable();
            $table->json('attached_files')->nullable(); // Para almacenar archivos como JSON
            $table->timestamps();
            $table->foreignId('medical_record_id')->constrained('medical_records')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
