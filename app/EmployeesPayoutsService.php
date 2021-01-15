<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeesPayoutsService extends Model
{
    protected $fillable = [
        'service_id' , 'employees_payout_id', 'multiplicity'
    ];

    public function EmployeesPayout(){
        return $this->belongsTo('App\EmployeesPayout');
    }
   
    public function Service(){
        return $this->belongsTo('App\Service');
    }


}
