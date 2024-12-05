<?php

use App\Models\DataSource;
use App\Models\OtherDataSource;
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
        Schema::create('core_group_data', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OtherDataSource::class)->nullable();
            $table->string('area_name_region')->nullable();
            $table->string('area_name_zone_somali')->nullable();
            $table->string('area_name_zone_oromia')->nullable();
            $table->string('area_name_zone_gambella')->nullable();
            $table->string('area_name_zone_benshangul')->nullable();
            $table->string('area_name_zone_snnp')->nullable();
            $table->string('area_name_woreda_somali_afder')->nullable();
            $table->string('area_name_woreda_somali_liben')->nullable();
            $table->string('area_name_woreda_somali_shebele')->nullable();
            $table->string('area_name_woreda_somali_siti')->nullable();
            $table->string('area_name_woreda_somali_dollo')->nullable();
            $table->string('area_name_woreda_somali_dawa')->nullable();
            $table->string('area_name_woreda_oromia_borena')->nullable();
            $table->string('area_name_woreda_oromia_kellem')->nullable();
            $table->string('area_name_woreda_gambella_agnua')->nullable();
            $table->string('area_name_woreda_gambella_nuer')->nullable();
            $table->string('area_name_woreda_gambella_majang')->nullable();
            $table->string('area_name_woreda_benshangul_assosa')->nullable();
            $table->string('area_name_woreda_benshangul_metekel')->nullable();
            $table->string('area_name_woreda_benshangul_kamashi')->nullable();
            $table->string('area_name_woreda_snnp_bench_maji')->nullable();
            $table->string('area_name_woreda_snnp_south_omo')->nullable();
            $table->string('area_name_kebele')->nullable();
            $table->string('area_name_village')->nullable();
            $table->string('area_name_gps')->nullable();
            $table->string('gps_latitude')->nullable();
            $table->string('gps_longitude')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('core_group_data');
    }
};
