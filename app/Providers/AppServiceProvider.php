<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Queue\Middleware\RateLimited;

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
        $this->configureRateLimiting();
    }


    public function configureRateLimiting(){
        RateLimiter::for('api',function(Request $request){
            if($request->user()->hasRole('admin')){
                return Limit::perMinute(9)->by($request->user()->id);
            }
            return Limit::perMinute(6)->by($request->user()->id?:$request->ip());
        });
        RateLimiter::for('guest',function(Request $request){
            return Limit::perMinute(5)->by($request->ip());
        });
        
    }

    // In app/Providers/RouteServiceProvider.php


}
