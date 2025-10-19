<?php

namespace App\Http\Controllers;

use App\DataTables\AttachmentTypeDataTable;
use App\Http\Requests\CreateAttachmentTypeRequest;
use App\Http\Requests\UpdateAttachmentTypeRequest;
use App\Models\AttachmentType;
use App\Services\AttachmentTypeService;
use laracasts\flash\Flash;
use Response;

class AttachmentTypeController extends AppBaseController
{
    public $attachmentTypeService;

    public function __construct(AttachmentTypeService $attachmentTypeService)
    {
        $this->attachmentTypeService = $attachmentTypeService;
    }

    public function index(AttachmentTypeDataTable $attachmentTypeDataTable)
    {
        return $attachmentTypeDataTable->render('attachment_types.index');
    }

    /**
     * Show the form for creating a new AttachmentType.
     *
     * @return Response
     */
    public function create()
    {
        return view('attachment_types.create');
    }

    /**
     * Store a newly created AttachmentType in storage.
     *
     *
     * @return Response
     */
    public function store(CreateAttachmentTypeRequest $request)
    {
        $input = $request->validated(); 

        $this->attachmentTypeService->createAttachmentType($input);

        Flash::success(__('messages.saved', ['model' => __('models/attachmentTypes.singular')]));

        return redirect(route('attachmentTypes.index'));
    }

    /**
     * Display the specified AttachmentType.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $attachmentType = $this->attachmentTypeService->find($id);

        if (empty($attachmentType)) {
            Flash::error(__('models/attachmentTypes.singular').' '.__('messages.not_found'));

            return redirect(route('attachmentTypes.index'));
        }

        return view('attachment_types.show')->with('attachmentType', $attachmentType);
    }

    /**
     * Show the form for editing the specified AttachmentType.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $attachmentType = $this->attachmentTypeService->find($id);

        if (empty($attachmentType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attachmentTypes.singular')]));

            return redirect(route('attachmentTypes.index'));
        }

        return view('attachment_types.edit')->with('attachmentType', $attachmentType);
    }

    /**
     * Update the specified AttachmentType in storage.
     *
     * @param  int  $id
     * @return Response
     */


    public function update($id, UpdateAttachmentTypeRequest $request)
    {
        $input = $request->validated();

        $attachmentType = $this->attachmentTypeService->updateAttachmentType($id, $input);

        if (empty($attachmentType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attachmentTypes.singular')]));

            return redirect(route('attachmentTypes.index'));
        }

        Flash::success(__('messages.updated', ['model' => __('models/attachmentTypes.singular')]));

        return redirect(route('attachmentTypes.index'));
    }

    
    /**
     * Remove the specified AttachmentType from storage.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */


    public function destroy($id)
    {
        $isDeleted = $this->attachmentTypeService->deleteAttachmentType($id);

        if (!$isDeleted) {
            Flash::error(__('messages.not_found', ['model' => __('models/attachmentTypes.singular')]));

            return redirect(route('attachmentTypes.index'));
        }

        Flash::success(__('messages.deleted', ['model' => __('models/attachmentTypes.singular')]));

        return redirect(route('attachmentTypes.index'));
    }
    
}
