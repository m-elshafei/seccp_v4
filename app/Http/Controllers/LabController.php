<?php

namespace App\Http\Controllers;

use App\DataTables\LabDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLabRequest;
use App\Http\Requests\UpdateLabRequest;
use App\Models\Lab;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class LabController extends AppBaseController
{
    /**
     * Display a listing of the Lab.
     *
     * @param LabDataTable $labDataTable
     * @return Response
     */
    public function index(LabDataTable $labDataTable)
    {
        return $labDataTable->render('labs.index');
    }

    /**
     * Show the form for creating a new Lab.
     *
     * @return Response
     */
    public function create()
    {
        return view('labs.create');
    }

    /**
     * Store a newly created Lab in storage.
     *
     * @param CreateLabRequest $request
     *
     * @return Response
     */
    public function store(CreateLabRequest $request)
    {
        $input = $request->all();

        /** @var Lab $lab */
        $lab = Lab::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/labs.singular')]));

        return redirect(route('labs.index'));
    }

    /**
     * Display the specified Lab.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Lab $lab */
        $lab = Lab::find($id);

        if (empty($lab)) {
            Flash::error(__('models/labs.singular').' '.__('messages.not_found'));

            return redirect(route('labs.index'));
        }

        return view('labs.show')->with('lab', $lab);
    }

    /**
     * Show the form for editing the specified Lab.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Lab $lab */
        $lab = Lab::find($id);

        if (empty($lab)) {
            Flash::error(__('messages.not_found', ['model' => __('models/labs.singular')]));

            return redirect(route('labs.index'));
        }

        return view('labs.edit')->with('lab', $lab);
    }

    /**
     * Update the specified Lab in storage.
     *
     * @param  int              $id
     * @param UpdateLabRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLabRequest $request)
    {
        /** @var Lab $lab */
        $lab = Lab::find($id);

        if (empty($lab)) {
            Flash::error(__('messages.not_found', ['model' => __('models/labs.singular')]));

            return redirect(route('labs.index'));
        }

        $lab->fill($request->all());
        $lab->save();

        Flash::success(__('messages.updated', ['model' => __('models/labs.singular')]));

        return redirect(route('labs.index'));
    }

    /**
     * Remove the specified Lab from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Lab $lab */
        $lab = Lab::find($id);

        if (empty($lab)) {
            Flash::error(__('messages.not_found', ['model' => __('models/labs.singular')]));

            return redirect(route('labs.index'));
        }

        $lab->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/labs.singular')]));

        return redirect(route('labs.index'));
    }
}
