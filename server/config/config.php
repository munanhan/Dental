<?php
/*
  自定义配置项
*/

return [

    'allow_origin' => [
        //允许跨域的列表
        'http://localhost:8080',
        'http://127.0.0.1:8080',
        'http://192.168.199.175:8082',
        'http://localhost:8082',
        ],

    'expect_route' => [  //排除权限控制的api
                         'api/privilege/get_user_privilege',
                         'api/user',
                         'api/areas/city',
                         'api/areas/get_by_id',
                      ],
                      
    'module' => [ //模块用于自动写入日志，
                  //不填模块就不会自动写入
                    'members' => '会员管理',
                    'patient_members' => '会员等级管理',
                    'cost_categories' => '处置收费大类管理',
                    'disposals' => '处置与收费管理',
                    'disposal_combo_menus' => '处置组合菜单管理',
                    'disposal_combos' => '处置组合管理',
                    'patients' => '会员管理',
                    'users' => '员工管理',
                    'patient_recycling_bin' => '患者回收管理',
                    'clinics' => '诊所管理',
                    'companies' => '公司管理',
                    'chain_stores' => '连锁店管理',
                    'case_template_menus' => '病历模板菜单',
                    'case_templates' => '病例模板',
                    'medicals' => '主诉，现病史，既往病史',
                    'inspects' => '检查，辅助检查',
                    'diagnoses' => '诊断',
                    'treats' => '治疗，治疗方案',
                    'advice' => '医嘱',
                    'expenditures' => '支出',
                    'expenditure_type' => '支出类别',
                    'expenditure_method' => '付款方法',
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
