<?php

namespace App\Observers;

use App\Models\LabResult;
use App\Models\LandLayer;
use App\Models\LandLayerHistory;

class LandLayerObserver
{
    /**
     * Handle the LandLayer "created" event.
     *
     * @param  \App\Models\LandLayer  $landLayer
     * @return void
     */
    public function created(LandLayer $landLayer)
    {
        $this->addLabResult($landLayer);

        LandLayerHistory::create([
            'work_order_id'         => $landLayer->work_order_id,
            'work_orders_permit_id' => $landLayer->work_orders_permit_id,
            'land_layer_id'         => $landLayer->id,
            'event_type'            => 'created',
            'user_id'               => auth()->id(),
            'lab_id'                => $landLayer->lab_id,
            'layer_id'              => $landLayer->layer_id,
            'layer_status'          => $landLayer->layer_status,
            'lab_result_status'     => $landLayer->lab_result_status,
            'note'                  => $landLayer->note,
        ]);
    }

    /**
     * Handle the LandLayer "updated" event.
     *
     * @param  \App\Models\LandLayer  $landLayer
     * @return void
     */
    public function updated(LandLayer $landLayer)
    {
        $labResult = LabResult::where('land_layer_id',$landLayer->id)->latest()->first();
        if(!empty($labResult) &&
            $landLayer->lab_result_status != $labResult->lab_result_status){
            $this->addLabResult($landLayer);
        }

        LandLayerHistory::create([
            'work_order_id'         => $landLayer->work_order_id,
            'work_orders_permit_id' => $landLayer->work_orders_permit_id,
            'land_layer_id'         => $landLayer->id,
            'event_type'            => 'updated',
            'user_id'               => auth()->id(),
            'lab_id'                => $landLayer->lab_id,
            'layer_id'              => $landLayer->layer_id,
            'layer_status'          => $landLayer->layer_status,
            'lab_result_status'     => $landLayer->lab_result_status,
            'note'                  => $landLayer->note,
        ]);
    }

    /**
     * Handle the LandLayer "deleted" event.
     *
     * @param  \App\Models\LandLayer  $landLayer
     * @return void
     */
    public function deleted(LandLayer $landLayer)
    {
        //
    }

    /**
     * Handle the LandLayer "restored" event.
     *
     * @param  \App\Models\LandLayer  $landLayer
     * @return void
     */
    public function restored(LandLayer $landLayer)
    {
        //
    }

    /**
     * Handle the LandLayer "force deleted" event.
     *
     * @param  \App\Models\LandLayer  $landLayer
     * @return void
     */
    public function forceDeleted(LandLayer $landLayer)
    {
        //
    }

    public function addLabResult(LandLayer $landLayer){

        if($landLayer->lab_send_date){
            $input = [
                'lab_id' => $landLayer->lab_id,
                'land_layer_id' => $landLayer->id,
                'lab_send_date' => $landLayer->lab_send_date,
                'lab_result_date' => $landLayer->lab_send_date, /** TODO:  */
                'lab_result_status' => $landLayer->lab_result_status,
                'executer' => $landLayer->executer,
            ];
    
            LabResult::create($input);    
        }

        
        // $workOrdersPermit = WorkOrdersPermit::find($workOrdersPermitsExtension->work_orders_permit_id);

        // $sum = $workOrdersPermit->withSum('workOrdersPermitsExtension', 'amount')
        //                         ->pluck('work_orders_permits_extension_sum_amount') ; 

        // $input = [
        //    'total_extend_amount' => $sum[0]
        // ];

        // $workOrdersPermit->fill($input);
        // $workOrdersPermit->save();        
    }
}
