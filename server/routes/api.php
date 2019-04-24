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

Route::group(['namespace'=>'Api','middleware' => 'auth:api'], function(){

    Route::get('users', 'UserController@index');

    Route::get('users/{user}', 'UserController@show');

    Route::post('users', 'Api\UserController@store');

    Route::put('users/{user}', 'UserController@update');

    Route::delete('users/{user}', 'UserController@delete');

});


Route::group(['namespace'=>'Api'],function (){

    Route::post('login','LoginController@login');

    Route::post('registration','RegisterController@register');

    Route::post('refreshment','LoginController@refreshToken');

    Route::get('message','UserController@getMessage');

    Route::get('hashpassword','UserController@getHashPassword');

    Route::get('dysms','UserController@sendMessage');

});







