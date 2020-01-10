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
        // Obtem todos clientes
        Route::get('/', 'CustomersController@index');
        // Obtem o cliente por userid
        //Route::get('/{userid}', 'CustomersController@show');
        // Obtem o cliente por userid
        //Route::patch('/{userid}', 'CustomersController@update');
    });
});
