<?php

namespace App\Http\Controllers;

use App\DataTables\AchievementCertificateDataTable;
use App\Enums\AssayFormEnum;
use App\Helpers\Helper;
use App\Http\Requests\CreateAchievementCertificateRequest;
use App\Http\Requests\UpdateAchievementCertificateRequest;
use App\Models\AchievementCertificate;
use App\Models\AssayForm;
use App\Models\WorkOrder;
use App\Services\AchievementCertificateService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;

class AchievementCertificateController extends AppBaseController
{
    const NEW_COC = 2;
    const APPROVED_COC = 1;
    protected $achievementCertificateService;
    protected $certificateService;


    public function __construct(AchievementCertificateService $achievementCertificateService, AchievementCertificateService $certificateService)
    {
        $this->achievementCertificateService = $achievementCertificateService;
        $this->certificateService = $certificateService;

    }


    /**
     * Display a listing of the AchievementCertificate.
     *
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
        $workOrders = $this->achievementCertificateService->getWorkOrdersForCreationView();

        if (is_null($workOrders)) {
            flash(__('models/achievementCertificates.no work order available'))->error();

            return redirect()->back();
        }

        return view('achievement_certificates.create', compact('workOrders'));
    }

    /**
     * Store a newly created AchievementCertificate in storage.
     *
     *
     * @return Response
     */
    public function store(CreateAchievementCertificateRequest $request)
    {
        $input = $request->all();

        $result = $this->certificateService->createCertificate($input);

        if (is_string($result)) {
            if ($result === 'models/achievementCertificates.no work order available') {
                Flash::error(__($result));
                return redirect()->back();
            }
            
            return redirect()->back()->withErrors($result)->withInput();
        }

        $achievementCertificate = $result;

        Flash::success(__('messages.saved', ['model' => __('models/achievementCertificates.singular')]));

        return Helper::redirectAfterSaving($achievementCertificate->id, $request, 'achievementCertificates');
    }

    public function show($id)
    {
        $viewData = $this->certificateService->getShowViewData($id);

        if (is_null($viewData)) {
            Flash::error(__('models/achievementCertificates.singular').' '.__('messages.not_found'));

            return redirect(route('achievementCertificates.index'));
        }

        return view('achievement_certificates.show')->with($viewData);
    }

    /**
     * Show the form for editing the specified AchievementCertificate.
     *
     * @param  int  $id
     * @return Response
     */

    public function edit($id)
    {
        $viewData = $this->certificateService->getEditViewData($id);

        if ($viewData === 'not_found') {
            Flash::error(__('messages.not_found', ['model' => __('models/achievementCertificates.singular')]));
            
            return redirect(route('achievementCertificates.index'));
        }

        if ($viewData === 'cannot_edit') {
            Flash::error(__('models/achievementCertificates.cannot change approved coc'));

            return redirect(route('achievementCertificates.index'));
        }

        return view('achievement_certificates.edit', $viewData);
    }

    /**
     * Update the specified AchievementCertificate in storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function update($id, UpdateAchievementCertificateRequest $request)
    {
        $input = $request->all();

        $result = $this->certificateService->updateCertificate($id, $input);

        if (is_string($result)) {
            return $this->certificateService->handleUpdateError($result);
        }

        Flash::success(__('messages.updated', ['model' => __('models/achievementCertificates.singular')]));

        return Helper::redirectAfterSaving($id, $request, 'achievementCertificates');
    }


    /**
     * Remove the specified AchievementCertificate from storage.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $result = $this->certificateService->deleteCertificate($id);

        if ($result === AchievementCertificateService::ERROR_NOT_FOUND) {
            Flash::error(__('messages.not_found', ['model' => __('models/achievementCertificates.singular')]));
            
            return redirect(route('achievementCertificates.index'));
        }

        Flash::success(__('messages.deleted', ['model' => __('models/achievementCertificates.singular')]));

        return redirect(route('achievementCertificates.index'));
    }

}
