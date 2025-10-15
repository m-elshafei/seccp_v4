<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Services\AttachmentService;

class AttachmentController extends Controller
{
    protected $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function download($uuid, Request $request)
    {
        try {

            return $this->attachmentService->downloadFile($uuid);
        } catch (Exception $e) {
            return abort(404, $e->getMessage());
        }
    }

    public function view($uuid, Request $request)
    {
        try {
            return $this->attachmentService->getFileViewUrl($uuid);
        } catch (Exception $e) {
            return abort(404, $e->getMessage());
        }
    }

    public function delete($uuid, Request $request)
    {
        try {
            $this->attachmentService->deleteFile($uuid);

            return redirect()->back()->withSuccess(__('messages.file_deleted'));
        } catch (Exception $e) {
            return abort(404, $e->getMessage());
        }
    }
}
