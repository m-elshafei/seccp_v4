<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Http\Requests;
use App\Models\Branch;
use App\Models\Department;
use App\DataTables\DepartmentDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;

class DepartmentController extends AppBaseController
{
    /**
     * Display a listing of the Department.
     *
     * @param DepartmentDataTable $departmentDataTable
     * @return Response
     */
    public function index(DepartmentDataTable $departmentDataTable)
    {
        return $departmentDataTable->render('departments.index');
    }

    /**
     * Show the form for creating a new Department.
     *
     * @return Response
     */
    public function create()
    {
        $branches = Branch::pluck('name', 'id');
        return view('departments.create',compact('branches'));
    }

    /**
     * Store a newly created Department in storage.
     *
     * @param CreateDepartmentRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartmentRequest $request)
    {
        $input = $request->all();

        /** @var Department $department */
        $department = Department::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/departments.singular')]));

        return redirect(route('departments.index'));
    }

    /**
     * Display the specified Department.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Department $department */
        $department = Department::with("branch")->find($id);

        if (empty($department)) {
            Flash::error(__('models/departments.singular').' '.__('messages.not_found'));

            return redirect(route('departments.index'));
        }

        return view('departments.show')->with('department', $department);
    }

    /**
     * Show the form for editing the specified Department.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Department $department */
        $department = Department::find($id);
        $branches = Branch::pluck('name', 'id');

        if (empty($department)) {
            Flash::error(__('messages.not_found', ['model' => __('models/departments.singular')]));

            return redirect(route('departments.index'));
        }

        return view('departments.edit', compact('department', 'branches'));
    }

    /**
     * Update the specified Department in storage.
     *
     * @param  int              $id
     * @param UpdateDepartmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartmentRequest $request)
    {
        /** @var Department $department */
        $department = Department::find($id);

        if (empty($department)) {
            Flash::error(__('messages.not_found', ['model' => __('models/departments.singular')]));

            return redirect(route('departments.index'));
        }

        $department->fill($request->all());
        $department->save();

        Flash::success(__('messages.updated', ['model' => __('models/departments.singular')]));

        return redirect(route('departments.index'));
    }

    /**
     * Remove the specified Department from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Department $department */
        $department = Department::find($id);

        if (empty($department)) {
            Flash::error(__('messages.not_found', ['model' => __('models/departments.singular')]));

            return redirect(route('departments.index'));
        }

        $department->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/departments.singular')]));

        return redirect(route('departments.index'));
    }
}
