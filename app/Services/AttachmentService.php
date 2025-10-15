<?php

namespace App\Services;

use App\Repositories\AttachmentRepository;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\RedirectResponse;
use Exception;

class AttachmentService
{
    protected $attachmentRepository;

    public function __construct(AttachmentRepository $attachmentRepository)
    {
        $this->attachmentRepository = $attachmentRepository;
    }

    protected function getFullPath(\App\Models\Attachment $file): string
    {

        return $file->path . DIRECTORY_SEPARATOR . $file->name;
    }

    public function downloadFile(string $uuid): StreamedResponse
    {
        $file = $this->attachmentRepository->findByUuid($uuid);

        if (empty($file)) {
            throw new Exception(__('messages.errors.file_not_found'));
        }

        $fullPath = $this->getFullPath($file);

        if (Storage::exists($fullPath)) {
            return Storage::download($fullPath, $file->filename);
        }

        throw new Exception(__('messages.errors.file_not_found'));
    }


    public function getFileViewUrl(string $uuid): RedirectResponse
    {
        $file = $this->attachmentRepository->findByUuid($uuid);

        if (empty($file)) {
            throw new Exception(__('messages.errors.file_not_found'));
        }

        $fullPath = $this->getFullPath($file);

        if (Storage::exists($fullPath)) {
       
            return redirect(Storage::url($fullPath)); 
        }

        throw new Exception(__('messages.errors.file_not_found'));
    }
    

    public function deleteFile(string $uuid): bool
    {
        $file = $this->attachmentRepository->findByUuid($uuid);

        if (empty($file)) {
            throw new Exception(__('messages.errors.file_not_found'));
        }
        
        $fullPath = $this->getFullPath($file);
        
        if (Storage::exists($fullPath)) {

            Storage::delete($fullPath);
            
            $this->attachmentRepository->delete($file);
            
            return true;
        }

        throw new Exception(__('messages.errors.file_not_found'));
    }
}