<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyMissionsV extends EmergencyMission
{
    use SoftDeletes;

    public $table = 'emergency_missions_v';
}
