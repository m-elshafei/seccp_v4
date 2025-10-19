<?php

namespace App\Repositories;

use App\Models\AttachmentType;

class AttachmentTypeRepository
{
    
    public function create(array $data): AttachmentType
    {
        return AttachmentType::create($data);
    }

    public function find(int $id): ?AttachmentType
    {
        return AttachmentType::find($id);
    }

    public function update(int $id, array $data): ?AttachmentType
    {
        $attachmentType = $this->find($id);

        if ($attachmentType) {
            $attachmentType->fill($data);
            $attachmentType->save();
        }

        return $attachmentType;
    }


    
}