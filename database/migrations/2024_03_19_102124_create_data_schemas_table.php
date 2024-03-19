<?php

use App\Models\Category;
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
        Schema::create('data_schemas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class);
            $table->json('structure');
            $table->json('validation')->nullable();
            $table->boolean('force_validation')->default(false);
            $table->boolean('force_validation_import')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_schemas');
    }
};
