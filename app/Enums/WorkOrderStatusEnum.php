<?php
namespace App\Enums;
use ArchTech\Enums\InvokableCases as InvokableCases;
use ArchTech\Enums\Names as Names;
use ArchTech\Enums\Values as Values;
use ArchTech\Enums\Options  as Options;



enum WorkOrderStatusEnum:int {

    use InvokableCases,Names,Values,Options;

    case New = 1;
    case NotStarted = 2;
    case WorkingInProgress = 3;
    case WorkingDone = 4;
    case DeliveryDone = 5;
    case TemporaryStopped = 6;
    case Canceled = 7;
    case Archived = 8;
    case WorkingInProgressStillProgram = 9;
    case PermanentStoped = 10;

    static function getOptions()  {
        return array_flip(WorkOrderStatusEnum::options());
    }
}
