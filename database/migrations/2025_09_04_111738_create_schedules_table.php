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
    Schema::create('schedules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('orchard_id')->constrained()->onDelete('cascade');
    $table->enum('type', ['irrigation', 'spray', 'fertilization']);
    $table->string('task'); // e.g., "Calcium spray"
    $table->date('scheduled_date');
    $table->boolean('auto_adjusted')->default(false); // if changed due to age/weather
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
