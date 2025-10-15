<?php

namespace App\Services;

use App\Repositories\AssayServiceRepository;
use App\Repositories\WorkOrderServiceRepository;
use App\Repositories\AssayFormRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\AssayService;

class AssayServiceService
{
    protected $assayServiceRepo;
    protected $workOrderServiceRepo;
    protected $assayFormRepo;

    public function __construct(
        AssayServiceRepository $assayServiceRepo,
        WorkOrderServiceRepository $workOrderServiceRepo,
        AssayFormRepository $assayFormRepo
    ) {
        $this->assayServiceRepo = $assayServiceRepo;
        $this->workOrderServiceRepo = $workOrderServiceRepo;
        $this->assayFormRepo = $assayFormRepo;
    }

 
    protected function calculatePrice(int $serviceId, float $quantity): float
    {
        $service = $this->workOrderServiceRepo->find($serviceId);
        if (empty($service)) {
            throw new ModelNotFoundException("WorkOrderService with ID $serviceId not found.");
        }
        return $service->price * $quantity;
    }
    
    public function recalculateFormAmount(int $formId): void
    {
        $assayForm = $this->assayFormRepo->find($formId);
        if (empty($assayForm)) {
            throw new ModelNotFoundException("AssayForm with ID $formId not found for recalculation.");
        }
        
        $assayServices = $this->assayServiceRepo->getServicesByFormId($formId);
        $amount = $assayServices->sum('price');
        
        $this->assayFormRepo->updateAmount($assayForm, $amount);
    }
    
    public function findOrCreateAndUpdate(array $input): AssayService
    {
        $serviceId = $input['service_id'];
        $formId = $input['assay_form_id'];
        $quantity = $input['quantity'];
        
        $result = $this->assayServiceRepo->findByKeys($formId, $serviceId);
        
        if ($result) {
            $newQuantity = $quantity + $result->quantity;
            $newPrice = $this->calculatePrice($serviceId, $newQuantity);
            
            $result->quantity = $newQuantity;
            $result->price = $newPrice;
            $result->save();
        } else {
            $price = $this->calculatePrice($serviceId, $quantity);
            $input['price'] = $price;
            $result = $this->assayServiceRepo->create($input);
        }
        
        $this->recalculateFormAmount($formId);
        
        return $result;
    }

    public function getAssayService(int $id): AssayService
    {
        $assayService = $this->assayServiceRepo->find($id);
        if (empty($assayService)) {
            throw new ModelNotFoundException('Assay item not found');
        }
        return $assayService;
    }

    public function updateAssayService(int $id, array $input): AssayService
    {
        $assayService = $this->getAssayService($id);
        
        $newPrice = $this->calculatePrice($input['service_id'], $input['quantity']);
        $input['price'] = $newPrice;
        
        $assayService = $this->assayServiceRepo->update($assayService, $input);
        
        $this->recalculateFormAmount($assayService->assay_form_id);
        
        return $assayService;
    }

    public function deleteAssayService(int $id): bool
    {
        $assayService = $this->getAssayService($id);
        $formId = $assayService->assay_form_id;
        
        $this->assayServiceRepo->delete($assayService);
        
        $this->recalculateFormAmount($formId);
        return true;
    }
    

    public function addServicesToForm(int $formId, array $servicesMap): void
    {
        foreach ($servicesMap as $service_id => $count) {
            if ($count <= 0) {
                continue;
            }

            $assayService = $this->assayServiceRepo->findByKeys($formId, $service_id);
            $data = ['assay_form_id' => $formId, 'service_id' => $service_id, 'quantity' => $count];
            
            if (empty($assayService)) {
                $assayService = $this->assayServiceRepo->create($data);
            } else {
                $assayService->quantity = $assayService->quantity + $count;
                $assayService->save();
            }


            $newPrice = $this->calculatePrice($service_id, $assayService->quantity);
            $assayService->price = $newPrice;
            $assayService->save();
        }

        $this->recalculateFormAmount($formId);
    }
}