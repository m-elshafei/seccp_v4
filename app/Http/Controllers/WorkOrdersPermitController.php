<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Carbon\Carbon;
use App\Http\Requests;
use App\Models\Balady;
use App\Helpers\Helper;
use App\Models\District;
use App\Models\WorkOrder;
use App\Models\WorkOrdersPermit;
use Illuminate\Support\Facades\DB;
use App\Models\WorkOrdersPermitType;
use App\Models\WorkOrdersPermitsFine;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Models\WorkOrdersPermitsExtension;
use App\Http\Controllers\AppBaseController;
use App\DataTables\WorkOrdersPermitDataTable;
use App\Enums\WorkOrderPermitStatusEnum;
use App\Http\Requests\CreateAttachmentRequest;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Http\Requests\CreateWorkOrdersPermitRequest;
use App\Http\Requests\UpdateWorkOrdersPermitRequest;
use function Laravel\Prompts\select;
use App\Models\WorkOrdersPermitNote;
use Illuminate\Support\Facades\Auth;


class WorkOrdersPermitController extends AppBaseController
{
    /**
     * Display a listing of the WorkOrdersPermit.
     *
     * @param WorkOrdersPermitDataTable $workOrdersPermitDataTable
     * @return Response
     */
    public function index(WorkOrdersPermitDataTable $workOrdersPermitDataTable)
    {
        return $workOrdersPermitDataTable->render('work_orders_permits.index');
    }

    /**
     * Show the form for creating a new WorkOrdersPermit.
     *
     * @return Response
     */
    public function create()
    {
        $workOrdersPermitTypes = WorkOrdersPermitType::get()->pluck('name','id');
        $workOrdersPermitTypes->prepend("اختر","");
        //TODO: this status can be Enum
        $workOrders = WorkOrder::whereIn('status',[2,3,4])->whereNull('mission_number')->get()->pluck('work_dispaly_number_permit', 'id');// status -> //لم يبدأ التنفيذ , جارى التنفيذ , تم التنفيذ
        $workOrders->prepend("اختر","");
        //whereIn('status',[2,3,4])->
        $missions = WorkOrder::whereNotNull('mission_number')->get()->pluck('work_dispaly_number_permit', 'id');// status -> //لم يبدأ التنفيذ , جارى التنفيذ , تم التنفيذ
        $missions->prepend("اختر","");

        // $baladys = ['اختر',''];
        Balady::with('city')->get()->map(function ($item) use (&$baladys){
            $baladys[$item->city->name][$item->id] = $item->name;
        });
        $baladys = collect($baladys)->prepend("اختر","");

        return view('work_orders_permits.create', compact('workOrdersPermitTypes','workOrders','missions', 'baladys'));
    }

    /**
     * Store a newly created WorkOrdersPermit in storage.
     *
     * @param CreateWorkOrdersPermitRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkOrdersPermitRequest $request)
    {
        $input = $request->all();

        $issue_date = Carbon::parse($input['issue_date']);
        $end_date = Carbon::parse($input['end_date']);
        if($issue_date->gte($end_date)){
            flash("يجب ان يكون تاريخ الانتهاء بعد تاريخ اصدار التصريح")->warning();
            return redirect()->back()->withInput()->withErrors([
                'issue_date'=>'يجب ان يكون تاريخ الانتهاء بعد تاريخ اصدار التصريح'
            ]);
        }
        $input['period'] = $issue_date->diff($end_date)->days;
        $input['total_period'] = $input['period'];
        $input['start_date'] = $input["issue_date"];
        if($input['permit_number']){
            $input['status'] = WorkOrderPermitStatusEnum::PaidAndIssued;//  3 => "تم السداد والاصدار"
        }elseif($input['sadad_number']){
            $input['status'] = WorkOrderPermitStatusEnum::WaitingForPayment;//  2 => "منتظر السداد"
        }else{
            $input['status'] = WorkOrderPermitStatusEnum::New;//  1 => "جديد"
        }

        $input['work_order_id'] = ($input['is_mission'] == 0)? $input['work_order_id'] : $input['mission_id'];
        $input['total_amount'] = $this->calculateTotalAmount($request);
        $work_order_id = $input['work_order_id'];
//        $exist = WorkOrdersPermit::where('work_orders_permit_type_id',$input['work_orders_permit_type_id'])
//            ->whereHas('workOrders', function($q) use($work_order_id) {
//                $q->where('work_order_id', $work_order_id);
//            })
//            ->count();
//        if($exist){
//            $message= "يوجد تصريح لنفس النوع وأمر العمل / مهمة";
//            flash($message)->warning();
//            return redirect()->back()->withInput()->withErrors([
//                'work_orders_permit_type_id' => $message
//            ]);
//        }

        if($input['permit_number']){
        if(WorkOrdersPermit::where('permit_number',$input['permit_number'])->count()){
            $message= "التصريح رقم " .$input['permit_number']." موجود من قبل";
            flash($message)->warning();
            return redirect()->back()->withInput()->withErrors([
                'work_orders_permit_type_id' => $message
            ]);
        }
        }



        $sadad_number_count = WorkOrdersPermit::where('sadad_number',$input['sadad_number'])->count();
        $sadad_number_extension_count = WorkOrdersPermitsExtension::where('sadad_number',$input['sadad_number'])->count();
        $sadad_number_fine_count = WorkOrdersPermitsFine::where('sadad_number',$input['sadad_number'])->count();
        if (!empty( $input['sadad_number'])) {
            if($sadad_number_count || $sadad_number_extension_count || $sadad_number_fine_count){
                flash("رقم السداد موجود مسبقا")->warning();
                return redirect()->back()->withInput()->withErrors([
                    'sadad_number' =>'رقم السداد موجود مسبقا'
                ]);
            }
        }


        $workOrder = WorkOrder::find($input['work_order_id']);
        $input['district_id'] = $workOrder->district_id;
        $workOrdersPermit = WorkOrdersPermit::where('permit_number',$input['permit_number'])->first();
        if ($input['notes']) {
            WorkOrdersPermitNote::create([
                'work_order_id' => $input['work_order_id'],
                'user_id' => Auth::user()->id,
                'branch_id' => Auth::user()->branch_id,
                'work_orders_permits_id' => null,
                'permit_number' => $input['permit_number'],
                'note' => $input['notes'],
                'work_orders_permits_status' => $input['status'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);


        }
        /** @var WorkOrdersPermit $workOrdersPermit */
        $workOrdersPermit = WorkOrdersPermit::create($input);

        if(isset($workOrder)){
            $workOrdersPermit->workOrders()->attach($workOrder);
        }

        Flash::success(__('messages.saved', ['model' => __('models/workOrdersPermits.singular')]));

        return Helper::redirectAfterSaving($workOrdersPermit->id,$request,"workOrdersPermits");
    }

    /**
     * Display the specified WorkOrdersPermit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var WorkOrdersPermit $workOrdersPermit */
        $workOrdersPermit = WorkOrdersPermit::find($id);
        if (empty($workOrdersPermit)) {
            Flash::error(__('models/workOrdersPermits.singular').' '.__('messages.not_found'));

            return redirect(route('workOrdersPermits.index'));
        }

        return view('work_orders_permits.show')->with('workOrdersPermit', $workOrdersPermit);
    }

    /**
     * Show the form for editing the specified WorkOrdersPermit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var WorkOrdersPermit $workOrdersPermit */
        $workOrdersPermit = WorkOrdersPermit::find($id);

        if (empty($workOrdersPermit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersPermits.singular')]));

            return redirect(route('workOrdersPermits.index'));
        }

        if($workOrdersPermit->status == 5){
            flash("لايمكنك التعديل علي تصريح بحالة`تم تسليم التصريح`")->warning();
            return redirect()->route('workOrdersPermits.index');
        }

        $workOrdersPermitTypes = WorkOrdersPermitType::get()->pluck('name','id');
        $workOrdersPermitTypes->prepend("اختر","");

        $workOrders =WorkOrder::pluck('work_order_number', 'id');
        $workOrders->prepend("اختر","");

        $baladys = ['','اختر'];
        Balady::with('city')->get()->map(function ($item) use (&$baladys){
            $baladys[$item->city->name][$item->id] = $item->name;
        });

        $workOrdersPermitsExtensions = $workOrdersPermit->workOrdersPermitsExtension()->get();

        $workOrdersPermitsFines = $workOrdersPermit->workOrdersPermitsFine()->get();

        $statusList = $this->getStatusList($workOrdersPermit->status);

        return view('work_orders_permits.edit',
                    compact('workOrdersPermit','workOrdersPermitsExtensions',
                            'workOrdersPermitTypes' , 'workOrdersPermitsFines',
                            'workOrders' , 'statusList', 'baladys')
                   );
    }

    /**
     * Update the specified WorkOrdersPermit in storage.
     *
     * @param  int              $id
     * @param UpdateWorkOrdersPermitRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkOrdersPermitRequest $request)
    {
        /** @var WorkOrdersPermit $workOrdersPermit */
        $workOrdersPermit = WorkOrdersPermit::find($id);
        $input = $request->all();
        $workOrdersExtension = WorkOrdersPermitsExtension::select('period', 'amount')->where('work_orders_permit_id', $workOrdersPermit->id)->get();
        $WorkOrdersFine = WorkOrdersPermitsFine::select('amount')->where('work_orders_permit_id', $workOrdersPermit->id)->get();
        $input['total_extend_period'] = $this->calculateCounterExtension($workOrdersExtension);
        $input['total_extend_amount'] = $this->calculateCounter($workOrdersExtension);
        $input['total_fines_amount'] = $this->calculateCounter($WorkOrdersFine) ;
        if (empty($workOrdersPermit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersPermits.singular')]));

            return redirect(route('workOrdersPermits.index'));
        }

        $issue_date = Carbon::parse($input['issue_date']);
        $end_date = Carbon::parse($input['end_date']);
        $input['period'] = $issue_date->diff($end_date)->days;
        $input['start_date'] = $input["issue_date"];
        $input['total_period'] = $workOrdersPermit->period
                               + $input['total_extend_period'];
        $input['total_amount'] = $this->calculateTotalAmount($workOrdersPermit);
        $workOrder = WorkOrder::find($input['work_order_id']);
        if ($input['notes']) {
            WorkOrdersPermitNote::create([
                'work_order_id' => $input['work_order_id'],
                'user_id' => Auth::user()->id,
                'work_orders_permits_id' =>$workOrdersPermit->id,
                'branch_id' => Auth::user()->branch_id,
                'permit_number' => $input['permit_number'],
                'note' => $input['notes'],
                'work_orders_permits_status' => $input['status'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $input['district_id'] = $workOrder->district_id;

        $workOrdersPermit->fill($input);
        $workOrdersPermit->save();

        if(isset($workOrder)){
            $workOrdersPermit->workOrders()->sync($workOrder);
        }

        Flash::success(__('messages.updated', ['model' => __('models/workOrdersPermits.singular')]));

        return Helper::redirectAfterSaving($id,$request,"workOrdersPermits");
    }


    public function update_attachment($id, CreateAttachmentRequest $request)
    {
        /** @var WorkOrder $workOrder */
        $workOrdersPermit = WorkOrdersPermit::find($id);

        if (empty($workOrdersPermit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersPermits.singular')]));

            return redirect()->back();
        }

        $workOrdersPermit->fill($request->all());
        $workOrdersPermit->save();

        Flash::success(__('messages.updated', ['model' => __('models/workOrdersPermits.singular')]));

        return redirect()->back();
    }



    /**
     * Remove the specified WorkOrdersPermit from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var WorkOrdersPermit $workOrdersPermit */
        $workOrdersPermit = WorkOrdersPermit::find($id);

        if (empty($workOrdersPermit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersPermits.singular')]));

            return redirect(route('workOrdersPermits.index'));
        }

        if (!in_array($workOrdersPermit->status, [1, 8])) {
            Flash::error(__('models/workOrdersPermits.validations.deleteWorkOrdersPermitNotAllowed', ['model' => __('models/workOrdersPermits.singular')]));
            return Redirect::back();

        }

        $workOrdersPermit->workOrders()->detach();
        $workOrdersPermit->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/workOrdersPermits.singular')]));

        return redirect(route('workOrdersPermits.index'));
    }

    private function getStatusList ($currentStatus)
    {
        $statusList = config("const.work_order_permit_status_list") ;
        // dd($workOrdersPermit->status)  ;
        // dd(WorkOrderPermitStatusEnum::UnderWay);
        if (in_array((int) $currentStatus,[
            WorkOrderPermitStatusEnum::WaitingForPayment->value,
            WorkOrderPermitStatusEnum::PaidAndIssued->value,
            WorkOrderPermitStatusEnum::UnderWay->value,
            WorkOrderPermitStatusEnum::UnderDelivery->value,
            WorkOrderPermitStatusEnum::InitialDelivery->value,
            WorkOrderPermitStatusEnum::FinalDelivery->value,
            ])){
            unset($statusList[WorkOrderPermitStatusEnum::New->value]);
        };

        if ($currentStatus ==WorkOrderPermitStatusEnum::PaidAndIssued->value   ){
            unset($statusList[WorkOrderPermitStatusEnum::WaitingForPayment->value]);
        };
        if ($currentStatus ==WorkOrderPermitStatusEnum::UnderWay->value){
            unset($statusList[WorkOrderPermitStatusEnum::WaitingForPayment->value]);
            unset($statusList[WorkOrderPermitStatusEnum::PaidAndIssued->value]);
        };
        if ($currentStatus ==WorkOrderPermitStatusEnum::UnderDelivery->value){
            unset($statusList[WorkOrderPermitStatusEnum::WaitingForPayment->value]);
            unset($statusList[WorkOrderPermitStatusEnum::PaidAndIssued->value]);
            unset($statusList[WorkOrderPermitStatusEnum::UnderWay->value]);
        };
        if ($currentStatus ==WorkOrderPermitStatusEnum::InitialDelivery->value){
            unset($statusList[WorkOrderPermitStatusEnum::WaitingForPayment->value]);
            unset($statusList[WorkOrderPermitStatusEnum::PaidAndIssued->value]);
            unset($statusList[WorkOrderPermitStatusEnum::UnderWay->value]);
            unset($statusList[WorkOrderPermitStatusEnum::UnderDelivery->value]);
        };
        if ($currentStatus ==WorkOrderPermitStatusEnum::FinalDelivery->value){
            unset($statusList[WorkOrderPermitStatusEnum::WaitingForPayment->value]);
            unset($statusList[WorkOrderPermitStatusEnum::PaidAndIssued->value]);
            unset($statusList[WorkOrderPermitStatusEnum::UnderWay->value]);
            unset($statusList[WorkOrderPermitStatusEnum::UnderDelivery->value]);
            unset($statusList[WorkOrderPermitStatusEnum::InitialDelivery->value]);
        };
        return $statusList;
    }

    // private function getStatusList ($currentStatus)
    // {
    //     $statusList = config("const.work_order_permit_status_list") ;
    //     // dd($workOrdersPermit->status)  ;
    //     if (in_array($currentStatus,[3,4,5])){
    //         unset($statusList[1]);
    //         unset($statusList[2]);
    //     };
    //     if ($currentStatus ==4){
    //         unset($statusList[3]);
    //     };
    //     if ($currentStatus ==5){
    //         unset($statusList[3]);
    //         unset($statusList[4]);
    //         unset($statusList[6]);
    //         unset($statusList[7]);
    //     };
    //     return $statusList;
    // }

        function calculateCounterExtension($workOrdersPermitsExtension)
    {
        $counterExtension = 0;
        for ($i = 0; $i < count($workOrdersPermitsExtension); $i++) {
            $counterExtension += $workOrdersPermitsExtension[$i]->period;
        }
        return $counterExtension;
    }


        function calculateCounter($items)
    {
        $counter = 0;
        for ($i = 0; $i < count($items); $i++) {
            $counter += $items[$i]->amount;
        }
        return $counter;
    }

    function calculateTotalAmount($workOrdersPermit)
    {
        $totalExtendAmount = intval($workOrdersPermit->total_extend_amount);
        $totalFinesAmount = intval($workOrdersPermit->total_fines_amount);
        $issuedAmount = intval($workOrdersPermit->issued_amount);
        $clearanceSdadAmount = intval($workOrdersPermit->clearance_sdad_amount);

        $totalAmount = $totalExtendAmount + $totalFinesAmount + $issuedAmount + $clearanceSdadAmount;

        return $totalAmount;
    }

    function RecalculateTotalAmount($workOrdersPermit)
    {
        $totalExtendAmount = intval($workOrdersPermit->total_extend_amount);
        $totalFinesAmount = intval($workOrdersPermit->total_fines_amount);
        $clearance_sdad_amount = intval($workOrdersPermit->clearance_sdad_amount);
        $issuedAmount = intval($workOrdersPermit->issued_amount);

        $totalAmount = $totalExtendAmount + $totalFinesAmount + $issuedAmount + $clearance_sdad_amount;
        return $totalAmount;
    }



    function recalculateWorkOrdersPermit(){

        $workOrdersPermits = WorkOrdersPermit::get();

        foreach ($workOrdersPermits as $workOrdersPermit) {
            if (!empty($workOrdersPermit->workOrdersPermitsExtension)) {
                $counterExtensionAmount = $workOrdersPermit->workOrdersPermitsExtension->sum('amount');
                $counterExtensionPeriod = $workOrdersPermit->workOrdersPermitsExtension->sum('period');
            }

            if (!empty($workOrdersPermit->workOrdersPermitsFine)) {
                $counterFineAmount = $workOrdersPermit->workOrdersPermitsFine->sum('amount');
            }

            $totalAmount = collect([
                $workOrdersPermit->issued_amount,
                $workOrdersPermit->total_extend_amount,
                $workOrdersPermit->total_fines_amount,
                $workOrdersPermit->clearance_sdad_amount
            ])->sum();

            $totalPeriod = $workOrdersPermit->period + $workOrdersPermit->total_extend_period;

            $workOrdersPermit->update([
                'total_extend_amount' => $counterExtensionAmount,
                'total_extend_period' => $counterExtensionPeriod,
                'total_fines_amount' => $counterFineAmount,
                'total_amount' => $totalAmount,
                'total_period' => $totalPeriod
            ]);
        }
        Flash::success('تم تحديث النظام');

        return redirect()->back();
    }


}
