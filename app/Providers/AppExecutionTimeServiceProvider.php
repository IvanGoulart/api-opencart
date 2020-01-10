<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Debug\AppExecutionTime;

class AppExecutionTimeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Libraries\Debug\AppExecutionTime', function () {
            return new AppExecutionTime;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
