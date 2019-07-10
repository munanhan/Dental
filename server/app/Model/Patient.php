<?php

namespace App\Model;

use App\Events\CreatingEvent;
use App\Events\RecordEvent;
use App\Events\UpdatingEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{

    use SoftDeletes;
    protected $dates = ['delete_at'];
    protected $guarded=['id',];

    protected $dispatchesEvents=[
        'creating'=>CreatingEvent::class,
        'updating'=>UpdatingEvent::class,
        'retrieved'=>RecordEvent::class,
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function patientCases()
    {
        return $this->hasMany(PatientCase::class);
    }

    public function patientVisits()
    {
        return $this->hasMany(PatientVisit::class);
    }

    public function setAllergyAttribute($value)
    {
        $value=empty($value) ? "" : implode(',',$value);
        $this->attributes['allergy']=$value;
    }

    public function getAllergyAttribute($value)
    {
        $data="";
        if(empty($value)){
            return $data;
        }else{
            $value=explode(',',$value);
            $allergy=PatientAllergy::whereIn('id',$value)->select('name')->get();
            $result=json_decode(json_encode($allergy),true);

            $data=implode(',',array_column($result,'name'));

            return $data;
        }

    }

    public function getTeethHabitsAttribute($value)
    {
        $teeth=PatientTeethHabit::where('id',$value)->first();
        return $teeth->name;
    }

    public function getAnamnesisAttribute($value)
    {
        $data="";
        if(empty($value)){
            return $data;
        }else{
            $value=explode(',',$value);
            $allergy=PatientAnamnesis::whereIn('id',$value)->select('name')->get();
            $result=json_decode(json_encode($allergy),true);

            $data=implode(',',array_column($result,'name'));

            return $data;
        }
    }

    public function getPatientBirthdayAttribute($value)
    {
        return date('Y-m-d',strtotime($value));
    }

    public function getMemberIdAttribute($value)
    {
        $member=PatientMember::where('id',$value)->first();
        return $member->name;
    }

    public function getPatientProfessionAttribute($value)
    {
        $member=PatientProfession::where('id',$value)->first();
        return $member->name;
    }

    public function getPatientSexAttribute($value)
    {
        $group=[
            0=>'男',
            1=>'女',
            2=>'未填'
        ];
        return $group[$value];
    }

    public function getPatientSourceAttribute($value)
    {
        $member=PatientSource::where('id',$value)->first();
        return $member->name;
    }

    public function getPatientCategoryAttribute($value)
    {
        $member=PatientCategory::where('id',$value)->first();
        return $member->name;
    }

    public function getCounselorAttribute($value)
    {
        return $this->getUserById($value)->name;
    }

    public function getGridConsultingAttribute($value)
    {
        return $this->getUserById($value)->name;
    }

    protected function getUserById($id)
    {
        return User::where('id',$id)->first();
    }

    public function setAnamnesisAttribute($value)
    {
        $value=empty($value) ? "" : implode(',',$value);
        $this->attributes['anamnesis']= $value;
    }

    public function getPatientGroupAttribute($value)
    {
        $group=[
          0=>'最近患者',
          1=>'黑名单',
          2=>'治疗完成'
        ];
        return $group[$value];
    }

}
