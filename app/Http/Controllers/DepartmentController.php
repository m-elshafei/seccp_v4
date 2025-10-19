<?php

namespace App\Http\Controllers;

use App\DataTables\DepartmentDataTable;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Branch;
use App\Models\Department;
use App\Services\DepartmentService;
use Laracasts\Flash\Flash;
use Response;

class DepartmentController extends AppBaseController
{
    /**
     * Display a listing of the Department.
     *
     * @return Response
     */
    public $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

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
        $formData = $this->departmentService->getCreateFormData();

        return view('departments.create', compact('formData'));
    }

    /**
     * Store a newly created Department in storage.
     *
     *
     * @return Response
     */
    public function store(CreateDepartmentRequest $request)
    {
        $input = $request->all();

        /** @var Department $department */
        $this->departmentService->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/departments.singular')]));

        return redirect(route('departments.index'));
    }

    /**
     * Display the specified Department.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $department = $this->departmentService->getDepartment($id);

        if (empty($department)) {
            Flash::error(__('models/departments.singular') . ' ' . __('messages.not_found'));

            return redirect(route('departments.index'));
        }

        return view('departments.show')->with('department', $department);
    }

    /**
     * Show the form for editing the specified Department.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $department = $this->departmentService->getDepartment($id);
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
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateDepartmentRequest $request)
    {
        $department = $this->departmentService->getDepartment($id);

        if (empty($department)) {
            Flash::error(__('messages.not_found', ['model' => __('models/departments.singular')]));

            return redirect(route('departments.index'));
        }

        $this->departmentService->update($id, $request->all());

        Flash::success(__('messages.updated', ['model' => __('models/departments.singular')]));

        return redirect(route('departments.index'));
    }

    /**
     * Remove the specified Department from storage.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $department = $this->departmentService->getDepartment($id);

        if (empty($department)) {
            Flash::error(__('messages.not_found', ['model' => __('models/departments.singular')]));

            return redirect(route('departments.index'));
        }

        $this->departmentService->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/departments.singular')]));

        return redirect(route('departments.index'));
    }
}
