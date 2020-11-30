<?php

namespace App\Http\Controllers;

use App\Payout;
use App\Employee;
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
       // $employees = Employee::all();
       // foreach($employees as $employee){

       // }
        return response()->json($payout, 201);
    }
}
