<?php

namespace App\Enums;

enum WorkOrderTypeEnum: int
{
    case Constructions = 1;
    case Projects = 2;
    case Emergency = 3;
}
