<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrdersPermit;
use App\Models\WorkOrdersPermitsFine;

class WorkOrdersPermitsFineController extends Controller
{
    public function store(Request $request)
    {

        request()->validate([
            'sadad_number' => 'required',
            'issue_date' => 'required',
            'amount' => 'required',
        ]);

        $input = $request->all();
        
        $work_orders_permit_id = $input['work_orders_permit_id'];
        $WorkOrdersPermit = WorkOrdersPermit::find($work_orders_permit_id);
        
        $inputDetail = [
                        new WorkOrdersPermitsFine($input)
                       ];

        $result = $WorkOrdersPermit->workOrdersPermitsFine()->saveMany($inputDetail);
        
        return $result;
    }

    
    public function show($id)
    {
      $workOrdersPermitsFine = WorkOrdersPermitsFine::find($id);
      if (empty($workOrdersPermitsFine)) {
          Flash::error('workOrdersPermitsFine not found');
          return redirect(route('workOrdersPermits.index'));
      }
      return $workOrdersPermitsFine;

    }


    public function edit($id)
    {
      $workOrdersPermitsFine = WorkOrdersPermitsFine::find($id);

      if (empty($workOrdersPermitsFine)) {
          Flash::error('workOrdersPermitsFine not found');
          return redirect(route('workOrdersPermits.index'));
      }

      return $workOrdersPermitsFine;
    }


    public function update(Request $request, $id)
    {
      $workOrdersPermitsFine = WorkOrdersPermitsFine::find($id);

      if(empty($workOrdersPermitsFine)){
          Flash::error('workOrdersPermitsFine is not found');
          return redirect(route('workOrdersPermits.index'));
      }

      $input = $request->all();
        
      $workOrdersPermitsFine->fill($input);
      $workOrdersPermitsFine->save();

      return $workOrdersPermitsFine;
    }

    
    public function destroy($id)
    {
      $workOrdersPermitsFine = WorkOrdersPermitsFine::find($id);

      if (empty($workOrdersPermitsFine)) {
          Flash::error('workOrdersPermitsFine is not found');
          return redirect(route('workOrdersPermits.index'));
      }

      $workOrdersPermitsFineDel = $workOrdersPermitsFine->delete();
    }

}
