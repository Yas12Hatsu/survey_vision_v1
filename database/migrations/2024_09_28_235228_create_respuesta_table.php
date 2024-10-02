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
        Schema::create('respuesta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_encuesta')->constrained('encuesta');
            $table->foreignId('id_pregunta')->constrained('pregunta');
            $table->integer('respuesta_cuanti')->nullable()->check('respuesta_cuanti >= 1 AND respuesta_cuanti <= 5');
            $table->text('respuesta_cuali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuesta');
    }
};
