<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/19
 * Time: 18:17
 */

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

class PatientCaseMedicalController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->table = 'medicals';
        parent::__construct($request);
    }
}