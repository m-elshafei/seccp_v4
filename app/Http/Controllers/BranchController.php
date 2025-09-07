<?php

namespace App\Http\Controllers;

use App\DataTables\BranchDataTable;
use App\Http\Requests\CreateBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Repositories\BranchRepository;
use App\Models\Branch;
use Flash;
use Response;

class BranchController extends AppBaseController
{
    /**
     * Display a listing of the Branch.
     *
     * @param  BranchDataTable  $branchDataTable
     * @return Response
     */
    protected $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

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
        $cities = $this->branchRepository->getCities();

        return view('branches.create', compact('cities'));
    }

    /**
     * Store a newly created Branch in storage.
     *
     *
     * @return Response
     */
    public function store(CreateBranchRequest $request)
    {
        $input = $request->all();

        $branch = $this->branchRepository->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/branches.singular')]));

        return redirect(route('branches.index'));
    }

    /**
     * Display the specified Branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $branch = $this->branchRepository->find($id);

        if (empty($branch)) {
            Flash::error(__('models/branches.singular').' '.__('messages.not_found'));

            return redirect(route('branches.index'));
        }

        return view('branches.show')->with('branch', $branch);
    }

    /**
     * Show the form for editing the specified Branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        /** @var Branch $branch */
        $branch = $this->branchRepository->find($id);
        $cities = $this->branchRepository->getCities();

        if (empty($branch)) {
            Flash::error(__('messages.not_found', ['model' => __('models/branches.singular')]));

            return redirect(route('branches.index'));
        }

        return view('branches.edit', compact('branch', 'cities'));
    }

    /**
     * Update the specified Branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateBranchRequest $request)
    {
        /** @var Branch $branch */
        $branch = $this->branchRepository->find($id);

        if (empty($branch)) {
            Flash::error(__('messages.not_found', ['model' => __('models/branches.singular')]));

            return redirect(route('branches.index'));
        }

        $this->branchRepository->update($id, $request->all());

        Flash::success(__('messages.updated', ['model' => __('models/branches.singular')]));

        return redirect(route('branches.index'));
    }

    /**
     * Remove the specified Branch from storage.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $branch = $this->branchRepository->find($id);

        if (empty($branch)) {
            Flash::error(__('messages.not_found', ['model' => __('models/branches.singular')]));

            return redirect(route('branches.index'));
        }

        $this->branchRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/branches.singular')]));

        return redirect(route('branches.index'));
    }
}
