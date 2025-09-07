<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\City;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Repositories\CityRepository;

class CityController extends AppBaseController
{
    /**
     * Display a listing of the City.
     *
     * @param Request $request
     *
     * @return Response
     */
    public $cityRepository;

    public function __construct(CityRepository $cityRepo)
    {
        $this->cityRepository = $cityRepo;
    }

    public function index(Request $request)
    {
        /** @var City $cities */
        $cities = $this->cityRepository->getCities()->paginate(15);

        return view('cities.index')
            ->with('cities', $cities);
    }

    /**
     * Show the form for creating a new City.
     *
     * @return Response
     */
    public function create()
    {
        return view('cities.create');
    }

    /**
     * Store a newly created City in storage.
     *
     * @param CreateCityRequest $request
     *
     * @return Response
     */
    public function store(CreateCityRequest $request)
    {
        $input = $request->all();

        /** @var City $city */
        $city = $this->cityRepository->create($input);
        Flash::success(__('messages.saved', ['model' => __('models/cities.singular')]));

        return redirect(route('cities.index'));
    }

    /**
     * Display the specified City.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var City $city */
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            Flash::error(__('models/cities.singular').' '.__('messages.not_found'));

            return redirect(route('cities.index'));
        }

        return view('cities.show')->with('city', $city);
    }

    /**
     * Show the form for editing the specified City.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var City $city */
        $city = $this->cityRepository->find($id);
        if (empty($city)) {
            Flash::error(__('messages.not_found', ['model' => __('models/cities.singular')]));

            return redirect(route('cities.index'));
        }

        return view('cities.edit')->with('city', $city);
    }

    /**
     * Update the specified City in storage.
     *
     * @param int $id
     * @param UpdateCityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCityRequest $request)
    {
        /** @var City $city */
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            Flash::error(__('messages.not_found', ['model' => __('models/cities.singular')]));

            return redirect(route('cities.index'));
        }

        $city = $this->cityRepository->update($city, $request->all());

        Flash::success(__('messages.updated', ['model' => __('models/cities.singular')]));

        return redirect(route('cities.index'));
    }

    /**
     * Remove the specified City from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var City $city */
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            Flash::error(__('messages.not_found', ['model' => __('models/cities.singular')]));

            return redirect(route('cities.index'));
        }

        $this->cityRepository->delete($city);
        Flash::success(__('messages.deleted', ['model' => __('models/cities.singular')]));

        return redirect(route('cities.index'));
    }
}
