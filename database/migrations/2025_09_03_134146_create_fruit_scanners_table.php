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
        Schema::create('fruit_scanners', function (Blueprint $table) {
            $table->id();
            $table->string('fruit_qr_code')->unique();
            $table->string('fruit_name')->nullable();
            $table->longText('qr_code_image')->nullable();
            $table->string('origin')->nullable();
            $table->string('farmer_name')->nullable();
            $table->unsignedInteger('orchard_size')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fruit_scanners');
    }
};
