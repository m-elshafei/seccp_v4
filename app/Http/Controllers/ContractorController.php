<?php

namespace App\Http\Controllers;

use App\DataTables\ContractorDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateContractorRequest;
use App\Http\Requests\UpdateContractorRequest;
use App\Models\Contractor;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ContractorController extends AppBaseController
{
    /**
     * Display a listing of the Contractor.
     *
     * @param ContractorDataTable $contractorDataTable
     * @return Response
     */
    public function index(ContractorDataTable $contractorDataTable)
    {
        return $contractorDataTable->render('contractors.index');
    }

    /**
     * Show the form for creating a new Contractor.
     *
     * @return Response
     */
    public function create()
    {
        return view('contractors.create');
    }

    /**
     * Store a newly created Contractor in storage.
     *
     * @param CreateContractorRequest $request
     *
     * @return Response
     */
    public function store(CreateContractorRequest $request)
    {
        $input = $request->all();

        /** @var Contractor $contractor */
        $contractor = Contractor::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/contractors.singular')]));

        return redirect(route('contractors.index'));
    }

    /**
     * Display the specified Contractor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Contractor $contractor */
        $contractor = Contractor::find($id);

        if (empty($contractor)) {
            Flash::error(__('models/contractors.singular').' '.__('messages.not_found'));

            return redirect(route('contractors.index'));
        }

        return view('contractors.show')->with('contractor', $contractor);
    }

    /**
     * Show the form for editing the specified Contractor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Contractor $contractor */
        $contractor = Contractor::find($id);

        if (empty($contractor)) {
            Flash::error(__('messages.not_found', ['model' => __('models/contractors.singular')]));

            return redirect(route('contractors.index'));
        }

        return view('contractors.edit')->with('contractor', $contractor);
    }

    /**
     * Update the specified Contractor in storage.
     *
     * @param  int              $id
     * @param UpdateContractorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContractorRequest $request)
    {
        /** @var Contractor $contractor */
        $contractor = Contractor::find($id);

        if (empty($contractor)) {
            Flash::error(__('messages.not_found', ['model' => __('models/contractors.singular')]));

            return redirect(route('contractors.index'));
        }

        $contractor->fill($request->all());
        $contractor->save();

        Flash::success(__('messages.updated', ['model' => __('models/contractors.singular')]));

        return redirect(route('contractors.index'));
    }

    /**
     * Remove the specified Contractor from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Contractor $contractor */
        $contractor = Contractor::find($id);

        if (empty($contractor)) {
            Flash::error(__('messages.not_found', ['model' => __('models/contractors.singular')]));

            return redirect(route('contractors.index'));
        }

        $contractor->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/contractors.singular')]));

        return redirect(route('contractors.index'));
    }
}
