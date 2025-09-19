<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum WorkOrderPermitStatusEnum: int
{
    use InvokableCases,Names,Options,Values;

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

    public static function getOptions()
    {
        return array_flip(WorkOrderPermitStatusEnum::options());
    }
}
