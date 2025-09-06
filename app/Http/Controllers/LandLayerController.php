<?php

namespace App\Http\Controllers;

use App\Models\WorkOrderFollow;
use App\Models\Lab;
use App\Models\LandLayerHistory;
use App\Models\Layer;
use App\Models\LandLayer;
use App\Models\WorkOrder;
use App\Models\WorkOrdersPermit;
use Illuminate\Http\Request;

class LandLayerController extends AppBaseController
{
    public function store(Request $request)
    {

        request()->validate([
            'layer_id'          => 'required|exists:layers,id',
            'start_date'        => 'required',
            'layer_worker_type' => 'required',
            'lab_result_status' => 'required|in:1,2',
            'layer_contractor_id' => 'required_if:layer_worker_type,1',
            'layer_employee_id' => 'required_if:layer_worker_type,2',
        ],[
            'layer_contractor_id.required_if' => "حقل المقاول مطلوب في حال ما إذا كان المنفذ مقاول.",
            'layer_employee_id.required_if'   => "حقل الموظف مطلوب في حال ما إذا كان المنفذ موظف."
        ]);

        $input = $request->all();

        $input['lab_id'] = Lab::first()->id;

        $layer = Layer::find($input['layer_id']);
        // $old_layers = LandLayer::where([
        //     'work_orders_permit_id' => $input['work_orders_permit_id'],
        //     'lab_result_status'     => '2'
        // ])->count();

        // if($old_layers){
        //     return response([
        //         'errors'    => ['لا بمكن اضافة طبقة جديده والسابقه لها فاشلة'],
        //         'message'   => 'لا بمكن اضافة طبقة جديده والسابقه لها فاشلة',
        //     ],422);
        // }

        // $LandLayer = LandLayer::where([
        //     'layer_id' => $input['layer_id'],
        // ])->count();
        // if ( $LandLayer) {
        //       return response([
        //         'errors'    => ['لا بمكن اضافة طبقة مرتين'],
        //         'message'   =>'لا بمكن اضافة طبقة مرتين',
        //     ],422);
        // }
        $input["layer_status"] = 2;

        if ($input['lab_result_status'] == 1){
            $input['note'] = null;
        }

        $workOrder = WorkOrderFollow::find($input['work_orders_permit_id']);
        $inputDetail = [
                        new LandLayer($input)
                       ];
        $result = $workOrder->landLayers()->saveMany($inputDetail);
        if($result){
          if($layer->is_final && $input['lab_result_status'] == 1){
            $workOrder->fill(['status'=>5]);
            $workOrder->save();
          }
        }


        $result[0]['layer_id'] = $layer->name;

        $layer_worker_type_list = config('const.layer_worker_type_list') ;
        $result[0]['layer_worker_type'] = $layer_worker_type_list[$input['layer_worker_type']];

        $lab_result_status_list = config('const.lab_result_status_list') ;
        $result[0]['lab_result_status'] = $lab_result_status_list[$input['lab_result_status']];

        return $result;
    }

    public function show($id,Request $request)
    {
      $landLayer = LandLayer::find($id);
      if (empty($landLayer)) {
          Flash::error('landLayer not found');
          return redirect(route('returnSituations.index'));
      }

      if ($request->get('action') != 'edit') {
          $landLayer['layer_id'] = $landLayer->layer->name;
          //dd($landLayer->layer_worker_type);
          if ($landLayer->layer_worker_type == 2){
              $landLayer->worker = $landLayer->employee->name;
          }else{
              $landLayer->worker = $landLayer->contractor->name;
          }

          $layer_worker_type_list = config('const.layer_worker_type_list');
          $landLayer['layer_worker_type'] = $layer_worker_type_list[$landLayer->layer_worker_type];

          $lab_result_status_list = config('const.lab_result_status_list');
          $landLayer['lab_result_status'] = $lab_result_status_list[$landLayer->lab_result_status];
      }

      return $landLayer;
    }


    public function edit($id)
    {
      $landLayer = LandLayer::find($id);

      if (empty($landLayer)) {
          Flash::error('landLayer not found');
          return redirect(route('returnSituations.index'));
      }

      return $landLayer;
    }


    public function update(Request $request, $id){
      $landLayer = LandLayer::find($id);

      if(empty($landLayer)){
          Flash::error('landLayer is not found');
          return redirect(route('returnSituations.index'));
      }

      $input = $request->all();
      if ($input['lab_result_status'] == 1){
          $input['note'] = null;
      }
      $input['description'] = $request->description;
      $landLayer->fill($input);
      $landLayer->save();


        $layer_worker_type_list = config('const.layer_worker_type_list') ;
        $landLayer->layer_worker_type = $layer_worker_type_list[$landLayer->layer_worker_type];

        $lab_result_status_list = config('const.lab_result_status_list') ;
        $landLayer->lab_result_status = $lab_result_status_list[$landLayer->lab_result_status];

      return $landLayer;
    }


    public function destroy($id)
    {
        $landLayer = LandLayer::find($id);

        if (empty($landLayer)) {
            Flash::error('workOrdersPermitsExtension is not found');
            return redirect(route('assayForms.index'));
        }

        $landLayerDel = $landLayer->delete();
    }


    public function deleteFromHistory($id)
    {
        $landLayerHistory = LandLayerHistory::find($id);

        if (empty($landLayerHistory)) {
            Flash::error('LandLayerHistory is not found');
            return redirect(route('assayForms.index'));
        }

        $landLayerDel = $landLayerHistory->delete();
        return response()->json(['id' => $id, 'status' => true]);
    }
}
