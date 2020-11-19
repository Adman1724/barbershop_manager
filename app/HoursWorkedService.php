<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoursWorkedService extends Model
{
    //
    public function Service(){
        return $this->belongsTo('App\Service');
    }
    public function HoursWorked(){
        return $this->belongsTo('App\HoursWorked');
    }
}
