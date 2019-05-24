<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;

class MemberController extends BaseController
{

    public function __construct(Request $request){
        $this->table = 'patients';
        //表
        $this->join = [
                         'patient_orders' => 'patients.id = patient_orders.patient_id',
                         'patient_members' => 'patient_members.id = patients.member_id'
                      ];
        //连表
        $this->group = ['patients.id'];
        //分组group
        $this->field = 'patients.id,patients.name,case_id,age,sex,phone,phone as member_card,patient_members.name as member_level,sum(receipts) as receipts,patients.updated_at,member_id';
        //表字段
        $this->replace_field = ['name' => 'patients.name','start_money' => '','end_money' => ''];
        //过滤字段
        $this->having = [ 
                            'start_money' => ['sum(receipts)','>','start_money'],
                            'end_money' => ['sum(receipts)','<','end_money']
                        ];
        //having筛选条件
        parent::__construct($request);
    }


}
