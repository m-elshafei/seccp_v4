<?php

namespace App\Services;

use App\Contracts\NotificationSenderInterface;
use Illuminate\Database\Eloquent\Collection;
use App\DataObjects\NotificationData;
use InvalidArgumentException;
use App\Notifications\GeneralNotification;
use App\Models\Notification;

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
