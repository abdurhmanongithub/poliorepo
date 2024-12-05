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
        Schema::create('other_data_sources', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('import_batch')->default(0);
            $table->boolean('is_from_api')->default(false);
            $table->string('api_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_data_sources');
    }
};
