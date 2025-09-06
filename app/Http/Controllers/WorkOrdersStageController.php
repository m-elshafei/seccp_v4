<?php

namespace App\Http\Controllers;

use App\DataTables\WorkOrdersStageDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateWorkOrdersStageRequest;
use App\Http\Requests\UpdateWorkOrdersStageRequest;
use App\Models\WorkOrdersStage;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class WorkOrdersStageController extends AppBaseController
{
    /**
     * Display a listing of the WorkOrdersStage.
     *
     * @param WorkOrdersStageDataTable $workOrdersStageDataTable
     * @return Response
     */
    public function index(WorkOrdersStageDataTable $workOrdersStageDataTable)
    {
        return $workOrdersStageDataTable->render('work_orders_stages.index');
    }

    /**
     * Show the form for creating a new WorkOrdersStage.
     *
     * @return Response
     */
    public function create()
    {
        return view('work_orders_stages.create');
    }

    /**
     * Store a newly created WorkOrdersStage in storage.
     *
     * @param CreateWorkOrdersStageRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkOrdersStageRequest $request)
    {
        $input = $request->all();

        /** @var WorkOrdersStage $workOrdersStage */
        $workOrdersStage = WorkOrdersStage::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/workOrdersStages.singular')]));

        return redirect(route('workOrdersStages.index'));
    }

    /**
     * Display the specified WorkOrdersStage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var WorkOrdersStage $workOrdersStage */
        $workOrdersStage = WorkOrdersStage::find($id);

        if (empty($workOrdersStage)) {
            Flash::error(__('models/workOrdersStages.singular').' '.__('messages.not_found'));

            return redirect(route('workOrdersStages.index'));
        }

        return view('work_orders_stages.show')->with('workOrdersStage', $workOrdersStage);
    }

    /**
     * Show the form for editing the specified WorkOrdersStage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var WorkOrdersStage $workOrdersStage */
        $workOrdersStage = WorkOrdersStage::find($id);

        if (empty($workOrdersStage)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersStages.singular')]));

            return redirect(route('workOrdersStages.index'));
        }

        return view('work_orders_stages.edit')->with('workOrdersStage', $workOrdersStage);
    }

    /**
     * Update the specified WorkOrdersStage in storage.
     *
     * @param  int              $id
     * @param UpdateWorkOrdersStageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkOrdersStageRequest $request)
    {
        /** @var WorkOrdersStage $workOrdersStage */
        $workOrdersStage = WorkOrdersStage::find($id);

        if (empty($workOrdersStage)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersStages.singular')]));

            return redirect(route('workOrdersStages.index'));
        }

        $workOrdersStage->fill($request->all());
        $workOrdersStage->save();

        Flash::success(__('messages.updated', ['model' => __('models/workOrdersStages.singular')]));

        return redirect(route('workOrdersStages.index'));
    }

    /**
     * Remove the specified WorkOrdersStage from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var WorkOrdersStage $workOrdersStage */
        $workOrdersStage = WorkOrdersStage::find($id);

        if (empty($workOrdersStage)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersStages.singular')]));

            return redirect(route('workOrdersStages.index'));
        }

        $workOrdersStage->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/workOrdersStages.singular')]));

        return redirect(route('workOrdersStages.index'));
    }
}
