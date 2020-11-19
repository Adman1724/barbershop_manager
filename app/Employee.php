<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $fillable = [
        'name', 'email', 'username','surname','wage',
    ];

    public function EmployeesPayouts(){
        return $this->hasMany('App\EmployeesPayout');
    }
}
