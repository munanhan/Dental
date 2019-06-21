<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PatientOrderController extends BaseController
{   

        public function __construct(Request $request){

            $this->field = [ 'charge_date,case_id,patients.patient_name,receivable,discount_amount,receipts,charging_type,arrearage,users.name as doctor,users.name as nurse,users.name as cashier,(select a.arrearage from patient_orders a where patient_orders.patient_id = a.patient_id and patient_orders.charge_date > a.charge_date order by a.charge_date desc limit 1) as last_arrearage' ];

            $this->join = [ 
                              'chargings' => 'patient_orders.charge_id = chargings.id',
                              'patients' => 'patient_orders.patient_id = patients.id',
                              'users' => 'users.id = doctor.id',
                              'users' => 'users.id = patient_orders.nurse_id',
                              'users' => 'users.id = patient_orders.cashier_id'
                          ];

            $this->search_date = [ 'charge_date' ];

            parent::__construct($request);

            $this->set();

            $this->export = [ 'charge_date' => '收费时间',
                              'case_id' => '病历号',
                              'patient_name' => '患者姓名',
                              'receivable' => '本次应收费用',
                              'discount_amount' => '折扣金额',
                              'receipts' => '实收金额',
                              'charging_type' => '收费类型',
                              'arrearage' => '本次欠费',
                              'last_arrearage' => '上次欠费',
                              'doctor' => '负责医生',
                              'nurse' => '负责护士',
                              'cashier' => '收款人'
                            ];

        }

        public function set(){
            //设置参数和条件

            if(isset($this->parms['dim'])){

                $this->where[] = [ '(patients.patient_name','=','patient_name','or' ];
                $this->where[] = [ 'patients.patient_phone','=','phone','or' ];
                $this->where[] = [ 'patients.case_id','=','case_id)' ];

                $this->parms['patient_name'] = $this->parms['dim'];
                $this->parms['phone'] = $this->parms['dim'];
                $this->parms['case_id'] = $this->parms['dim'];

                unset($this->parms['dim']);
            }

        }



}
