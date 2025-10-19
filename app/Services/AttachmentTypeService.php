<?php

namespace App\Services;

use App\Repositories\AttachmentTypeRepository;
use App\Models\AttachmentType;

class AttachmentTypeService
{
    protected AttachmentTypeRepository $attachmentTypeRepository;

    public function __construct(AttachmentTypeRepository $attachmentTypeRepository)
    {
        $this->attachmentTypeRepository = $attachmentTypeRepository;
    }

 
    public function createAttachmentType(array $data): AttachmentType
    {
        $attachmentType = $this->attachmentTypeRepository->create($data);

        return $attachmentType;
    }

    public function find(int $id): ?AttachmentType
    {
        return $this->attachmentTypeRepository->find($id);
    }

    public function updateAttachmentType(int $id, array $data): ?AttachmentType
    {
        $attachmentType = $this->attachmentTypeRepository->update($id, $data);

        return $attachmentType;
    }


    public function deleteAttachmentType(int $id): bool
    {

        $isDeleted = $this->attachmentTypeRepository->delete($id);

        return $isDeleted;
    }


}