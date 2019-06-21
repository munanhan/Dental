<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
       
class ArrearageStatisticsController extends BaseController
{
	//统计欠款人

	public function __construct(Request $request){

		$this->table = 'patient_orders';//表

		$this->field = [ 'charge_date,patient_name,name as doctor,patient_age,patient_phone,patient_address,case_id,sum(arrearage) as arrearage,comment' ];
		//字段

		$this->join = [
						  'patients' => 'patients.id = patient_orders.patient_id',
						  'users' => 'users.id = patient_orders.doctor_id',
					  ];
		//连表

		$this->group = [ 'patient_id' ];
		//分组

		$this->where = [ ['arrearage','>','arrearage'] ];
		//条件

		parent::__construct($request);

		$this->parms['arrearage'] = 0;

		$this->search_date = [ 'charge_date' ];

		$this->set();
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
