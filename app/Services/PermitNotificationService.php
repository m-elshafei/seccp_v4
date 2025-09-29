<?php

namespace App\Services;

use App\Models\WorkOrder;
use App\Models\WorkOrdersPermit;
use App\Services\Notifications\NotificationService;
use App\Services\Notifications\NotificationSystemService;
use Carbon\Carbon;

class PermitNotificationService
{
    private NotificationService $notificationService;

    private NotificationSystemService $notificationSystemService;

    public function __construct(NotificationService $notificationService, NotificationSystemService $notificationSystemService)
    {
        $this->notificationService = $notificationService;
        $this->notificationSystemService = $notificationSystemService;
    }

    public function sendPermitExpirationNotifications()
    {
        try {
            $permits = WorkOrdersPermit::all();

            foreach ($permits as $permit) {
                $workOrder = WorkOrder::where('work_order_number', $permit->work_order_number)->first();

                if ($workOrder) {
                    $today = Carbon::now();
                    $permitEndDate = Carbon::parse($permit->end_date);

                    $remainingDays = $permitEndDate->gt($today) ? $today->diffInDays($permitEndDate) : 0;

                    if (in_array($remainingDays, [14, 9, 4, 3, 2, 1])) {
                        $title = 'قارب تصريح على الانتهاء';
                        $message = 'متبقي على انتهاء التصريح رقم '.$permit->permit_number.' - '.$remainingDays.' يوم ';

                        $this->notificationSystemService->sendNotifications($title, $message, $workOrder->current_department_id, 'Department', '/workOrdersManagement/workOrdersPermits/'.$permit->id, 'bg-light-success', 'check');
                        $this->notificationService->sendTelegramNotification('permitExpiration', $permit->permit_number, 8, $remainingDays);

                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return false;
        }

        return true;
    }
}
