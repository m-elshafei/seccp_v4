<?php

namespace App\Services;

use App\Contracts\NotificationSenderInterface;
use App\DataObjects\NotificationData;
use App\Notifications\GeneralNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use InvalidArgumentException;

class NotificationSender implements NotificationSenderInterface
{
    public function send(Collection $users, NotificationData $notificationData): void
    {
        if ($users->isEmpty()) {
            throw new InvalidArgumentException('No users found to send notifications to');
        }

        Notification::send(
            $users,
            new GeneralNotification(
                $notificationData->getTitle(),
                $notificationData->getMessage(),
                $notificationData->getLink(),
            )
        );
    }
}
