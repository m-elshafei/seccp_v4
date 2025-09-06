<?php

namespace App\Http\Controllers;

use App\DataTables\ElectricityDepartmentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateElectricityDepartmentRequest;
use App\Http\Requests\UpdateElectricityDepartmentRequest;
use App\Models\ElectricityDepartment;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ElectricityDepartmentController extends AppBaseController
{
    /**
     * Display a listing of the ElectricityDepartment.
     *
     * @param ElectricityDepartmentDataTable $electricityDepartmentDataTable
     * @return Response
     */
    public function index(ElectricityDepartmentDataTable $electricityDepartmentDataTable)
    {
        return $electricityDepartmentDataTable->render('electricity_departments.index');
    }

    /**
     * Show the form for creating a new ElectricityDepartment.
     *
     * @return Response
     */
    public function create()
    {
        return view('electricity_departments.create');
    }

    /**
     * Store a newly created ElectricityDepartment in storage.
     *
     * @param CreateElectricityDepartmentRequest $request
     *
     * @return Response
     */
    public function store(CreateElectricityDepartmentRequest $request)
    {
        $input = $request->all();

        /** @var ElectricityDepartment $electricityDepartment */
        $electricityDepartment = ElectricityDepartment::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/electricityDepartments.singular')]));

        return redirect(route('electricityDepartments.index'));
    }

    /**
     * Display the specified ElectricityDepartment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ElectricityDepartment $electricityDepartment */
        $electricityDepartment = ElectricityDepartment::find($id);

        if (empty($electricityDepartment)) {
            Flash::error(__('models/electricityDepartments.singular').' '.__('messages.not_found'));

            return redirect(route('electricityDepartments.index'));
        }

        return view('electricity_departments.show')->with('electricityDepartment', $electricityDepartment);
    }

    /**
     * Show the form for editing the specified ElectricityDepartment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var ElectricityDepartment $electricityDepartment */
        $electricityDepartment = ElectricityDepartment::find($id);

        if (empty($electricityDepartment)) {
            Flash::error(__('messages.not_found', ['model' => __('models/electricityDepartments.singular')]));

            return redirect(route('electricityDepartments.index'));
        }

        return view('electricity_departments.edit')->with('electricityDepartment', $electricityDepartment);
    }

    /**
     * Update the specified ElectricityDepartment in storage.
     *
     * @param  int              $id
     * @param UpdateElectricityDepartmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateElectricityDepartmentRequest $request)
    {
        /** @var ElectricityDepartment $electricityDepartment */
        $electricityDepartment = ElectricityDepartment::find($id);

        if (empty($electricityDepartment)) {
            Flash::error(__('messages.not_found', ['model' => __('models/electricityDepartments.singular')]));

            return redirect(route('electricityDepartments.index'));
        }

        $electricityDepartment->fill($request->all());
        $electricityDepartment->save();

        Flash::success(__('messages.updated', ['model' => __('models/electricityDepartments.singular')]));

        return redirect(route('electricityDepartments.index'));
    }

    /**
     * Remove the specified ElectricityDepartment from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ElectricityDepartment $electricityDepartment */
        $electricityDepartment = ElectricityDepartment::find($id);

        if (empty($electricityDepartment)) {
            Flash::error(__('messages.not_found', ['model' => __('models/electricityDepartments.singular')]));

            return redirect(route('electricityDepartments.index'));
        }

        $electricityDepartment->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/electricityDepartments.singular')]));

        return redirect(route('electricityDepartments.index'));
    }
}
