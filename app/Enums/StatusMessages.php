<?php

namespace App\Enums;

class StatusMessages
{
    const CONVERT_DEPARTMENT = 'convertDepartment';
    const RESTABLISH_WORK_IN_PROGRESS = 'restablishWorkInProgress';
    const RESTABLISH_WORK_FINISHED = 'restablishWorkFinished';
    const DRILL_IN_PROGRESS = 'drillInProgress';
    const DRILL_FINISHED = 'drillFinished';
    const UPDATE_STATUS_TO_START = 'updateStatusToStart';
    const TEMPORARY_STOPPED = 'temporaryStopped';
    const PERMANENT_STOPPED = 'permanentStopped';
    const REOPEN_DRILLING_WORK_ORDER = 'reOpenDrillingWorkOrder';
    const ELECTRICITY_IN_PROGRESS = 'electricityInProgress';
    const ELECTRICAL_OPERATIONS_FINISHED = 'electricalOperationsFinished';
    const ELECTRICAL_CONVERT_DEPARTMENT = 'electricalConvertDepartment';
    const TO_GENERAL = 'toGeneral';
    const IN_PROGRESS_STILL_PROGRAM = 'inProgressStillProgram';
    const DATABASE_DUMP = 'databaseDump';
    const INITIAL_DELIVERY = 'initialDelivery';
    const DATABASE_DELETED = 'databaseDeleted';
    const PERMIT_EXPIRATION = 'permitExpiration';


    // Store the messages in a private static array
    private static array $messages = [
        self::CONVERT_DEPARTMENT => 'تم تحويل %s الي قسم الإعادة والتسليم',
        self::RESTABLISH_WORK_IN_PROGRESS => 'تم تحويل %s الي جاري العمل',
        self::RESTABLISH_WORK_FINISHED => 'تم تحويل %s الي انتهاء العمل',
        self::DRILL_IN_PROGRESS => 'تم تحويل %s الي جاري تنفيذ اعمال الحفر',
        self::DRILL_FINISHED => 'تم تحويل %s الي انتهاء اعمال الحفر',
        self::UPDATE_STATUS_TO_START => 'تم تحويل %s الي الاداره التابعة له',
        self::TEMPORARY_STOPPED => 'تم تحويل %s الي متوقف مؤقتأ',
        self::PERMANENT_STOPPED => 'تم تحويل %s الي متوقف دائمأ',
        self::REOPEN_DRILLING_WORK_ORDER => 'تم تحويل %s الي اعاده تنفيذ اعمال الحفر',
        self::ELECTRICITY_IN_PROGRESS => 'تم تحويل %s الي جاري تنفيذ اعمال الهوائي',
        self::ELECTRICAL_OPERATIONS_FINISHED => 'تم تحويل %s الي الانتهاء من اعمال الهوائي',
        self::ELECTRICAL_CONVERT_DEPARTMENT => 'تم تحويل %s الي قسم المستخلصات',
        self::TO_GENERAL => 'تم تحويل %s الي قسم اعاده الوضع',
        self::IN_PROGRESS_STILL_PROGRAM => 'تم تحويل %s الي متبقي البرنامج',
        self::DATABASE_DUMP => ' تم انشاء نسخه بيانات احتياطيه جديده باسم %s',
        self::INITIAL_DELIVERY => 'تم تحويل %s الي تم التسليم',
        self::DATABASE_DELETED => ' تم حذف نسخه بيانات سابقه باسم %s',
        self::PERMIT_EXPIRATION => "متبقي على انتهاء التصريح رقم %s - %s يوم",
    ];

    /**
     * Get the formatted status message.
     *
     * @param string $statusKey
     * @param mixed ...$replacements
     * @return string
     */
    public static function getMessage(string $statusKey, ...$replacements): string
    {
        $template = self::$messages[$statusKey] ?? "Status not found: " . $statusKey;

        if (str_contains($template, '%s')) {
            return sprintf($template, ...$replacements);
        }

        return $template;
    }
}
