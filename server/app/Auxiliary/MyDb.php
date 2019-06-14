<?php

namespace App\Auxiliary;
              

class MyDb 
{   
    protected $db;
    public function __construct(){

    }
    public function get(){
        return $this->db;
    }

    public function set($db){
        $this->db = $db;
    }
}


