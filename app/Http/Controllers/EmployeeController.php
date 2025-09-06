<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use App\Models\User;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class EmployeeController extends AppBaseController
{
    /**
     * Display a listing of the Employee.
     *
     * @param EmployeeDataTable $employeeDataTable
     * @return Response
     */
    public function index(EmployeeDataTable $employeeDataTable)
    {
        return $employeeDataTable->render('employees.index');
    }

    /**
     * Show the form for creating a new Employee.
     *
     * @return Response
     */
    public function create()
    {
        $branches = Branch::pluck('name', 'id');
        $departments = Department::pluck('name', 'id');
        $jobs = Job::pluck('name', 'id');

        return view('employees.create',[
            'departments' => $departments,
            'branches' => $branches,
            'jobs' => $jobs,
        ]);
    }

    /**
     * Store a newly created Employee in storage.
     *
     * @param CreateEmployeeRequest $request
     *
     * @return Response
     */
    public function store(CreateEmployeeRequest $request)
    {
        $input = $request->all();

        /** @var Employee $employee */
        $employee = Employee::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/employees.singular')]));

        return redirect(route('employees.index'));
    }

    /**
     * Display the specified Employee.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Employee $employee */
        $employee = Employee::with(['user','branch','department','job'])->find($id);

        if (empty($employee)) {
            Flash::error(__('models/employees.singular').' '.__('messages.not_found'));

            return redirect(route('employees.index'));
        }

        return view('employees.show')->with('employee', $employee);
    }

    /**
     * Show the form for editing the specified Employee.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Employee $employee */
        $employee = Employee::find($id);

        if (empty($employee)) {
            Flash::error(__('messages.not_found', ['model' => __('models/employees.singular')]));

            return redirect(route('employees.index'));
        }

        $branches = Branch::pluck('name', 'id');
        $departments = Department::pluck('name', 'id');
        $jobs = Job::pluck('name', 'id');
        $user = User::where('id',$employee->user_id)->pluck('name', 'id');


        return view('employees.edit')->with([
            'employee'=>$employee,
            'departments' => $departments,
            'branches' => $branches,
            'jobs' => $jobs,
            'user' => $user,
        ]);
    }

    /**
     * Update the specified Employee in storage.
     *
     * @param  int              $id
     * @param UpdateEmployeeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEmployeeRequest $request)
    {
        /** @var Employee $employee */
        $employee = Employee::find($id);

        if (empty($employee)) {
            Flash::error(__('messages.not_found', ['model' => __('models/employees.singular')]));

            return redirect(route('employees.index'));
        }

        $employee->fill($request->all());
        $employee->save();

        Flash::success(__('messages.updated', ['model' => __('models/employees.singular')]));

        return redirect(route('employees.index'));
    }

    /**
     * Remove the specified Employee from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Employee $employee */
        $employee = Employee::find($id);

        if (empty($employee)) {
            Flash::error(__('messages.not_found', ['model' => __('models/employees.singular')]));

            return redirect(route('employees.index'));
        }

        $employee->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/employees.singular')]));

        return redirect(route('employees.index'));
    }

    public function updateTheme($id)
    {
        $employee = Employee::where('name',$id)->first();
        $employee->theme = ($employee->theme == 0) ? 1 : 0;
        $employee->save();
        return redirect()->back();
    }
}
