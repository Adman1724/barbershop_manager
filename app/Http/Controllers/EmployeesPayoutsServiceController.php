<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service;
use App\EmployeesPayoutsService;


class EmployeesPayoutsServiceController extends Controller
{

    public function getAllEmployeesPayoutsService(){

        $employeesPayoutsServices =  EmployeesPayoutsService::all();

        return response()->json(['employeesPayoutsServices'=>$employeesPayoutsServices],200);

    }
    
    public function getAllEmployeesPayoutsServicesById($id){

        $employeesPayoutsServices =  EmployeesPayoutsService::with('Service')->where('employees_payout_id', '=', $id)->get();

        return response()->json($employeesPayoutsServices,200);

    }
    public function update(Request $request, $id){
        $employee = EmployeesPayoutsService::findOrFail($id);
        $employee->update($request->all());

        
        
        

        return response()->json(['result'=>$employee],200);
    }

}

