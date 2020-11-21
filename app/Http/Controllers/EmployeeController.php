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
    public function delete($id ){
       $employee = Employee::findOrFail($id);
       
       //$employee->EmployeesPayouts->delete();
      
        
        if($employee)
        $employee->delete(); 
        else
        return response()->json([],500);
     
    return response()->json(['result'=>'done'],200);
    }
    public function update(Request $request, $id){
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        
        
        

        return response()->json(['result'=>$employee],200);
    }
    public function store(Request $request){
        $employee = Employee::create($request->all());

        return response()->json($employee, 201);
    }
}
