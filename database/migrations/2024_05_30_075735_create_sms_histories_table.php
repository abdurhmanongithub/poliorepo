<?php

use App\Models\Community;
use App\Models\Knowledge;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sms_histories', function (Blueprint $table) {
            $table->id();
            $table->string('message')->nullable();
            $table->string('phone')->nullable();
            $table->foreignIdFor(Knowledge::class)->nullable()->constrained();
            $table->foreignIdFor(Community::class)->nullable()->constrained();
            $table->integer('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_histories');
    }
};
