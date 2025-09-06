<?php

namespace App\Observers;

use App\Enums\WorkOrderStatusEnum;
use App\Models\WorkOrder;
use App\Models\WorkOrderTransactionsHistory;
use Carbon\Carbon;

class WorkOrderObserver
{
    /**
     * Handle the WorkOrder "created" event.
     */
    public function created(WorkOrder $workOrder): void
    {
        WorkOrderTransactionsHistory::createTransactionsHistory($workOrder, 1);
    }

    public function updating(WorkOrder $workOrder)
    {
        if($workOrder->isDirty('status')){
            WorkOrderTransactionsHistory::createTransactionsHistory($workOrder, 2);
           
            if($workOrder->status == WorkOrderStatusEnum::WorkingDone() || $workOrder->status == WorkOrderStatusEnum::DeliveryDone()){
                if(!$workOrder->finished_date){
                    $workOrder->finished_date=Carbon::now();
                }
            }
            
        }

        if($workOrder->isDirty('current_department_id')){
            WorkOrderTransactionsHistory::createTransactionsHistory($workOrder, 3);
        }

        if($workOrder->isDirty('drilling_status')){
            WorkOrderTransactionsHistory::createTransactionsHistory($workOrder, 4);
        }

        if($workOrder->isDirty('electrical_operations_status')){
            WorkOrderTransactionsHistory::createTransactionsHistory($workOrder, 5);
        }
      
    }

    /**
     * Handle the WorkOrder "updated" event.
     */
    public function updated(WorkOrder $workOrder): void
    {
        //
    }

    /**
     * Handle the WorkOrder "deleted" event.
     */
    public function deleted(WorkOrder $workOrder): void
    {
        //
    }

    /**
     * Handle the WorkOrder "restored" event.
     */
    public function restored(WorkOrder $workOrder): void
    {
        //
    }

    /**
     * Handle the WorkOrder "force deleted" event.
     */
    public function forceDeleted(WorkOrder $workOrder): void
    {
        //
    }
}
