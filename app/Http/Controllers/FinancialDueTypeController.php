<?php

namespace App\Http\Controllers;

use App\DataTables\FinancialDueTypeDataTable;
use App\Http\Requests\CreateFinancialDueTypeRequest;
use App\Http\Requests\UpdateFinancialDueTypeRequest;
use App\Models\FinancialDueType;
use Flash;
use Response;

class FinancialDueTypeController extends AppBaseController
{
    /**
     * Display a listing of the FinancialDueType.
     *
     * @return Response
     */
    public function index(FinancialDueTypeDataTable $financialDueTypeDataTable)
    {
        return $financialDueTypeDataTable->render('financial_due_types.index');
    }

    /**
     * Show the form for creating a new FinancialDueType.
     *
     * @return Response
     */
    public function create()
    {
        return view('financial_due_types.create');
    }

    /**
     * Store a newly created FinancialDueType in storage.
     *
     *
     * @return Response
     */
    public function store(CreateFinancialDueTypeRequest $request)
    {
        $input = $request->all();

        /** @var FinancialDueType $financialDueType */
        $financialDueType = FinancialDueType::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/financialDueTypes.singular')]));

        return redirect(route('financialDueTypes.index'));
    }

    /**
     * Display the specified FinancialDueType.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        /** @var FinancialDueType $financialDueType */
        $financialDueType = FinancialDueType::find($id);

        if (empty($financialDueType)) {
            Flash::error(__('models/financialDueTypes.singular').' '.__('messages.not_found'));

            return redirect(route('financialDueTypes.index'));
        }

        return view('financial_due_types.show')->with('financialDueType', $financialDueType);
    }

    /**
     * Show the form for editing the specified FinancialDueType.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        /** @var FinancialDueType $financialDueType */
        $financialDueType = FinancialDueType::find($id);

        if (empty($financialDueType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/financialDueTypes.singular')]));

            return redirect(route('financialDueTypes.index'));
        }

        return view('financial_due_types.edit')->with('financialDueType', $financialDueType);
    }

    /**
     * Update the specified FinancialDueType in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateFinancialDueTypeRequest $request)
    {
        /** @var FinancialDueType $financialDueType */
        $financialDueType = FinancialDueType::find($id);

        if (empty($financialDueType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/financialDueTypes.singular')]));

            return redirect(route('financialDueTypes.index'));
        }

        $financialDueType->fill($request->all());
        $financialDueType->save();

        Flash::success(__('messages.updated', ['model' => __('models/financialDueTypes.singular')]));

        return redirect(route('financialDueTypes.index'));
    }

    /**
     * Remove the specified FinancialDueType from storage.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var FinancialDueType $financialDueType */
        $financialDueType = FinancialDueType::find($id);

        if (empty($financialDueType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/financialDueTypes.singular')]));

            return redirect(route('financialDueTypes.index'));
        }

        $financialDueType->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/financialDueTypes.singular')]));

        return redirect(route('financialDueTypes.index'));
    }
}
