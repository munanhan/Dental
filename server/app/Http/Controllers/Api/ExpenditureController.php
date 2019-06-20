<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
       
class ExpenditureController extends BaseController
{

	public function __construct(Request $request){

		$this->table = 'expenditures';

		$this->search_date = [ 'date' ];//设置搜索时间字段

		$this->setField();

		$this->setJoin();

		parent::__construct($request);

		$this->setWhere();

		$this->setExport();
	}

	public function setWhere(){
		isset($this->parms['expenditure_type']) || !empty($this->parms['expenditure_type'])?$this->where = [['expenditures.expenditure_type','=','expenditure_type']]:'';//where条件

	}

	public function setExport(){
		//设置导出
        $this->export = [ 'date' => '日期',
                          'handler' => '经手人',
                          'charge_person' => '负责人',
                          'expenditure_type' => '支出类别',
                          'expenditure_content' => '支出明细',
                          'expenditure_money' => '支出金额',
                          'expenditure_method' => '付款方式',
                          'remark' => '备注',
                        ];
	}

	public function setJoin(){

		$this->join = [ 'expenditure_methods' => 'expenditure_methods.id = expenditures.expenditure_method',
						'expenditure_types' => 'expenditure_types.id = expenditures.expenditure_type',
						'users' => 'users.id = handler'
					  ];//设置连表
	}

	public function setField(){
		//设置字段
		$this->field = [ 'expenditures.id,date,charge_person,expenditure_content,expenditure_money,remark,expenditure_types.expenditure_type as expenditure_type,expenditure_methods.expenditure_method as expenditure_method,users.name as handler' ];//设置查询字段
	}
	

	public function getSelect(){
		//获取下拉
		$data = [];

		$data['expenditure_type'] = DB::table('expenditure_types')->get(['id','expenditure_type']);
		$data['expenditure_method'] = DB::table('expenditure_methods')->get(['id','expenditure_method']);
		$data['user'] = DB::table('users')->get(['id','name']);

		return message('成功',$data,200);
	}
}
