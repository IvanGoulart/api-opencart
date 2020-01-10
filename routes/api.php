<?php

/*---------------------------------------------------
* AUTHENTICAÇÃO
---------------------------------------------------*/
Route::post('auth', 'APIController@login');

Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api\v1\Opencart',
    'middleware' => 'auth.jwt'
], function () {
    /*---------------------------------------------------
     * CLIENTES
    ---------------------------------------------------*/
    Route::group(['prefix' => 'customer'], function () {
        // Obtem o cliente pelo CNPJ
        Route::get('/{cnpj}', 'CustomersController@show');

        // Rotas Marketplace
        Route::group(['prefix' => 'marketplace'], function () {
            // Obtem o cliente pelo CNPJ
            Route::post('/', 'CustomersController@create');
        });
    });
});
