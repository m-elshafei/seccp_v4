<?php

namespace App\Repositories;

use App\Enums\AssayFormEnum;
use App\Models\AssayForm;
use App\Models\AssayItem;

class AssayFormRepository
{

    public function modal()
    {
        return AssayForm::get();
    }
    
    public function find(int $id)
    {
        return $this->modal()->find($id);
    }

    public function create($input)
    {
        $assayForm = $this->modal()->create($input);

        return $assayForm;
    }

    public function checkAssayForm($workOrderId)
    {
        $assayForm_count = $this->modal()->where('work_order_id', $workOrderId)->count();

        return $assayForm_count;
    }

    public function updateAssayForm($input)
    {
        $assayForm = $this->modal()->create($input);

        return $assayForm;
    }

    public function updateWorkOrders($workOrders)
    {
        $workOrders->save();

        return $workOrders;
    }

      public function update(AssayForm $assayForm, array $data): AssayForm
    {
        $assayForm->fill($data);
        $assayForm->save();
        
        return $assayForm;
    }
    public function getApprovedFormByWorkOrderId(int $workOrderId)
    {
        return $this->modal()->where([
            'work_order_id' => $workOrderId,
            'status' => AssayFormEnum::APPROVED_ASSAY,
        ])->first();
    }

    public function findForPrint(int $id)
    {
        return AssayForm::with([
            'assayItem.item.unit', 
            'assayService.service', 
            'workType', 
            'workOrder.consultant'
        ])->find($id);
    }


      public function getAssayServicesByFormId(int $formId)
    {
        return \App\Models\AssayService::where('assay_form_id', $formId)->with('service')->get();
    }

    public function getAssayItemsByFormId(int $formId)
    {
        return AssayItem::where('assay_form_id', $formId)->with('item')->get();
    }

    public function delete(AssayForm $assayForm): ?bool
    {
        return $assayForm->delete();
    }


   public function findForApproval(int $id): ?AssayForm
    {

        return AssayForm::with('workOrder.workOrdersProject')->find($id);
    }


    public function updateStatus(AssayForm $assayForm, int $status): AssayForm
    {
        $assayForm->status = $status;
        $assayForm->save();
        
        return $assayForm;
    }


    public function updateAmount(AssayForm $assayForm, float $amount): AssayForm
    {
        $assayForm->amount = $amount;
        $assayForm->save();
        return $assayForm;
    }
}
