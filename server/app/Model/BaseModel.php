<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Events\CreatingEvent;
use App\Events\UpdatingEvent;

class BaseModel extends Model
{

    protected $guarded = [
            'id',
        ];

    protected $dispatchesEvents = [
    		'creating' => CreatingEvent::class,
    		'updating' => UpdatingEvent::class,
    	];

	public function __construct($table){
		$this->table = $table;
	}

	public function getData(){
		return $this->all();
	}
}
