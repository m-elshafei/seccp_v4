<?php

namespace App\Http\Controllers;

use App\DataTables\ItemsCategoryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateItemsCategoryRequest;
use App\Http\Requests\UpdateItemsCategoryRequest;
use App\Models\ItemsCategory;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ItemsCategoryController extends AppBaseController
{
    /**
     * Display a listing of the ItemsCategory.
     *
     * @param ItemsCategoryDataTable $itemsCategoryDataTable
     * @return Response
     */
    public function index(ItemsCategoryDataTable $itemsCategoryDataTable)
    {
        return $itemsCategoryDataTable->render('items_categories.index');
    }

    /**
     * Show the form for creating a new ItemsCategory.
     *
     * @return Response
     */
    public function create()
    {
        $itemsCategories = ItemsCategory::pluck('name', 'id');
        return view('items_categories.create',[
            'itemsCategories' => $itemsCategories,
        ]);
    }

    /**
     * Store a newly created ItemsCategory in storage.
     *
     * @param CreateItemsCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateItemsCategoryRequest $request)
    {
        $input = $request->all();

        /** @var ItemsCategory $itemsCategory */
        $itemsCategory = ItemsCategory::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/itemsCategories.singular')]));

        return redirect(route('itemsCategories.index'));
    }

    /**
     * Display the specified ItemsCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ItemsCategory $itemsCategory */
        $itemsCategory = ItemsCategory::with("category")->find($id);

        if (empty($itemsCategory)) {
            Flash::error(__('models/itemsCategories.singular').' '.__('messages.not_found'));

            return redirect(route('itemsCategories.index'));
        }

        return view('items_categories.show')->with('itemsCategory', $itemsCategory);
    }

    /**
     * Show the form for editing the specified ItemsCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var ItemsCategory $itemsCategory */
        $itemsCategory = ItemsCategory::find($id);

        if (empty($itemsCategory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/itemsCategories.singular')]));

            return redirect(route('itemsCategories.index'));
        }
        $itemsCategories = ItemsCategory::where('id','<>',$id)->pluck('name', 'id');

        return view('items_categories.edit')->with([
            'itemsCategory'=> $itemsCategory,
            'itemsCategories'=> $itemsCategories,
        ]);
    }

    /**
     * Update the specified ItemsCategory in storage.
     *
     * @param  int              $id
     * @param UpdateItemsCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemsCategoryRequest $request)
    {
        /** @var ItemsCategory $itemsCategory */
        $itemsCategory = ItemsCategory::find($id);

        if (empty($itemsCategory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/itemsCategories.singular')]));

            return redirect(route('itemsCategories.index'));
        }

        $itemsCategory->fill($request->all());
        $itemsCategory->save();

        Flash::success(__('messages.updated', ['model' => __('models/itemsCategories.singular')]));

        return redirect(route('itemsCategories.index'));
    }

    /**
     * Remove the specified ItemsCategory from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ItemsCategory $itemsCategory */
        $itemsCategory = ItemsCategory::find($id);

        if (empty($itemsCategory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/itemsCategories.singular')]));

            return redirect(route('itemsCategories.index'));
        }

        $itemsCategory->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/itemsCategories.singular')]));

        return redirect(route('itemsCategories.index'));
    }
}
