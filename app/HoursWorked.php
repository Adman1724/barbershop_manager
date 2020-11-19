<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoursWorked extends Model
{
    //
    public function EmployeesPayout(){
        return $this->belongsTo('App\EmployeesPayout');
    }
    public function HoursWorkedServices(){
        return $this->hasMany('App\HoursWorkedService');
    }
}
