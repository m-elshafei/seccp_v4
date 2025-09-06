<?php

namespace App\Models;

use App\Models\AppBaseModel;
use App\Enums\WorkOrderStatusEnum;
use App\Enums\WorkOrderOperationsStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrderTransactionsHistory extends AppBaseModel
{
    use HasFactory;

    protected $table = "work_order_transactions_history";

    public $fillable = [
        'work_order_id',
        'user_id',
        'work_order_number',
        'new_status',
        'old_status',
        'new_department',
        'old_department',
        'description',
        'type',
        'note',
    ];
    
    protected $casts = [
        'work_order_id' => 'integer',
        'user_id' => 'integer',
        'work_order_number' => 'string',
        'old_status' => 'integer',
        'new_status' => 'integer',
        'old_department' => 'integer',
        'new_department' => 'integer',
        'type' => 'integer',
        'description' => 'string',
        'note' => 'string'
    ];

    static function  createTransactionsHistory($workOrder , $type)  : WorkOrderTransactionsHistory {
        // dd($workOrder);
        $statusFieldName = "status";
        if($type == 1){
            $workOrder->status=1;
            $description= 'انشاء أمر العمل';
            $note = "تم انشاء أمر العمل بواسطة المستخدم " . auth()->user()->name . " من الادارة : " .    session('current_department_name' );
        }elseif($type == 2){
            $description= 'تغيير حالة امر العمل';
            $note = "تم تغيير حالة امر العمل الى " . __("models/workOrders.status.".WorkOrderStatusEnum::getOptions()[ $workOrder->status]) ;
        }elseif ($type==3) {
            if($workOrder->currentDepartment()->first()){
                $description= 'تغيير الادارة المسئولة';
                $note = "تم تغيير الادارة المسئولة عن أمر العمل الى " . " " . $workOrder->currentDepartment()->first()->name ?? "({$workOrder->current_department_id})";
            }else{
                $description= 'تم ازالة الادارة المسئولة';
                $note = "تم ازالة الادارة المسئولة عن أمر العمل عن طريق اداره   " . session('current_department_name' ) ;
            }
            
        }elseif ($type==4) {
            $statusFieldName = "drilling_status";
            $description= 'تغيير حالة الحفر';
            $note = "تم تغيير حالة الحفر لأمر العمل الى " . __("models/workOrders.drillingStatus.".WorkOrderOperationsStatusEnum::getOptions()[ $workOrder->drilling_status]) ;
        }elseif ($type==5) {
            $statusFieldName = "electrical_operations_status";
            $description= 'تغيير حالة الاعمال الكهربائية';
            $note = "تم تغيير حالة الاعمال الكهربائية لأمر العمل الى " . __("models/workOrders.drillingStatus.".WorkOrderOperationsStatusEnum::getOptions()[ $workOrder->electrical_operations_status]) ;
        }
        return WorkOrderTransactionsHistory::create([
            'work_order_id'         => $workOrder->id,
            'user_id'               => auth()->id(),
            'work_order_number'     => $workOrder->work_order_number,
            'new_status'            => $workOrder->{"$statusFieldName"},
            'old_status'            => $workOrder->getOriginal($statusFieldName),
            'new_department'        => $workOrder->current_department_id,
            'old_department'        => $workOrder->getOriginal('current_department_id'),
            'type'                  => $type,
            'description'           => $description,
            'note'                  => $note,
        ]);

    }
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

}
