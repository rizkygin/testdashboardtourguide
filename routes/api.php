<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->prefix('qr')->name('qr.')->group(function(){
  Route::get('generate/{id}', 'API\QrCodeController@generate')->name('generate');
  Route::get('scan/{id}', 'API\QrCodeController@scan')->name('scan');
});

Route::middleware('auth:api')->group(function(){
  Route::apiResource('tourism', 'API\TourismController');
  Route::get('/tourism-city/{id}', 'API\TourismController@indexCity'); 
  Route::apiResource('merchant', 'API\MerchantController')->except([
    'update'
  ]);
  Route::put('merchant/update', 'API\MerchantController@update');
  Route::get('getmerchant', 'API\MerchantController@user');
  Route::get('/merchant-city/{id}', 'API\MerchantController@indexCity'); 
  Route::apiResource('items', 'API\MerchantItemController');
  Route::apiResource('promo', 'API\PromoController');
  Route::get('getpromo', 'API\PromoController@user');
  Route::put('user/update', 'API\UserController@update');
  Route::apiResource('reward', 'API\RewardController');
  Route::get('reward-redeem/{id}', 'API\RewardController@reedem');
});

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::get('getUser', 'API\UserController@getUser');
Route::get('test', 'API\UserController@test');