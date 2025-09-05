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
        Schema::create('sub_consultancy_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultancy_topic_id')->constrained('consultancy_topics')->onDelete('cascade');
            $table->string('name'); // e.g. "Tax Planning", "Mental Health", "Corporate Law"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_consultancy_topics');
    }
};
