<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface NotificationChannelInterface
{
    public function send(string $message, array $recipients = []): void;
}
