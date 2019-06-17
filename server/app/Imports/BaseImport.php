<?php
 
namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

 
class BaseImport implements ToArray
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function Array(array $table)
    {

        // return $table[0];
    }
}
