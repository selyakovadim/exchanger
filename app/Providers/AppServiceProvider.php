<?php

namespace App\Providers;

use App\Models\Bill;
use App\Models\Exchange;
use App\Observers\BillObserver;
use App\Observers\ExchangeNotifications;
use App\Observers\ExchangeObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Bill::observe(BillObserver::class);
        Exchange::observe(ExchangeObserver::class);
        Exchange::observe(ExchangeNotifications::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
