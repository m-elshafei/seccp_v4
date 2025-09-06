<?php

namespace App\Http\Controllers;


use App\DataTables\WorkOrderDailyFollowDataTable;
use PDF;
use Flash;
use Response;
use Carbon\Carbon;
use App\Models\Layer;
//use App\Http\Requests;
use App\Helpers\Helper;
use App\Models\District;
use App\Models\Employee;
use App\Models\WorkType;
use App\Models\Contractor;
use App\Utils\SessionUtil;
use App\Models\WorkOrderFollow;
use App\Enums\WorkOrderStatusEnum;
use App\Enums\WorkOrderPermitStatusEnum;
use App\Http\Controllers\AppBaseController;
use App\DataTables\WorkOrderFollowDataTable;
use App\Enums\WorkOrderOperationsStatusEnum;
use App\Services\WorkOrders\WorkOrderService;
use App\Http\Requests\CreateWorkOrderFollowRequest;
use App\Http\Requests\UpdateWorkOrderFollowRequest;
use Illuminate\Http\Request;


class WorkOrderFollowController extends AppBaseController
{
    private $workOrderService;

    function __construct(WorkOrderService $workOrderService) {
        $this->workOrderService = $workOrderService;
    }
    /**
     * Display a listing of the WorkOrderFollow.
     *
     * @param WorkOrderFollowDataTable $workOrderFollowDataTable
     * @return Response
     */
    public function index(WorkOrderFollowDataTable $workOrderFollowDataTable ,$type = '')
    {

        $workOrderStatus=$this->workOrderService->getStausFromConfig('work_order_general_status');
        $workOrderPermitStatus=$this->workOrderService->getStausFromConfig('work_order_permit_status');
        $workTypes = WorkType::all()->map->only('id', 'full_name')->pluck('full_name', 'id')->prepend("اختر","");
        $city_id =SessionUtil::getCurrentCityByBranch();
        $districts = District::where("city_id",$city_id)->pluck('name', 'id')->prepend("اختر","");
        if ($type == 'notFinished'){
            $WorkOrderDailyFollowDataTable = new WorkOrderDailyFollowDataTable();
            return $WorkOrderDailyFollowDataTable->render('work_orders_follows.index',compact('workTypes','districts','workOrderStatus','workOrderPermitStatus'));
        }else{

            return $workOrderFollowDataTable->render('work_orders_follows.index',compact('workTypes','districts','workOrderStatus','workOrderPermitStatus'));
        }

    }

    /**
     * Show the form for creating a new WorkOrderFollow.
     *
     * @return Response
     */
    public function create()
    {
        return view('work_orders_follows.create');
    }

    /**
     * Store a newly created WorkOrderFollow in storage.
     *
     * @param CreateWorkOrderFollowRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkOrderFollowRequest $request)
    {
        $inputWorkOrder = $request->all();

        /** @var WorkOrderFollow $workOrderFollow */
        $workOrderFollow = WorkOrderFollow::create($inputWorkOrder);

        Flash::success(__('messages.saved', ['model' => __('models/workOrderFollows.singular')]));

        return Helper::redirectAfterSaving($workOrderFollow->id,$request,"workOrderFollows");
    }

    /**
     * Display the specified WorkOrderFollow.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var WorkOrderFollow $workOrderFollow */
        $workOrderFollow = WorkOrderFollow::find($id);

        if (empty($workOrderFollow)) {
            Flash::error(__('models/workOrderFollows.singular').' '.__('messages.not_found'));

            return redirect(route('workOrderFollows.index'));
        }
        $labResultStatusList = config("const.lab_result_status_list") ;

        return view('work_orders_follows.show')->with([
            'workOrderFollow'=> $workOrderFollow,
            'labResultStatusList'=> $labResultStatusList,
        ]);
    }

    /**
     * Show the form for editing the specified WorkOrderFollow.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var WorkOrderFollow $workOrderFollow */
        $workOrderFollow = WorkOrderFollow::with(['landLayersHistory',"workOrders","workOrders.district"])->find($id);
        if (empty($workOrderFollow)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrderFollows.singular')]));

            return redirect(route('workOrderFollows.index'));
        }
        $workOrder=$workOrderFollow->workOrders()->first() ;
        $landLayers = $workOrderFollow->landLayers()->get();

        $layerWorkerTypeList = config("const.layer_worker_type_list") ;
        $layerWorkerTypeList['']='اختر';

        $layerStatusList = config("const.return_situation_layer_status_list") ;

        $labResultStatusList = config("const.lab_result_status_list") ;
        $labResultStatusList['']='اختر';

        $layersList =Layer::pluck('name', 'id');
        $layersList->prepend("اختر","");

        $employeesList = Employee::pluck('name','id');
        $employeesList->prepend("اختر","");

        $contractorsList = Contractor::pluck('name','id');
        $contractorsList->prepend("اختر","");

        $layer_worker_type_list = config('const.layer_worker_type_list');

        return view('work_orders_follows.edit')
            ->with([
                'workOrderFollow' => $workOrderFollow,
                'workOrder' => $workOrder,
                'landLayers' => $landLayers ,
                'layerWorkerTypeList' => $layerWorkerTypeList,
                'layerStatusList' => $layerStatusList,
                'labResultStatusList' => $labResultStatusList,
                'layersList' => $layersList,
                'employeesList' => $employeesList,
                'contractorsList' => $contractorsList,
                'layer_worker_type_list' => $layer_worker_type_list
            ])
            ;
    }

    /**
     * Update the specified WorkOrderFollow in storage.
     *
     * @param  int              $id
     * @param UpdateWorkOrderFollowRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkOrderFollowRequest $request)
    {
        /** @var WorkOrderFollow $workOrderFollow */
        $workOrderFollow = WorkOrderFollow::find($id);

        if (empty($workOrderFollow)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrderFollows.singular')]));

            return redirect(route('workOrderFollows.index'));
        }

        $workOrderFollow->fill($request->all());
        $workOrderFollow->save();

        Flash::success(__('messages.updated', ['model' => __('models/workOrderFollows.singular')]));

        return Helper::redirectAfterSaving($id,$request,"workOrderFollows");
    }


    public function updatePermit(Request $request, $id)
    {
        try {
            $workOrder = WorkOrderFollow::find($id);
            if (!$workOrder) {
                Flash::error(__('messages.not_found', ['model' => __('models/workOrderFollows.singular')]));
                return response()->json(['success' => false, 'error' => __('messages.not_found', ['model' => __('models/workOrderFollows.singular')])]);
            }

            $workOrder->status = WorkOrderPermitStatusEnum::WaitingForProcess->value;
            $workOrder->restablish_convert_date = Carbon::now();

            $workOrder->save();

            $message = 'تم تحويل التصريح رقم ' . $workOrder->id . ' الي اعاده الوضع';

            Flash::success(__('messages.updated', ['model' => __('models/workOrders.singular')]));
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Flash::error(__('messages.error', ['model' => 'حدث خطأ اثناء تحويل التصريح']));
            return response()->json(['success' => false, 'error' => 'حدث خطأ اثناء تحويل التصريح']);
        }
    }







    public function updateStatus($statusKey,$id,$redirectTo="")
    {
        // dd($statusKey,$id,$redirectTo);
        if(!$redirectTo){
            $redirectTo='WorkOrderFollows';
        }
        /** @var WorkOrder $workOrder */
        $workOrderFollow = WorkOrderFollow::with('workOrders')->find($id);
        if (empty($workOrderFollow)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrderFollows.singular')]));

            return redirect(route($redirectTo.'.index'));
        }
        $workOrder=$workOrderFollow->workOrders()->first() ;
        // $workTypeData = WorkType::find($workOrder->work_type_id);
        // if($workTypeData){
        //     $inputWorkOrder['current_department_id'] = $workTypeData->default_department_id;
        // }
        $inputWorkOrder=[];
        $inputWorkOrderFollow=[];
        $redirectAction = 'edit';
        // if ($status=="drillInProgress"){
        //     $inputWorkOrder['status']=3;//جارى التنفيذ
        //     $inputWorkOrder['drilling_status']=1;//جارى التنفيذ
        // }else if ($status=="drillFinished"){
        //     $inputWorkOrder['drilling_status']=2;//تم التنفيذ
        // }else if ($status=="convertDepartment"){
        //     $inputWorkOrder['current_department_id']=4;//قسم الإعادة والتسليم
        //     $redirectAction = 'index';
        // }else if ($status=="stopped"){
        //     $inputWorkOrder['status']=6;//متوقف
        // }else if ($status=="reOpenDrillingWorkOrder"){
        //     $inputWorkOrder['status']=3;//جارى التنفيذ
        //     $inputWorkOrder['drilling_status']=1;//جارى التنفيذ
        // }else if ($status=="electricityInProgress"){
        //     $inputWorkOrder['status']=3;//جارى التنفيذ
        //     $inputWorkOrder['electrical_operations_status']=1;//جارى التنفيذ
        // }else if ($status=="electricalOperationsFinished"){
        //     $inputWorkOrder['electrical_operations_status']=2;//جارى التنفيذ
        // }else if ($status=="electricalConvertDepartment"){
        //     $inputWorkOrder['current_department_id']=6;//قسم المستخلصات
        //     $redirectAction = 'index';
        // }
        /**Validation */
        if ($statusKey=="restablishWorkFinished"){
            $lastLayer = $workOrderFollow->landLayers()->latest()->first();
            if(!$lastLayer || $lastLayer->lab_result_status !=1){
                Flash::error("لا يمكن انهاء العمل و نتيجة اختبار اخر طبقة لم تنجح");

                return redirect(route($redirectTo.'.'.$redirectAction,$workOrderFollow->id));
            }
            if(!$lastLayer->layer()->first()->is_final){
                Flash::error("لا يمكن انهاء العمل الا أن تكون أخر طبقة ناجحة هي الطبقة النهائية");

                return redirect(route($redirectTo.'.'.$redirectAction,$workOrderFollow->id));
            }
            // dd($lastLayer);
            // dd($lastLayer->layer()->first()->is_final);
            // dd("i am here");
        }

        if ($statusKey=="restablishWorkInProgress"){
            $workOrderFollow->status = WorkOrderPermitStatusEnum::UnderWay->value;
            $workOrderFollow->save();
            // $inputWorkOrder['status']=4;//تم التسليم
        }else if ($statusKey=="restablishWorkFinished"){
            $workOrderFollow->status = WorkOrderPermitStatusEnum::UnderDelivery->value;
            $workOrderFollow->save();
            $inputWorkOrder['status']=4;//تم التنفيذ
        }else if ($statusKey=="initialDelivery"){
            $workOrderFollow->status = WorkOrderPermitStatusEnum::InitialDelivery->value;
            $workOrderFollow->save();
            $inputWorkOrder['status']=5;//تم التسليم
            // $inputWorkOrder['current_department_id']=4;//قسم المستخلصات
        }else if ($statusKey=="finalDelivery"){
            $workOrderFollow->status = WorkOrderPermitStatusEnum::FinalDelivery->value;
            $workOrderFollow->save();
            $inputWorkOrder['status']=5;//تم التسليم
            $redirectAction="index";
            // $inputWorkOrder['current_department_id']=6;//قسم المستخلصات
        }else if ($statusKey=="restablishConvertDepartment"){
            $inputWorkOrder['status']=5;//تم التسليم
            $inputWorkOrder['current_department_id']=6;//قسم المستخلصات
        }else if ($statusKey=="returnWorkOrderToDrilling"){
            $inputWorkOrder['status']=WorkOrderStatusEnum::WorkingInProgress->value;
            $inputWorkOrder['current_department_id']=1;
            $inputWorkOrder['drilling_status']=WorkOrderOperationsStatusEnum::WorkingInProgress->value;
            $redirectAction="index";
        }
        // dd($workOrderFollow);
        // $this->workOrderService->sendNotificationBasedOnStatus($statusKey,$workOrderFollow->workOrders->first(),$workOrderFollow->toArray());
        // //Helper::SendTelegramNotifications($message, $workOrderFollow->workOrders->current_department_id);
        Helper::SendTelegramNotifications($statusKey,$workOrderFollow->permit_number,$workOrderFollow->workOrders[0]->current_department_id);

        if($inputWorkOrder){
            $workOrder->fill($inputWorkOrder);
            $workOrder->save();
        }

        if($inputWorkOrderFollow){
            $workOrder->fill($inputWorkOrderFollow);
            $workOrder->save();
        }


        Flash::success(__('messages.updated', ['model' => __('models/workOrders.singular')]));

        return redirect(route($redirectTo.'.'.$redirectAction,$workOrderFollow->id));
    }

    /**
     * Remove the specified WorkOrderFollow from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var WorkOrderFollow $workOrderFollow */
        $workOrderFollow = WorkOrderFollow::find($id);

        if (empty($workOrderFollow)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrderFollows.singular')]));

            return redirect(route('workOrderFollows.index'));
        }

        $workOrderFollow->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/workOrderFollows.singular')]));

        return redirect(route('workOrderFollows.index'));
    }

    public function printWorkOrderFollows($id)
    {
        /** @var WorkOrderFollow $assayForm */
        // $assayForm = WorkOrderFollow::with('assayItem.item.unit','assayService.service','workType','workOrder.consultant')->find($id);
        $workOrderFollow = WorkOrderFollow::find($id);
        // $workOrderFollow = WorkOrderFollow::with('workOrdersPermitsFine','assayService.service','workType','workOrder.consultant')->find($id);
        // dd($workOrderFollow);
        if (empty($workOrderFollow)) {
            Flash::error(__('models/assayForms.singular').' '.__('messages.not_found'));

            return redirect(route('assayForms.index'));
        }
        $report = [
            'font_name'=>'calibri',
            'font_size'=>'18',
            'title_background_color'=>'4CAF50'
            ];

        $data = [
            'data'=>$workOrderFollow,
            'dateTime'=>Carbon::now()->format('h:i Y-m-d'),
            'report'=>$report

        ];
        $pdf = PDF::loadView('work_orders_follows.print-work-order-follow', $data);
        return $pdf->stream($id.'.pdf');
    }
}
