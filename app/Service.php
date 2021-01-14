<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'price', 'duration'
    ];
    public function EmployeesPayoutsService(){
        return $this->hasMany('App\EmployeesPayoutsService');
    }
}
