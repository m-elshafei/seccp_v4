<?php

namespace App\Observers;

use App\Models\WorkOrdersPermit;
use App\Models\WorkOrdersPermitsExtension;

class WorkOrdersPermitsExtensionObserver
{
    /**
     * Handle the WorkOrdersPermitsExtension "created" event.
     *
     * @param  \App\Models\WorkOrdersPermitsExtension  $workOrdersPermitsExtension
     * @return void
     */
    public function created(WorkOrdersPermitsExtension $workOrdersPermitsExtension)
    {
        $this->calcTotalAmount($workOrdersPermitsExtension);
    }

    /**
     * Handle the WorkOrdersPermitsExtension "updated" event.
     *
     * @param  \App\Models\WorkOrdersPermitsExtension  $workOrdersPermitsExtension
     * @return void
     */
    public function updated(WorkOrdersPermitsExtension $workOrdersPermitsExtension)
    {
        $this->calcTotalAmount($workOrdersPermitsExtension);
    }

    /**
     * Handle the WorkOrdersPermitsExtension "deleted" event.
     *
     * @param  \App\Models\WorkOrdersPermitsExtension  $workOrdersPermitsExtension
     * @return void
     */
    public function deleted(WorkOrdersPermitsExtension $workOrdersPermitsExtension)
    {
        $this->calcTotalAmount($workOrdersPermitsExtension);
    }

    /**
     * Handle the WorkOrdersPermitsExtension "restored" event.
     *
     * @param  \App\Models\WorkOrdersPermitsExtension  $workOrdersPermitsExtension
     * @return void
     */
    public function restored(WorkOrdersPermitsExtension $workOrdersPermitsExtension)
    {
        //
    }

    /**
     * Handle the WorkOrdersPermitsExtension "force deleted" event.
     *
     * @param  \App\Models\WorkOrdersPermitsExtension  $workOrdersPermitsExtension
     * @return void
     */
    public function forceDeleted(WorkOrdersPermitsExtension $workOrdersPermitsExtension)
    {
        //
    }

    public function saving(WorkOrdersPermitsExtension $workOrdersPermitsExtension)
    {
       
    }

    public function calcTotalAmount(WorkOrdersPermitsExtension $workOrdersPermitsExtension){
        $workOrdersPermit = WorkOrdersPermit::find($workOrdersPermitsExtension->work_orders_permit_id);

        $sum = $workOrdersPermit->withSum('workOrdersPermitsExtension', 'amount')
                                ->pluck('work_orders_permits_extension_sum_amount') ; 

        $input = [
           'total_extend_amount' => $sum[0]
        ];

        $workOrdersPermit->fill($input);
        $workOrdersPermit->save();        
    }
}
