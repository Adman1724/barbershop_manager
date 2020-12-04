<?php

namespace App\Http\Controllers;

use App\Payout;
use App\Employee;
use App\EmployeesPayout;
use Illuminate\Http\Request;

class PayoutController extends Controller


{
    public function showAll()
    {
        $payouts =  Payout::all();
        return response()->json(['payouts' => $payouts], 200);
    }

    public function delete($id)
    {
        $payout = Payout::findOrFail($id);

        if ($payout)
            $payout->delete();
        else
            return response()->json([], 500);

        return response()->json(['result' => 'done'], 200);
    }

    public function update(Request $request, $id)
    {
        $payout = Payout::findOrFail($id);
        $payout->update($request->all());
        return response()->json(['result' => $payout], 200);
    }
    public function updateJson(Request $request, $id){
        $payout = Payout::findOrFail($id);

        $payout->json=$request->all();
        $payout->save();



        return response()->json(['result' => $payout], 200);
    }

    public function store(Request $request)
    {
        $payout = Payout::create($request->all());
        $employees = Employee::all();

        foreach ($employees as $employee) {
            //$employeesPayout= EmployeesPayment::where(['payout_id', '=', payout->id], ['employee_id', '=', employee->id])->get();
            //if($employeesPayout){

            //return response()->json($employees, 201);
            $employeesPayout = new EmployeesPayout(
                ['payout_id' => $payout->id , 'employee_id' => $employee->id, 'holiday' => 0, 'first_part' => 0,'second_part' => 0,'lunch_card' => 0,'overtime' => 0]
            );
            $employeesPayout->save();


        }
       // $employees = Employee::all();
       // foreach($employees as $employee){

       // }
        return response()->json($payout, 201);
    }
}
