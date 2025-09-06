<?php

namespace App\Http\Controllers;

use App\DataTables\MissionTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMissionTypeRequest;
use App\Http\Requests\UpdateMissionTypeRequest;
use App\Models\MissionType;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MissionTypeController extends AppBaseController
{
    /**
     * Display a listing of the MissionType.
     *
     * @param MissionTypeDataTable $missionTypeDataTable
     * @return Response
     */
    public function index(MissionTypeDataTable $missionTypeDataTable)
    {
        return $missionTypeDataTable->render('mission_types.index');
    }

    /**
     * Show the form for creating a new MissionType.
     *
     * @return Response
     */
    public function create()
    {
        return view('mission_types.create');
    }

    /**
     * Store a newly created MissionType in storage.
     *
     * @param CreateMissionTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateMissionTypeRequest $request)
    {
        $input = $request->all();

        /** @var MissionType $missionType */
        $missionType = MissionType::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/missionTypes.singular')]));

        return redirect(route('missionTypes.index'));
    }

    /**
     * Display the specified MissionType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var MissionType $missionType */
        $missionType = MissionType::find($id);

        if (empty($missionType)) {
            Flash::error(__('models/missionTypes.singular').' '.__('messages.not_found'));

            return redirect(route('missionTypes.index'));
        }

        return view('mission_types.show')->with('missionType', $missionType);
    }

    /**
     * Show the form for editing the specified MissionType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var MissionType $missionType */
        $missionType = MissionType::find($id);

        if (empty($missionType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/missionTypes.singular')]));

            return redirect(route('missionTypes.index'));
        }

        return view('mission_types.edit')->with('missionType', $missionType);
    }

    /**
     * Update the specified MissionType in storage.
     *
     * @param  int              $id
     * @param UpdateMissionTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMissionTypeRequest $request)
    {
        /** @var MissionType $missionType */
        $missionType = MissionType::find($id);

        if (empty($missionType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/missionTypes.singular')]));

            return redirect(route('missionTypes.index'));
        }

        $missionType->fill($request->all());
        $missionType->save();

        Flash::success(__('messages.updated', ['model' => __('models/missionTypes.singular')]));

        return redirect(route('missionTypes.index'));
    }

    /**
     * Remove the specified MissionType from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var MissionType $missionType */
        $missionType = MissionType::find($id);

        if (empty($missionType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/missionTypes.singular')]));

            return redirect(route('missionTypes.index'));
        }

        $missionType->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/missionTypes.singular')]));

        return redirect(route('missionTypes.index'));
    }
}
