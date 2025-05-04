<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

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
        Schema::defaultStringLength(191);

        if (!Session::has('country_code')) {
            try {
                $ip = request()->ip(); // Get IP
                $response = Http::get("http://ip-api.com/json/{$ip}");
                Session::put('BD', $data['BD'] ?? 'us');
            } catch (\Exception $e) {
                Session::put('country_code', 'us'); // fallback
            }
        }
    }
}
