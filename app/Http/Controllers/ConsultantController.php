<?php

namespace App\Http\Controllers;

use App\DataTables\ConsultantDataTable;
use App\Http\Requests\CreateConsultantRequest;
use App\Http\Requests\UpdateConsultantRequest;
use App\Models\Consultant;
use Flash;
use Response;
use App\Services\ConsultantService;

class ConsultantController extends AppBaseController
{

    protected ConsultantService $consultantService;

    public function __construct(ConsultantService $consultantService)
    {
        $this->consultantService = $consultantService;
    }

    public function index(ConsultantDataTable $consultantDataTable)
    {
        return $consultantDataTable->render('consultants.index');
    }

    /**
     * Show the form for creating a new Consultant.
     *
     * @return Response
     */
    public function create()
    {
        return view('consultants.create');
    }

    /**
     * Store a newly created Consultant in storage.
     *
     *
     * @return Response
     */
    public function store(CreateConsultantRequest $request)
    {
        $input = $request->validated(); 

        $this->consultantService->createConsultant($input);

        Flash::success(__('messages.saved', ['model' => __('models/consultants.singular')]));

        return redirect(route('consultants.index'));
    }

    /**
     * Display the specified Consultant.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $consultant = $this->consultantService->getConsultant($id);

        if (empty($consultant)) {
            Flash::error(__('models/consultants.singular').' '.__('messages.not_found'));

            return redirect(route('consultants.index'));
        }

        return view('consultants.show')->with('consultant', $consultant);
    }

    /**
     * Show the form for editing the specified Consultant.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $consultant = $this->consultantService->getConsultant($id);

        if (empty($consultant)) {
            Flash::error(__('messages.not_found', ['model' => __('models/consultants.singular')]));

            return redirect(route('consultants.index'));
        }

        return view('consultants.edit')->with('consultant', $consultant);
    }

    /**
     * Update the specified Consultant in storage.
     *
     * @param  int  $id
     * @return Response
     */
public function update($id, UpdateConsultantRequest $request)
    {
        $input = $request->validated();

        $consultant = $this->consultantService->updateConsultant($id, $input);

        if (empty($consultant)) {
            Flash::error(__('messages.not_found', ['model' => __('models/consultants.singular')]));

            return redirect(route('consultants.index'));
        }

        Flash::success(__('messages.updated', ['model' => __('models/consultants.singular')]));

        return redirect(route('consultants.index'));
    }

    /**
     * Remove the specified Consultant from storage.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $isDeleted = $this->consultantService->deleteConsultant($id);

        if (!$isDeleted) {
            Flash::error(__('messages.not_found', ['model' => __('models/consultants.singular')]));

            return redirect(route('consultants.index'));
        }

        Flash::success(__('messages.deleted', ['model' => __('models/consultants.singular')]));

        return redirect(route('consultants.index'));
    }
}
