<?php

namespace App\Model;

use App\Events\CreatingEvent;
use App\Events\UpdatingEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
        use SoftDeletes;
        protected $dates = ['delete_at'];
        protected $guarded=['id',];
        protected $dispatchesEvents=[
            'creating'=>CreatingEvent::class,
            'updating'=>UpdatingEvent::class,
//            'retrieved'=>RecordEvent::class,
        ];

        public function patient()
        {
            $this->belongsTo(Patient::class);
        }
}
