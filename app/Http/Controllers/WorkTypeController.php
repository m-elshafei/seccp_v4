<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Http\Requests;
use App\Models\WorkType;
use App\Models\Department;
use App\DataTables\WorkTypeDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateWorkTypeRequest;
use App\Http\Requests\UpdateWorkTypeRequest;

class WorkTypeController extends AppBaseController
{
    /**
     * Display a listing of the WorkType.
     *
     * @param WorkTypeDataTable $workTypeDataTable
     * @return Response
     */
    public function index(WorkTypeDataTable $workTypeDataTable)
    {
        return $workTypeDataTable->render('work_types.index');
    }

    /**
     * Show the form for creating a new WorkType.
     *
     * @return Response
     */
    public function create()
    {
        $departmentsList =Department::pluck('name', 'id');
        $departmentsList->prepend("اختر","");
        return view('work_types.create',compact('departmentsList'));
    }

    /**
     * Store a newly created WorkType in storage.
     *
     * @param CreateWorkTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkTypeRequest $request)
    {
        $input = $request->all();

        /** @var WorkType $workType */
        $workType = WorkType::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/workTypes.singular')]));

        return redirect(route('workTypes.index'));
    }

    /**
     * Display the specified WorkType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var WorkType $workType */
        $workType = WorkType::find($id);

        if (empty($workType)) {
            Flash::error(__('models/workTypes.singular').' '.__('messages.not_found'));

            return redirect(route('workTypes.index'));
        }

        return view('work_types.show')->with('workType', $workType);
    }

    /**
     * Show the form for editing the specified WorkType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var WorkType $workType */
        $workType = WorkType::find($id);

        if (empty($workType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workTypes.singular')]));

            return redirect(route('workTypes.index'));
        }
        $departmentsList =Department::pluck('name', 'id');
        $departmentsList->prepend("اختر","");
        return view('work_types.edit' ,compact('workType','departmentsList'));
    }

    /**
     * Update the specified WorkType in storage.
     *
     * @param  int              $id
     * @param UpdateWorkTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkTypeRequest $request)
    {
        /** @var WorkType $workType */
        $workType = WorkType::find($id);

        if (empty($workType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workTypes.singular')]));

            return redirect(route('workTypes.index'));
        }

        $workType->fill($request->all());
        $workType->save();

        Flash::success(__('messages.updated', ['model' => __('models/workTypes.singular')]));

        return redirect(route('workTypes.index'));
    }

    /**
     * Remove the specified WorkType from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var WorkType $workType */
        $workType = WorkType::find($id);

        if (empty($workType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workTypes.singular')]));

            return redirect(route('workTypes.index'));
        }

        $workType->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/workTypes.singular')]));

        return redirect(route('workTypes.index'));
    }
}
