<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LandLayerHistory extends Model
{
    use HasFactory;
    use Branchable;
    use SoftDeletes;
    use CreatedUpdatedBy;

    public $fillable = [
        'work_order_id',
        'work_orders_permit_id',
        'land_layer_id',
        'event_type',
        'user_id',
        'lab_id',
        'layer_id',
        'layer_status',
        'lab_result_status',
        'note'
    ];

    public function layer()
    {
        return $this->belongsTo(Layer::class)->withDefault();
    }

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class)->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }

    public function land_layer(){
        return $this->belongsTo(LandLayer::class)->withDefault();
    }
}
