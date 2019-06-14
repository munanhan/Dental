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

            parent::__construct($request);

        }



}
