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

    /*
     * Route User APi
     */
    Route::get('user','UserController@getCurrentUser');

    Route::get('users', 'UserController@index');

    Route::get('users/{user}', 'UserController@show');

    Route::post('users', 'UserController@store');

    Route::put('users/{user}', 'UserController@update');

    Route::delete('users/{user}', 'UserController@delete');

    /*
     * Route Patient Api
     */
    Route::get('patients', 'PatientController@index');

    Route::get('patients/{patient}', 'PatientController@show');

    Route::post('patients', 'PatientController@store');

    Route::put('patients/{patient}', 'PatientController@update');

    Route::delete('patients/{patient}', 'PatientController@delete');

    /*
     * Route OperationLog Api
     */
    Route::get('operation_log', 'operationLogController@operationLogList');//日志列表
    Route::get('operation_log/get_user_list','operationLogController@getUserList');//下拉用户列表
    Route::get('operation_log/get_module_list','operationLogController@getModuleList');//下拉模块选项

});


Route::group(['namespace'=>'Api'],function (){

    Route::post('login','LoginController@login');

    Route::post('registration','RegisterController@register');

    Route::post('refreshment','LoginController@refreshToken');

    Route::get('message','UserController@getMessage');

    Route::get('hashpassword','UserController@getHashPassword');

    Route::get('dysms','UserController@sendMessage');

    Route::get('order','OrderController@store');

    // Route::get('publish', function () {
    //     // Route logic...

    //     Redis::publish('test-channel', json_encode(['foo' => 'bar']));
    // });

});







