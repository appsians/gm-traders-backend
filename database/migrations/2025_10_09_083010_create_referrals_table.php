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
        Schema::create('referrals', function (Blueprint $table) {
              $table->id();

                 $table->unsignedBigInteger('referrer_id'); // user who shared the code
        $table->unsignedBigInteger('referred_user_id')->nullable(); // user who registered
        $table->string('referral_code');
        $table->integer('coins_rewarded')->default(0);
        $table->timestamps();

         $table->foreign('referrer_id')->references('id')->on('users')->onDelete('cascade');
         $table->foreign('referred_user_id')->references('id')->on('users')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
