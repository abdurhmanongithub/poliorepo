<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->string('mo');
            $table->string('dy');
            $table->string('t2m');
            $table->string('t2mdew');
            $table->string('t2mwet');
            $table->string('ts');
            $table->string('t2m_range');
            $table->string('t2m_max');
            $table->string('t2m_min');
            $table->string('qv2m');
            $table->string('rh2m');
            $table->string('prectotcorr');
            $table->string('location');
            $table->timestamps();
            $table->unique(['year', 'mo', 'dy']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_data');
    }
}
