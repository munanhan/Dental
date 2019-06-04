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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/*
 * We can improve the endpoints by using implicit route model binding.
 * This way, Laravel will inject the User instance in our methods and automatically return a 404 if it isn’t found.
 * We’ll have to make changes on the routes file and on the controller:
 */

Route::group(['namespace'=>'Api','middleware' => 'auth:api'], function(){

    /*
     * Route Patient Config Api
     */

    Route::get('patients/resource', function () {
        return  new \App\Http\Resources\PatientCollection(\App\Model\Patient::all());
    });

    /*
     * Route PatientConsult Config Api
     */

    Route::get('consults/resource',function (){
        return new \App\Http\Resources\PatientConsultCollection(\App\Model\PatientConsult::all());
    });

    /*
     * Patient Visit Config Api
     * author by han
     */
    Route::get('visit_items', 'VisitItemController@index');

    Route::get('visit_items/{visitItem}', 'VisitItemController@show');

    Route::post('visit_items', 'VisitItemController@store');

    Route::put('visit_items/{visitItem}', 'VisitItemController@update');

    Route::delete('visit_items/{visitItem}', 'VisitItemController@delete');

    //批量删除
    Route::delete('visit_items','VisitItemController@deleteById');


    /*
     * Route User APi
     */
    Route::get('user','UserController@getCurrentUser');

    Route::get('users', 'UserController@index');

    Route::get('users/{user}', 'UserController@show');

    Route::post('users', 'UserController@store');

    Route::put('users/{user}', 'UserController@update');


    /*
     * Route Patient Api
     */

    Route::get('patients/generate','PatientController@getCaseNumber');

    Route::get('patients', 'PatientController@index');

    Route::get('patients/{patient}', 'PatientController@show');

    Route::post('patients', 'PatientController@store');

    Route::put('patients/{patient}', 'PatientController@update');

    Route::delete('patients/{patient}', 'PatientController@delete');

    Route::get('patient/intraday','PatientController@intraday');


    /*
     * Route OperationLog Api
     * created for yu
     */
    Route::get('operation_log', 'operationLogController@operationLogList');//日志列表

    Route::get('operation_log/get_user_list','operationLogController@getUserList');//下拉用户列表

    Route::get('operation_log/get_module_list','operationLogController@getModuleList');//下拉模块选项



    /*
     * Route patientCategory Api
     */
    Route::get('patient_categories', 'PatientCategoryController@index');

    Route::get('patient_categories/{patientCategory}', 'PatientCategoryController@show');

    Route::post('patient_categories', 'PatientCategoryController@store');

    Route::put('patient_categories/{patientCategory}', 'PatientCategoryController@update');

    Route::delete('patient_categories/{patientCategory}', 'PatientCategoryController@delete');

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
     * Route PatientCategory Api
     */
    Route::get('patient_groups', 'PatientCategoryController@index');

    Route::get('patient_groups/{patientGroup}', 'PatientCategoryController@show');

    Route::post('patient_groups', 'PatientCategoryController@store');

    Route::put('patient_groups/{patientGroup}', 'PatientCategoryController@update');

    Route::delete('patient_groups/{patientGroup}', 'PatientCategoryController@delete');

     /*
     * Route PatientTeethHabit Api
     */
    Route::get('patient_teeth_habits', 'PatientTeethHabitController@index');

    Route::get('patient_teeth_habits/{patientTeethHabit}', 'PatientTeethHabitController@show');

    Route::post('patient_teeth_habits', 'PatientTeethHabitController@store');

    Route::put('patient_teeth_habits/{patientTeethHabit}', 'PatientTeethHabitController@update');

    Route::delete('patient_teeth_habits/{patientTeethHabit}', 'PatientTeethHabitController@delete');

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
    // Route::get('patient_members', 'PatientMemberController@index');

    // Route::get('patient_members/{patientMember}', 'PatientMemberController@show');

    // Route::post('patient_members', 'PatientMemberController@store');

    // Route::put('patient_members/{patientMember}', 'PatientMemberController@update');

    // Route::delete('patient_members/{patientMember}', 'PatientMemberController@delete');

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
     * Route PatientAllergy Api
     */
    Route::get('patient_allergies', 'PatientAllergyController@index');

    Route::get('patient_allergies/{patientAllergy}', 'PatientAllergyController@show');

    Route::post('patient_allergies', 'PatientAllergyController@store');

    Route::put('patient_allergies/{patientAllergy}', 'PatientAllergyController@update');

    Route::delete('patient_allergies/{patientAllergy}', 'PatientAllergyController@delete');

      
    /*
     * Route PatientAnamnesis Api
     */
    Route::get('patient_anamnesis', 'PatientAnamnesisController@index');

    Route::get('patient_anamnesis/{patientAnamnesis}', 'PatientAnamnesisController@show');

    Route::post('patient_anamnesis', 'PatientAnamnesisController@store');

    Route::put('patient_anamnesis/{patientAnamnesis}', 'PatientAnamnesisController@update');

    Route::delete('patient_anamnesis/{patientAnamnesis}', 'PatientAnamnesisController@delete');


    // Route::delete('patient_recycling_bin/{patientVisit}', 'PatientRecyclingBinController@delete');
    //lw
    Route::get('appointment/getCaseNumber','PatientController@getCaseNumber');

    Route::get('appointment/getTodayAppointment','AppointmentController@getTodayAppointment');

    Route::get('appointment/getListAppointment','AppointmentController@getListAppointment');

    Route::get('appointment/getByIdAppointment','AppointmentController@getByIdAppointment');

    Route::get('appointment/getPatientByPhone','AppointmentController@getPatientByPhone');

    Route::post('appointment/add_appointment','AppointmentController@addAppointment');

    Route::post('appointment/getWeekAppointment','AppointmentController@getWeekAppointment');
});



Route::group(['namespace'=>'Api'],function (){

    Route::post('login','LoginController@login');

    Route::put('logout','LoginController@logout');

    Route::post('registration','RegisterController@register');

    Route::post('refreshment','LoginController@refreshToken');

    Route::get('message','UserController@getMessage');

    Route::get('password',function (){
        return \Illuminate\Support\Facades\Hash::make(request('password'));
    });

    /*
     * 获取地区省
     */
    Route::get('areas/province','AreaController@getProvince');


    // Route::get('publish', function () {
    //     // Route logic...

    //     Redis::publish('test-channel', json_encode(['foo' => 'bar']));
    // });
   


    Route::post('appointment/getWeekAppointment','AppointmentController@getWeekAppointment');

    Route::post('appointment/getMonthAppointment','AppointmentController@getMonthAppointment');

    Route::post('appointment/changeAppointmentStatus','AppointmentController@changeAppointmentStatus');

});

/*
 * Route for yu api,middleware => ['auth:api','check']
 *
 */

Route::group(['namespace'=>'Api','middleware' => ['auth:api','check']], function(){
    /*
     * Route DisposalConbo Api
     * created for yu
     */
    Route::get('disposal_combo','DisposalComboController@index');//处置列表

    Route::post('disposal_combo', 'DisposalComboController@addData');//添加

    Route::get('disposal_combo/get_by_id','DisposalComboController@getById');//根据id获取数量

    Route::get('disposal_combo/get_list','DisposalComboController@getList');//根据id获取列表

    Route::put('disposal_combo', 'DisposalComboController@update');//修改

    Route::delete('disposal_combo/{id}', 'DisposalComboController@delete');//删除

     /*
     * Route PatientMember Api
     * created for yu
     */
    Route::get('patient_member','PatientMemberController@index');//处置列表

    Route::post('patient_member', 'PatientMemberController@addData');//添加

    Route::get('patient_member/get_by_id','PatientMemberController@getById');//根据id获取数量

    Route::put('patient_member', 'PatientMemberController@update');//修改

    Route::delete('patient_member/{id}', 'PatientMemberController@delete');//删除

    Route::delete('members/{id}','PatientMemberController@deleteMember');

    Route::post('patient_member/update_store','PatientMemberController@store');

     /*
     * Route Member Api
     * created for yu
     */
    Route::get('member','MemberController@index');//列表

    Route::get('member/get_by_id','MemberController@getById');//根据id获取数量

    Route::put('member', 'MemberController@update');//修改

    /*
     * Route PatientRecyclingBin Api 
     * created for yu
     */
    Route::get('patient_recycling_bin', 'PatientRecyclingBinController@index');//患者回收列表

    Route::put('patient_recycling_bin/{id}', 'PatientRecyclingBinController@update');//修改

    Route::delete('patient_recycling_bin/{id}', 'PatientRecyclingBinController@delete');//删除

    Route::post('patient_recycling_bin', 'PatientRecyclingBinController@deleteAll');//批量删除

    /*
     * Route Disposal Api
     * created for yu
     */
    Route::get('disposal','DisposalController@index');//处置列表

    Route::post('disposal', 'DisposalController@addData');//添加

    Route::get('disposal/get_by_id','DisposalController@getById');//根据id获取

    Route::put('disposal', 'DisposalController@update');//修改

    Route::delete('disposal/{id}', 'DisposalController@delete');//删除

    /*
     * Route CostCategory Api
     * created for yu
     */
    Route::get('cost_category','CostCategoryController@index');//费用类型列表

    Route::post('cost_category', 'CostCategoryController@addData');//添加

    Route::put('cost_category', 'CostCategoryController@update');//修改

    Route::delete('cost_category/{id}', 'CostCategoryController@delete');//删除

    /*
     * Route DiisposalComboMenu Api
     * created for yu
     */
    Route::get('disposal_combo_menu','DisposalComboMenuController@index');//处置组合菜单列表

    Route::get('disposal_combo_menu/get_by_id','DisposalComboMenuController@getById');//处置组合id菜单列表

    Route::post('disposal_combo_menu', 'DisposalComboMenuController@addData');//添加

    Route::put('disposal_combo_menu', 'DisposalComboMenuController@update');//修改

    Route::delete('disposal_combo_menu/{id}', 'DisposalComboMenuController@delete');//删除

    /*
     * Route User APi
     * created for yu
     */
    Route::get('staff/user_list','StaffController@userList');//员工列表

    Route::get('staff/get_role','StaffController@getRole');//获取下拉职位

    Route::post('staff/add', 'StaffController@addData');//添加用户

    Route::delete('staff/{id}', 'StaffController@delete');//删除用户

    Route::post('staff/update_password', 'StaffController@updatePassword');//修改密码

    Route::put('staff', 'StaffController@update');//修改用户信息

    Route::get('staff/get_by_id','StaffController@getById');//根据id获取

    /*
     * Route ClinicController Api
     * created for yu
     */
    Route::get('clinic/get_clinic','ClinicController@getClinic');//当前诊所

    Route::get('clinic','ClinicController@index');//诊所列表

    Route::get('clinic/get_by_id','ClinicController@getById');//根据id获取

    Route::post('clinic', 'ClinicController@addData');//添加

    Route::put('clinic', 'ClinicController@update');//修改

    Route::delete('clinic/{id}', 'ClinicController@delete');//删除

    Route::post('clinic/upload','ClinicController@upload');//上传

    /*
     * Route AreaController Api
     * created for yu
     */
    Route::get('areas/get_by_id','AreaController@getById');//根据id获取

    Route::get('areas/city','AreaController@getCityOrCountry');

    /*
     * Route CompanyController Api
     * created for yu
     */

    Route::get('company','CompanyController@index');//公司列表

    Route::get('company/get_by_id','CompanyController@getById');//根据id获取

    Route::post('company', 'CompanyController@addData');//添加

    Route::put('company', 'CompanyController@update');//修改

    Route::delete('company/{id}', 'CompanyController@delete');//删除

    Route::post('company/upload','CompanyController@upload');//上传

    /*
     * Route ChainStoreController Api
     * created for yu
     */

    Route::get('chain_store','ChainStoreController@index');//连锁店管理的员工列表

    Route::put('chain_store', 'ChainStoreController@update');//修改

    /*
     * Route CaseTemplateMenuController Api
     * created for yu
     */

    Route::get('case_template_menu','CaseTemplateMenuController@index');//病历模板的菜单列表

    Route::get('case_template_menu/get_by_id','CaseTemplateMenuController@getById');//根据id获取

    Route::post('case_template_menu', 'CaseTemplateMenuController@addData');//添加

    Route::put('case_template_menu', 'CaseTemplateMenuController@update');//修改

    Route::delete('case_template_menu/{id}', 'CaseTemplateMenuController@delete');//删除


    /*
     * Route CaseTemplateController Api
     * created for yu
     */

    Route::get('case_template','CaseTemplateController@index');//病历模板的菜单列表

    Route::get('case_template/get_by_id','CaseTemplateController@getById');//根据id获取

    Route::post('case_template', 'CaseTemplateController@addData');//添加

    Route::put('case_template','CaseTemplateController@update');//修改

    Route::delete('case_template/{id}', 'CaseTemplateController@delete');//删除

    /*
     * Route MedicalController Api
     * created for yu
     */

    Route::get('medical','MedicalController@index');//病例模板的菜单列表

    Route::get('medical/get_by_id','MedicalController@getById');//根据id获取

    Route::post('medical', 'MedicalController@addData');//添加

    Route::put('medical', 'MedicalController@update');//修改

    Route::delete('medical/{id}', 'MedicalController@delete');//删除

    /*
     * Route InspectController Api
     * created for yu
     */

    Route::get('inspect','InspectController@index');//病例模板的菜单列表

    Route::get('inspect/get_by_id','InspectController@getById');//根据id获取

    Route::post('inspect', 'InspectController@addData');//添加

    Route::put('inspect', 'InspectController@update');//修改

    Route::delete('inspect/{id}', 'InspectController@delete');//删除

    /*
     * Route DiagnoseController Api
     * created for yu
     */

    Route::get('diagnose','DiagnoseController@index');//病例模板的菜单列表

    Route::get('diagnose/get_by_id','DiagnoseController@getById');//根据id获取

    Route::post('diagnose', 'DiagnoseController@addData');//添加

    Route::put('diagnose', 'DiagnoseController@update');//修改

    Route::delete('diagnose/{id}', 'DiagnoseController@delete');//删除

    /*
     * Route TreatController Api
     * created for yu
     */

    Route::get('treat','TreatController@index');//病例模板的菜单列表

    Route::get('treat/get_by_id','TreatController@getById');//根据id获取

    Route::post('treat', 'TreatController@addData');//添加

    Route::put('treat', 'TreatController@update');//修改

    Route::delete('treat/{id}', 'TreatController@delete');//删除

    /*
     * Route AdviceController Api
     * created for yu
     */

    Route::get('advice','AdviceController@index');//病例模板的菜单列表

    Route::get('advice/get_by_id','AdviceController@getById');//根据id获取

    Route::post('advice', 'AdviceController@addData');//添加

    Route::put('advice', 'AdviceController@update');//修改

    Route::delete('advice/{id}', 'AdviceController@delete');//删除







});







