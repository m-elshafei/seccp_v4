<?php

namespace App\Observers;

use App\Models\WorkOrdersPermit;
use App\Models\WorkOrdersPermitsFine;

class WorkOrdersPermitsFineObserver
{
    /**
     * Handle the WorkOrdersPermitsFine "created" event.
     *
     * @param  \App\Models\WorkOrdersPermitsFine  $workOrdersPermitsFine
     * @return void
     */
    public function created(WorkOrdersPermitsFine $workOrdersPermitsFine)
    {
        $this->calcTotalAmount($workOrdersPermitsFine);
    }

    /**
     * Handle the WorkOrdersPermitsFine "updated" event.
     *
     * @param  \App\Models\WorkOrdersPermitsFine  $workOrdersPermitsFine
     * @return void
     */
    public function updated(WorkOrdersPermitsFine $workOrdersPermitsFine)
    {
        $this->calcTotalAmount($workOrdersPermitsFine);
    }

    /**
     * Handle the WorkOrdersPermitsFine "deleted" event.
     *
     * @param  \App\Models\WorkOrdersPermitsFine  $workOrdersPermitsFine
     * @return void
     */
    public function deleted(WorkOrdersPermitsFine $workOrdersPermitsFine)
    {
        $this->calcTotalAmount($workOrdersPermitsFine);
    }

    /**
     * Handle the WorkOrdersPermitsFine "restored" event.
     *
     * @param  \App\Models\WorkOrdersPermitsFine  $workOrdersPermitsFine
     * @return void
     */
    public function restored(WorkOrdersPermitsFine $workOrdersPermitsFine)
    {
        //
    }

    /**
     * Handle the WorkOrdersPermitsFine "force deleted" event.
     *
     * @param  \App\Models\WorkOrdersPermitsFine  $workOrdersPermitsFine
     * @return void
     */
    public function forceDeleted(WorkOrdersPermitsFine $workOrdersPermitsFine)
    {
        //
    }

    public function calcTotalAmount(WorkOrdersPermitsFine $workOrdersPermitsFine){
        $workOrdersPermit = WorkOrdersPermit::find($workOrdersPermitsFine->work_orders_permit_id);

        $sum = $workOrdersPermit->withSum('workOrdersPermitsFine', 'amount')
                                ->pluck('work_orders_permits_fine_sum_amount') ; 

        $input = [
           'total_fines_amount' => $sum[0]
        ];

        $workOrdersPermit->fill($input);
        $workOrdersPermit->save();        
    }
}
