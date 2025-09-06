<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Models\City;
use App\Http\Requests;
use App\Models\Branch;
use App\Models\District;
use App\DataTables\BranchDataTable;
use App\Http\Requests\CreateBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Http\Controllers\AppBaseController;

class BranchController extends AppBaseController
{
    /**
     * Display a listing of the Branch.
     *
     * @param BranchDataTable $branchDataTable
     * @return Response
     */
    public function index(BranchDataTable $branchDataTable)
    {
        return $branchDataTable->render('branches.index');
    }

    /**
     * Show the form for creating a new Branch.
     *
     * @return Response
     */
    public function create()
    {
        $cities = City::pluck('name', 'id');
        return view('branches.create', compact('cities'));
    }

    /**
     * Store a newly created Branch in storage.
     *
     * @param CreateBranchRequest $request
     *
     * @return Response
     */
    public function store(CreateBranchRequest $request)
    {
        $input = $request->all();

        /** @var Branch $branch */
        $branch = Branch::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/branches.singular')]));

        return redirect(route('branches.index'));
    }

    /**
     * Display the specified Branch.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Branch $branch */
        $branch = Branch::with(["city","district"])->find($id);

        if (empty($branch)) {
            Flash::error(__('models/branches.singular').' '.__('messages.not_found'));

            return redirect(route('branches.index'));
        }

        return view('branches.show')->with('branch', $branch);
    }

    /**
     * Show the form for editing the specified Branch.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Branch $branch */
        $branch = Branch::find($id);
        $cities = City::pluck('name', 'id');

        if (empty($branch)) {
            Flash::error(__('messages.not_found', ['model' => __('models/branches.singular')]));

            return redirect(route('branches.index'));
        }

        return view('branches.edit', compact('branch', 'cities'));
    }

    /**
     * Update the specified Branch in storage.
     *
     * @param  int              $id
     * @param UpdateBranchRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBranchRequest $request)
    {
        /** @var Branch $branch */
        $branch = Branch::find($id);

        if (empty($branch)) {
            Flash::error(__('messages.not_found', ['model' => __('models/branches.singular')]));

            return redirect(route('branches.index'));
        }

        $branch->fill($request->all());
        $branch->save();

        Flash::success(__('messages.updated', ['model' => __('models/branches.singular')]));

        return redirect(route('branches.index'));
    }

    /**
     * Remove the specified Branch from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Branch $branch */
        $branch = Branch::find($id);

        if (empty($branch)) {
            Flash::error(__('messages.not_found', ['model' => __('models/branches.singular')]));

            return redirect(route('branches.index'));
        }

        $branch->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/branches.singular')]));

        return redirect(route('branches.index'));
    }
}
