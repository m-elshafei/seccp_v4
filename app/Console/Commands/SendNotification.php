<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PermitNotificationService;

class SendNotification  extends Command
{
    protected $signature = 'notify:permitExpire';
    protected $description = 'Send notifications for permits nearing expiration';
    protected $permitNotificationService;

    public function __construct(PermitNotificationService  $permitNotificationService)
    {
        parent::__construct();
        $this->permitNotificationService = $permitNotificationService;
    }

    public function handle()
    {
        $this->permitNotificationService->sendPermitExpirationNotifications();

    }
}

