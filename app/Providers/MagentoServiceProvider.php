<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\Magento\MagentoClient;
use App\Http\Services\Magento\Products\ProductService;

class MagentoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'App\Contracts\Magento\ClientContract',
            function () {
                return new MagentoClient(
                    new \GuzzleHttp\Client([
                        'base_uri' => config('app.magento_url'),
                        'timeout' => config('app.magento_api_timeout'),
                        'verify' => config('app.magento_api_ssl_verify'),
                        'debug' => config('app.magento_api_debug'),
                        'headers' => [
                            'Content-type' => 'application/json'
                        ]
                    ])
                );
            }
        );
        $this->app->bind(
            'App\Http\Services\Magento\Products\ProductService',
            ProductService::class
        );
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
