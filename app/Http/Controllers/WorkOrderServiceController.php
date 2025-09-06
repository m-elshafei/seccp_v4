<?php

namespace App\Http\Controllers;

use App\DataTables\WorkOrderServiceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateWorkOrderServiceRequest;
use App\Http\Requests\UpdateWorkOrderServiceRequest;
use App\Models\ServicesCategory;
use App\Models\Unit;
use App\Models\WorkOrderService;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class WorkOrderServiceController extends AppBaseController
{
    /**
     * Display a listing of the WorkOrderService.
     *
     * @param WorkOrderServiceDataTable $workOrderServiceDataTable
     * @return Response
     */
    public function index(WorkOrderServiceDataTable $workOrderServiceDataTable)
    {
        return $workOrderServiceDataTable->render('work_order_services.index');
    }

    /**
     * Show the form for creating a new WorkOrderService.
     *
     * @return Response
     */
    public function create()
    {
        $units = Unit::pluck('name', 'id');
        $categories = ServicesCategory::pluck('name', 'id');
        return view('work_order_services.create',[
            'units' => $units,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created WorkOrderService in storage.
     *
     * @param CreateWorkOrderServiceRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkOrderServiceRequest $request)
    {
        $input = $request->all();
        $_count = WorkOrderService::where('code','like', $input['code'])->count();
        if ($_count != 0){
            //flash("هذا الكود تم ادخاله من قبل")->error();
            return redirect()->back()->withErrors("هذا الكود تم ادخاله من قبل")->withInput();
        }

        /** @var WorkOrderService $workOrderService */
        $workOrderService = WorkOrderService::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/workOrderServices.singular')]));

        return redirect(route('workOrderServices.index'));
    }

    /**
     * Display the specified WorkOrderService.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var WorkOrderService $workOrderService */
        $workOrderService = WorkOrderService::with(['servicesCategory','unit'])->find($id);

        if (empty($workOrderService)) {
            Flash::error(__('models/workOrderServices.singular').' '.__('messages.not_found'));

            return redirect(route('workOrderServices.index'));
        }

        return view('work_order_services.show')->with('workOrderService', $workOrderService);
    }

    /**
     * Show the form for editing the specified WorkOrderService.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var WorkOrderService $workOrderService */
        $workOrderService = WorkOrderService::find($id);

        if (empty($workOrderService)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrderServices.singular')]));

            return redirect(route('workOrderServices.index'));
        }
        $units = Unit::pluck('name', 'id');
        $categories = ServicesCategory::pluck('name', 'id');
        return view('work_order_services.edit',[
            'workOrderService' => $workOrderService,
            'units' => $units,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified WorkOrderService in storage.
     *
     * @param  int              $id
     * @param UpdateWorkOrderServiceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkOrderServiceRequest $request)
    {
        /** @var WorkOrderService $workOrderService */
        $workOrderService = WorkOrderService::find($id);

        $_count = WorkOrderService::where('id','<>',$id)->where('code','like', $request->get('code'))->count();
        if ($_count != 0){
            //flash("هذا الكود تم ادخاله من قبل")->error();
            return redirect()->back()->withErrors("هذا الكود تم ادخاله من قبل")->withInput();
        }

        if (empty($workOrderService)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrderServices.singular')]));

            return redirect(route('workOrderServices.index'));
        }

        $workOrderService->fill($request->all());
        $workOrderService->save();

        Flash::success(__('messages.updated', ['model' => __('models/workOrderServices.singular')]));

        return redirect(route('workOrderServices.index'));
    }

    /**
     * Remove the specified WorkOrderService from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var WorkOrderService $workOrderService */
        $workOrderService = WorkOrderService::find($id);

        if (empty($workOrderService)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrderServices.singular')]));

            return redirect(route('workOrderServices.index'));
        }

        $workOrderService->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/workOrderServices.singular')]));

        return redirect(route('workOrderServices.index'));
    }
}
