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
    public function Payout(){
        return $this->belongsTo('App\Payout');
    }
    public function EmployeesPayoutsService(){
        return $this->hasMany('App\EmployeesPayoutsService');
    }
    public static function boot() {
        parent::boot();

        static::deleting(function($employeesPayout) { // before delete() method call this
            $employeesPayout->employeesPayoutsService()->delete();
             // do the rest of the cleanup...
        });
    }


}
