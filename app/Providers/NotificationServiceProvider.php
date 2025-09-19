<?php

namespace App\Providers;

use App\Contracts\NotificationSenderInterface;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\Notifications\NotificationService;
use App\Services\NotificationSender;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(NotificationSenderInterface::class, NotificationSender::class);
        $this->app->bind(NotificationService::class);
    }
}
