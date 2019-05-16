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
