<?php

namespace App\Contracts;

use App\DataObjects\NotificationData;
use Illuminate\Database\Eloquent\Collection;

interface NotificationSenderInterface
{
    public function send(Collection $users, NotificationData $notificationData): void;
}
