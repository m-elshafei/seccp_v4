<?php
namespace App\Enums;
use ArchTech\Enums\InvokableCases as InvokableCases;
use ArchTech\Enums\Names as Names;
use ArchTech\Enums\Values as Values;
use ArchTech\Enums\Options  as Options;

enum WorkOrderPermitStatusEnum:int {
    use InvokableCases,Names,Values,Options;

    case New = 1;
    case WaitingForPayment = 2;
    case PaidAndIssued = 3;
    case WaitingForProcess = 10;
    case UnderWay = 4;
    case UnderDelivery = 5;
    case InitialDelivery = 6;
    case FinalDelivery = 7;
    case Canceled = 8;
    case Rejected = 9;


    static function getOptions()  {
        return array_flip(WorkOrderPermitStatusEnum::options());
    }
}
