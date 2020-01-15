<?php

/*---------------------------------------------------
* AUTHENTICAÇÃO
---------------------------------------------------*/
Route::post('auth', 'APIController@login');

Route::group([
    'prefix' => 'v1',
    //'middleware' => 'auth.jwt'
], function () {
    Route::group([
        // Customer
        'prefix' => 'customer',
    ], function () {
        // Opencart
        Route::group([
            'prefix' => 'opencart',
            'namespace' => 'Api\v1\Customer\Opencart',
        ], function () {
            // Busca o cliente no opencart pelo CNPJ
            Route::get('/{cnpj}', 'CustomerController@show');
        });
        // Marketplace
        Route::group([
            'prefix' => 'marketplace',
            'namespace' => 'Api\v1\Customer\Marketplace',
        ], function () {
            // Busca o cliente no Marketplace pelo CNPJ
            Route::get('/{cnpj}', 'CustomerController@show');
            // Grava o cliente no Marketplace
            Route::post('/', 'CustomerController@create');
        });
    });
});
