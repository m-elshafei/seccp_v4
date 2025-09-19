<?php

namespace App\Http\Controllers;

use App\DataTables\ServicesCategoryDataTable;
use App\Http\Requests\CreateServicesCategoryRequest;
use App\Http\Requests\UpdateServicesCategoryRequest;
use App\Models\ServicesCategory;
use Flash;
use Response;

class ServicesCategoryController extends AppBaseController
{
    /**
     * Display a listing of the ServicesCategory.
     *
     * @return Response
     */
    public function index(ServicesCategoryDataTable $servicesCategoryDataTable)
    {
        return $servicesCategoryDataTable->render('services_categories.index');
    }

    /**
     * Show the form for creating a new ServicesCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('services_categories.create');
    }

    /**
     * Store a newly created ServicesCategory in storage.
     *
     *
     * @return Response
     */
    public function store(CreateServicesCategoryRequest $request)
    {
        $input = $request->all();

        /** @var ServicesCategory $servicesCategory */
        $servicesCategory = ServicesCategory::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/servicesCategories.singular')]));

        return redirect(route('servicesCategories.index'));
    }

    /**
     * Display the specified ServicesCategory.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        /** @var ServicesCategory $servicesCategory */
        $servicesCategory = ServicesCategory::find($id);

        if (empty($servicesCategory)) {
            Flash::error(__('models/servicesCategories.singular').' '.__('messages.not_found'));

            return redirect(route('servicesCategories.index'));
        }

        return view('services_categories.show')->with('servicesCategory', $servicesCategory);
    }

    /**
     * Show the form for editing the specified ServicesCategory.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        /** @var ServicesCategory $servicesCategory */
        $servicesCategory = ServicesCategory::find($id);

        if (empty($servicesCategory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/servicesCategories.singular')]));

            return redirect(route('servicesCategories.index'));
        }

        return view('services_categories.edit')->with('servicesCategory', $servicesCategory);
    }

    /**
     * Update the specified ServicesCategory in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateServicesCategoryRequest $request)
    {
        /** @var ServicesCategory $servicesCategory */
        $servicesCategory = ServicesCategory::find($id);

        if (empty($servicesCategory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/servicesCategories.singular')]));

            return redirect(route('servicesCategories.index'));
        }

        $servicesCategory->fill($request->all());
        $servicesCategory->save();

        Flash::success(__('messages.updated', ['model' => __('models/servicesCategories.singular')]));

        return redirect(route('servicesCategories.index'));
    }

    /**
     * Remove the specified ServicesCategory from storage.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var ServicesCategory $servicesCategory */
        $servicesCategory = ServicesCategory::find($id);

        if (empty($servicesCategory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/servicesCategories.singular')]));

            return redirect(route('servicesCategories.index'));
        }

        $servicesCategory->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/servicesCategories.singular')]));

        return redirect(route('servicesCategories.index'));
    }
}
