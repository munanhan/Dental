<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/19
 * Time: 17:55
 */

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;


class PatientCaseMenuController extends CaseTemplateMenuController
{
    public function __construct(Request $request)
    {
        $action = explode('@',\Route::current()->getActionName());
        switch ($action[1]){
            case 'index':
                $this->table = 'case_template_menus';
                break;
            case 'getById':
                $this->table = 'case_templates';
                break;
        }
        parent::__construct($request);
    }


}