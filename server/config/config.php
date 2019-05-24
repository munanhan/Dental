<?php
/*
  自定义配置项
*/

return [

    'allow_origin' => [
        //允许跨域的列表
        'http://localhost:8080',
        'http://127.0.0.1:8080',
        ],

    'module' => [ 
                    'members' => '会员管理',
                    'patient_members' => '会员等级管理',
                    'cost_categories' => '处置收费大类管理',
                    'disposals' => '处置与收费管理',
                    'disposal_combo_menus' => '处置组合菜单管理',
                    'disposal_combos' => '处置组合管理',
                    'patients' => '会员管理',
                    'users' => '员工管理',
                    'patient_recycling_bin' => '患者回收管理'
                ],

    'patient_group' => [
    	//患者分组
    	'最近患者',
    	'黑名单',
    	'治疗完成'
    	],

    'billing_mode'  =>  [
        //收费模式
        1 => '按牙齿收费',
        2 => '按其他收费'
    ],

    'common_status' => [
        //通用状态
        1 => '是',
        0 => '否'
    ]

];
