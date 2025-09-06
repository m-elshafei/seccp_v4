<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\WorkOrdersPermit;
use App\Models\WorkOrdersPermitsExtension;
use Flash;

class WorkOrdersPermitsExtensionController extends AppBaseController
{
    public function store(Request $request)
    {

        request()->validate([
            'sadad_number' => 'required',
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'period' => 'required'
            // 'issue_date' => 'required',
            // 'from_date' => 'required',
        ]);

        $input = $request->all();

        $work_orders_permit_id = $input['work_orders_permit_id'];
        $WorkOrdersPermit = WorkOrdersPermit::find($work_orders_permit_id);
        $WorkOrdersPermitsExtension = WorkOrdersPermitsExtension::where('work_orders_permit_id',$work_orders_permit_id)->orderby('to_date','DESC')->first();
        // if ($WorkOrdersPermitsExtension){
        //     $from_date =Carbon::parse($WorkOrdersPermitsExtension->to_date)
        //     ->addDay(1);
        // }else{
        //     $from_date =Carbon::parse($WorkOrdersPermit->end_date)
        //     ->addDay(1);
        // }
        if ($WorkOrdersPermitsExtension){
          $from_date = $WorkOrdersPermitsExtension->to_date;
        }else{
          $from_date = $WorkOrdersPermit->end_date;
        }
        $input['status'] = 1;
        $input['from_date'] = $from_date;
        $input['issue_date'] = $input['from_date'];
        $input['to_date'] = Carbon::parse($input['issue_date'])
                                    ->addDay($input['period']);
        $inputDetail = [
                        new WorkOrdersPermitsExtension($input)
                       ];

        $result = $WorkOrdersPermit->workOrdersPermitsExtension()->saveMany($inputDetail);

        return $result;
    }

    public function show($id)
    {
      $workOrdersPermitsExtension = WorkOrdersPermitsExtension::find($id);
      if (empty($workOrdersPermitsExtension)) {
          Flash::error('workOrdersPermitsExtension not found');
          return redirect(route('workOrdersPermits.index'));
      }
      return $workOrdersPermitsExtension;

    }


    public function edit($id)
    {
      $workOrdersPermitsExtension = WorkOrdersPermitsExtension::find($id);

      if (empty($workOrdersPermitsExtension)) {
          Flash::error('workOrdersPermitsExtension not found');
          return redirect(route('workOrdersPermits.index'));
      }

      return $workOrdersPermitsExtension;
    }


    public function update(Request $request, $id){
      $workOrdersPermitsExtension = WorkOrdersPermitsExtension::find($id);

      if(empty($workOrdersPermitsExtension)){
          Flash::error('workOrdersPermitsExtension is not found');
          return redirect(route('workOrdersPermits.index'));
      }

      request()->validate([
        'sadad_number' => 'required',
        'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/'
      ]);

      $input = $request->all();

      $input['to_date'] = Carbon::parse($workOrdersPermitsExtension->from_date)
                                  ->addDay($input['period']);

      $workOrdersPermitsExtension->fill($input);
      $workOrdersPermitsExtension->save();

      return $workOrdersPermitsExtension;
    }


    public function destroy($id)
    {
      $workOrdersPermitsExtension = WorkOrdersPermitsExtension::find($id);

      if (empty($workOrdersPermitsExtension)) {
          Flash::error('workOrdersPermitsExtension is not found');
          return redirect(route('workOrdersPermits.index'));
      }

      $workOrdersPermitsExtensionDel = $workOrdersPermitsExtension->delete();
    }


}
