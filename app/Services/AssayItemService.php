<?php

namespace App\Services;

use App\Repositories\AssayItemRepository;
use App\Models\AssayItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AssayItemService
{
    protected $assayItemRepository;

    public function __construct(AssayItemRepository $assayItemRepository)
    {
        $this->assayItemRepository = $assayItemRepository;
    }

    protected function calculateReturnedValues(array $input): array
    {
        $spend = $input['spend'];
        $used = $input['used'];
        $_returned = $spend - $used;

        if ($_returned < 0) {
            $returned_spend = $used - $spend;
            $returned = 0;
        } else {
            $returned_spend = 0;
            $returned = $_returned;
        }

        return compact('returned', 'returned_spend');
    }

    public function storeOrUpdateAssayItem(array $input): AssayItem
    {
        $calculated = $this->calculateReturnedValues($input);

        $fillable = array_merge([
            'assay_form_id' => $input['assay_form_id'],
            'item_id' => $input['item_id'],
            'spend' => $input['spend'],
            'used' => $input['used'],
        ], $calculated);

        $result = $this->assayItemRepository->findByKeys($input['assay_form_id'], $input['item_id']);

        if ($result) {

            return $this->assayItemRepository->update($result, $fillable);
        } else {

            return $this->assayItemRepository->create($fillable);
        }
    }
    
 
    public function getAssayItemWithItem(int $id): AssayItem
    {
        $assayItem = $this->assayItemRepository->find($id, ['item']);
        if (empty($assayItem)) {
            throw new ModelNotFoundException('Assay item not found');
        }
        return $assayItem;
    }

    public function getAssayItem(int $id): AssayItem
    {
        $assayItem = $this->assayItemRepository->find($id);
        if (empty($assayItem)) {
            throw new ModelNotFoundException('Assay item not found');
        }
        return $assayItem;
    }

    public function updateAssayItem(int $id, array $input): AssayItem
    {
        $assayItem = $this->getAssayItem($id);
        
        $calculated = $this->calculateReturnedValues($input);
        
        $fillable = array_merge([
            'item_id' => $input['item_id'],
            'spend' => $input['spend'],
            'used' => $input['used'],
        ], $calculated);
        
        return $this->assayItemRepository->update($assayItem, $fillable);
    }
    
    public function deleteAssayItem(int $id): bool
    {
        $assayItem = $this->getAssayItem($id);
        
        $this->assayItemRepository->delete($assayItem);
        return true;
    }
}