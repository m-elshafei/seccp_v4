<?php

namespace App\Http\Controllers;

use App\DataTables\ElectricalStationsTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateElectricalStationsTypeRequest;
use App\Http\Requests\UpdateElectricalStationsTypeRequest;
use App\Models\ElectricalStationsType;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ElectricalStationsTypeController extends AppBaseController
{
    const electricalTypes = [
        1=> "ضغط عالى" ,
        2=> "ضغط منخفض" ,
    ];
    /**
     * Display a listing of the ElectricalStationsType.
     *
     * @param ElectricalStationsTypeDataTable $electricalStationsTypeDataTable
     * @return Response
     */
    public function index(ElectricalStationsTypeDataTable $electricalStationsTypeDataTable)
    {
        return $electricalStationsTypeDataTable->render('electrical_stations_types.index');
    }

    /**
     * Show the form for creating a new ElectricalStationsType.
     *
     * @return Response
     */
    public function create()
    {

        return view('electrical_stations_types.create')->with(['electricalTypes' => self::electricalTypes]);
    }

    /**
     * Store a newly created ElectricalStationsType in storage.
     *
     * @param CreateElectricalStationsTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateElectricalStationsTypeRequest $request)
    {
        $input = $request->all();

        /** @var ElectricalStationsType $electricalStationsType */
        $electricalStationsType = ElectricalStationsType::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/electricalStationsTypes.singular')]));

        return redirect(route('electricalStationsTypes.index'));
    }

    /**
     * Display the specified ElectricalStationsType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ElectricalStationsType $electricalStationsType */
        $electricalStationsType = ElectricalStationsType::find($id);

        if (empty($electricalStationsType)) {
            Flash::error(__('models/electricalStationsTypes.singular').' '.__('messages.not_found'));

            return redirect(route('electricalStationsTypes.index'));
        }

        return view('electrical_stations_types.show')->with([
            'electricalStationsType' => $electricalStationsType,
            'electricalTypes' => self::electricalTypes
        ]);
    }

    /**
     * Show the form for editing the specified ElectricalStationsType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var ElectricalStationsType $electricalStationsType */
        $electricalStationsType = ElectricalStationsType::find($id);

        if (empty($electricalStationsType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/electricalStationsTypes.singular')]));

            return redirect(route('electricalStationsTypes.index'));
        }

        return view('electrical_stations_types.edit')->with([
            'electricalStationsType' => $electricalStationsType,
            'electricalTypes' => self::electricalTypes
        ]);
    }

    /**
     * Update the specified ElectricalStationsType in storage.
     *
     * @param  int              $id
     * @param UpdateElectricalStationsTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateElectricalStationsTypeRequest $request)
    {
        /** @var ElectricalStationsType $electricalStationsType */
        $electricalStationsType = ElectricalStationsType::find($id);

        if (empty($electricalStationsType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/electricalStationsTypes.singular')]));

            return redirect(route('electricalStationsTypes.index'));
        }

        $electricalStationsType->fill($request->all());
        $electricalStationsType->save();

        Flash::success(__('messages.updated', ['model' => __('models/electricalStationsTypes.singular')]));

        return redirect(route('electricalStationsTypes.index'));
    }

    /**
     * Remove the specified ElectricalStationsType from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ElectricalStationsType $electricalStationsType */
        $electricalStationsType = ElectricalStationsType::find($id);

        if (empty($electricalStationsType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/electricalStationsTypes.singular')]));

            return redirect(route('electricalStationsTypes.index'));
        }

        $electricalStationsType->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/electricalStationsTypes.singular')]));

        return redirect(route('electricalStationsTypes.index'));
    }
}
