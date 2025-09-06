<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Models\City;
use App\Http\Requests;
use App\Models\District;
use App\DataTables\DistrictDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;

class DistrictController extends AppBaseController
{
    /**
     * Display a listing of the District.
     *
     * @param DistrictDataTable $districtDataTable
     * @return Response
     */
    public function index(DistrictDataTable $districtDataTable)
    {
        return $districtDataTable->render('districts.index');
    }

    /**
     * Show the form for creating a new District.
     *
     * @return Response
     */
    public function create()
    {
        $cities = City::pluck('name', 'id');

        return view('districts.create', compact('cities'));
    }

    /**
     * Store a newly created District in storage.
     *
     * @param CreateDistrictRequest $request
     *
     * @return Response
     */
    public function store(CreateDistrictRequest $request)
    {
        $input = $request->all();

        /** @var District $district */
        $district = District::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/districts.singular')]));

        return redirect(route('districts.index'));
    }

    /**
     * Display the specified District.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var District $district */
        $district = District::find($id);

        if (empty($district)) {
            Flash::error(__('models/districts.singular').' '.__('messages.not_found'));

            return redirect(route('districts.index'));
        }

        return view('districts.show')->with('district', $district);
    }

    /**
     * Show the form for editing the specified District.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cities = City::pluck('name', 'id');

        /** @var District $district */
        $district = District::find($id);

        if (empty($district)) {
            Flash::error(__('messages.not_found', ['model' => __('models/districts.singular')]));

            return redirect(route('districts.index'));
        }

        return view('districts.edit', compact('district', 'cities'));
    }

    /**
     * Update the specified District in storage.
     *
     * @param  int              $id
     * @param UpdateDistrictRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDistrictRequest $request)
    {
        /** @var District $district */
        $district = District::find($id);

        if (empty($district)) {
            Flash::error(__('messages.not_found', ['model' => __('models/districts.singular')]));

            return redirect(route('districts.index'));
        }

        $district->fill($request->all());
        $district->save();

        Flash::success(__('messages.updated', ['model' => __('models/districts.singular')]));

        return redirect(route('districts.index'));
    }

    /**
     * Remove the specified District from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var District $district */
        $district = District::find($id);

        if (empty($district)) {
            Flash::error(__('messages.not_found', ['model' => __('models/districts.singular')]));

            return redirect(route('districts.index'));
        }

        $district->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/districts.singular')]));

        return redirect(route('districts.index'));
    }
}
