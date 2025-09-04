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
        Schema::create('plant_scanners', function (Blueprint $table) {
        $table->id();
        $table->string('tree_id')->unique();
        $table->string('plant_name');
        $table->longText('qr_code_image')->nullable();
        $table->string('variety')->nullable();
        $table->date('birthday')->nullable();
        $table->text('care_instructions')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_scanners');
    }
};
