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

    Route::get('patients/generate','PatientController@getCaseNumber');

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



    /*
     * Route PatientAddress Api
     */
    Route::get('patient_addresses', 'PatientAddressController@index');

    Route::get('patient_addresses/{patientAddress}', 'PatientAddressController@show');

    Route::post('patient_addresses', 'PatientAddressController@store');

    Route::put('patient_addresses/{patientAddress}', 'PatientAddressController@update');

    Route::delete('patient_addresses/{patientAddress}', 'PatientAddressController@delete');

    /*
     * Route PatientCase Api
     */
    Route::get('patient_cases', 'PatientCaseController@index');

    Route::get('patient_cases/{patientCase}', 'PatientCaseController@show');

    Route::post('patient_cases', 'PatientCaseController@store');

    Route::put('patient_cases/{patientCase}', 'PatientCaseController@update');

    Route::delete('patient_cases/{patientCase}', 'PatientCaseController@delete');

    /*
     * Route PatientConsult Api
     */
    Route::get('patient_consults', 'PatientConsultController@index');

    Route::get('patient_consults/{patientConsult}', 'PatientConsultController@show');

    Route::post('patient_consults', 'PatientConsultController@store');

    Route::put('patient_consults/{patientConsult}', 'PatientConsultController@update');

    Route::delete('patient_consults/{patientConsult}', 'PatientConsultController@delete');

    /*
     * Route PatientGroup Api
     */
    Route::get('patient_groups', 'PatientGroupController@index');

    Route::get('patient_groups/{patientGroup}', 'PatientGroupController@show');

    Route::post('patient_groups', 'PatientGroupController@store');

    Route::put('patient_groups/{patientGroup}', 'PatientGroupController@update');

    Route::delete('patient_groups/{patientGroup}', 'PatientGroupController@delete');

    /*
     * Route PatientImpression Api
     */
    Route::get('patient_impressions', 'PatientImpressionController@index');

    Route::get('patient_impressions/{patientImpression}', 'PatientImpressionController@show');

    Route::post('patient_impressions', 'PatientImpressionController@store');

    Route::put('patient_impressions/{patientImpression}', 'PatientImpressionController@update');

    Route::delete('patient_impressions/{patientImpression}', 'PatientImpressionController@delete');

    /*
     * Route PatientMember Api
     */
    Route::get('patient_members', 'PatientMemberController@index');

    Route::get('patient_members/{patientMember}', 'PatientMemberController@show');

    Route::post('patient_members', 'PatientMemberController@store');

    Route::put('patient_members/{patientMember}', 'PatientMemberController@update');

    Route::delete('patient_members/{patientMember}', 'PatientMemberController@delete');

    /*
     * Route PatientProfession Api
     */
    Route::get('patient_professions', 'PatientProfessionController@index');

    Route::get('patient_professions/{patientProfession}', 'PatientProfessionController@show');

    Route::post('patient_professions', 'PatientProfessionController@store');

    Route::put('patient_professions/{patientProfession}', 'PatientProfessionController@update');

    Route::delete('patient_professions/{patientProfession}', 'PatientProfessionController@delete');

    /*
     * Route PatientSource Api
     */
    Route::get('patient_sources', 'PatientSourceController@index');

    Route::get('patient_sources/{patientSource}', 'PatientSourceController@show');

    Route::post('patient_sources', 'PatientSourceController@store');

    Route::put('patient_sources/{patientSource}', 'PatientSourceController@update');

    Route::delete('patient_sources/{patientSource}', 'PatientSourceController@delete');

    /*
     * Route PatientVisit Api
     */
    Route::get('patient_visits', 'PatientVisitController@index');

    Route::get('patient_visits/{patientVisit}', 'PatientVisitController@show');

    Route::post('patient_visits', 'PatientVisitController@store');

    Route::put('patient_visits/{patientVisit}', 'PatientVisitController@update');

    Route::delete('patient_visits/{patientVisit}', 'PatientVisitController@delete');

    /*
     * Route PatientRecyclingBin Api
     */
    Route::get('patient_recycling_bin', 'PatientRecyclingBinController@index');

    Route::get('patient_recycling_bin/{patientVisit}', 'PatientRecyclingBinController@show');

    Route::post('patient_recycling_bin', 'PatientRecyclingBinController@store');

    Route::put('patient_recycling_bin/{patientVisit}', 'PatientRecyclingBinController@update');

    Route::delete('patient_recycling_bin/{patientVisit}', 'PatientRecyclingBinController@delete');
    //lw
    Route::get('appointment/getCaseNumber','PatientController@getCaseNumber');

    Route::get('appointment/getTodayAppointment','AppointmentController@getTodayAppointment');

    Route::get('appointment/getByIdAppointment','AppointmentController@getByIdAppointment');

    Route::post('appointment/add_appointment','AppointmentController@addAppointment');

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







