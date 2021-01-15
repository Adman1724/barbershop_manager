<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;
use App\EmployeesPayout;
use App\Payout;

class EmployeesPayoutController extends Controller
{

    public function getAllEmployeesPayouts(){

        $employeesPayout =  EmployeesPayout::all();

        return response()->json(['employees'=>$employeesPayout],200);

    }
    public function getAllEmployeesPayoutsById($id){

        $employeesPayouts =  EmployeesPayout::with('Employee')->where('payout_id', '=', $id)->get();

        return response()->json($employeesPayouts,200);

    }
    public function update(Request $request, $id){
        $employee = EmployeesPayout::findOrFail($id);
        $employee->update($request->all());

        
        
        

        return response()->json(['result'=>$employee],200);
    }
    

}

