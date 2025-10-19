<?php

namespace App\Http\Controllers;

use App\DataTables\ContractorDataTable;
use App\Http\Requests\CreateContractorRequest;
use App\Http\Requests\UpdateContractorRequest;
use App\Models\Contractor;
use Flash;
use Response;
use App\Services\ContractorService;

class ContractorController extends AppBaseController
{
    public ContractorService $contractorService;

    public function __construct(ContractorService $contractorService)
    {
        $this->contractorService = $contractorService;
    }

    public function index(ContractorDataTable $contractorDataTable)
    {
        return $contractorDataTable->render('contractors.index');
    }

    public function create()
    {
        return view('contractors.create');
    }

    /**
     * Store a newly created Contractor in storage.
     *
     *
     * @return Response
     */
   public function store(CreateContractorRequest $request)
    {
        $input = $request->validated(); 

        $this->contractorService->createContractor($input);

        Flash::success(__('messages.saved', ['model' => __('models/contractors.singular')]));

        return redirect(route('contractors.index'));
    }

    /**
     * Display the specified Contractor.
     *
     * @param  int  $id
     * @return Response
     */


    public function show($id)
    {
        $contractor = $this->contractorService->getContractor($id);

        if (empty($contractor)) {
            Flash::error(__('models/contractors.singular').' '.__('messages.not_found'));

            return redirect(route('contractors.index'));
        }
        return view('contractors.show')->with('contractor', $contractor);
    }

    /**
     * Show the form for editing the specified Contractor.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $contractor = $this->contractorService->getContractor($id);

        if (empty($contractor)) {
            Flash::error(__('messages.not_found', ['model' => __('models/contractors.singular')]));

            return redirect(route('contractors.index'));
        }

        return view('contractors.edit')->with('contractor', $contractor);
    }

    /**
     * Update the specified Contractor in storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function update($id, UpdateContractorRequest $request)
    {
        $input = $request->validated(); 
        $contractor = $this->contractorService->updateContractor($id, $input);

        if (empty($contractor)) {
            Flash::error(__('messages.not_found', ['model' => __('models/contractors.singular')]));

            return redirect(route('contractors.index'));
        }

        Flash::success(__('messages.updated', ['model' => __('models/contractors.singular')]));

        return redirect(route('contractors.index'));
    }

    /**
     * Remove the specified Contractor from storage.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    
    public function destroy($id)
    {
        $isDeleted = $this->contractorService->deleteContractor($id);

        if (!$isDeleted) {
            Flash::error(__('messages.not_found', ['model' => __('models/contractors.singular')]));

            return redirect(route('contractors.index'));
        }

        Flash::success(__('messages.deleted', ['model' => __('models/contractors.singular')]));

        return redirect(route('contractors.index'));
    }
}
