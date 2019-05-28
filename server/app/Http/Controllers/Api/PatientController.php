<?php

namespace App\Http\Controllers\Api;

use App\Model\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

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
        $patient=Patient::create($request->all());

        return message('',$patient);
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

    public function intraday()
    {
        $patients=Patient::withCount('appointments')->get();

        dd($patients);
        foreach ($patients as $patient) {
            echo $patient->appointments_count;
        }
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

        $serial['case_id']=$date.$seq;

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


}
