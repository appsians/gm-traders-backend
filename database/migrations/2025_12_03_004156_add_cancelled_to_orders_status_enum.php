<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum column to include 'cancelled'
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        // First, update any 'cancelled' orders to 'pending'
        DB::statement("UPDATE orders SET status = 'pending' WHERE status = 'cancelled'");
        // Then modify the enum back
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'completed') DEFAULT 'pending'");
    }
};
