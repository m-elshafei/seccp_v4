<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum WorkOrderOperationsStatusEnum: int
{
    use InvokableCases,Names,Options,Values;

    case NotStarted = 0;
    case WorkingInProgress = 1;
    case WorkingDone = 2;

    public static function getOptions()
    {
        return array_flip(WorkOrderOperationsStatusEnum::options());
    }
}
