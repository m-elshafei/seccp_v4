<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Telegram\Bot\Laravel\Facades\Telegram;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if ($e instanceof \Exception) {
                $message = $e->getMessage();
                $this->sendLogToTelegram($message);
            }
        });
    }

    private function sendTelegramMessage($message)
    {
        Telegram::bot('mybot')->sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'text' => $message,
        ]);
    }

    private function sendLogToTelegram($message)
{
    try {
        Telegram::bot('log_bot')->sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID_LOG'),
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);
    } catch (TelegramResponseException $e) {
        // Log the error message for debugging
        \Log::error('Telegram Error: ' . $e->getMessage());
    } catch (\Exception $e) {
        // Handle any other exceptions
        \Log::error('General Error: ' . $e->getMessage());
    }
}

}
