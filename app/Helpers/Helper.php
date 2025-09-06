<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Config;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Auth;
// use App\Helpers\Telegram;
class Helper
{
    public static function applClasses()
    {
        // default data array
        $DefaultData = [
            'mainLayoutType' => 'vertical',
            'theme' => 'light',
            'sidebarCollapsed' => false,
            'navbarColor' => '',
            'horizontalMenuType' => 'floating',
            'verticalMenuNavbarType' => 'floating',
            'footerType' => 'static', //footer
            'layoutWidth' => 'boxed',
            'showMenu' => true,
            'bodyClass' => '',
            'pageClass' => '',
            'pageHeader' => true,
            'contentLayout' => 'default',
            'blankPage' => false,
            'defaultLanguage' => 'ar',
            'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];

        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($DefaultData, config('custom.custom'));

        // All options available in the template
        $allOptions = [
            'mainLayoutType' => array('vertical', 'horizontal'),
            'theme' => array('light' => 'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'),
            'sidebarCollapsed' => array(true, false),
            'showMenu' => array(true, false),
            'layoutWidth' => array('full', 'boxed'),
            'navbarColor' => array('bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'),
            'horizontalMenuType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'),
            'horizontalMenuClass' => array('static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'),
            'verticalMenuNavbarType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'),
            'navbarClass' => array('floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'),
            'footerType' => array('static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'),
            'pageHeader' => array(true, false),
            'contentLayout' => array('default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'),
            'blankPage' => array(false, true),
            'sidebarPositionClass' => array('content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'),
            'contentsidebarClass' => array('content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'),
            'defaultLanguage' => array('ar' => 'ar','en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt'),
            'direction' => array('ltr', 'rtl'),
        ];

        //if mainLayoutType value empty or not match with default options in custom.php config file then set a default value
        foreach ($allOptions as $key => $value) {
            if (array_key_exists($key, $DefaultData)) {
                if (gettype($DefaultData[$key]) === gettype($data[$key])) {
                    // data key should be string
                    if (is_string($data[$key])) {
                        // data key should not be empty
                        if (isset($data[$key]) && $data[$key] !== null) {
                            // data key should not be exist inside allOptions array's sub array
                            if (!array_key_exists($data[$key], $value)) {
                                // ensure that passed value should be match with any of allOptions array value
                                $result = array_search($data[$key], $value, 'strict');
                                if (empty($result) && $result !== 0) {
                                    $data[$key] = $DefaultData[$key];
                                }
                            }
                        } else {
                            // if data key not set or
                            $data[$key] = $DefaultData[$key];
                        }
                    }
                } else {
                    $data[$key] = $DefaultData[$key];
                }
            }
        }

        $employee = Auth::check()
                    ? Employee::where('name', Auth::user()->name)->first()
                    : "";

        $theme = $employee && $employee->theme === 1 ? 'dark' : 'light';
        $layoutClasses = [
            'theme' => $theme ,
            'layoutTheme' => $allOptions['theme'][$theme ],
            'sidebarCollapsed' => $data['sidebarCollapsed'],
            'showMenu' => $data['showMenu'],
            'layoutWidth' => $data['layoutWidth'],
            'verticalMenuNavbarType' => $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass' => $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor' => $data['navbarColor'],
            'horizontalMenuType' => $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass' => $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType' => $allOptions['footerType'][$data['footerType']],
            'sidebarClass' => '',
            'bodyClass' => $data['bodyClass'],
            'pageClass' => $data['pageClass'],
            'pageHeader' => $data['pageHeader'],
            'blankPage' => $data['blankPage'],
            'blankPageClass' => '',
            'contentLayout' => $data['contentLayout'],
            'sidebarPositionClass' => $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass' => $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType' => $data['mainLayoutType'],
            'defaultLanguage' => $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction' => $data['direction'],
        ];
        // set default language if session hasn't locale value the set default language
        if (!session()->has('locale')) {
            app()->setLocale($layoutClasses['defaultLanguage']);
        }

        // sidebar Collapsed
        if ($layoutClasses['sidebarCollapsed'] == 'true') {
            $layoutClasses['sidebarClass'] = "menu-collapsed";
        }

        // blank page class
        if ($layoutClasses['blankPage'] == 'true') {
            $layoutClasses['blankPageClass'] = "blank-page";
        }

        return $layoutClasses;
    }

    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('custom.' . $demo . '.' . $config, $val);
                }
            }
        }
    }

    public static function checkCurrentRouteName($route_name = null)
    {
        if (strpos(Route::currentRouteName(), $route_name.".") !== false) {
            return true;
        }
        if (strpos(Route::currentRouteName(), $route_name) !== false) {
            return true;
        }
        // Helper::checkCurrentRouteName($pageConfigs)
        // dd(Route::currentRouteName());
        return false;
    }

    public static function SendNotifications($title, $message, $ids, $type = 'User', $link = null, $class_bg = 'bg-light-success', $class_icon = 'check')
    {
        //TODO: make try catch here
        // Check if the type is 'Department'
        if ($type == 'Department') {
            if (!is_array($ids)) {
                $ids = [$ids];
            }
            // Find users by department
            $users = Employee::whereIn('department_id', $ids)
                ->whereNotNull('user_id')
                ->with('user')
                ->get();

            // Get user objects
            $usersList = $users->pluck('user');
        } else {
            // Check if the type is 'User'
            if (!is_array($ids)) {
                $ids = [$ids];
            }
            // Find users directly if given user IDs
            $users = User::whereIn('id', $ids)->get();
            $usersList = $users;
        }

        // Send notifications
        Notification::send($usersList, new GeneralNotification($title, $message, $link, $class_bg, $class_icon));

        // self::SendTelegramNotifications($message,$ids);
        // self::SendTelegramNotifications('databaseDump',$file,8);
    }

    public static function SendTelegramNotifications($statusKey,$workOrder,$ids = null,$remainingDays = null)
    {
        try{

            $statusMessage = self::getStatusMessage($statusKey,$workOrder,$remainingDays);
            if (is_int($ids)) {
                $ids = [$ids];
         }
         if (is_array($ids) && !empty($ids)) {
             $users = Employee::whereIn('department_id', $ids)->pluck('name');
             $userNames = $users->implode(' - ');
             Telegram::bot('notification_bot')->sendMessage([
                 'chat_id' => env('TELEGRAM_CHAT_ID'),
                 'text' => $statusMessage . " - " . $userNames,
                 'parse_mode' => 'HTML'
                ]);
         }else {
             Telegram::bot('notification_bot')->sendMessage([
                 'chat_id' => env('TELEGRAM_CHAT_ID'),
                 'text' => $statusMessage,
                 'parse_mode' => 'HTML'
                ]);
            }
        }catch(\Exception $e){}
    }

    public static function getStatusMessage($statusKey,$id,$remainingDays=null)
    {
        $status = [
            'convertDepartment' => 'تم تحويل '.$id.' الي قسم الإعادة والتسليم',
            'restablishWorkInProgress' => 'تم تحويل '.$id.' الي جاري العمل',
           'restablishWorkFinished' => 'تم تحويل '.$id.' الي انتهاء العمل',
            'drillInProgress' => 'تم تحويل '.$id.' الي جاري تنفيذ اعمال الحفر',
            'drillFinished' => 'تم تحويل '.$id.' الي انتهاء اعمال الحفر',
            'updateStatusToStart' => 'تم تحويل '.$id.' الي الاداره التابعة له',
            'temporaryStopped' => 'تم تحويل '.$id.' الي متوقف مؤقتأ',
            'permanentStopped' => 'تم تحويل '.$id.' الي متوقف دائمأ',
            'reOpenDrillingWorkOrder' => 'تم تحويل '.$id.' الي اعاده تنفيذ اعمال الحفر',
            'electricityInProgress' => 'تم تحويل '.$id.' الي جاري تنفيذ اعمال الهوائي',
            'electricalOperationsFinished' => 'تم تحويل '.$id.' الي الانتهاء من اعمال الهوائي',
            'electricalConvertDepartment' => 'تم تحويل '.$id.' الي قسم المستخلصات',
            'toGeneral' => 'تم تحويل '.$id.' الي قسم اعاده الوضع',
            'inProgressStillProgram' => 'تم تحويل '.$id.' الي متبقي البرنامج',
            'databaseDump' => ' تم انشاء نسخه بيانات احتياطيه جديده باسم '. $id,
            'initialDelivery' => 'تم تحويل '.$id.' الي تم التسليم',
            'databaseDeleted' => ' تم حذف نسخه بيانات سابقه باسم '.$id,
            'permitExpiration' => "متبقي على انتهاء التصريح رقم " . $id . ' - ' . $remainingDays . " يوم "



        ];
        return $status[$statusKey] ?? "Status not found: " . $statusKey;
    }

    public static function dateFormat($value , $format='Y-m-d')
    {
        return Carbon::parse($value)->format($format);
    }

    public static function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }

    public static function checkActiveRoute($menuRouteName , $comp_type ="")
    {
        if($comp_type && $comp_type ==4){//  4  ===> for report type
            // Debugbar::info($menuRouteName);
            // Debugbar::info(Route::current()->parameters());
            $routeReportName = "";
            $routeParamters= Route::current()->parameters();
            if($routeParamters  && isset($routeParamters['reportName'])  && $routeParamters['reportName']){
                $routeReportName =$routeParamters['reportName'] ;
            }
            return $routeReportName == $menuRouteName;
        }else{
            $menuRouteArr = array($menuRouteName.'.index',$menuRouteName.'.edit' , $menuRouteName.'.show' , $menuRouteName.'.create' , $menuRouteName );
            return in_array(Route::currentRouteName(), $menuRouteArr);
        }
    }

    public static function redirectAfterSaving($id,$request,$routeName)
    {
        if(isset($request->redirectAction ) && $request->redirectAction  && $request->redirectAction =="edit"){
            return redirect(route($routeName.'.edit',$id));
        }

        return redirect(route($routeName.'.index'));
    }

    public static function getConfigOptionsList($constName)
    {
        $listOptions =collect(config($constName))->map(function ($item, $key) {return $item["title"] ;})->prepend("لا يوجد",0);

        return $listOptions;
    }

    public static function pdfImagePath($image_path)
    {
        if ( env('APP_ENV')=='production') {
            return url($image_path);
        //    return asset($image_path);
        }
        return public_path($image_path);
    }

}
