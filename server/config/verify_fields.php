<?php
/*
  自定义字段验证配置
*/
/*备注：使用方法，控制器 => [ '方法名' => [ '字段名' => '验证规则' ] ],
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

    'AreaController' => [
                            'getById' => [ 'province_id' => 'unique:省份id|type:int',
                                           'city_id' => 'unique:城市id|type:int',
                                         ] 
                        ]

];
