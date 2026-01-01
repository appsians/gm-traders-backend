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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

              $table->unsignedBigInteger('user_id');

    // Polymorphic relation
    $table->unsignedBigInteger('bookable_id');
    $table->string('bookable_type'); // model name (Plant or TrillsMaterial)

    $table->integer('quantity')->default(1)->nullable();
    $table->decimal('total_price', 10, 2)->nullable();
    $table->string('status')->default('pending');
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
