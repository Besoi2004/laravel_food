<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\OrderDetail;
use App\Observers\OrderDetailObserver;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        OrderDetail::observe(OrderDetailObserver::class);
    }
}