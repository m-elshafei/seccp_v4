<?php

namespace App\Http\Controllers;
use Flash;
use App\Models\EmergencyIssuesType;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateEmergencyIssuesTypeRequest;
use App\Http\Requests\CreateEmergencyIssuesTypeRequest;
use App\DataTables\EmergencyIssuesTypeDataTable;

class EmergencyIssuesTypeController extends Controller
{
    /**
     * Display a listing of the District.
     *
     * @param EmergencyIssuesTypeDataTable $districtDataTable
     * @return Response
     */
    public function index(EmergencyIssuesTypeDataTable $EmergencyIssuesTypeDataTable)
    {
        return $EmergencyIssuesTypeDataTable->render('emergency_issues_types.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('emergency_issues_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmergencyIssuesTypeRequest $request)
    {
        $input = $request->all();

        /** @var EmergencyIssuesType $EmergencyIssuesType */
        $emergencyIssuesType = EmergencyIssuesType::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/emergencyIssuesTypes.singular')]));

        return redirect(route('emergencyIssuesTypes.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $emergencyIssuesType = EmergencyIssuesType::find($id);

        if (empty($emergencyIssuesType)) {
            Flash::error(__('models/emergencyIssuesTypes.singular').' '.__('messages.not_found'));

            return redirect(route('emergencyIssuesTypes.index'));
        }

        return view('emergency_issues_types.show')->with('emergencyIssuesType', $emergencyIssuesType);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        /** @var District $district */
        $emergencyIssuesType = EmergencyIssuesType::find($id);

        if (empty($emergencyIssuesType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/emergencyIssuesTypes.singular')]));

            return redirect(route('emergencyIssuesTypes.index'));
        }

        return view('emergency_issues_types.edit', compact('emergencyIssuesType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateEmergencyIssuesTypeRequest $request )
    {
        /** @var EmergencyIssuesType $EmergencyIssuesType */
        $emergencyIssuesType = EmergencyIssuesType::find($id);

        if (empty($emergencyIssuesType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/emergencyIssuesTypes.singular')]));

            return redirect(route('emergencyIssuesTypes.index'));
        }

        $emergencyIssuesType->fill($request->all());
        $emergencyIssuesType->save();

        Flash::success(__('messages.updated', ['model' => __('models/emergencyIssuesTypes.singular')]));

        return redirect(route('emergencyIssuesTypes.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        /** @var EmergencyIssuesType $EmergencyIssuesType */
        $emergencyIssuesType = EmergencyIssuesType::find($id);

        if (empty($emergencyIssuesType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/emergencyIssuesTypes.singular')]));

            return redirect(route('emergencyIssuesTypes.index'));
        }

        $emergencyIssuesType->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/emergencyIssuesTypes.singular')]));

        return redirect(route('emergencyIssuesTypes.index'));
    }
}
