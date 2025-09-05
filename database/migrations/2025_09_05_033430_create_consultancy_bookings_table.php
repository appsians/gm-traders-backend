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
        Schema::create('consultancy_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // assuming you have users table
            $table->foreignId('consultancy_topic_id')->constrained('consultancy_topics')->onDelete('cascade');
            $table->foreignId('sub_consultancy_topic_id')->nullable()->constrained('sub_consultancy_topics')->onDelete('cascade');
            $table->timestamp('booked_at')->useCurrent(); // booking timestamp
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultancy_bookings');
    }
};
