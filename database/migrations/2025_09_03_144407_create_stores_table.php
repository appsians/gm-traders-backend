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

        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('store_category_id')->constrained('store_categories')->cascadeOnDelete();
            $table->string('name'); // e.g., Granny Smith, Golden Delicious
            $table->string('scientific_name')->nullable(); // e.g., Malus domestica
            $table->string('size')->nullable(); // Medium, Small
            $table->string('plant_type')->nullable(); // e.g., Orchard
            $table->integer('height')->nullable(); // in cm
            $table->integer('humidity')->nullable(); // in %
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable(); // if sale
            $table->string('image')->nullable(); // store image path
            $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
