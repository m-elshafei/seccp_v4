<?php

namespace App\Http\Controllers;

use App\DataTables\ConsultantDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateConsultantRequest;
use App\Http\Requests\UpdateConsultantRequest;
use App\Models\Consultant;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ConsultantController extends AppBaseController
{
    /**
     * Display a listing of the Consultant.
     *
     * @param ConsultantDataTable $consultantDataTable
     * @return Response
     */
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
     * @param CreateConsultantRequest $request
     *
     * @return Response
     */
    public function store(CreateConsultantRequest $request)
    {
        $input = $request->all();

        /** @var Consultant $consultant */
        $consultant = Consultant::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/consultants.singular')]));

        return redirect(route('consultants.index'));
    }

    /**
     * Display the specified Consultant.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Consultant $consultant */
        $consultant = Consultant::find($id);

        if (empty($consultant)) {
            Flash::error(__('models/consultants.singular').' '.__('messages.not_found'));

            return redirect(route('consultants.index'));
        }

        return view('consultants.show')->with('consultant', $consultant);
    }

    /**
     * Show the form for editing the specified Consultant.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Consultant $consultant */
        $consultant = Consultant::find($id);

        if (empty($consultant)) {
            Flash::error(__('messages.not_found', ['model' => __('models/consultants.singular')]));

            return redirect(route('consultants.index'));
        }

        return view('consultants.edit')->with('consultant', $consultant);
    }

    /**
     * Update the specified Consultant in storage.
     *
     * @param  int              $id
     * @param UpdateConsultantRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateConsultantRequest $request)
    {
        /** @var Consultant $consultant */
        $consultant = Consultant::find($id);

        if (empty($consultant)) {
            Flash::error(__('messages.not_found', ['model' => __('models/consultants.singular')]));

            return redirect(route('consultants.index'));
        }

        $consultant->fill($request->all());
        $consultant->save();

        Flash::success(__('messages.updated', ['model' => __('models/consultants.singular')]));

        return redirect(route('consultants.index'));
    }

    /**
     * Remove the specified Consultant from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Consultant $consultant */
        $consultant = Consultant::find($id);

        if (empty($consultant)) {
            Flash::error(__('messages.not_found', ['model' => __('models/consultants.singular')]));

            return redirect(route('consultants.index'));
        }

        $consultant->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/consultants.singular')]));

        return redirect(route('consultants.index'));
    }
}
