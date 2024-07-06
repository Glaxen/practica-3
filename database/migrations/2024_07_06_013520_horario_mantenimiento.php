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
        Schema::create('horario_mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->date('dia');
            $table->unsignedBigInteger('id_vehiculo');
            $table->foreign('id_vehiculo')->references('id')->on('vehicles');
            $table->string('tipo');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->unsignedBigInteger('id_mantenimiento');
            $table->foreign('id_mantenimiento')->references('id')->on('mantenimientos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_mantenimientos');
    }
};
