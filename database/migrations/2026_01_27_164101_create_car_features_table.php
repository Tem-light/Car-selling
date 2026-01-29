<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_features', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->primary();
            $table->boolean('abs')->default(0);
            $table->boolean('air_conditioning')->default(0);
            $table->boolean('power_windows')->default(0);
            $table->boolean('power_door_lock')->default(0);
            $table->boolean('cruise_control')->default(0);
            $table->boolean('bluetooth_connection')->default(0);
            $table->boolean('remote_start')->default(0);
            $table->boolean('gps_navigation')->default(0);
            $table->boolean('heated_seats')->default(0);
            $table->boolean('climate_control')->default(0);
            $table->boolean('rear_parking_sensors')->default(0);
            $table->boolean('leather_seats')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_features');
    }
};
