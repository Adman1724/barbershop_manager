<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{

    public function EmployeesPayouts(){
        return $this->hasMany('App\EmployeesPayout');
    }
    

}
