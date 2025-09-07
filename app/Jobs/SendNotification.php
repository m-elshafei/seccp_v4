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
    private const REMAINING_DAYS_THRESHOLD = 15;

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

        if ($this->hasFifteenDaysRemaining($workOrdersPermit)) {
            $this->sendWorkOrderNotification($workOrdersPermit);
        }
    }


    private function hasFifteenDaysRemaining($workOrdersPermit): bool
    {
        $currentDate = Carbon::now();
        $issueDate = Carbon::createFromFormat('Y-m-d', $workOrdersPermit->issue_date);
        $daysDifference = $issueDate->diffInDays($currentDate);

        return ($workOrdersPermit->period - $daysDifference) <= self::REMAINING_DAYS_THRESHOLD;
    }


    private function sendWorkOrderNotification($workOrdersPermit): void
    {
        $workOrder = WorkOrder::where('work_order_number', $workOrdersPermit->work_order_number)->first();

        if (!$workOrder) {
            return;
        }

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
