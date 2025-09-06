<?php
namespace App\Enums;
use ArchTech\Enums\InvokableCases as InvokableCases;
use ArchTech\Enums\Names as Names;
use ArchTech\Enums\Values as Values;
use ArchTech\Enums\Options  as Options;



enum WorkOrderOperationsStatusEnum:int {

    use InvokableCases,Names,Values,Options;

    case NotStarted = 0;
    case WorkingInProgress = 1;
    case WorkingDone = 2;


    static function getOptions()  {
        return array_flip(WorkOrderOperationsStatusEnum::options());
    }
}
