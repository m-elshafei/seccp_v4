<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Carbon\Carbon;
use App\Models\Branch;
use App\Helpers\Helper;
use App\Models\District;
use App\Models\Employee;
use App\Models\WorkType;
use App\Models\WorkOrder;
use App\Enums\JobNameEnum;
use App\Models\Consultant;
use App\Models\Contractor;
use App\Models\Department;
use App\Utils\SessionUtil;
use App\Models\WorkOrderNote;
use App\Models\WorkOrdersType;
use App\Models\WorkOrdersProject;
use App\Enums\WorkOrderStatusEnum;
use App\Utils\GeographicPointUtil;
use Illuminate\Support\Facades\DB;
use App\Models\ElectricalOperation;
use App\Models\WorkOrderTransactionsHistory;
use App\Models\ElectricityDepartment;
use App\Models\ElectricalStationsType;
use Illuminate\Support\Facades\Redirect;
use App\Models\ElectricityCompanyEmployees;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateWorkOrderRequest;
use App\Http\Requests\UpdateWorkOrderRequest;
use App\Services\WorkOrders\WorkOrderService;
use App\Http\Requests\CreateAttachmentRequest;

class WorkOrderController extends AppBaseController
{

    private $workOrderService;

    function __construct(WorkOrderService $workOrderService) {
        $this->workOrderService = $workOrderService;
    }
    /**
     * Display a listing of the WorkOrder.
     *
     * @return Response
     */
    public function index()
    {
        return $this->workOrderService->getWorkOrderDataTable();
    }

    /**
     * Show the form for creating a new WorkOrder.
     *
     * @return Response
     */
    public function create()
    {
        $workPeriodDefaultValue=30;
        $mode=$this->workOrderService->mode;
        $branchData=Branch::find(SessionUtil::getCurrentBranch());
        if($branchData){
            $city_id = $branchData->city_id;
        }else{
            return redirect(route('login'));
        }

        $workTypes = WorkType::all()->map->only('id', 'full_name')->pluck('full_name', 'id')->prepend("اختر","");
        $districts = District::where("city_id",$city_id)->pluck('name', 'id')->prepend("اختر","");
        $consultants = Consultant::pluck('name', 'id')->prepend("اختر","");
        $electricityDepartments =ElectricityDepartment::pluck('name', 'id')->prepend("اختر","");
        $electricityCompanyEmployees =ElectricityCompanyEmployees::pluck('name', 'id')->prepend("اختر","");
        $electricalStationsTypes =ElectricalStationsType::pluck('name', 'id')->prepend("اختر","");
        $workOrdersTypes =WorkOrdersType::pluck('name', 'id');

        return view('work_orders.create', compact('workTypes','mode','districts','electricityDepartments','electricalStationsTypes','workPeriodDefaultValue','consultants','workOrdersTypes','electricityCompanyEmployees','electricityDepartments'));
    }

    /**
     * Store a newly created WorkOrder in storage.
     *
     * @param CreateWorkOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkOrderRequest $request)
    {
        $workOrderCount = WorkOrder::where('work_order_number',$request->work_order_number)->where('work_type_id',$request->work_type_id)->count();
        if ($workOrderCount) {
            Flash::error('لا يمكن الحفظ رقم العمل موجود من قبل مع نفس نوع العمل');
            return Redirect::back();
        }

        $result = $this->workOrderService->createWorkOrder($request);

        Flash::success(__('messages.saved', ['model' => __('models/workOrders.singular')]));

        return Helper::redirectAfterSaving($result->id,$request,$this->workOrderService->routeName); // return redirect(route('workOrders.index'));
    }

    /**
     * Display the specified WorkOrder.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var WorkOrder $workOrder */
        $workOrder = WorkOrder::find($id);
        $workOrderHistory= WorkOrderTransactionsHistory::where('work_order_id',$id)->get();
        $mode=$this->workOrderService->mode;
        if (empty($workOrder)) {
            Flash::error(__('models/workOrders.singular').' '.__('messages.not_found'));

            return redirect(route('workOrders.index'));
        }

        return view('work_orders.show',compact('workOrder','mode','workOrderHistory'));
    }

    /**
     * Show the form for editing the specified WorkOrder.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $branchData= Branch::find(SessionUtil::getCurrentBranch());
        $mode=$this->workOrderService->mode;
        /********************* */
        $workTypes = WorkType::all()->map->only('id', 'full_name')->pluck('full_name', 'id')->prepend("اختر","");
        $districts = District::where("city_id",$branchData->city_id)->pluck('name', 'id')->prepend("اختر","");
        $electricityDepartments = ElectricityDepartment::pluck('name', 'id')->prepend("اختر","");
        $electricityCompanyEmployees = ElectricityCompanyEmployees::pluck('name', 'id')->prepend("اختر","");
        $electricalStationsTypes = ElectricalStationsType::pluck('name', 'id')->prepend("اختر","");
        $workOrdersProject = WorkOrdersProject::where('status',1)->pluck('name', 'id')->prepend("اختر","");
        $contractors = Contractor::pluck('name', 'id')->prepend("اختر","");
        $consultants = Consultant::pluck('name', 'id')->prepend("اختر","");
        $employees = Employee::where("job_id",JobNameEnum::Observer)->pluck('name', 'id')->prepend("اختر","");
        $departmentsList =Department::pluck('name', 'id');
        $departmentsList->prepend("اختر","");
        $workOrdersTypes =WorkOrdersType::pluck('name', 'id');
        /********************* */
        $workOrder = WorkOrder::with(['workOrdersNotes', 'landscape', 'electrical_operation', 'meters', 'electricity_tower'])->find($id);
        if (empty($workOrder)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrders.singular')]));

            return redirect(route('workOrders.index'));
        }
        /******************** */
        if($workOrder->x_axis && $workOrder->y_axis){
            $point = GeographicPointUtil::createUTMPoint($workOrder->x_axis ,$workOrder->y_axis);
            $workOrder->utm_easting = $point['utm_easting'] ;
            $workOrder->utm_northing = $point['utm_northing'] ;
        }

        // if($workOrder->utm_easting && $workOrder->utm_northing){
        //     // dd($workOrder->utm_easting);
        //     $result = GeographicPointUtil::createXYPoint($workOrder->utm_easting ,$workOrder->utm_northing);
        //     $workOrder->x_axis = $result['lat'] ;
        //     $workOrder->y_axis = $result['lng'] ;
        // }

        return view('work_orders.edit_'.$mode,compact('mode','employees', 'contractors', 'workOrder', 'workTypes','districts','electricityDepartments','electricalStationsTypes','workOrdersProject','departmentsList','consultants','workOrdersTypes','electricityCompanyEmployees'));
    }

    /**
     * Update the specified WorkOrder in storage.
     *
     * @param  int              $id
     * @param UpdateWorkOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkOrderRequest $request)
    {
        /** @var WorkOrder $workOrder */
        //$mode = $this->mode;
        $workOrder = WorkOrder::find($id);

        if (empty($workOrder)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrders.singular')]));

            return redirect(route('workOrders.index'));
        }

        if (!empty($workOrder->current_department_id)) {
            if(!$request->utm_easting &&  !$request->utm_northing && !$request->x_axis && !$request->y_axis){
                Flash::error('الموقع على الخريطة مطلوب');
                return Redirect::back();
            }
        }

        if($request->utm_easting && $request->utm_northing && !$request->x_axis && !$request->y_axis){
            $result = GeographicPointUtil::createXYPoint($request->utm_easting ,$request->utm_northing);
            $request->request->add(['x_axis' => $result['lat']]); //add request
            $request->request->add(['y_axis' => $result['lng']]); //add request
        }

        $this->workOrderService->updateWorkOrder($request, $workOrder);

        Flash::success(__('messages.updated', ['model' => __('models/workOrders.singular')]));

        return Helper::redirectAfterSaving($id,$request,$this->workOrderService->routeName);
    }

    public function updateStatus($statusKey,$id,$redirectTo="")
    {
        if(!$redirectTo){
            $redirectTo='workOrders';
        }
        /** @var WorkOrder $workOrder */
        $workOrder = WorkOrder::find($id);
        if (empty($workOrder)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrders.singular')]));

            return Redirect::back();
        }

        if (empty($workOrder->owner_department_id)) {
            Flash::error('برجاء ادخال الاداره التى سيتم التحويل اليها أمر العمل ثم القيام بعمليه الحفظ');

            return Redirect::back();
        }

        /****start validation updateStatus of work order****** */
        if(!$this->workOrderService->validateWorkOrderToUpdateStatus($workOrder,$statusKey)){
            return Redirect::back();
        }
        /****end validation updateStatus of work order****** */
        DB::beginTransaction();
        $input=$this->workOrderService->getUpdatedData($statusKey,$workOrder);
        $redirectAction = $this->workOrderService->GetUpdateStatusRedirectAction($statusKey);
        $this->workOrderService->createStopNote($statusKey,$workOrder);
        $this->workOrderService->updateElectricalOperationStatus($statusKey,$workOrder);
        // $this->workOrderService->sendNotificationBasedOnStatus($statusKey,$workOrder,$input);
        $message = 'تم تحويل التصريح رقم ' . $workOrder->work_order_number . ' الي اعاده الوضع';

        // //Helper::SendTelegramNotifications($message, $workOrder->current_department_id);
        $workOrderNumber = $workOrder->work_order_number ?? $workOrder->mission_number;
        // dd($workOrderNumber,$workOrder->current_department_id);

        Helper::SendTelegramNotifications($statusKey,$workOrder->work_order_number,$workOrder->current_department_id);


        if($input){
            $workOrder->fill($input);
            $result = $workOrder->save();
            if(!$result){
                DB::rollBack();
                Flash::error(__('messages.not_found', ['model' => __('models/workOrders.singular')]));
                return Redirect::back();
            }else{
                DB::commit();
                Flash::success(__('messages.updated', ['model' => __('models/workOrders.singular')]));
            }
        }

        return redirect(route($redirectTo.'.'.$redirectAction,$workOrder->id));
    }

    public function update_attachment($id, CreateAttachmentRequest $request)
    {
        /** @var WorkOrder $workOrder */
        $workOrder = WorkOrder::find($id);

        if (empty($workOrder)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrders.singular')]));

            return redirect()->back();
        }

        $workOrder->fill($request->all());
        $workOrder->save();

        Flash::success(__('messages.updated', ['model' => __('models/workOrders.singular')]));

        return redirect()->back();
    }

    /**
     * Remove the specified WorkOrder from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var WorkOrder $workOrder */
        $workOrder = WorkOrder::find($id);

        if (empty($workOrder)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrders.singular')]));

            return redirect(route('workOrders.index'));
        }

        if ($workOrder->status != 1 ) {
            Flash::error(__('models/workOrders.validations.delete_error_workorder_new', ['model' => __('models/workOrders.singular')]));
            return Redirect::back();

        }

        $workOrder->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/workOrders.singular')]));

        return redirect(route('workOrders.index'));
    }
}
