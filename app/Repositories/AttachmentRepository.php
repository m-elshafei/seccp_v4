<?php

namespace App\Repositories;

use App\Models\Attachment;

class AttachmentRepository
{

    public function findByUuid(string $uuid): ?Attachment
    {
        return Attachment::where('uuid', $uuid)->first();
    }
    

    public function delete(Attachment $attachment): ?bool
    {
        return $attachment->delete();
    }
}