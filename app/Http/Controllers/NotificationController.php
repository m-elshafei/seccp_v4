<?php

namespace App\Http\Controllers;

use App\DataObjects\NotificationData;
use App\Services\Notifications\NotificationService;
use App\Services\Notifications\NotificationSystemService;
use Exception;
use Flash;
use Illuminate\Http\Request;

class NotificationController extends AppBaseController
{
    private NotificationService $notificationService;

    private NotificationSystemService $notificationSystemService;

    public function __construct(NotificationService $notificationService, NotificationSystemService $notificationSystemService)
    {
        $this->notificationService = $notificationService;
        $this->notificationSystemService = $notificationSystemService;
    }

    public function markAsReadNotificationAll()
    {
        auth()->user()->unreadNotifications->markAsRead();
        // return $this->sendSuccess('تم تعليم كمقروء');
        Flash::success('تم تعليم كمقروء');

        return redirect()->back();
    }

    public function markAsReadNotification($id)
    {
        $notifications = auth()->user()->unreadNotifications;
        // dd($notifications->where('id',$id));
        $notifications->where('id', $id)->markAsRead();
        // return $this->sendSuccess('تم تعليم كمقروء');
        Flash::success('تم تعليم كمقروء');

        return redirect()->back();
    }

    public function showNotification()
    {
        $notifications = auth()->user()->notifications()->paginate();

        return view('notification.index', ['notifications' => $notifications]);
    }

    public function sendUserNotifications(Request $request)
    {
        try {
            $notificationData = new NotificationData(
                title: $request->input('title'),
                message: $request->input('message'),
                link: $request->input('link'),
                backgroundClass: $request->input('background_class', 'bg-light-success'),
                iconClass: $request->input('icon_class', 'check')
            );

            $this->notificationSystemService->sendNotifications(title: $notificationData->title, message: $notificationData->message, ids: $request->input('user_ids'), type: 'User', link: $notificationData->link, classBg: $notificationData->backgroundClass, classIcon: $notificationData->iconClass);

            return response()->json(['success' => true, 'message' => 'Notifications sent successfully']);

        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function sendDepartmentNotifications(Request $request)
    {
        try {
            $notificationData = new NotificationData(
                title: $request->input('title'),
                message: $request->input('message'),
                link: $request->input('link'),
                backgroundClass: $request->input('background_class', 'bg-light-success'),
                iconClass: $request->input('icon_class', 'check')
            );

            $this->notificationService->sendNotifications(
                notificationData: $notificationData,
                recipientIds: $request->input('department_ids'),
                recipientType: 'Department'
            );

            return response()->json(['success' => true, 'message' => 'Department notifications sent successfully']);

        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
