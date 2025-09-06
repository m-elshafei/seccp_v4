<?php

namespace App\Services\WorkOrders;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\District;
use App\Models\Employee;
use App\Models\WorkType;
use App\Models\Consultant;
use App\Models\Department;
use App\Utils\SessionUtil;
use Laracasts\Flash\Flash;
use App\Models\MissionType;
use App\Models\WorkOrderNote;
use App\Enums\WorkOrderStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Models\ElectricalOperation;
use App\Models\ElectricityDepartment;
use Illuminate\Support\Facades\Route;
use App\DataTables\WorkOrderDataTable;
use App\Enums\WorkOrderPermitStatusEnum;
use App\Models\WorkOrderEmergencyMissions;
use App\Models\ElectricityCompanyEmployees;
use App\DataTables\EmergencyMissionDataTable;
use Illuminate\Support\Facades\Request;
use App\DataTables\EmergencyMissionElectricTowersDataTable;
use App\DataTables\EmergencyMissionOnlyDataTable;
use App\DataTables\WorkOrderDrillingDataTable;
use App\DataTables\WorkOrderElectricDataTable;
use App\Services\WorkOrders\BaseWorkOrderService;
use App\Services\WorkOrders\WorkOrderNotesService;
use App\DataTables\WorkOrderElectricTowerDataTable;
use App\Services\WorkOrders\DrillingWorkOrderService;
use App\Services\WorkOrders\ElectricWorkOrderService;
use App\DataTables\WorkOrderDrillingProjectsDataTable;
use App\Models\LandscapeInformation;
use App\Models\WorkOrder;
use App\Services\WorkOrders\ElectricTowerWorkOrderService;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Contractor;


class WorkOrderService extends BaseWorkOrderService
{
    public  $mode ;
    public  $routeName ;
    private $electricWorkOrderService;
    private $drillingWorkOrderService;
    private $electricTowerWorkOrderService;
    private $workOrderNotesService;

    function __construct(
                            DrillingWorkOrderService $drillingWorkOrderService ,
                            ElectricWorkOrderService $electricWorkOrderService,
                            ElectricTowerWorkOrderService $electricTowerWorkOrderService,
                            WorkOrderNotesService $workOrderNotesService
                        )
    {
        $routeArr = explode(".", Route::currentRouteName());
        $this->routeName = $routeArr[0];
        $this->mode = $this->getModeName($this->routeName);

        $this->electricWorkOrderService = $electricWorkOrderService;
        $this->drillingWorkOrderService = $drillingWorkOrderService;
        $this->electricTowerWorkOrderService = $electricTowerWorkOrderService;
        $this->workOrderNotesService=$workOrderNotesService;

    }

    public function getWorkOrderDataTable()
    {

        $workOrderStatus=$this->getStausFromConfig('work_order_general_status');
        $workOrderPrimitStatus=$this->getStausFromConfig('work_order_permit_status');
        $workOrderDrillingStatus=$this->getStausFromConfig('work_order_drilling_status');
        $workTypes = WorkType::all()->map->only('id', 'full_name')->pluck('full_name', 'id')->prepend("اختر","");
        $city_id =SessionUtil::getCurrentCityByBranch();
        $districts = District::where("city_id",$city_id)->pluck('name', 'id')->prepend("اختر","");
        $departments = Department::pluck('name', 'id')->prepend("غير مرتبط بإدارة","null")->prepend("اختر","");
        $electricityDepartments =ElectricityDepartment::pluck('name', 'id')->prepend("اختر","");
        $electricityCompanyEmployees = ElectricityCompanyEmployees::pluck('name', 'id')->prepend("اختر","");
        $consultant = Consultant::pluck('name', 'id')->prepend("اختر","");
        $landInformation = LandscapeInformation::pluck('drilling_employee_id')->toArray();
        // $employees = Employee::whereIn('id', $landInformation)->pluck('name', 'name') ->prepend("اختر", "");
        $employees = Contractor::pluck('company_name', 'company_name')->merge(Employee::whereIn('id', $landInformation)->pluck('name', 'name'))->prepend('اختر', '');

        $screen_name = $this->routeName;
        $mode = $this->mode;

        if($this->mode == "drilling"){
            $workOrderDataTable = new WorkOrderDrillingDataTable;
        }elseif ($this->mode == "drillingProjects"){
            $workOrderDataTable = new WorkOrderDrillingProjectsDataTable;
        }elseif ($this->mode == "electricity"){
            $workOrderDataTable = new WorkOrderElectricDataTable;
        }elseif($this->mode == "electricTowers"){
            $workOrderDataTable = new WorkOrderElectricTowerDataTable;
        }else{
            $workOrderDataTable = new WorkOrderDataTable;
        }

        return $workOrderDataTable->render('work_orders.index',compact('consultant','departments','screen_name','mode','workTypes','districts','workOrderStatus','electricityDepartments','electricityCompanyEmployees','employees','workOrderDrillingStatus','workOrderPrimitStatus'));
    }

    public function createWorkOrder($request)
    {
        $workOrder = parent::createWorkOrder($request);
        $this->workOrderNotesService->save($request, $workOrder);
        // dd($workOrder);
        return $workOrder ;
    }

    public function creatEmergencyMissionDetail($request ,$emergencyMission)
    {
        $dataArray= [];
        // dd($request->electricity_employee_name);
        $dataArray['mission_received_employee']     = $request->get("mission_received_employee");
        $dataArray['mission_operation_number']      = $request->get("mission_operation_number");
        $dataArray['mission_meter_number']          = $request->get("mission_meter_number");
        $dataArray['electricity_employee_name']     = $request->get("electricity_employee_name");
        if($request->get("mission_executed_worker_type")) $dataArray['mission_executed_worker_type']  = $request->get("mission_executed_worker_type");
        if($request->get("mission_executed_employee_id")) $dataArray['mission_executed_employee_id']  = $request->get("mission_executed_employee_id");
        if($request->get("mission_executed_contractor_id")) $dataArray['mission_executed_contractor_id']= $request->get("mission_executed_contractor_id");
        $dataArray['mission_complete_date']         = $request->get("mission_complete_date") ?? null;
        $dataArray['branch_id']                     = $emergencyMission->branch_id;
        $dataArray['emergency_issues_type_id']      = $request->get("emergency_issues_type_id") ?? null;
        // $dataArray['electricity_company_employee_id ']      = ['electricity_company_employee_id '=>5]  ?? null;
        $dataArray['electricity_company_employee_id ']      = $request->get("electricity_company_employee_id")  ?? null;
        $WorkOrderEmergencyMissions= WorkOrderEmergencyMissions::updateOrCreate([
            'work_order_id'     => $emergencyMission->id
        ],$dataArray);
        // dd($WorkOrderEmergencyMissions);
        return $WorkOrderEmergencyMissions ;
    }
    public function updateWorkOrder($request, $workOrder)
    {
        $request->merge([
            'user_id' => auth()->id()
        ]);

        DB::transaction(function () use ($request, $workOrder) {
            $this->workOrderNotesService->save($request, $workOrder);

            if ($this->mode == "drilling") {
                $this->drillingWorkOrderService->updateWorkOrder($request, $workOrder);
                $this->electricWorkOrderService->updateWorkOrder($request, $workOrder);
            }elseif ($this->mode == "electricity"){
                $this->electricWorkOrderService->updateWorkOrder($request, $workOrder);
            }elseif($this->mode == "electricTowers"){
                $this->drillingWorkOrderService->updateWorkOrder($request, $workOrder);
                $this->electricTowerWorkOrderService->updateWorkOrder($request, $workOrder);
                $this->electricWorkOrderService->updateWorkOrder($request, $workOrder);
            }
            if($request->is_project){
                $request->request->add(['work_orders_type_id' => '2']); //مشاريع
            }
            parent::updateWorkOrder($request, $workOrder);

        },1);
        return $workOrder;
    }

    public function validateWorkOrderToUpdateStatus($workOrder,$status)
    {
        if ($status=="convertDepartment"){
            if (!empty($workOrder->needs_work_orders_permit)) {
               // dd($workOrder->workOrdersPermits()->where("work_orders_permit_type_id",1)->whereIn("status",[WorkOrderPermitStatusEnum::PaidAndIssued,WorkOrderPermitStatusEnum::WaitingForProcess])->count());
                $count = $workOrder->workOrdersPermits()->where("work_orders_permit_type_id",1)->whereIn("status",[WorkOrderPermitStatusEnum::PaidAndIssued,WorkOrderPermitStatusEnum::WaitingForProcess])->count();
                if (!$count){//  3 => "تم السداد والاصدار"
                    Flash::error(__('models/workOrders.validations.noWorkOrdersPermitsFound'), ['model' => __('models/workOrders.singular')]);
                    return false;
                }
            }
            if ($workOrder->needs_drilling_operations  && $workOrder->drilling_status != 2){
                Flash::error(__('models/workOrders.validations.drillingStatusNotFinished'), ['model' => __('models/workOrders.singular')]);
                return false;
            }
            //TODO: must move this condition on work order finish
            // if($workOrder->needs_electrical_work && $workOrder->electrical_operations_status != 2){
            //     Flash::error(__('models/workOrders.validations.electricalOperationsNotFinished'), ['model' => __('models/workOrders.singular')]);
            //     return false;
            // }

        }
        return true;
    }

    public function getStausFromConfig($configName , $fieldTitle = 'title',$reportFilterMode=false)
    {
        $collection = collect(config("const." .$configName ));
        $grouped = $collection->mapWithKeys(function ($item, $key) use ($fieldTitle,$reportFilterMode)  {
            if($reportFilterMode){
                return [$key."||".$item[$fieldTitle ] => $item[$fieldTitle ]];
            }else{
                return [$key => $item[$fieldTitle ]];
            }

        });
        return ['' => 'الكل'] + $grouped->all();
    }

    public function getEmergencyMissionDataTable()
    {

        $workOrderStatus=$this->getStausFromConfig('work_order_general_status');
        $missionTypes = MissionType::pluck('name', 'id')->prepend("اختر","");

        $city_id =SessionUtil::getCurrentCityByBranch();
        // $currentDepartmentId = WorkOrder::pluck('current_department_id')->toArray();
        // $currentDepartment = Department::whereIn('id',$currentDepartmentId)->pluck('name','id')->prepend("اختر","");
        $currentDepartment = Department::whereIn('id',[1,2,3,4,5,6])->pluck('name','id')->prepend("اختر","");
        $districts = District::where("city_id",$city_id)->pluck('name', 'id')->prepend("اختر","");
        $screen_name = $this->routeName;
        $mode = $this->mode;

        $emergencyMissionDataTable = new EmergencyMissionDataTable;
        $lastSegment = last(explode('/', Request::url()));

        if ($lastSegment == 'electricTowers'){
            $EmergencyMissionElectricTowersDataTable = new EmergencyMissionElectricTowersDataTable();
            return $EmergencyMissionElectricTowersDataTable->render('emergency_missions.index',compact('screen_name','mode','districts','missionTypes','workOrderStatus','currentDepartment'));
        }else if ($lastSegment == 'emergency'){
            $EmergencyMissionOnlyDataTable = new EmergencyMissionOnlyDataTable();
            return $EmergencyMissionOnlyDataTable->render('emergency_missions.index',compact('screen_name','mode','districts','missionTypes','workOrderStatus','currentDepartment'));
        }else {
            return $emergencyMissionDataTable->render('emergency_missions.index',compact('screen_name','mode','districts','missionTypes','workOrderStatus','currentDepartment'));
        }
    }

    function getUpdatedData($statusKey,$workOrder)  {
         $input=[];
        if ($statusKey=="updateStatusToStart"){//تحويل أمر العمل الى الاداره التابعة من اوامر العمل العامة
            $workTypeData = WorkType::find($workOrder->work_type_id);
            if($workTypeData){
                if(!$workOrder->owner_department_id ){
                    if($workTypeData->default_department_id){
                        $input['current_department_id'] = $workTypeData->default_department_id;
                        $input['owner_department_id'] = $workTypeData->default_department_id;
                    }
                }else{
                    $input['current_department_id'] = $workOrder->owner_department_id;
                }
                $title="استلام أمر عمل جديد";
                $message= "تم تحويل أمر العمل رقم " . $workOrder->work_order_number ?? $workOrder->mission_number . " الى الادارة الخاصة بك";
                Helper::SendNotifications($title,$message, 7,'Department','/workOrdersManagement/workOrders/'.$workOrder->id,'bg-light-success', 'check');
                Helper::SendNotifications($title,$message, $input['current_department_id'],'Department','/workOrdersManagement/workOrders/'.$workOrder->id,'bg-light-success', 'check');

            }
            $input['status']=2;
        }
        else if ($statusKey=="drillInProgress"){
            $input['status']=3;//جارى التنفيذ
            $input['drilling_status']=1;//جارى التنفيذ
        }else if ($statusKey=="drillFinished"){
            $input['drilling_status']=2;//تم التنفيذ
        }else if ($statusKey=="convertDepartment"){
            $input['current_department_id']=4;//قسم الإعادة والتسليم
            $this->permitsNotTransferred($workOrder);
            $title="استلام أمر عمل جديد";
            $message= "تم تحويل أمر العمل رقم " . $workOrder->work_order_number . "  الى الادارة الخاصة بك" . " مع كل التصاريح المرتبطة";
            Helper::SendNotifications($title,$message, 4,'Department','/workOrdersManagement/workOrders/'.$workOrder->id,'bg-light-success', 'check');

        }else if ($statusKey=="temporaryStopped"){
            $input['stop_note'] = request("stop_note");
            $input['stop_date'] = Carbon::now()->toDateString();
            $input['status']=WorkOrderStatusEnum::TemporaryStopped->value;//متوقف

        }else if ($statusKey=="permanentStopped"){
            $input['stop_note'] = request("stop_note");
            $input['stop_date'] = Carbon::now()->toDateString();
            $input['status']=WorkOrderStatusEnum::PermanentStoped->value;//متوقف

        }else if ($statusKey=="reOpenDrillingWorkOrder"){
            $input['status']=3;//جارى التنفيذ
            $input['drilling_status']=1;//جارى التنفيذ
        }else if ($statusKey=="electricityInProgress"){
            $input['status']=3;//جارى التنفيذ
            $input['electrical_operations_status']=1;//جارى التنفيذ

        }else if ($statusKey=="electricalOperationsFinished"){
            // TODO chnage department number to read from sesstion  current department id
            if ($workOrder->current_department_id== 2){
                $input['status']=4;
            }
            $input['electrical_operations_status']=2;//تم التنفيذ

        }else if ($statusKey=="electricalConvertDepartment"){
            $input['status']=5;
            $input['current_department_id']=6;//قسم المستخلصات
        }else if ($statusKey=="toGeneral"){
            $input['status']=1;
            $input['current_department_id']=null;
            $input['electrical_operations_status']=0;
            $input['drilling_status']=0;
        }else if ($statusKey=="inProgressStillProgram"){
            $input['status']=WorkOrderStatusEnum::WorkingInProgressStillProgram->value;
        }
        Helper::SendTelegramNotifications($statusKey,$workOrder->work_order_number,$workOrder->current_department_id);
        return $input;
    }

    function permitsNotTransferred($workOrder) {
        $workOrderPermits = $workOrder->workOrdersPermits;

        foreach ($workOrderPermits as $workOrderPermit) {
            if ($workOrderPermit->restablish_convert_date == null) {
                $workOrderPermit->restablish_convert_date = Carbon::now();
                $workOrderPermit->status = WorkOrderPermitStatusEnum::WaitingForProcess->value;
                $workOrderPermit->save();
            }
        }
    }


    // function sendNotificationBasedOnStatus($statusKey, $workOrder, $input) {
    //     $title = '';
    //     // dd($input->permit_number);
    //     $message = '';
    //     $messageTelegram = '';
    //     $telegramUrl = env('APP_URL') . "/workOrdersManagement/workOrders/{$workOrder->id}";

    //     switch ($statusKey) {

    //         case "updateStatusToStart":
    //         case "convertDepartment":
    //             $title = "استلام أمر عمل جديد";
    //             $message = "تم تحويل أمر العمل رقم " . $workOrder->work_order_number . " الى الادارة الخاصة بك";
    //             break;
    //         case "restablishWorkInProgress":
    //             $title = "البدء فى تنفيذ امر العمل";
    //             $message = "تم البدء في تنفيذ التصريح رقم " . $input['permit_number'] . " المرتبط برقم امر العمل ".$workOrder->work_order_number;
    //             break;
    //         case "temporaryStopped":
    //             $title = "ايقاف مؤقت لامر العمل";
    //             $message = "تم تحويل أمر العمل رقم " . $workOrder->work_order_number . " الى إيقاف مؤقت بسبب " . $input['stop_note'];
    //             break;

    //         case "permanentStopped":
    //             $title = "ايقاف دائم لامر العمل";
    //             $message = "تم تحويل أمر العمل رقم " . $workOrder->work_order_number . " الى إيقاف دائم بسبب " . $input['stop_note'];
    //             break;

    //         case "reOpenDrillingWorkOrder":
    //             $title = "بدء العمل على امر عمل متوقف";
    //             $message = "تم تحويل أمر العمل المتوقف رقم " . $workOrder->work_order_number . " الى حالة بدء العمل";
    //             break;

    //         case "electricityInProgress":
    //         case "electricalOperationsFinished":

    //             return true;

    //         case "electricalConvertDepartment":
    //             $title = "استلام أمر عمل تم الانتهاء منه";
    //             $message = "تم تحويل أمر العمل رقم " . $workOrder->work_order_number . " الى الادارة الخاصة بك";
    //             break;

    //             case "toGeneral":
    //         case "inProgressStillProgram":

    //             return true;

    //         default:

    //             return false;
    //     }

    //     Helper::SendNotifications($title, $message, 7, 'Department', "/workOrdersManagement/workOrders/{$workOrder->id}", 'bg-light-success', 'check');
    //     Helper::SendNotifications($title, $message, 8, 'Department', "/workOrdersManagement/workOrders/{$workOrder->id}", 'bg-light-success', 'check');
    //     Helper::SendNotifications($title, $message, $input['current_department_id'] ?? 4, 'Department', "/workOrdersManagement/workOrders/{$workOrder->id}", 'bg-light-success', 'check');

    //     $messageTelegram = "تم تحويل أمر العمل رقم <a href='{$telegramUrl}'>{$workOrder->work_order_number}</a> إلى " . $workOrder->currentDepartment->name ;
    //     Telegram::sendMessage(['chat_id' => env('TELEGRAM_CHAT_ID'),'text' => $messageTelegram,'parse_mode' => 'HTML']);

    //     return true;
    // }

    function sendNotificationBasedOnStatus($statusKey, $workOrder, $input) {
        $title = '';
        $message = '';
        $messageTelegram = '';
        $telegramUrl = env('APP_URL') . "/workOrdersManagement/workOrders/{$workOrder->id}";

        try {
            switch ($statusKey) {
                case "updateStatusToStart":
                case "convertDepartment":
                    $title = "استلام أمر عمل جديد";
                    $message = "تم تحويل أمر العمل رقم " . $workOrder->work_order_number . " الى الادارة الخاصة بك";
                    break;
                case "restablishWorkInProgress":
                    $title = "البدء فى تنفيذ امر العمل";
                    $message = "تم البدء في تنفيذ التصريح رقم " . $input['permit_number'] . " المرتبط برقم امر العمل " . $workOrder->work_order_number;
                    break;
                case "temporaryStopped":
                    $title = "ايقاف مؤقت لامر العمل";
                    $message = "تم تحويل أمر العمل رقم " . $workOrder->work_order_number . " الى إيقاف مؤقت بسبب " . $input['stop_note'];
                    break;
                case "permanentStopped":
                    $title = "ايقاف دائم لامر العمل";
                    $message = "تم تحويل أمر العمل رقم " . $workOrder->work_order_number . " الى إيقاف دائم بسبب " . $input['stop_note'];
                    break;
                case "reOpenDrillingWorkOrder":
                    $title = "بدء العمل على امر عمل متوقف";
                    $message = "تم تحويل أمر العمل المتوقف رقم " . $workOrder->work_order_number . " الى حالة بدء العمل";
                    break;
                case "electricityInProgress":
                case "electricalOperationsFinished":
                    return true;
                case "electricalConvertDepartment":
                    $title = "استلام أمر عمل تم الانتهاء منه";
                    $message = "تم تحويل أمر العمل رقم " . $workOrder->work_order_number . " الى الادارة الخاصة بك";
                    break;
                case "toGeneral":
                case "inProgressStillProgram":
                    return true;
                default:
                    return false;
            }

            // Send notifications
            Helper::SendNotifications($title, $message, 7, 'Department', "/workOrdersManagement/workOrders/{$workOrder->id}", 'bg-light-success', 'check');
            Helper::SendNotifications($title, $message, 8, 'Department', "/workOrdersManagement/workOrders/{$workOrder->id}", 'bg-light-success', 'check');
            Helper::SendNotifications($title, $message, $input['current_department_id'] ?? 4, 'Department', "/workOrdersManagement/workOrders/{$workOrder->id}", 'bg-light-success', 'check');

            // Send Telegram message
            // $messageTelegram = "تم تحويل أمر العمل رقم <a href='{$telegramUrl}'>{$workOrder->work_order_number}</a> إلى " . $workOrder->currentDepartment->name;
            $work_order_number = "<a href=\"" . url('http://localhost:8089/workOrdersManagement/workOrders/' . $workOrder->id) . "\">" . $workOrder->work_order_number . "</a>";



                        Helper::SendTelegramNotifications($statusKey,$work_order_number,$input['current_department_id']);

            return true;
        } catch (\Exception $e) {
            \Log::error( $e->getMessage());
            return false;
        }
    }


    function GetUpdateStatusRedirectAction($statusKey)  {
        $redirectAction = 'edit';
        if ($statusKey=="convertDepartment"){
            $redirectAction = 'index';
        }else if ($statusKey=="electricalConvertDepartment"){
            $redirectAction = 'index';
        }else if ($statusKey=="toGeneral"){
            $redirectAction = 'index';
        }else if ($statusKey=="inProgressStillProgram"){
            $redirectAction = 'edit';
        }
        return $redirectAction ;
    }

    function createStopNote($statusKey,$workOrder)  {
        if ($statusKey=="temporaryStopped" ||$statusKey=="permanentStopped" ){
            //add note for stopping the workorder
            $workOrderNote['work_order_number'] = $workOrder->work_order_number ?? $workOrder->mission_number;
            $workOrderNote['work_order_id'] = $workOrder->id;
            if($statusKey=="temporaryStopped"){
                $workOrderNote['note'] = "تم إيقاف مؤقت لأمر العمل بسبب : ".request("stop_note");
                $workOrderNote['work_order_status'] = WorkOrderStatusEnum::TemporaryStopped->value;
            }else{
                $workOrderNote['note'] = "تم إيقاف دائم لأمر العمل بسبب : ".request("stop_note");
                $workOrderNote['work_order_status'] = WorkOrderStatusEnum::PermanentStoped->value;
            }
            $workOrderNote['user_id'] = auth()->id();
            return WorkOrderNote::create($workOrderNote);
        }
        return false ;
    }

    function updateElectricalOperationStatus($statusKey,$workOrder)  {
        if ($statusKey=="reOpenDrillingWorkOrder"){
            $electricalOperation = ElectricalOperation::where("work_order_id",$workOrder->id)->first();
            if($electricalOperation){
                $electricalOperation->status = 1;
                return $electricalOperation->save();
            }
        }else if ($statusKey=="electricityInProgress"){
            $electricalOperation = ElectricalOperation::where("work_order_id",$workOrder->id)->first();
            if($electricalOperation){
                $electricalOperation->status = 1;
                return $electricalOperation->save();
            }
        }else if ($statusKey=="electricalOperationsFinished"){
            $electricalOperation = ElectricalOperation::where("work_order_id",$workOrder->id)->first();
            if($electricalOperation){
                $electricalOperation->status = 2;
                if(!$electricalOperation->electrical_complete_date){
                    $electricalOperation->electrical_complete_date = Carbon::now();
                }
                return $electricalOperation->save();
            }
        }
        return false;
    }
}
