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
        Schema::create('vehicleroutes', function (Blueprint $table) {
            $table->id();
            $table->date('date_route');
            $table->time('hour_route');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('routestatus_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('route_id');
            $table->foreign('routestatus_id')->references('id')->on('routestatus');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('route_id')->references('id')->on('routes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicleroutes');
    }
};
