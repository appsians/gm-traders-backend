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
         Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // e.g. Order #90897
            $table->string('name')->nullable; // Saddam Hussain
            $table->string('location'); // Shopian Kashmir
            $table->date('placed_date'); // Placed on Aug 6 2025
            $table->date('deliver_date')->nullable();
             $table->date('delivered_date')->nullable(); // Deliver on Aug 10 2025
            $table->decimal('amount_paid', 10, 2)->default(0); // Amount Paid ₹400
            $table->decimal('amount_remaining', 10, 2)->default(0); // Amount Remaining ₹1000
            $table->integer('items')->default(0); // Number of items
            $table->enum('status', ['pending', 'completed'])->default('pending'); // default pending
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
