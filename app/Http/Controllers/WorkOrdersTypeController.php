<?php

namespace App\Http\Controllers;

use App\DataTables\WorkOrdersTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateWorkOrdersTypeRequest;
use App\Http\Requests\UpdateWorkOrdersTypeRequest;
use App\Models\WorkOrdersType;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class WorkOrdersTypeController extends AppBaseController
{
    /**
     * Display a listing of the WorkOrdersType.
     *
     * @param WorkOrdersTypeDataTable $workOrdersTypeDataTable
     * @return Response
     */
    public function index(WorkOrdersTypeDataTable $workOrdersTypeDataTable)
    {
        return $workOrdersTypeDataTable->render('work_orders_types.index');
    }

    /**
     * Show the form for creating a new WorkOrdersType.
     *
     * @return Response
     */
    public function create()
    {
        return view('work_orders_types.create');
    }

    /**
     * Store a newly created WorkOrdersType in storage.
     *
     * @param CreateWorkOrdersTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkOrdersTypeRequest $request)
    {
        $input = $request->all();

        /** @var WorkOrdersType $workOrdersType */
        $workOrdersType = WorkOrdersType::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/workOrdersTypes.singular')]));

        return redirect(route('workOrdersTypes.index'));
    }

    /**
     * Display the specified WorkOrdersType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var WorkOrdersType $workOrdersType */
        $workOrdersType = WorkOrdersType::find($id);

        if (empty($workOrdersType)) {
            Flash::error(__('models/workOrdersTypes.singular').' '.__('messages.not_found'));

            return redirect(route('workOrdersTypes.index'));
        }

        return view('work_orders_types.show')->with('workOrdersType', $workOrdersType);
    }

    /**
     * Show the form for editing the specified WorkOrdersType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var WorkOrdersType $workOrdersType */
        $workOrdersType = WorkOrdersType::find($id);

        if (empty($workOrdersType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersTypes.singular')]));

            return redirect(route('workOrdersTypes.index'));
        }

        return view('work_orders_types.edit')->with('workOrdersType', $workOrdersType);
    }

    /**
     * Update the specified WorkOrdersType in storage.
     *
     * @param  int              $id
     * @param UpdateWorkOrdersTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkOrdersTypeRequest $request)
    {
        /** @var WorkOrdersType $workOrdersType */
        $workOrdersType = WorkOrdersType::find($id);

        if (empty($workOrdersType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersTypes.singular')]));

            return redirect(route('workOrdersTypes.index'));
        }

        $workOrdersType->fill($request->all());
        $workOrdersType->save();

        Flash::success(__('messages.updated', ['model' => __('models/workOrdersTypes.singular')]));

        return redirect(route('workOrdersTypes.index'));
    }

    /**
     * Remove the specified WorkOrdersType from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var WorkOrdersType $workOrdersType */
        $workOrdersType = WorkOrdersType::find($id);

        if (empty($workOrdersType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersTypes.singular')]));

            return redirect(route('workOrdersTypes.index'));
        }

        $workOrdersType->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/workOrdersTypes.singular')]));

        return redirect(route('workOrdersTypes.index'));
    }
}
