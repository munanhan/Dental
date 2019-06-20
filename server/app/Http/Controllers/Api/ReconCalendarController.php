<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
       
class ReconCalendarController extends BaseController
{

	public function __construct(Request $request){

		$this->setField();

		$this->setTable();

		$this->setOrder();

		parent::__construct($request);

	}

	public function index(){

		$expenditure = $this->getData()['data'];
		
		$expenditure_list = [];

		$expenditure_total = 0;

		$temp_key = '';//记录临时的key

		$length = count($expenditure) - 1;//长度

		foreach ($expenditure as $k => $v) {
			$v->expenditure_money = $v->expenditure_money * 100;//精度问题*100处理
			$expenditure_total+= $v->expenditure_money;

			if (!array_key_exists($v->date, $expenditure_list)) {

				if (isset($expenditure_list[$temp_key]['expenditure'])) {
					$expenditure_list[$temp_key]['expenditure'] = $expenditure_list[$temp_key]['expenditure']/100;
				}

				$temp_key = $v->date;//临时key用于区分当前数据是否需要/100处理

				if ($k == $length) {
					$expenditure_list[$v->date]['expenditure'] = $v->expenditure_money/100 + 0;
				}
				else{
					$expenditure_list[$v->date]['expenditure'] = $v->expenditure_money + 0;
					//+0是为了转化成数字 
				}

				continue;
			}

				$expenditure_list[$v->date]['expenditure']+= $v->expenditure_money; 

		}

		
		$sql = 'select charge_date,receipts from patient_orders where charge_date between :dtfm and :dtto order by charge_date';

		$patient_order = getData($sql,$this->date)['data'];

		$order_list = [];

		$receipts_total = 0;

		$temp_key = '';

		$length = count($patient_order)-1;

		foreach ($patient_order as $k => $v) {
			$v->receipts = $v->receipts * 100;
			$receipts_total+= $v->receipts;
			if (!array_key_exists($v->charge_date, $order_list)) {

				if (isset($order_list[$temp_key]['receipts'])) {
					$order_list[$temp_key]['receipts'] = $order_list[$temp_key]['receipts']/100;
				}

				$temp_key = $v->charge_date;//临时key用于区分当前数据是否需要/100处理

				if ($k == $length) {
					$order_list[$v->charge_date]['receipts'] = $v->receipts/100 + 0;
				}
				else{
					$order_list[$v->charge_date]['receipts'] = $v->receipts + 0;
					//+0是为了转化成数字 
				}

				continue;
			}

				$order_list[$v->charge_date]['receipts']+= $v->receipts; 

		}

		return message('成功',[ 'receipts' => $order_list, 
								'expenditure' => $expenditure_list,
								'expenditure_total' => $expenditure_total/100,
								'receipts_total' => $receipts_total/100],200);

		// dd($order_list,$expenditure_list);

	}


	private function setField(){
		$this->field = [ 'date,expenditure_money' ];
	}

	private function setTable(){
		$this->table = 'expenditures';
	}

	private function setOrder(){
		$this->order = [ 'date' => 'asc' ];
	}

	private function setSearch(){
		$this->search_date = [ 'date' ];
	}

}
