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

/*
 * We can improve the endpoints by using implicit route model binding.
 * This way, Laravel will inject the User instance in our methods and automatically return a 404 if it isn’t found.
 * We’ll have to make changes on the routes file and on the controller:
 */

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('users', 'Api\UserController@index');
    Route::get('users/{user}', 'Api\UserController@show');
    Route::post('users', 'Api\UserController@store');
    Route::put('users/{user}', 'Api\UserController@update');
    Route::delete('users/{user}', 'Api\UserController@delete');
});

Route::post('login','Api\LoginController@login');

Route::post('registration','Api\RegisterController@register');

Route::post('refreshment','APi\LoginController@refreshToken');

Route::get('message','Api\UserController@getMessage');

Route::get('hashpassword','Api\UserController@getHashPassword');




