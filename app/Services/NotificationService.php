<?php

namespace App\Services;

use App\Contracts\NotificationSenderInterface;
use App\Contracts\UserRepositoryInterface;
use App\Enums\StatusMessages;
use Exception;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotificationService
{
    private UserRepositoryInterface $userRepository;

    private NotificationSenderInterface $notificationSender;

    public function __construct(
        UserRepositoryInterface $userRepository,
        NotificationSenderInterface $notificationSender
    ) {
        $this->userRepository = $userRepository;
        $this->notificationSender = $notificationSender;
    }

    public function sendTelegramNotification($statusKey, $workOrder, $ids = null, $remainingDays = null)
    {
        try {
            $workOrderNumber = $workOrder->work_order_number ?? $workOrder->id;
            $statusMessage = StatusMessages::getMessage($statusKey, $workOrderNumber, $remainingDays);

            if (is_int($ids)) {
                $ids = [$ids];
            }

            if (is_array($ids) && ! empty($ids)) {
                $users = $this->userRepository->findUsersByDepartmentIds($ids);
                $userNames = $users->implode(' - ');
                Telegram::bot('notification_bot')->sendMessage([
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text' => $statusMessage.' - '.$userNames,
                    'parse_mode' => 'HTML',
                ]);
            }
        } catch (Exception $e) {
            // Log the exception but don't let it break the application flow
            Log::error('Telegram notification failed: '.$e->getMessage());
        }
    }
}
