<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'command1';
    protected string $description = 'Start Command to get you started';

    public function handle()
    {
        $this->replyWithMessage([
            'text' => 'Hey, there! Welcome to our bot!',
        ]);
    }
}
