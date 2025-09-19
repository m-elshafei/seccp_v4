<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Contracts\NotificationSenderInterface;
use App\Services\NotificationSender;
use App\Services\Notifications\NotificationService;

class NotificationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(NotificationSenderInterface::class, NotificationSender::class);
        $this->app->bind(NotificationService::class);
    }
}
