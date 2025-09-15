<?php

namespace App\Services;

use App\Contracts\NotificationSenderInterface;
use Illuminate\Database\Eloquent\Collection;
use App\DataObjects\NotificationData;
use App\Contracts\UserRepositoryInterface;
use App\Strategies\UserRetrieval\UserRetrievalStrategyFactory;
use Exception;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    private UserRepositoryInterface $userRepository;
    private NotificationSenderInterface $notificationSender;

    public function __construct(
        UserRepositoryInterface $userRepository,
        NotificationSenderInterface $notificationSender
    ) {
        $this->userRepository = $userRepository;
        $this->notificationSender = $notificationSender;
    }

    /**
     * إرسال إشعارات للمستخدمين
     *
     * @param NotificationData $notificationData بيانات الإشعار
     * @param array|int $recipientIds معرفات المستلمين
     * @param string $recipientType نوع المستلمين (User أو Department)
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function sendNotifications(
        NotificationData $notificationData,
        $recipientIds,
        string $recipientType = 'User'
    ): void {
        try {
            // تحويل إلى array إذا لم يكن كذلك
            $normalizedIds = $this->normalizeIds($recipientIds);

            // الحصول على استراتيجية استخراج المستخدمين
            $strategy = UserRetrievalStrategyFactory::create($recipientType);

            // الحصول على المستخدمين
            $users = $strategy->getUsers($normalizedIds, $this->userRepository);

            // إرسال الإشعارات
            $this->notificationSender->send($users, $notificationData);

        } catch (Exception $e) {
            // تسجيل الخطأ
            Log::error('Failed to send notifications', [
                'error' => $e->getMessage(),
                'recipient_ids' => $recipientIds,
                'recipient_type' => $recipientType,
                'title' => $notificationData->getTitle()
            ]);

            throw new Exception('Failed to send notifications: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * تحويل المعرفات إلى array
     */
    private function normalizeIds($ids): array
    {
        if (!is_array($ids)) {
            return [$ids];
        }

        return $ids;
    }
}

