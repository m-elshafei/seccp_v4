<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum WorkOrderStatusEnum: int
{
    use InvokableCases,Names,Options,Values;

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

    public static function getOptions()
    {
        return array_flip(WorkOrderStatusEnum::options());
    }
}
