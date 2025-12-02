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
        Schema::create('trills__materials', function (Blueprint $table) {
            $table->id();

        $table->string('trellis_code')->nullable(); // Trellis code
        $table->string('title');                   // Name of the material
        $table->text('description')->nullable();  // Description of the material
        $table->string('image')->nullable();      // Image path
        $table->decimal('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trills__materials');
    }
};
