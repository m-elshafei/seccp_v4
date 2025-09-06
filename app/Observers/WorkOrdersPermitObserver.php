<?php

namespace App\Observers;

use App\Models\WorkOrdersPermit;
use App\Models\WorkOrdersPermitsExtension;
use App\Models\WorkOrdersPermitsFine;

class WorkOrdersPermitObserver
{
      /**
     * Handle the WorkOrdersPermitsExtension "created" event.
     */
    public function created(WorkOrdersPermit $workOrdersPermit): void
    {
        //
    }

    /**
     * Handle the WorkOrdersPermit "updated" event.
     */
    public function updated(WorkOrdersPermit $workOrdersPermit): void
    {
        //
    }

    /**
     * Handle the WorkOrdersPermit "deleted" event.
     */
    public function deleted(WorkOrdersPermit $workOrdersPermit): void
    {
        //
    }

    /**
     * Handle the WorkOrdersPermit "restored" event.
     */
    public function restored(WorkOrdersPermit $workOrdersPermit): void
    {
        //
    }

    /**
     * Handle the WorkOrdersPermit "force deleted" event.
     */
    public function forceDeleted(WorkOrdersPermit $workOrdersPermit): void
    {
        //
    }

    public function saving(WorkOrdersPermit $workOrdersPermit): void
    {
        $this->totalExtendPeriod($workOrdersPermit);
        $this->calcTotalAmount($workOrdersPermit);
        $this->totalPeriod($workOrdersPermit);
    }


    public function saved(WorkOrdersPermit $workOrdersPermit): void
    {
        $this->totalPeriod($workOrdersPermit);
        $this->totalExtendPeriod($workOrdersPermit);
        $this->calcTotalAmount($workOrdersPermit);
    }

    public function calcTotalAmount(WorkOrdersPermit $workOrdersPermit){
        // $workOrdersPermit = WorkOrdersPermit::find($workOrdersPermit->id);

        // $sum = $workOrdersPermit->total_extend_amount + $workOrdersPermit->total_fines_amount;

        // $input = [
        //     'total_amount' => $sum[0]
        // ];
        // dd($input);
        // $workOrdersPermit->fill($input);
        // $workOrdersPermit->save();
    }
    public function totalExtendPeriod(WorkOrdersPermit $workOrdersPermit){
        // $workOrdersPermit = WorkOrdersPermit::find($workOrdersPermit->id);

        // $sum = $workOrdersPermit->withSum('workOrdersPermitsExtension', 'period')
        //                         ->pluck('work_orders_permits_extension_sum_period') ;

        // $input = [
        // 'total_extend_period' => $sum[0]
        // ];
        // dd($input);
        // $workOrdersPermit->fill($input);
        // $workOrdersPermit->save();
    }
    public function totalPeriod(WorkOrdersPermit $workOrdersPermit){
        // $workOrdersPermit = WorkOrdersPermit::find($workOrdersPermit->id);

        // $sum = $workOrdersPermit->period + $workOrdersPermit->total_extend_period;

        // $input = [
        //     'total_period' => $sum
        // ];
        // dd($input);
        // $workOrdersPermit->fill($input);
        // $workOrdersPermit->save();
    }
}
