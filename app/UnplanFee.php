<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeesPayout extends Model
{
    protected $fillable = [
        'name' , 'employees_payout_id', 'value'
    ];

    public function EmployeesPayout(){
        return $this->belongsTo('App\EmployeesPayout');
    }
    


}
