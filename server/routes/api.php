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

Route::group(['namespace'=>'Api','middleware' => ['auth:api','check']], function(){


    Route::get('potential_demands', 'PotentialDemandController@index');

    Route::post('potential_demands', 'PotentialDemandController@store');

    Route::delete('potential_demands/{potentialDemand}', 'PotentialDemandController@delete');

    /*
     * Patient Consult Base Demand Config Api
     */
    Route::get('base_demands', 'BaseDemandController@index');

    Route::post('base_demands', 'BaseDemandController@store');

    Route::delete('base_demands/{baseDemand}', 'BaseDemandController@delete');



    /*
     * Patient VisitItem Config Api
     * author by han
     */
    Route::get('visit_items', 'VisitItemController@index');

    Route::get('visit_items/get_by_id', 'VisitItemController@getById');

    Route::post('visit_items', 'VisitItemController@addData');

    Route::put('visit_items/', 'VisitItemController@update');

    Route::delete('visit_items/{id}', 'VisitItemController@delete');


    /*
    * Patient VisitContent Config Api
    * author by han
    */

    Route::get('visit_contents', 'VisitContentController@index');

    Route::get('visit_contents/get_by_id', 'VisitContentController@getById');

    Route::post('visit_contents', 'VisitContentController@addData');

    Route::put('visit_contents/', 'VisitContentController@update');

    Route::delete('visit_contents/{id}', 'VisitContentController@delete');


    /*
    * Patient VisitCombo Config Api
    * author by han
    */

    Route::get('visit_combos', 'VisitComboController@index');

    Route::get('visit_combos/get_by_id', 'VisitComboController@getById');

    Route::post('visit_combos', 'VisitComboController@addData');

    Route::put('visit_combos/', 'VisitComboController@update');

    Route::delete('visit_combos/{id}', 'VisitComboController@delete');

    /*
    * Patient VisitResult Config Api
    * author by han
    */

    Route::get('visit_results', 'VisitResultController@index');

    Route::get('visit_results/get_by_id', 'VisitResultController@getById');

    Route::post('visit_results', 'VisitResultController@addData');

    Route::put('visit_results/', 'VisitResultController@update');

    Route::delete('visit_results/{id}', 'VisitResultController@delete');


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

    Route::get('patients', 'PatientController@index');

    Route::get('patients/get_by_id', 'PatientController@show');

    Route::get('patients/resource', 'PatientController@resource');

    Route::post('patients', 'PatientController@store');

    Route::put('patients', 'PatientController@update');

    Route::delete('patients/{id}', 'PatientController@delete');

//    Route::get('patients/generate','PatientController@getCaseNumber');

    Route::get('patients/search_by_name','PatientController@searchByName');

//    Route::get('patients/attend_doctor','PatientController@attendDoctor');

    Route::get('patients/today_work','TodayWorkController@todayWork');

    Route::delete('patients/today_work/{id}', 'TodayWorkController@deleteTodayWork');

    Route::get('patients/all_patient', 'AllPatientsController@allPatient');

    Route::get('patients/recent_visit','RecentVisitController@recentVisitPatient');

    Route::get('patients/appoint','PatientAppointController@show');

    Route::get('patients/treat','PatientTreatmentController@show');




    /*
     * Route OperationLog Api
     * created for yu
     */
    Route::get('operation_log', 'OperationLogController@operationLogList');//日志列表

    Route::get('operation_log/get_user_list','OperationLogController@getUserList');//下拉用户列表

    Route::get('operation_log/get_module_list','OperationLogController@getModuleList');//下拉模块选项



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

    Route::get('patient_cases/get_by_id', 'PatientCaseController@show');

    Route::post('patient_cases', 'PatientCaseController@store');

    Route::get('patient_cases/get_template', 'PatientCaseMenuController@index');

    Route::get('patient_cases/get_template_by_id', 'PatientCaseMenuController@getById');

    Route::get('patient_cases/get_medical', 'PatientCaseMedicalController@index');

    Route::get('patient_cases/get_medical_by_id', 'PatientCaseMedicalController@getById');


    /*
    * Route patient_disposal Api
    */
    Route::get('patient_disposal', 'PatientDisposalController@index');

    Route::get('patient_disposal/get_by_id', 'PatientDisposalController@show');

    Route::post('patient_disposal', 'PatientDisposalController@store');

    Route::get('patient_disposal/categories', 'PatientDisposalController@categories');

    Route::get('patient_disposal/all_disposals', 'PatientDisposalController@allDisposals');


    /*
    * Route PatientCharge Api
    */
    Route::get('patient_charge', 'PatientChargeController@index');

    Route::get('patient_charge/get_by_id', 'PatientChargeController@show');

    Route::post('patient_charge', 'PatientChargeController@store');

    /*
     * Route PatientConsult Api
     */
    Route::get('patient_consults', 'PatientConsultController@index');

    Route::get('patient_consults/patient_id', 'PatientConsultController@show');

    Route::get('patient_consults/get_by_id', 'PatientConsultController@getById');

    Route::post('patient_consults', 'PatientConsultController@store');

    Route::put('patient_consults', 'PatientConsultController@update');

    Route::delete('patient_consults/{id}', 'PatientConsultController@delete');

    Route::get('patient_consults/consult_info','PatientConsultController@consultInfoList');

    Route::get('patient_consults/default_record','PatientConsultController@defaultRecorder');



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

    Route::get('patient_visits/get_by_id', 'PatientVisitController@show');

    Route::post('patient_visits', 'PatientVisitController@store');

    Route::put('patient_visits', 'PatientVisitController@update');

    Route::delete('patient_visits/{id}', 'PatientVisitController@delete');

    Route::get('patient_visits/visit_info', 'PatientVisitController@visitInfo');

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
    Route::get('appointment/getCaseNumber','AppointmentController@getCaseNumber');

    Route::get('PatientController/attendDoctor','AppointmentController@getDoctor');

    Route::get('appointment/getTodayAppointment','AppointmentController@getTodayAppointment');

    Route::get('appointment/getListAppointment','AppointmentController@getListAppointment');

    Route::get('appointment/getByIdAppointment','AppointmentController@getByIdAppointment');

    Route::get('appointment/getPatientByPhone','AppointmentController@getPatientByPhone');

    Route::post('appointment/add_appointment','AppointmentController@addAppointment');

    Route::post('appointment/getWeekAppointment','AppointmentController@getWeekAppointment');

    Route::get('appointment/clinicPatientSource','ClinicOperationController@clinicPatientSource');

    Route::get('appointment/clinicVisitData','ClinicOperationController@clinicVisitData');

    Route::get('appointment/clinicAppointData','ClinicOperationController@clinicAppointData');

    Route::get('appointment/clinicAppointItemData','ClinicOperationController@clinicAppointItemData');

    Route::get('appointment/clinicAppointStatusData','ClinicOperationController@clinicAppointStatusData');
});



Route::group(['namespace'=>'Api'],function (){

    Route::post('test','LoginController@test');

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

    Route::put('patient_recycling_bin', 'PatientRecyclingBinController@update');//修改

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

    Route::get('disposal/export','DisposalController@export');//导出

    Route::post('disposal/import','DisposalController@import');//导入

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


    /*
     * Route PrivilegeController Api
     * created for yu
     */

    // Route::get('privilege','PrivilegeController@index');//菜单列表
    Route::get('privilege/get_user_privilege','PrivilegeController@getUserPrivilege');//获取个人权限

    Route::get('privilege/get_by_type','PrivilegeController@getByType');//根据类型获取权限

    Route::get('privilege/get_by_id','PrivilegeController@getById');//根据id获取

    Route::post('privilege', 'PrivilegeController@addData');//添加

    Route::put('privilege', 'PrivilegeController@update');//修改

    Route::delete('privilege/{id}', 'PrivilegeController@delete');//删除


    /*
     * Route RoleController Api
     * created for yu
     */

    Route::get('role','RoleController@index');//角色菜单列表

    Route::get('role/get_by_id','RoleController@getById');//根据id获取

    Route::post('role', 'RoleController@addData');//添加

    Route::put('role', 'RoleController@update');//修改

    Route::delete('role/{id}', 'RoleController@delete');//删除

    /*
     * Route PatientOrderController Api
     * created for yu
     */

    Route::get('patient_order','PatientOrderController@index');//列表

    Route::get('patient_order/export','PatientOrderController@export');//导出

    /*
     * Route ExpenditureController Api
     * created for yu
     */

    Route::get('expenditure','ExpenditureController@index');//列表

    Route::get('expenditure/get_by_id','ExpenditureController@getById');//根据id获取

    Route::post('expenditure', 'ExpenditureController@addData');//添加

    Route::put('expenditure', 'ExpenditureController@update');//修改

    Route::delete('expenditure/{id}', 'ExpenditureController@delete');//删除

    Route::get('expenditure/export','ExpenditureController@export');//导出

    Route::get('expenditure/get_select','ExpenditureController@getSelect');//列表


    /*
     * Route ExpenditureTypeController Api
     * created for yu
     */

    Route::get('expenditure_type','ExpenditureTypeController@index');//列表

    Route::get('expenditure_type/get_by_id','ExpenditureTypeController@getById');//根据id获取

    Route::post('expenditure_type', 'ExpenditureTypeController@addData');//添加

    Route::put('expenditure_type', 'ExpenditureTypeController@update');//修改

    Route::delete('expenditure_type/{id}', 'ExpenditureTypeController@delete');//删除

    /*
     * Route ExpenditureMethodController Api
     * created for yu
     */

    Route::get('expenditure_method','ExpenditureMethodController@index');//列表

    Route::get('expenditure_method/get_by_id','ExpenditureMethodController@getById');//根据id获取

    Route::post('expenditure_method', 'ExpenditureMethodController@addData');//添加

    Route::put('expenditure_method', 'ExpenditureMethodController@update');//修改

    Route::delete('expenditure_method/{id}', 'ExpenditureMethodController@delete');//删除

    /*
     * Route ReconCalendarController Api
     * created for yu
     */

    Route::get('recon_calendar','ReconCalendarController@index');//列表

    /*
     * Route ExpenditureStatisticsController Api
     * created for yu
     */

    Route::get('expenditure_statistics','ExpenditureStatisticsController@index');//列表

    Route::get('expenditure_statistics/export','ExpenditureStatisticsController@export');//导出

    Route::get('expenditure_statistics/get_select','ExpenditureStatisticsController@getSelect');//下拉列表

    /*
     * Route ArrearageStatisticsController Api
     * created for yu
     */

    Route::get('arrearage_statistics','ArrearageStatisticsController@index');//列表

    Route::get('arrearage_statistics/export','ArrearageStatisticsController@export');//导出

    /*
     * Route FlowSheetController Api
     * created for yu
     */

    Route::get('flow_sheet','FlowSheetController@index');//列表

    Route::get('flow_sheet/export','FlowSheetController@export');//导出

    Route::get('flow_sheet/get_select','FlowSheetController@getSelect');//下拉列表




});

    
Route::group(['namespace'=>'Api'], function(){

    Route::get('test','Test@test');//测试接口
});
    

