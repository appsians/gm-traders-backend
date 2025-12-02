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
        Schema::create('plantbookings', function (Blueprint $table) {
            $table->id();
                $table->string('plantation_area');
                    $table->string('plant_varieties')->nullable();
                        $table->string('plant_grading')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantbookings');
    }
};
