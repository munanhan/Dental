<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ExpenditureController;
use Illuminate\Support\Facades\DB;

       
class FlowSheetController extends BaseController
{

	public function __construct(Request $request){

		$this->table = 'patient_orders';

		$this->field = [ 'charge_date,case_id,patient_name,patient_orders.id,charging_type,receivable,receipts,a.name as doctor,b.name as chshier,'.$this->setCaseThen() ];

		$this->join = [
						  'patients' => 'patients.id = patient_orders.patient_id',
						  'users a' => 'a.id = patient_orders.doctor_id',
						  'users b' => 'b.id = patient_orders.cashier_id',
						  'chargings' => 'chargings.id = patient_orders.charge_id'
					  ];

		$this->search_date = [ 'charge_date' ];

		$this->export = [
							'charge_date' => '单据时间',
							'case_id' => '病历号',
							'patient_name' => '患者姓名',
							'status' => '单据状态',
							'id' => '单据编号',
							'charging_type' => '收费类型',
							'receivable' => '应收',
							'receipts' => '实收',
							'chshier' => '收银员',
							'doctor' => '医生' 
					    ];
		 
		parent::__construct($request);

	}

	public function getSelect(){
		//获取下拉
		$data = DB::table('users')->get(['id','name']);

		return message('成功',$data,200);
	}

	public function setCaseThen(){
		//case then
        $_case = [
                    'data' => [ 0 => '未收费',1 => '正常收费',2 => '退费' ],
                    'table' => 'patient_orders',//表
                    'field' => 'status'
                 ];
        return caseThen($_case);
	}
}
