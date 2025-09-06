<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Helpers\Helper;
use App\Models\WorkOrder;
use Laracasts\Flash\Flash;
use App\Models\FinancialDue;
use Illuminate\Http\Request;
use App\Models\FinancialDueType;
use Illuminate\Support\Facades\DB;
use App\Models\ElectricityDepartment;
use App\Models\AchievementCertificate;
use Illuminate\Support\Facades\Response;
use App\DataTables\FinancialDueDataTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateFinancialDueRequest;
use App\Http\Requests\UpdateFinancialDueRequest;


class FinancialDueController extends AppBaseController
{
    const STATUS_NEW = 2;
    const STATUS_APPROVED = 1;
    /**
     * Display a listing of the FinancialDue.
     *
     * @param FinancialDueDataTable $financialDueDataTable
     * @return Response
     */
    public function index(FinancialDueDataTable $financialDueDataTable)
    {
        return $financialDueDataTable->render('financial_dues.index');
    }

    /**
     * Show the form for creating a new FinancialDue.
     *
     * @return Response
     */
    public function create()
    {
        $financialDueTypes =FinancialDueType::pluck('name', 'id');
        $financialDueTypes->prepend("اختر","");

        $electricityDepartments =ElectricityDepartment::pluck('name', 'id');
        $electricityDepartments->prepend("اختر","");

        return view('financial_dues.create',compact(
            'financialDueTypes',
            'electricityDepartments'));
    }

    /**
     * Store a newly created FinancialDue in storage.
     *
     * @param CreateFinancialDueRequest $request
     *
     * @return Response
     */
    public function store(CreateFinancialDueRequest $request)
    {
        $input = $request->all();

        /** @var FinancialDue $financialDue */
        $input['status'] = 2;
        $financialDue = FinancialDue::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/financialDues.singular')]));

        return Helper::redirectAfterSaving($financialDue->id,$request,"financialDues");
    }

    /**
     * Display the specified FinancialDue.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FinancialDue $financialDue */
        $financialDue = FinancialDue::find($id);

        if (empty($financialDue)) {
            Flash::error(__('models/financialDues.singular').' '.__('messages.not_found'));

            return redirect(route('financialDues.index'));
        }

        return view('financial_dues.show')->with('financialDue', $financialDue);
    }

    /***
     * Delete attached work order
     * @param $work_order_id
     * @param $financial_due_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteWorkOrder($financial_due_id,$work_order_id){
        $financialDue = FinancialDue::find($financial_due_id);

        if (empty($financialDue)) {
            Flash::error(__('messages.not_found', ['model' => __('models/financialDues.singular')]));

            return redirect(route('financialDues.index'));
        }
        Flash::info("تم حذف الربط");
        $financialDue->workOrder()->detach($work_order_id);

        $work_order_ids = $financialDue->workOrder()->pluck("work_order_id");

        $achievementCertificate = AchievementCertificate::whereIn('id',$work_order_ids)->get();
        $financialDue->total_amount = $achievementCertificate->sum("amount");
        $financialDue->total_fines_amount = $achievementCertificate->sum("fines_amount");
        $financialDue->total_net_amount = $achievementCertificate->sum("net_amount");
        $financialDue->total_final_amount= $achievementCertificate->sum("final_amount");
        $financialDue->save();
        return redirect()->back();
    }

    /***
     * Attach workOrder to the financialDue
     * @param Request $request
     * @param $financial_due_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeWorkOrder(Request $request, $financial_due_id){
        Validator::make($request->all(), [
            'work_order_ids' => [
                'required',
                'array',
            ],
        ]);
        DB::transaction(function() use ($request ,$financial_due_id)
        {
            $financialDue = FinancialDue::find($financial_due_id);

            if (empty($financialDue)) {
                Flash::error(__('messages.not_found', ['model' => __('models/financialDues.singular')]));

                return redirect(route('financialDues.index'));
            }

            $financialDue->workOrder()->syncWithoutDetaching($request->get("work_order_ids"));
            $work_order_ids = $financialDue->workOrder()->pluck("work_order_id");

            $achievementCertificate = AchievementCertificate::whereIn('work_order_id',$work_order_ids)->get();

            $financialDue->total_amount = $achievementCertificate->sum("amount");
            $financialDue->total_fines_amount = $achievementCertificate->sum("fines_amount");
            $financialDue->total_net_amount = $achievementCertificate->sum("net_amount");
            $financialDue->total_final_amount = $achievementCertificate->sum("final_amount");
            $financialDue->save();
        });
        Flash::success(__('messages.saved', ['model' => __('models/financialDues.singular')]));
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified FinancialDue.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var FinancialDue $financialDue */
        $financialDue = FinancialDue::with([
            "workOrder",
            "workOrder.workType",
            "workOrder.achievementCertificate",
            "workOrder.currentDepartment"
        ])->find($id);

        if (empty($financialDue)) {
            Flash::error(__('messages.not_found', ['model' => __('models/financialDues.singular')]));

            return redirect(route('financialDues.index'));
        }
        if($financialDue->status == self::STATUS_APPROVED){
            Flash::error(__('models/financialDues.cannot change approved financial Due'));

            return redirect(route('financialDues.index'));
        }
        //dd($financialDue);

        $financialDueTypes =FinancialDueType::pluck('name', 'id');
        $financialDueTypes->prepend("اختر","");

        $electricityDepartments =ElectricityDepartment::pluck('name', 'id');
        $electricityDepartments->prepend("اختر","");

        $workOrder =WorkOrder::whereIn('status',['4','5'])->
        whereHas('achievementCertificate', function (Builder $query) {
            $query->where('status', AchievementCertificateController::APPROVED_COC);
        })->
        doesntHave("financialDue")->
        get()->
        pluck('work_display_number', 'id');

        $missionNumber =WorkOrder::whereIn('status',['4','5'])->
        whereNotNull('mission_number')->
        doesntHave("financialDue")->
        get()->
        pluck('work_display_number', 'id');
        $workOrders = $workOrder->merge($missionNumber)->unique();


        return view('financial_dues.edit' ,compact(
            'financialDue',
            'financialDueTypes',
            'workOrders',
            'electricityDepartments'));
    }

    /**
     * Update the specified FinancialDue in storage.
     *
     * @param  int              $id
     * @param UpdateFinancialDueRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFinancialDueRequest $request)
    {
        /** @var FinancialDue $financialDue */
        $financialDue = FinancialDue::find($id);

        if (empty($financialDue)) {
            Flash::error(__('messages.not_found', ['model' => __('models/financialDues.singular')]));

            return redirect(route('financialDues.index'));
        }

        if($financialDue->status == self::STATUS_APPROVED){
            Flash::error(__('models/financialDues.cannot change approved financial Due'));

            return redirect(route('financialDues.index'));
        }

        $financialDue->fill($request->all());
        $financialDue->save();

        Flash::success(__('messages.updated', ['model' => __('models/financialDues.singular')]));

        return Helper::redirectAfterSaving($id,$request,"financialDues");
    }

    /**
     * Remove the specified FinancialDue from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FinancialDue $financialDue */
        $financialDue = FinancialDue::find($id);

        if (empty($financialDue)) {
            Flash::error(__('messages.not_found', ['model' => __('models/financialDues.singular')]));

            return redirect(route('financialDues.index'));
        }

        $financialDue->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/financialDues.singular')]));

        return redirect(route('financialDues.index'));
    }



    public function approval($id){
        $financialDue = FinancialDue::find($id);

        if (empty($financialDue)) {
            Flash::error(__('messages.not_found', ['model' => __('models/financialDues.singular')]));

            return redirect(route('financialDues.index'));
        }

        if ($financialDue->status != self::STATUS_NEW){
            Flash::error(__('models/financialDues.The status should be new'));
            return redirect()->back();
        }

        $financialDue->status = self::STATUS_APPROVED;
        $financialDue->save();

        Flash::success(__('messages.updated', ['model' => __('models/financialDues.singular')]));

        return redirect(route('financialDues.index'));
    }
}
