<?php

namespace App\Providers;
use App\Models\Order;
use Carbon\Carbon;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS URLs when:
        // 1. The request is secure (direct HTTPS)
        // 2. X-Forwarded-Proto header indicates HTTPS (behind proxy/load balancer)
        // 3. In production environment
        $isSecure = request()->isSecure() || 
                   request()->header('X-Forwarded-Proto') === 'https' ||
                   app()->environment('production');
        
        if ($isSecure) {
            \URL::forceScheme('https');
        }
        
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
        
    //     Order::where('is_verify', false)
    //     ->where('created_at', '<', Carbon::now()->subMinutes(5))
    //     ->delete();
     }
}
