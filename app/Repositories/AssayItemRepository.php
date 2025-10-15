<?php

namespace App\Repositories;

use App\Models\AssayItem;
use Illuminate\Database\Eloquent\Collection;

class AssayItemRepository
{
 
    public function find(int $id, array $withRelations = []): ?AssayItem
    {
        return AssayItem::with($withRelations)->find($id);
    }
    
    public function findByKeys(int $assayFormId, int $itemId): ?AssayItem
    {
        return AssayItem::where('item_id', $itemId)
                        ->where('assay_form_id', $assayFormId)
                        ->first();
    }
    
    public function create(array $data): AssayItem
    {
        return AssayItem::create($data);
    }

    public function update(AssayItem $assayItem, array $data): AssayItem
    {
        $assayItem->fill($data);
        $assayItem->save();
        return $assayItem;
    }

    public function delete(AssayItem $assayItem): ?bool
    {
        return $assayItem->delete();
    }
}