<?php

namespace App\Http\Controllers;

use App\DataTables\AttachmentTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAttachmentTypeRequest;
use App\Http\Requests\UpdateAttachmentTypeRequest;
use App\Models\AttachmentType;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AttachmentTypeController extends AppBaseController
{
    /**
     * Display a listing of the AttachmentType.
     *
     * @param AttachmentTypeDataTable $attachmentTypeDataTable
     * @return Response
     */
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
     * @param CreateAttachmentTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateAttachmentTypeRequest $request)
    {
        $input = $request->all();

        /** @var AttachmentType $attachmentType */
        $attachmentType = AttachmentType::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/attachmentTypes.singular')]));

        return redirect(route('attachmentTypes.index'));
    }

    /**
     * Display the specified AttachmentType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AttachmentType $attachmentType */
        $attachmentType = AttachmentType::find($id);

        if (empty($attachmentType)) {
            Flash::error(__('models/attachmentTypes.singular').' '.__('messages.not_found'));

            return redirect(route('attachmentTypes.index'));
        }

        return view('attachment_types.show')->with('attachmentType', $attachmentType);
    }

    /**
     * Show the form for editing the specified AttachmentType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var AttachmentType $attachmentType */
        $attachmentType = AttachmentType::find($id);

        if (empty($attachmentType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attachmentTypes.singular')]));

            return redirect(route('attachmentTypes.index'));
        }

        return view('attachment_types.edit')->with('attachmentType', $attachmentType);
    }

    /**
     * Update the specified AttachmentType in storage.
     *
     * @param  int              $id
     * @param UpdateAttachmentTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttachmentTypeRequest $request)
    {
        /** @var AttachmentType $attachmentType */
        $attachmentType = AttachmentType::find($id);

        if (empty($attachmentType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attachmentTypes.singular')]));

            return redirect(route('attachmentTypes.index'));
        }

        $attachmentType->fill($request->all());
        $attachmentType->save();

        Flash::success(__('messages.updated', ['model' => __('models/attachmentTypes.singular')]));

        return redirect(route('attachmentTypes.index'));
    }

    /**
     * Remove the specified AttachmentType from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AttachmentType $attachmentType */
        $attachmentType = AttachmentType::find($id);

        if (empty($attachmentType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attachmentTypes.singular')]));

            return redirect(route('attachmentTypes.index'));
        }

        $attachmentType->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/attachmentTypes.singular')]));

        return redirect(route('attachmentTypes.index'));
    }
}
