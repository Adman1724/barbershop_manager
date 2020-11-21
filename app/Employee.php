<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $fillable = [
        'name', 'email', 'username','surname','wage',
    ];

    public function employeesPayouts(){
        return $this->hasMany('App\EmployeesPayout');
    }
    public static function boot() {
        parent::boot();

        static::deleting(function($employee) { // before delete() method call this
             $employee->employeesPayouts()->delete();
             // do the rest of the cleanup...
        });
    }
}
