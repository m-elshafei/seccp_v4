<?php

namespace App\Services\Notifications;

use App\Models\Employee;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class NotificationSystemService
{
    public static function sendNotifications(
        string $title,
        string $message,
        array|int $ids,
        string $type = 'User',
        ?string $link = null,
        string $classBg = 'bg-light-success',
        string $classIcon = 'check'
    ): void {
        try {
            $ids = self::normalizeIds($ids);

            $recipients = self::resolveRecipients($ids, $type);

            if ($recipients->isEmpty()) {
                self::logNoRecipients($ids, $type);

                return;
            }

            self::dispatchNotification($recipients, $title, $message, $link, $classBg, $classIcon);

        } catch (\Throwable $e) {
            self::handleException($e, $ids, $type);
        }
    }

    private static function normalizeIds(array|int $ids): array
    {
        return is_array($ids) ? $ids : [$ids];
    }

    private static function resolveRecipients(array $ids, string $type): \Illuminate\Support\Collection
    {
        return match ($type) {
            'Department' => self::getUsersByDepartment($ids),
            'User' => self::getUsersByIds($ids),
            default => collect(),
        };
    }

    private static function getUsersByDepartment(array $departmentIds): \Illuminate\Support\Collection
    {
        return Employee::whereIn('department_id', $departmentIds)
            ->whereNotNull('user_id')
            ->with('user')
            ->get()
            ->pluck('user');
    }

    private static function getUsersByIds(array $userIds): \Illuminate\Support\Collection
    {
        return User::whereIn('id', $userIds)->get();
    }

    private static function dispatchNotification(
        \Illuminate\Support\Collection $recipients,
        string $title,
        string $message,
        ?string $link,
        string $classBg,
        string $classIcon
    ): void {
        Notification::send(
            $recipients,
            new GeneralNotification($title, $message, $link, $classBg, $classIcon)
        );
    }

    private static function logNoRecipients(array $ids, string $type): void
    {
        Log::warning('No recipients found for notification', [
            'ids' => $ids,
            'type' => $type,
        ]);
    }

    private static function handleException(\Throwable $e, array $ids, string $type): void
    {
        Log::error('Notification sending failed', [
            'error' => $e->getMessage(),
            'type' => $type,
            'ids' => $ids,
        ]);
    }
}
