<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;
use App\EmployeesPayout;
use App\Payout;

class EmployeeController extends Controller
{
    
    public function getAllEmployees(){

        $employees =  Employee::all();

        return response()->json(['employees'=>$employees],200);

    }
}
