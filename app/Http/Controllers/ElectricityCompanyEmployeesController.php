<?php

namespace App\Http\Controllers;

use Flash;
use App\Models\ElectricityCompanyEmployees;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateElectricityCompanyEmployeesRequest;
use App\Http\Requests\CreateElectricityCompanyEmployeesRequest;
use App\DataTables\ElectricityCompanyEmployeeDataTable;

class ElectricityCompanyEmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ElectricityCompanyEmployeeDataTable $ElectricityCompanyEmployeeDataTable)
    {
        return $ElectricityCompanyEmployeeDataTable->render('electricity_company_employees.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('electricity_company_employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateElectricityCompanyEmployeesRequest $request)
    {
        $input = $request->all();

        /** @var ElectricityCompanyEmployees $electricityDepartment */
        $electricityCompanyEmployees = ElectricityCompanyEmployees::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/electricityCompanyEmployees.singular')]));

        return redirect(route('electricityCompanyEmployees.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        /** @var ElectricityCompanyEmployees $electricityCompanyEmployees */
        $electricityCompanyEmployees = ElectricityCompanyEmployees::find($id);

        if (empty($electricityCompanyEmployees)) {
            Flash::error(__('models/electricityCompanyEmployees.singular').' '.__('messages.not_found'));

            return redirect(route('electricityCompanyEmployees.index'));
        }

        return view('electricity_company_employees.show')->with('electricityCompanyEmployees', $electricityCompanyEmployees);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        /** @var ElectricityCompanyEmployees $electricityCompanyEmployees */
        $electricityCompanyEmployees = ElectricityCompanyEmployees::find($id);

        if (empty($electricityCompanyEmployees)) {
            Flash::error(__('messages.not_found', ['model' => __('models/electricityCompanyEmployees.singular')]));

            return redirect(route('electricityCompanyEmployees.index'));
        }

        return view('electricity_company_employees.edit')->with('electricityCompanyEmployees', $electricityCompanyEmployees);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateElectricityCompanyEmployeesRequest $request)
    {
        /** @var ElectricityCompanyEmployees $electricityCompanyEmployees */
        $electricityCompanyEmployees = ElectricityCompanyEmployees::find($id);

        if (empty($electricityCompanyEmployees)) {
            Flash::error(__('messages.not_found', ['model' => __('models/electricityCompanyEmployees.singular')]));

            return redirect(route('electricityCompanyEmployees.index'));
        }

        $electricityCompanyEmployees->fill($request->all());
        $electricityCompanyEmployees->save();

        Flash::success(__('messages.updated', ['model' => __('models/electricityCompanyEmployees.singular')]));

        return redirect(route('electricityCompanyEmployees.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        /** @var ElectricityCompanyEmployees $electricityDepartment */
        $electricityCompanyEmployees = ElectricityCompanyEmployees::find($id);

        if (empty($electricityCompanyEmployees)) {
            Flash::error(__('messages.not_found', ['model' => __('models/electricityCompanyEmployees.singular')]));

            return redirect(route('electricityCompanyEmployees.index'));
        }

        $electricityCompanyEmployees->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/electricityCompanyEmployees.singular')]));

        return redirect(route('electricityCompanyEmployees.index'));
    }
}
