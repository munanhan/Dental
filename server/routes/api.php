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

Route::group(['middleware' => 'auth:api'], function(){

    Route::get('details', 'Api\UserController@getDetails');

});

Route::post('login','Api\LoginController@login');

Route::post('register','Api\RegisterController@register');

Route::post('refreshment','APi\LoginController@refreshToken');

Route::post('logout','APi\LoginController@logout');

Route::get('test','Api\UserController@test');
