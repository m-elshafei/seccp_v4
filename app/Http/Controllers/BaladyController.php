<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Models\City;
use App\Http\Requests;
use App\Models\Balady;
use App\DataTables\BaladyDataTable;
use App\Http\Requests\CreateBaladyRequest;
use App\Http\Requests\UpdateBaladyRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\BaladyRepository;
class BaladyController extends AppBaseController
{
    /**
     * Display a listing of the Balady.
     *
     * @param BaladyDataTable $baladyDataTable
     * @return Response
     */

    public $baladyRepository;

    public function __construct(BaladyRepository $baladyRepo)
    {
        $this->baladyRepository = $baladyRepo;
    }

    public function index(BaladyDataTable $baladyDataTable)
    {
        return $baladyDataTable->render('baladies.index');
    }

    /**
     * Show the form for creating a new Balady.
     *
     * @return Response
     */
    public function create()
    {
        $cities = $this->baladyRepository->getCities();

        return view('baladies.create',compact('cities'));
    }

    /**
     * Store a newly created Balady in storage.
     *
     * @param CreateBaladyRequest $request
     *
     * @return Response
     */
    public function store(CreateBaladyRequest $request)
    {
        $input = $request->all();

        /** @var Balady $balady */
        $balady = $this->baladyRepository->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/baladies.singular')]));

        return redirect(route('baladies.index'));
    }

    /**
     * Display the specified Balady.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Balady $balady */
        $balady = $this->baladyRepository->find($id);

        if (empty($balady)) {
            Flash::error(__('models/baladies.singular').' '.__('messages.not_found'));

            return redirect(route('baladies.index'));
        }

        return view('baladies.show')->with('balady', $balady);
    }

    /**
     * Show the form for editing the specified Balady.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Balady $balady */
        $balady = $this->baladyRepository->find($id);

        if (empty($balady)) {
            Flash::error(__('messages.not_found', ['model' => __('models/baladies.singular')]));

            return redirect(route('baladies.index'));
        }

        $cities = $this->baladyRepository->getCities();

        return view('baladies.edit')
                    ->with('balady', $balady)
                    ->with('cities', $cities)
                    ;
    }

    /**
     * Update the specified Balady in storage.
     *
     * @param  int              $id
     * @param UpdateBaladyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBaladyRequest $request)
    {
        /** @var Balady $balady */
        $balady = $this->baladyRepository->find($id);

        if (empty($balady)) {
            Flash::error(__('messages.not_found', ['model' => __('models/baladies.singular')]));

            return redirect(route('baladies.index'));
        }

        $balady = $this->baladyRepository->update($balady, $request->all());

        Flash::success(__('messages.updated', ['model' => __('models/baladies.singular')]));

        return redirect(route('baladies.index'));
    }

    /**
     * Remove the specified Balady from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Balady $balady */
        $balady = $this->baladyRepository->find($id);

        if (empty($balady)) {
            Flash::error(__('messages.not_found', ['model' => __('models/baladies.singular')]));

            return redirect(route('baladies.index'));
        }

        $this->baladyRepository->delete($balady);

        Flash::success(__('messages.deleted', ['model' => __('models/baladies.singular')]));

        return redirect(route('baladies.index'));
    }
}
