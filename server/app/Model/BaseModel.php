<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Events\CreatingEvent;
use App\Events\UpdatingEvent;
use Illuminate\Support\Facades\Auth;

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

		public function getData($parms = []){
			return $this->where($parms)->get();
		}

		public function getById($parms = []){
			return $this->where($parms)->first();
		}

		public function getCount($parms = []){
			return $this->where($parms)->count();
		}

		public function updateData($parms = []){
			$parms['update']['updated_at'] = date('Y-m-d H:i:s',time());
            $parms['update']['updated_by'] = Auth::user()['name'];
			return $this->where($parms['where'])->update($parms['update']);
		}

		public function deleteData($parms = []){
			return $this->where($parms)->delete();
		}

		public function insertData($parms = []){
			return $this->insert($parms);
		}

		public function insertDataGetId($parms = []){
			$parms['created_at'] = date('Y-m-d H:i:s',time());
            $parms['created_by'] = Auth::user()['name'];
			return $this->insertGetId($parms);
		}
}
