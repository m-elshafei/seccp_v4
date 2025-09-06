<?php

namespace App\Models;

use App\Models\AppBaseModel;
use App\Models\EmergencyMission;
use Illuminate\Database\Eloquent\SoftDeletes;


class EmergencyMissionsV extends EmergencyMission
{
    use SoftDeletes;

    public $table = 'emergency_missions_v';
    
}
