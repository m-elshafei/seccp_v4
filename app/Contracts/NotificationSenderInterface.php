<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\DataObjects\NotificationData;

interface NotificationSenderInterface
{
    public function send(Collection $users, NotificationData $notificationData): void;
}

