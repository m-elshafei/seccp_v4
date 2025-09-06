<?php
  
namespace App\Enums;

use Ramsey\Uuid\Type\Integer;

enum WorkOrderTypeEnum:int {
    case Constructions = 1;
    case Projects = 2;
    case Emergency = 3;
}