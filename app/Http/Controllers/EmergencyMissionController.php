<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Http\Requests;
use App\Models\Branch;
use App\Helpers\Helper;
use App\Models\District;
use App\Models\Employee;
use App\Models\WorkType;
use App\Models\WorkOrder;
use App\Enums\JobNameEnum;
use App\Utils\SessionUtil;
use App\Models\MissionType;

use App\Models\SystemComponent;
use App\Enums\WorkOrderTypeEnum;
use App\Models\EmergencyMission;
use App\Enums\WorkOrderStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Models\EmergencyIssuesType;
use App\Models\LandscapeInformation;
use App\Models\ElectricityDepartment;
use Illuminate\Support\Facades\Route;
use App\Models\ElectricalStationsType;
use function PHPUnit\Framework\isEmpty;
use App\Enums\WorkOrderPermitStatusEnum;
use Illuminate\Support\Facades\Redirect;
use App\Models\WorkOrderEmergencyMissions;
use App\Models\ElectricityCompanyEmployees;
use App\Http\Controllers\AppBaseController;
use App\Models\WorkOrderTransactionsHistory;
use App\DataTables\EmergencyMissionDataTable;
use App\Services\WorkOrders\WorkOrderService;
use App\Http\Requests\CreateAttachmentRequest;
use App\Http\Requests\CreateEmergencyMissionRequest;
use App\Http\Requests\UpdateEmergencyMissionRequest;
use App\Http\Requests\CreateEmergencyWorkOrderRequest;

class EmergencyMissionController extends AppBaseController
{
    private $workOrderService;

    function __construct(WorkOrderService $workOrderService) {
        $this->workOrderService = $workOrderService;
    }
    /**
     * Display a listing of the EmergencyMission.
     *
     * @param EmergencyMissionDataTable $emergencyMissionDataTable
     * @return Response
     */
    public function index()
    {
        return $this->workOrderService->getEmergencyMissionDataTable();
    }



    /**
     * Show the form for creating a new EmergencyMission.
     *
     * @return Response
     */
    public function create()
    {
        $branchData=Branch::find(SessionUtil::getCurrentBranch());
        if($branchData){
            $city_id = $branchData->city_id;
        }else{
            // $city_id= 1;
            return redirect(route('login'));
        }

        // $workTypes = WorkType::all()->map->only('id', 'full_name')->pluck('full_name', 'id')->prepend("اختر","");
        $districts = District::where("city_id",$city_id)->pluck('name', 'id')->prepend("اختر","");
        $missionTypes = MissionType::pluck('name', 'id')->prepend("اختر","");
        $missionReceivedEmployees =Employee::where("job_id",JobNameEnum::Observer)->pluck('name', 'id')->prepend("اختر","");
        $electricalStationsTypes =ElectricalStationsType::pluck('name', 'id')->prepend("اختر","");
        $emergencyWorkOrders =EmergencyMission::where('is_emergency_mission',0)->where('work_orders_type_id',WorkOrderTypeEnum::Emergency)->pluck('work_order_number', 'id')->prepend("اختر","");
        $emergencyIssuesType =EmergencyIssuesType::pluck('name', 'id')->prepend("اختر","");
        $electricityCompanyEmployees =ElectricityCompanyEmployees::pluck('name', 'id')->prepend("اختر","");
        return view('emergency_missions.create', compact('districts','missionReceivedEmployees','electricalStationsTypes','missionTypes','emergencyWorkOrders','emergencyIssuesType','electricityCompanyEmployees'));
    }

    /**
     * Store a newly created EmergencyMission in storage.
     *
     * @param CreateEmergencyMissionRequest $request
     *
     * @return Response
     */
    public function store(CreateEmergencyMissionRequest $request)
    {
        // $input = $request->all();

        // /** @var EmergencyMission $emergencyMission */
        // $emergencyMission = EmergencyMission::create($input);
        if( in_array(session('current_department_id'),[3,5])){
            $request->request->add(['current_department_id' => session('current_department_id')]); //add request
            $request->request->add(['owner_department_id' => session('current_department_id')]); //add request
        }else{
            $request->request->add(['current_department_id' => 5]); //add request
            $request->request->add(['owner_department_id' => 5]);
        }
        // dd($request->all());
        $request->request->add(['is_emergency_mission' => 1]); //add request
        // $request->request->add(['owner_department_id' => 5]); //add request
        $request->request->add(['status' => 2]); //add request
        // $request->request->add(['electricity_company_employee_id ' => 2]); //add request
        DB::beginTransaction();
        // dd($request->all());
        $emergencyMission = $this->workOrderService->createWorkOrder($request);
        $emergencyMissionDetail = $this->workOrderService->creatEmergencyMissionDetail($request, $emergencyMission);
        DB::commit();
        Flash::success(__('messages.saved', ['model' => __('models/emergencyMissions.singular')]));

        // return redirect(route('emergencyMissions.index'));
        return Helper::redirectAfterSaving($emergencyMission->id,$request,'emergencyMissions');
    }

    /**
     * Display the specified EmergencyMission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var EmergencyMission $emergencyMission */
        $emergencyMission = EmergencyMission::find($id);
        $workOrder = WorkOrder::find($id);
        $workOrderHistory= WorkOrderTransactionsHistory::where('work_order_id',$id)->get();
        $mode=$this->workOrderService->mode;
        if (empty($emergencyMission) && empty($workOrder)) {
            Flash::error(__('models/emergencyMissions.singular').' '.__('messages.not_found'));

            return redirect(route('emergencyMissions.index'));
        }

        return view('emergency_missions.show',compact('workOrder','mode','workOrderHistory','emergencyMission'));
    }

    /**
     * Show the form for editing the specified EmergencyMission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $branchData=Branch::find(SessionUtil::getCurrentBranch());
        if($branchData){
            $city_id = $branchData->city_id;
        }else{
            // $city_id= 1;
            return redirect(route('login'));
        }
        /** @var EmergencyMission $emergencyMission */
        $emergencyMission = EmergencyMission::find($id);

        if (empty($emergencyMission)) {
            Flash::error(__('messages.not_found', ['model' => __('models/emergencyMissions.singular')]));

            return redirect(route('emergencyMissions.index'));
        }
        $workTypes = WorkType::all()->map->only('id', 'full_name')->pluck('full_name', 'id')->prepend("اختر","");
        $emergencyWorkOrders =EmergencyMission::where('work_orders_type_id',WorkOrderTypeEnum::Emergency)->pluck('work_order_number', 'id')->prepend("اختر","");
        // dd($emergencyWorkOrders);
        $districts = District::where("city_id",$city_id)->pluck('name', 'id')->prepend("اختر","");
        $missionTypes = MissionType::pluck('name', 'id')->prepend("اختر","");
        $missionReceivedEmployees =Employee::where("job_id",JobNameEnum::Observer)->pluck('name', 'id')->prepend("اختر","");
        $workOrderEmergencyMissions = WorkOrderEmergencyMissions::where('work_order_id',$emergencyMission->id)->first();
        $emergencyIssuesType =EmergencyIssuesType::pluck('name', 'id')->prepend("اختر","");
        $electricityCompanyEmployees =ElectricityCompanyEmployees::pluck('name', 'id')->prepend("اختر","");
        return view('emergency_missions.edit', compact('workOrderEmergencyMissions','emergencyMission','districts','workTypes','missionReceivedEmployees','missionTypes','emergencyWorkOrders','emergencyIssuesType','electricityCompanyEmployees'));
    }

    /**
     * Update the specified EmergencyMission in storage.
     *
     * @param  int              $id
     * @param UpdateEmergencyMissionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEmergencyMissionRequest $request)
    {
        /** @var EmergencyMission $emergencyMission */
        $emergencyMission = EmergencyMission::find($id);
        DB::beginTransaction();
        if (empty($emergencyMission)) {
            Flash::error(__('messages.not_found', ['model' => __('models/emergencyMissions.singular')]));

            return redirect(route('emergencyMissions.index'));
        }
        $request->merge(['user_id'=>auth()->id()]);
        LandscapeInformation::updateOrCreate(['work_order_id' => $emergencyMission->id], $request->all());
        // $this->workOrderNotesService->save($request, $workOrder);
        // $emergencyMission->fill($request->all());
        // $emergencyMission->save();
        //dd($request->all(),$emergencyMission);
        $this->workOrderService->updateWorkOrder($request, $emergencyMission);
        $emergencyMissionDetail = $this->workOrderService->creatEmergencyMissionDetail($request, $emergencyMission);
        DB::commit();
        Flash::success(__('messages.updated', ['model' => __('models/emergencyMissions.singular')]));

        // return redirect(route('emergencyMissions.index'));
        return Helper::redirectAfterSaving($id,$request,'emergencyMissions');

    }

    public function updateStatus($statusKey,$id,$redirectTo="EmergencyMissions")
    {
        /** @var WorkOrder $workOrder */
        $emergencyMission = EmergencyMission::find($id);



        if (empty($emergencyMission)) {
            Flash::error(__('messages.not_found', ['model' => __('models/emergencyMissions.singular')]));
            return redirect(route($redirectTo.'.index'));
        }

        $redirectAction = 'edit';
        if ($statusKey=="convertDepartment"){
            if (!$emergencyMission->workOrdersPermits()->where("work_orders_permit_type_id",1)->where("status",WorkOrderPermitStatusEnum::PaidAndIssued)->first()){//  3 => "تم السداد والاصدار"
                Flash::error(__('models/emergencyMissions.validations.noWorkOrdersPermitsFound'), ['model' => __('models/workOrders.singular')]);
                return redirect(route($redirectTo.'.'.$redirectAction,$emergencyMission->id));
            }
        }
        if ($statusKey=="restablishWorkInProgress"){
            $emergencyMission->status = WorkOrderStatusEnum::WorkingInProgress->value;
        }else if ($statusKey=="restablishWorkFinished"){
            $emergencyMission->status = WorkOrderStatusEnum::WorkingDone->value;
            $emergencyMission->electrical_operations_status = 1;
        }else if ($statusKey=="convertDepartment"){
//            $emergencyMission->status = WorkOrderStatusEnum::WorkingDone->value;
            $emergencyMission->electrical_operations_status = 1;
            $emergencyMission['current_department_id']=4;  //قسم الإعادة والتسليم

        }
        WorkOrderTransactionsHistory::createTransactionsHistory($emergencyMission,$emergencyMission->status);
        // $this->workOrderService->sendNotificationBasedOnStatus($statusKey,$emergencyMission,$emergencyMission['current_department_id']);
        $message = 'تم تحويل التصريح رقم ' . $emergencyMission->id . ' الي اعاده الوضع';

        // //Helper::SendTelegramNotifications($message, $emergencyMission->current_department_id);
        $emergencyNumber = $emergencyMission->work_order_number ?? $emergencyMission->mission_number;

                // dd($emergencyMission->current_department_id);
        Helper::SendTelegramNotifications($statusKey,$emergencyNumber,$emergencyMission->current_department_id);



        $emergencyMission->save();

        Flash::success(__('messages.updated', ['model' => __('models/emergencyMission.singular')]));

        return redirect(route($redirectTo.'.'.$redirectAction,$emergencyMission->id));
    }


    public function convertToWorkOrder($id,  CreateEmergencyWorkOrderRequest $request)
    {
        // dd(WorkOrder::where("work_order_number",$request->work_order_number)->first());
        //received_date
        $workOrder= WorkOrder::where("work_order_number",$request->work_order_number)->first();
        if ($workOrder) {
            Flash::error("لا يمكن اضافة أمر العمل بهذا الرقم لانه موجود من قبل ");

            return redirect()->back();
        }
        $emergencyMission = EmergencyMission::find($id);
        $workOrder = WorkOrder::find($id);

        $newWorkOrder = $workOrder->replicate([
            'mission_number',
            'mission_typeـid',
            'is_emergency_mission',
            'mission_opreation_number',
            //'mission_meter_number',
            'shift_number',
            'mission_number',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ])->fill([
            'work_order_number' => $request->work_order_number,
            'work_type_id' => $request->work_type_id,
            'received_date' => $request->received_date,
            'work_orders_type_id' =>3,
            // 'created_at' =>3,
            // 'work_orders_type_id' =>3
        ]);
        // $newWorkOrder->mission_number = null;
        // $newWorkOrder->work_type_id = $request->work_type_id;
        // $newWorkOrder->mission_typeـid = null;
        // $newWorkOrder->is_emergency_mission = 0;
        // $newWorkOrder->mission_opreation_number = null;
        // $newWorkOrder->mission_meter_number = null;
        // $newWorkOrder->shift_number = null;
        // $newWorkOrder->electricity_employee_name = null;
        // $newWorkOrder->work_orders_type_id = 3;
        // $newWorkOrder->shift_number = null;
        // $newWorkOrder->shift_number = null;
        // $newWorkOrder->created_at = Carbon::now();
        $newWorkOrder->save();
        $emergencyMission->parent_id=$newWorkOrder->id;
        $emergencyMission->save();
        // Flash::success(__('messages.updated', ['model' => __('models/emergencyMission.singular')]));
        Flash::success("تم انشاء أمر العمل بنجاح برقم " . $request->work_order_number);

        return redirect()->back();
        // dd($newWorkOrder->id);
    }

    public function update_attachment($id, CreateAttachmentRequest $request)
    {
        // dd($request);
        /** @var emergencyMission $emergencyMission */
        $emergencyMission = EmergencyMission::find($id);

        if (empty($emergencyMission)) {
            Flash::error(__('messages.not_found', ['model' => __('models/emergencyMission.singular')]));

            return redirect()->back();
        }

        $emergencyMission->fill($request->all());
        $emergencyMission->save();

        Flash::success(__('messages.updated', ['model' => __('models/emergencyMission.singular')]));

        return redirect()->back();
    }

    /**
     * Remove the specified EmergencyMission from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var EmergencyMission $emergencyMission */
        $emergencyMission = EmergencyMission::find($id);

        if (empty($emergencyMission)) {
            Flash::error(__('messages.not_found', ['model' => __('models/emergencyMissions.singular')]));

            return redirect(route('emergencyMissions.index'));
        }

        $emergencyMission->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/emergencyMissions.singular')]));

        return redirect(route('emergencyMissions.index'));
    }
}
