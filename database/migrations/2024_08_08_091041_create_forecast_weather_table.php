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
        Schema::create('forecast_weather', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->timestamp('forecast_time');
            $table->decimal('temperature', 5, 2);
            $table->integer('humidity');
            $table->decimal('wind_speed', 5, 2);
            $table->integer('pressure');
            $table->string('weather_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forecast_weather');
    }
};
