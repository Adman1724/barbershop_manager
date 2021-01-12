<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service;


class ServiceController extends Controller
{
    
    public function getAllServices(){

        $services =  Service::all();

        return response()->json(['services'=>$services],200);

    }
    public function delete($id ){
       $service = Service::findOrFail($id);
       
       //$employee->EmployeesPayouts->delete();
      
        
        if($service)
        $service->delete(); 
        else
        return response()->json([],500);
     
    return response()->json(['result'=>'done'],200);
    }
    public function update(Request $request, $id){
        $service = Service::findOrFail($id);
        $service->update($request->all());

        
        
        

        return response()->json(['result'=>$service],200);
    }
    public function store(Request $request){
        $service = Service::create($request->all());

        return response()->json($service, 201);
    }
}
