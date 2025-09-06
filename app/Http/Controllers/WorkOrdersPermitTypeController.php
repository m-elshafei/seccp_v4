<?php

namespace App\Http\Controllers;

use App\DataTables\WorkOrdersPermitTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateWorkOrdersPermitTypeRequest;
use App\Http\Requests\UpdateWorkOrdersPermitTypeRequest;
use App\Models\WorkOrdersPermitType;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class WorkOrdersPermitTypeController extends AppBaseController
{
    /**
     * Display a listing of the WorkOrdersPermitType.
     *
     * @param WorkOrdersPermitTypeDataTable $workOrdersPermitTypeDataTable
     * @return Response
     */
    public function index(WorkOrdersPermitTypeDataTable $workOrdersPermitTypeDataTable)
    {
        return $workOrdersPermitTypeDataTable->render('work_orders_permit_types.index');
    }

    /**
     * Show the form for creating a new WorkOrdersPermitType.
     *
     * @return Response
     */
    public function create()
    {
        return view('work_orders_permit_types.create');
    }

    /**
     * Store a newly created WorkOrdersPermitType in storage.
     *
     * @param CreateWorkOrdersPermitTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkOrdersPermitTypeRequest $request)
    {
        $input = $request->all();

        /** @var WorkOrdersPermitType $workOrdersPermitType */
        $workOrdersPermitType = WorkOrdersPermitType::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/workOrdersPermitTypes.singular')]));

        return redirect(route('workOrdersPermitTypes.index'));
    }

    /**
     * Display the specified WorkOrdersPermitType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var WorkOrdersPermitType $workOrdersPermitType */
        $workOrdersPermitType = WorkOrdersPermitType::find($id);

        if (empty($workOrdersPermitType)) {
            Flash::error(__('models/workOrdersPermitTypes.singular').' '.__('messages.not_found'));

            return redirect(route('workOrdersPermitTypes.index'));
        }

        return view('work_orders_permit_types.show')->with('workOrdersPermitType', $workOrdersPermitType);
    }

    /**
     * Show the form for editing the specified WorkOrdersPermitType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var WorkOrdersPermitType $workOrdersPermitType */
        $workOrdersPermitType = WorkOrdersPermitType::find($id);

        if (empty($workOrdersPermitType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersPermitTypes.singular')]));

            return redirect(route('workOrdersPermitTypes.index'));
        }

        return view('work_orders_permit_types.edit')->with('workOrdersPermitType', $workOrdersPermitType);
    }

    /**
     * Update the specified WorkOrdersPermitType in storage.
     *
     * @param  int              $id
     * @param UpdateWorkOrdersPermitTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkOrdersPermitTypeRequest $request)
    {
        /** @var WorkOrdersPermitType $workOrdersPermitType */
        $workOrdersPermitType = WorkOrdersPermitType::find($id);

        if (empty($workOrdersPermitType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersPermitTypes.singular')]));

            return redirect(route('workOrdersPermitTypes.index'));
        }

        $workOrdersPermitType->fill($request->all());
        $workOrdersPermitType->save();

        Flash::success(__('messages.updated', ['model' => __('models/workOrdersPermitTypes.singular')]));

        return redirect(route('workOrdersPermitTypes.index'));
    }

    /**
     * Remove the specified WorkOrdersPermitType from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var WorkOrdersPermitType $workOrdersPermitType */
        $workOrdersPermitType = WorkOrdersPermitType::find($id);

        if (empty($workOrdersPermitType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersPermitTypes.singular')]));

            return redirect(route('workOrdersPermitTypes.index'));
        }

        $workOrdersPermitType->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/workOrdersPermitTypes.singular')]));

        return redirect(route('workOrdersPermitTypes.index'));
    }
}
