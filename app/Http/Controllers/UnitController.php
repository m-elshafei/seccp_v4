<?php

namespace App\Http\Controllers;

use App\DataTables\UnitDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Unit;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class UnitController extends AppBaseController
{
    /**
     * Display a listing of the Unit.
     *
     * @param UnitDataTable $unitDataTable
     * @return Response
     */
    public function index(UnitDataTable $unitDataTable)
    {
        return $unitDataTable->render('units.index');
    }

    /**
     * Show the form for creating a new Unit.
     *
     * @return Response
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created Unit in storage.
     *
     * @param CreateUnitRequest $request
     *
     * @return Response
     */
    public function store(CreateUnitRequest $request)
    {
        $input = $request->all();

        /** @var Unit $unit */
        $unit = Unit::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/units.singular')]));

        return redirect(route('units.index'));
    }

    /**
     * Display the specified Unit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Unit $unit */
        $unit = Unit::find($id);

        if (empty($unit)) {
            Flash::error(__('models/units.singular').' '.__('messages.not_found'));

            return redirect(route('units.index'));
        }

        return view('units.show')->with('unit', $unit);
    }

    /**
     * Show the form for editing the specified Unit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Unit $unit */
        $unit = Unit::find($id);

        if (empty($unit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/units.singular')]));

            return redirect(route('units.index'));
        }

        return view('units.edit')->with('unit', $unit);
    }

    /**
     * Update the specified Unit in storage.
     *
     * @param  int              $id
     * @param UpdateUnitRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUnitRequest $request)
    {
        /** @var Unit $unit */
        $unit = Unit::find($id);

        if (empty($unit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/units.singular')]));

            return redirect(route('units.index'));
        }

        $unit->fill($request->all());
        $unit->save();

        Flash::success(__('messages.updated', ['model' => __('models/units.singular')]));

        return redirect(route('units.index'));
    }

    /**
     * Remove the specified Unit from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Unit $unit */
        $unit = Unit::find($id);

        if (empty($unit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/units.singular')]));

            return redirect(route('units.index'));
        }

        $unit->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/units.singular')]));

        return redirect(route('units.index'));
    }
}
