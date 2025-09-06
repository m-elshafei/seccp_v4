<?php

namespace App\Jobs;

use App\Models\WorkOrdersPermit;
use App\Models\WorkOrder;
use App\Services\NotificationService; // Import the new class
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workOrdersPermit;
    protected $notificationService; // Add a property for the new service

    /**
     * Create a new job instance.
     *
     * @param \App\Models\WorkOrdersPermit $workOrdersPermit
     * @param \App\Services\NotificationService $notificationService
     */
    public function __construct(WorkOrdersPermit $workOrdersPermit, NotificationService $notificationService)
    {
        $this->workOrdersPermit = $workOrdersPermit;
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $workOrdersPermit = $this->workOrdersPermit;
        $dt1 = Carbon::now();
        $dt2 = Carbon::createFromFormat('Y-m-d', $workOrdersPermit->issue_date);
        $diff = $dt2->diffInDays($dt1);
        $workOrder = WorkOrder::where('work_order_number', $workOrdersPermit->work_order_number)->first();

        if (($workOrdersPermit->period - $diff) == 15) {
            if ($workOrder) {
                $title = 'قارب تصريح على الانتهاء';
                $message = "متبقي على انهاء التصريح رقم " . $workOrdersPermit->permit_number . " اقل من 15 يوم";

                $this->notificationService->send(
                    $title,
                    $message,
                    $workOrder->current_department_id,
                    'Department',
                    '/workOrdersManagement/workOrdersPermits/' . $workOrdersPermit->id,
                    'bg-light-success',
                    'check'
                );
            }
        }
    }
}
