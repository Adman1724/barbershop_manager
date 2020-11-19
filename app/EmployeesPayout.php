<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeesPayout extends Model
{
    
    public function Employee(){
        return $this->belongsTo('App\Employee');
    }
    public function HoursWorked(){
        return $this->hasMany('App\HoursWorked');
    }
    public function Payout(){
        return $this->belongsTo('App\Payout');
    }


}
