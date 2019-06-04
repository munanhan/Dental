<?php
/*
  自定义字段验证配置
*/
/*备注：使用方法，控制器 => [ '方法名' => [ '字段名' => '验证规则' ] ],
  验证方法:  addData => 增，
            getById => 使用id获取，
            update => 改，
            delete => '删除'
            当update的规则没有设置的时候，会自动获取addData的规则进行设置验证
            getById 和 delete 不填的时候会选取common数组进行验证

  类型判断和大小判断顺序不能相反，否则会报错.即要先判断类型，只有数字才能进行大小判断.
/ 验证规则: unique(必填)/normal(非必填):字段描述
           type(类型): int(整形)/float(浮点)/array(数组)/object(对象)/number(数字)
           min(限制最小): 数字
           max(限制最大): 数字
           后续再补充...

  每次修改完此文件，必须要刷新配置缓存，否则不会生效
  指令：php artisan config:cache
*/
return [
    'CommonDelete' => [ 'id' => 'unique:id|type:int' ],
    'CommonGetById' => [ 'id' => 'unique:id|type:int' ],

    'DisposalComboController' => [
                                    'index'   =>  [ 'combo_id' => 'unique:组合id|type:int' ],
                                    'getById' =>  [ 'combo_id' => 'unique:组合id|type:int',
                                                    'disposal_id' => 'unique:处方id|type:int'
                                                  ],
                                    'update'  =>  [ 'combo_id' => 'unique:组合id|type:int',
                                                    'disposal_id' => 'unique:处方id|type:int',
                                                    'combo_qty' => 'unique:处方数量|type:int|min:1|max:1000'
                                                  ],
                                    'getList' =>  [ 'id' => 'unique:组合id|type:int' ],
                                    'addData' =>  [ 'combo_id' => 'unique:组合id|type:int' ],
                                    'delete'  =>  [ 'disposal_id' => 'unique:处置id|type:int' ]
                                 ],

    'MemberController' => [
                              'getById' => [ 'id' => 'unique:id|type:int' ],
                              'update'  => [ 'id' => 'unique:id|type:int',
                                             'member_id' => 'unique:会员等级|type:int'
                                           ] 
                          ], 

    'ClinicController' => [
                             'getById' =>  [ 'id' => 'unique:id|type:int' ],
                             'update' => [ 'id' => 'unique:id|type:int',
                                           'clinic_name' => 'unique:诊所名|type:string',
                                           'contact' =>  'unique:联系人|type:string',
                                           'phone' => 'unique:电话|type:int',
                                           'industry_name' => 'unique:工商祖册名|type:string',
                                           'license_no' => 'unique:营业执照号',
                                           'license_image_url' => 'unique:营业执照照片',
                                           'card_image_url' => 'unique:身份证照片'
                                         ]
                          ],

    'CompanyController' => [ 
                              'getById' =>  [ 'id' => 'unique:id|type:int' ],
                              'update' => [ 'id' => 'unique:id|type:int',
                                            'contact' => 'unique:企业联系人|type:string',
                                            'phone' => 'unique:联系电话|type:int'
                                          ],

                           ],

    'PatientMemberController'=>[
        'store'=>[
            'name'=>'unique:会员等级|type:string',
            'discount'=>'unique:折扣|type:int|min:1|max:100',
        ],
        'addData'=>[
            'name'=>'unique:会员等级|type:string',
            'discount'=>'unique:折扣|type:int|min:1|max:100',
        ]

    ],

    'PatientCategoryController'=>[
      'store'=>[
          'name'=>'unique:患者分类|type:string',
      ]
    ],

    'PatientTeethHabitController'=>[
        'store'=>[
            'name'=>'unique:洁牙习惯|type:string',
        ]
    ],

    'CaseTemplateMenuController' => [
                                         'addData' => [ 'outline_name' => 'unique:菜单目录|type:string' ],


                                    ],

    'MedicalController' => [
                              'addData' => [ 'medical_content' => 'unique:病史配置|type:string',
                                             'type' => 'unique:类型|type:int' 
                                           ],
                           ],

    'InspectController' => [
                              'addData' => [ 'inspect_content' => 'unique:检查配置|type:string',
                                             'type' => 'unique:类型|type:int' 
                                           ],
                           ],

    'DiagnoseController' => [
                              'addData' => [ 'diagnose_content' => 'unique:诊断配置|type:string',
                                             'type' => 'unique:类型|type:int' 
                                           ],
                           ],

    'TreatController' => [
                              'addData' => [ 'treat_name' => 'unique:治疗配置|type:string',
                                             'type' => 'unique:类型|type:int' 
                                           ],
                           ],

    'AdviceController' => [
                              'addData' => [ 'advice_name' => 'unique:医嘱|type:string' ],
                           ],

];
