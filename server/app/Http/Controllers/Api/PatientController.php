<?php

namespace App\Http\Controllers\Api;

use App\Model\Patient;
use App\Model\PatientInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Schema;

class PatientController extends Controller
{
    const SERIAL_NUMBER="serial.number:";

    const DEFAULT_LENGTH=3;

    public function index()
    {
        return message('',Patient::all());
    }

    public function show(Patient $patient)
    {
        return message('',$patient);
    }

    public function store(Request $request)
    {
        $patient=$this->createPatient($request->all());

        PatientInfoController::createPatientInfo($patient,$request->all());

        return message('',$request->all());
    }

    public function update(Request $request ,Patient $patient)
    {
        $patient->update($request->all());

        return message('',$patient, 200);
    }

    public function delete(Patient $patient)
    {
        $patient->delete();

        return message('',null, 200);
    }

    protected  function getToday()
    {
        return now()->format('Ymd');
    }

    protected  function getCaseNumber()
    {

        $date=$this->getToday();

        $key=self::SERIAL_NUMBER.$date;

        $sequence=Redis::incr($key);

        $seq=$this->getSequence($sequence);

        $serial=$date.$seq;

        return message('',$serial);

    }

    protected function getSequence($seq)
    {
        $len=mb_strlen($seq);

        if($len>=self::DEFAULT_LENGTH){
            return $seq;
        }

        $rest=self::DEFAULT_LENGTH-$len;

        for($i=0;$i<$rest;$i++){
            $seq='0'.$seq;
        }

        return $seq;
    }

    protected function createPatient(array $data)
    {

        $info=Schema::getColumnListing('patient_infos');

        foreach ($info as $key){
            array_key_exists($key,$data);
            unset($data[$key]);
        }

        return Patient::create($data);
    }

}
