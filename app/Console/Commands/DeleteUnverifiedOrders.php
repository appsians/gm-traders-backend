<?php

namespace App\Console\Commands;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use Illuminate\Console\Command;

class DeleteUnverifiedOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     *
     */
    protected $signature = 'app:delete-unverified-orders';

    protected $description = 'Delete orders with verify=0 older than 5 minutes';

    /**
     * The console command description.
     *
     * @var string
     */
 //   protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // ✅ Delete all orders with verify = 0 and older than 5 minutes
            $deleted = Order::where('verify', 0)
                ->where('created_at', '<', Carbon::now()->subMinutes(5))
                ->delete();

            Log::info("✅ Deleted {$deleted} unverified orders successfully.");

            $this->info("✅ Deleted {$deleted} unverified orders successfully.");
        } catch (\Exception $e) {
            Log::error('❌ Failed to delete unverified orders: ' . $e->getMessage());
            $this->error('❌ Failed to delete unverified orders: ' . $e->getMessage());
        }
    }
}
