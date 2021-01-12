<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeesPayout extends Model
{
    protected $fillable = [
        'payout_id' , 'employee_id', 'holiday', 'first_part', 'second_part', 'lunch_card', 'overtime','worked_hour',
    ];

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
