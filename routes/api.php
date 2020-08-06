<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::prefix('v1')->group(function ()  {
    Route::middleware('auth:api')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });

    Route::middleware('guest:api')->group(function () {
        //Routes that should be in auth:api group when we implement user authentication
        Route::post('clients', 'ClientController@index')->name('clients');
        Route::post('clients/add', 'ClientController@store')->name('clients.add');
        Route::patch('clients/{client}', 'ClientController@show')->name('clients.show');
        Route::patch('clients/{client}/update', 'ClientController@update')->name('clients.update');
        Route::delete('clients/{client}/remove', 'ClientController@destroy')->name('clients.remove');
        Route::get('clients/{client}/history', 'ClientController@showHistory')->name('clients.history');
        Route::delete('clients/{client}/history/remove', 'ClientController@destroyHistory')->name('clients.history.remove');

        Route::post('cars/add', 'CarController@store')->name('cars.add');
        Route::patch('cars/{car}/update', 'CarController@update')->name('cars.update');
        Route::delete('cars/{car}/remove', 'CarController@destroy')->name('cars.remove');

        //Routes that should be in guest:api or without middleware
        Route::get('cars', 'CarController@index')->name('cars');
        Route::get('cars/brands/{brand}', 'CarController@indexBrands')->name('cars.brands');
        Route::post('cars/{car}', 'CarController@show')->name('cars.show');
        Route::post('cars/{car}/buy', 'CarController@buy')->name('cars.buy');
        Route::post('cars/{car}/trade', 'CarController@trade')->name('cars.trade');
        Route::post('cars/{car}/trade/evaluate', 'CarController@tradeEvaluate')->name('cars.trade.evaluate');
    });
});
