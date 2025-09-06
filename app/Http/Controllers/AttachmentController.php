<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function download($uuid, Request $request){

        if ($file = Attachment::where('uuid', $uuid)->first()) {
            if(Storage::exists($file->path.DIRECTORY_SEPARATOR.$file->name)){
                return Storage::download($file->path.$file->name, $file->filename);
            }
        }
        return abort(404, __('messages.errors.file_not_found'));
    }

    public function view($uuid, Request $request){
        if ($file = Attachment::where('uuid', $uuid)->first()) {
            if(Storage::exists($file->path.DIRECTORY_SEPARATOR.$file->name)){
                return redirect(Storage::url($file->path.$file->name, $file->filename));
            }
        }
        return abort(404, __('messages.errors.file_not_found'));
    }

    public function delete($uuid, Request $request){
        if ($file = Attachment::where('uuid', $uuid)->first()) {
            if(Storage::exists($file->path.DIRECTORY_SEPARATOR.$file->name)){
                Storage::delete($file->path.$file->name, $file->filename);
                $file->delete();
                return redirect()->back()->withSuccess(__('messages.file_deleted'));
            }
        }
        return abort(404, __('messages.errors.file_not_found'));
    }


}
