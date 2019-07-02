<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Model\BaseModel;

use App\Auxiliary\MyDb;
       
class Test
{

	public function index(MyDb $db){
		// $db->set(new BaseModel('users'));
		// dd($db->get()->getData());
		// $args = [1,2,3];
		// $this->test(...$args);

	}

	public function test($file = ''){

		$path = $file == ''?"C:/":$file;

		$res = scandir($path);

		foreach ($res as $k => $v) {
			if ($v == '.' || $v == '..') {
				continue;
			}
			if (is_dir($path.'/'.$v)) {
				$this->test($path.'/'.$v);
			}
			else{
				echo $path.'/'.$v.'<br>';
			}
		}

	}

}
