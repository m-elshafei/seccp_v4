<?php

namespace App\Http\Controllers;

use App\DataTables\WorkOrderTransactionsHistoryDataTable;
use App\Http\Requests\CreateWorkOrderTransactionsHistoryRequest;
use App\Http\Requests\UpdateWorkOrderTransactionsHistoryRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\WorkOrderTransactionsHistory;
use Illuminate\Http\Request;
use Flash;

class WorkOrderTransactionsHistoryController extends AppBaseController
{
    /**
     * Display a listing of the WorkOrderTransactionsHistory.
     */
    public function index(WorkOrderTransactionsHistoryDataTable $workOrderTransactionsHistoryDataTable)
    {
    return $workOrderTransactionsHistoryDataTable->render('work_order_transactions_histories.index');
    }


    /**
     * Show the form for creating a new WorkOrderTransactionsHistory.
     */
    public function create()
    {
        return view('work_order_transactions_histories.create');
    }

    /**
     * Store a newly created WorkOrderTransactionsHistory in storage.
     */
    public function store(CreateWorkOrderTransactionsHistoryRequest $request)
    {
        $input = $request->all();

        /** @var WorkOrderTransactionsHistory $workOrderTransactionsHistory */
        $workOrderTransactionsHistory = WorkOrderTransactionsHistory::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/workOrderTransactionsHistories.singular')]));

        return redirect(route('workOrderTransactionsHistories.index'));
    }

    /**
     * Display the specified WorkOrderTransactionsHistory.
     */
    public function show($id)
    {
        /** @var WorkOrderTransactionsHistory $workOrderTransactionsHistory */
        $workOrderTransactionsHistory = WorkOrderTransactionsHistory::find($id);

        if (empty($workOrderTransactionsHistory)) {
            Flash::error(__('models/workOrderTransactionsHistories.singular').' '.__('messages.not_found'));

            return redirect(route('workOrderTransactionsHistories.index'));
        }

        return view('work_order_transactions_histories.show')->with('workOrderTransactionsHistory', $workOrderTransactionsHistory);
    }

    /**
     * Show the form for editing the specified WorkOrderTransactionsHistory.
     */
    public function edit($id)
    {
        /** @var WorkOrderTransactionsHistory $workOrderTransactionsHistory */
        $workOrderTransactionsHistory = WorkOrderTransactionsHistory::find($id);

        if (empty($workOrderTransactionsHistory)) {
            Flash::error(__('models/workOrderTransactionsHistories.singular').' '.__('messages.not_found'));

            return redirect(route('workOrderTransactionsHistories.index'));
        }

        return view('work_order_transactions_histories.edit')->with('workOrderTransactionsHistory', $workOrderTransactionsHistory);
    }

    /**
     * Update the specified WorkOrderTransactionsHistory in storage.
     */
    public function update($id, UpdateWorkOrderTransactionsHistoryRequest $request)
    {
        /** @var WorkOrderTransactionsHistory $workOrderTransactionsHistory */
        $workOrderTransactionsHistory = WorkOrderTransactionsHistory::find($id);

        if (empty($workOrderTransactionsHistory)) {
            Flash::error(__('models/workOrderTransactionsHistories.singular').' '.__('messages.not_found'));

            return redirect(route('workOrderTransactionsHistories.index'));
        }

        $workOrderTransactionsHistory->fill($request->all());
        $workOrderTransactionsHistory->save();

        Flash::success(__('messages.updated', ['model' => __('models/workOrderTransactionsHistories.singular')]));

        return redirect(route('workOrderTransactionsHistories.index'));
    }

    /**
     * Remove the specified WorkOrderTransactionsHistory from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var WorkOrderTransactionsHistory $workOrderTransactionsHistory */
        $workOrderTransactionsHistory = WorkOrderTransactionsHistory::find($id);

        if (empty($workOrderTransactionsHistory)) {
            Flash::error(__('models/workOrderTransactionsHistories.singular').' '.__('messages.not_found'));

            return redirect(route('workOrderTransactionsHistories.index'));
        }

        $workOrderTransactionsHistory->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/workOrderTransactionsHistories.singular')]));

        return redirect(route('workOrderTransactionsHistories.index'));
    }
}
