<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = [
        'date', 'works_days',
    ];
    public function EmployeesPayouts(){
        return $this->hasMany('App\EmployeesPayout');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($payout) { // before delete() method call this
             $payout->employeesPayouts()->delete();
             // do the rest of the cleanup...
        });
    }
    

}
