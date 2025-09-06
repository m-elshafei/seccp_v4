<?php

namespace App\Http\Controllers;

use App\Models\AssayForm;
use Laracasts\Flash\Flash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Response;
use App\Http\Requests;
use App\Helpers\Helper;
use App\Models\WorkOrder;
use App\Models\AchievementCertificate;
use App\Http\Controllers\AppBaseController;
use App\DataTables\AchievementCertificateDataTable;
use App\Http\Requests\CreateAchievementCertificateRequest;
use App\Http\Requests\UpdateAchievementCertificateRequest;

class AchievementCertificateController extends AppBaseController
{
    const NEW_COC = 2;
    const APPROVED_COC = 1;

    /**
     * Display a listing of the AchievementCertificate.
     *
     * @param AchievementCertificateDataTable $achievementCertificateDataTable
     * @return Response
     */
    public function index(AchievementCertificateDataTable $achievementCertificateDataTable)
    {
        return $achievementCertificateDataTable->render('achievement_certificates.index');
    }

    /**
     * Show the form for creating a new AchievementCertificate.
     *
     * @return Response
     */
    public function create()
    {
        //"تم التسليم"
        // $workOrders = WorkOrder::where('status','5')->
        //     whereHas('assay_forms', function (Builder $query) {
        //         $query->where('status', AssayFormController::APPROVED_ASSAY);
        //     })->
        // get()->
        // pluck('work_dispaly_number_permit', 'id');
        //TODO: musr review this condition
        $workOrders = WorkOrder::whereHas('assay_forms', function (Builder $query) {
            $query->where('status', AssayFormController::APPROVED_ASSAY);
        })->
        get()->
        pluck('work_dispaly_number_permit', 'id');
        /**$_workOrders =WorkOrder::with('assay_forms')->
        get();
        dd($workOrders, $_workOrders);**/
        //dd($workOrders, $workOrders->isEmpty());
        if($workOrders->isEmpty()){
            flash(__("models/achievementCertificates.no work order available"))->error();
            return redirect()->back();
        }
        $workOrders->prepend("اختر","");

        return view('achievement_certificates.create', compact('workOrders'));
    }

    /**
     * Store a newly created AchievementCertificate in storage.
     *
     * @param CreateAchievementCertificateRequest $request
     *
     * @return Response
     */
    public function store(CreateAchievementCertificateRequest $request)
    {
        $input = $request->all();
        $assayForm = AssayForm::where([
            'work_order_id'=>$input['work_order_id'],
            'status' => AssayFormController::APPROVED_ASSAY
        ])->first();
        if(empty($assayForm)){
            flash(__("models/achievementCertificates.no work order available"))->error();
            return redirect()->back();
        }

        $input['status'] = self::NEW_COC;
        $input['amount'] = $assayForm->amount;

        $input['net_amount'] = $this->calcNetAmount($input);
        $input['final_amount'] = $input['net_amount'];
        if (! $input['fines_amount']){
             $input['fines_amount'] = 0;
        }

        $_count = AchievementCertificate::where('work_order_id', $input['work_order_id'])->count();
        if ($_count != 0){
            return redirect()->back()->withErrors("أمر العمل هذا له شهادة انجاز من قبل")->withInput();
        }
        /** @var AchievementCertificate $achievementCertificate */
        $achievementCertificate = AchievementCertificate::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/achievementCertificates.singular')]));

        return Helper::redirectAfterSaving($achievementCertificate->id,$request,"achievementCertificates");
    }

    /**
     * Display the specified AchievementCertificate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AchievementCertificate $achievementCertificate */
        $achievementCertificate = AchievementCertificate::with("workOrder")->find($id);

        if (empty($achievementCertificate)) {
            Flash::error(__('models/achievementCertificates.singular').' '.__('messages.not_found'));

            return redirect(route('achievementCertificates.index'));
        }

        $status = config("const.achievement_cert_status_list")[$achievementCertificate->status];

        $assayForm = AssayForm::where([
            'work_order_id'=>$achievementCertificate->work_order_id,
            'status' => AssayFormController::APPROVED_ASSAY
        ])->with(['assayService','assayService.service'])->first();

        return view('achievement_certificates.show')->with([
            'achievementCertificate' => $achievementCertificate,
            'status' => $status,
            'assayForm' => $assayForm,
        ]);
    }

    /**
     * Show the form for editing the specified AchievementCertificate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var AchievementCertificate $achievementCertificate */
        $achievementCertificate = AchievementCertificate::with('workOrder')->find($id);

        if (empty($achievementCertificate)) {
            Flash::error(__('messages.not_found', ['model' => __('models/achievementCertificates.singular')]));

            return redirect(route('achievementCertificates.index'));
        }
        //TODO: Activate this condition
        // if($achievementCertificate->status == self::APPROVED_COC){
        //     Flash::error(__('models/achievementCertificates.cannot change approved coc'));

        //     return redirect(route('achievementCertificates.index'));
        // }

        $assayForm = AssayForm::where([
            'work_order_id' => $achievementCertificate->work_order_id,
            'status' => AssayFormController::APPROVED_ASSAY
        ])->first();

//        $workOrders =WorkOrder::where('status','5')->
//        whereHas('assay_forms', function (Builder $query) {
//            $query->where('status', AssayFormController::APPROVED_ASSAY);
//        })->
//        get()->
//        pluck('work_order_number', 'id');
//        $workOrders->prepend("اختر","");


        return view('achievement_certificates.edit',compact(
            'achievementCertificate',
            //'workOrders',
            'assayForm'));
    }

    /**
     * Update the specified AchievementCertificate in storage.
     *
     * @param  int              $id
     * @param UpdateAchievementCertificateRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAchievementCertificateRequest $request)
    {
        /** @var AchievementCertificate $achievementCertificate */
        $achievementCertificate = AchievementCertificate::find($id);
        //TODO: Activate this condition

        // if($achievementCertificate->status == self::APPROVED_COC){
        //     Flash::error(__('models/achievementCertificates.cannot change approved coc'));

        //     return redirect(route('achievementCertificates.index'));
        // }

        $input = $request->all();

        if (empty($achievementCertificate)) {
            Flash::error(__('messages.not_found', ['model' => __('models/achievementCertificates.singular')]));

            return redirect(route('achievementCertificates.index'));
        }
        $assayForm = AssayForm::where([
            'work_order_id'=>$input['work_order_id'],
            'status' => AssayFormController::APPROVED_ASSAY
        ])->first();

        if(empty($assayForm)){
            flash(__("models/achievementCertificates.no work order available"))->error();
            return redirect()->back();
        }

        $input['amount'] = $assayForm->amount;
        $input['net_amount'] = $this->calcNetAmount($input);
        if(!$input['final_amount']){
            $input['final_amount'] = $input['net_amount'];
        }

        $_count = AchievementCertificate::where('id','<>',$id)->where('work_order_id', $input['work_order_id'])->count();
        if ($_count != 0){
            return redirect()->back()->withErrors("أمر العمل هذا له شهادة انجاز من قبل")->withInput();
        }


        $achievementCertificate->fill($input);
        $achievementCertificate->save();

        Flash::success(__('messages.updated', ['model' => __('models/achievementCertificates.singular')]));

        return Helper::redirectAfterSaving($id,$request,"achievementCertificates");
    }

    /**
     * Remove the specified AchievementCertificate from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AchievementCertificate $achievementCertificate */
        $achievementCertificate = AchievementCertificate::find($id);

        if (empty($achievementCertificate)) {
            Flash::error(__('messages.not_found', ['model' => __('models/achievementCertificates.singular')]));

            return redirect(route('achievementCertificates.index'));
        }

        $achievementCertificate->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/achievementCertificates.singular')]));

        return redirect(route('achievementCertificates.index'));
    }

    public function calcNetAmount($input){
        return floatval($input['amount']) - floatval($input['fines_amount']) ;
    }

    public function approval($id){
        $achievementCertificate = AchievementCertificate::find($id);

        if (empty($achievementCertificate)) {
            Flash::error(__('messages.not_found', ['model' => __('models/achievementCertificates.singular')]));

            return redirect(route('achievementCertificates.index'));
        }

        if ($achievementCertificate->status != self::NEW_COC){
            Flash::error(__('models/achievementCertificates.The coc status should be new'));
            return redirect()->back();
        }

        $achievementCertificate->status = self::APPROVED_COC;
        $achievementCertificate->save();

        Flash::success(__('messages.updated', ['model' => __('models/achievementCertificates.singular')]));

        return redirect(route('achievementCertificates.index'));
    }
}
