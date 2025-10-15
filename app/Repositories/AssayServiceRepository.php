<?php

namespace App\Repositories;

use App\Models\AssayService;

class AssayServiceRepository
{
    public function find(int $id)
    {
        return AssayService::find($id);
    }
    
    public function findByKeys(int $formId, int $serviceId)
    {
        return AssayService::where(['service_id' => $serviceId, 'assay_form_id' => $formId])->first();
    }
    
    public function create(array $data): AssayService
    {
        return AssayService::create($data);
    }

    public function update(AssayService $assayService, array $data): AssayService
    {
        $assayService->fill($data);
        $assayService->save();
        return $assayService;
    }
    
    public function delete(AssayService $assayService): bool
    {
        return $assayService->delete();
    }
    
    public function getServicesByFormId(int $formId)
    {
        return AssayService::where('assay_form_id', $formId)->get();
    }
}