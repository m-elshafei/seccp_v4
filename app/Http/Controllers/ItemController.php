<?php

namespace App\Http\Controllers;

use App\DataTables\ItemDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Models\ItemsCategory;
use App\Models\Unit;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ItemController extends AppBaseController
{
    /**
     * Display a listing of the Item.
     *
     * @param ItemDataTable $itemDataTable
     * @return Response
     */
    public function index(ItemDataTable $itemDataTable)
    {
        return $itemDataTable->render('items.index');
    }

    /**
     * Show the form for creating a new Item.
     *
     * @return Response
     */
    public function create()
    {
        $units = Unit::pluck('name', 'id');
        $categories = ItemsCategory::pluck('name', 'id');
        return view('items.create',[
            'units' => $units,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created Item in storage.
     *
     * @param CreateItemRequest $request
     *
     * @return Response
     */
    public function store(CreateItemRequest $request)
    {
        $input = $request->all();
        $_count = Item::where('code','like', $input['code'])->count();
        if ($_count != 0){
            //flash("هذا الكود تم ادخاله من قبل")->error();
            return redirect()->back()->withErrors("هذا الكود تم ادخاله من قبل")->withInput();
        }
        /** @var Item $item */
        $item = Item::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/items.singular')]));

        return redirect(route('items.index'));
    }

    /**
     * Display the specified Item.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Item $item */
        $item = Item::with(['category','unit'])->find($id);

        if (empty($item)) {
            Flash::error(__('models/items.singular').' '.__('messages.not_found'));

            return redirect(route('items.index'));
        }

        return view('items.show')->with('item', $item);
    }

    /**
     * Show the form for editing the specified Item.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            Flash::error(__('messages.not_found', ['model' => __('models/items.singular')]));

            return redirect(route('items.index'));
        }
        $units = Unit::pluck('name', 'id');
        $categories = ItemsCategory::pluck('name', 'id');

        return view('items.edit',[
            'item' => $item,
            'units' => $units,
            'categories' => $categories,
        ]);

    }

    /**
     * Update the specified Item in storage.
     *
     * @param  int              $id
     * @param UpdateItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemRequest $request)
    {
        /** @var Item $item */
        $item = Item::find($id);

        $_count = Item::where('id','<>',$id)->where('code','like', $request->get('code'))->count();
        if ($_count != 0){
            //flash("هذا الكود تم ادخاله من قبل")->error();
            return redirect()->back()->withErrors("هذا الكود تم ادخاله من قبل")->withInput();
        }
        if (empty($item)) {
            Flash::error(__('messages.not_found', ['model' => __('models/items.singular')]));

            return redirect(route('items.index'));
        }

        $item->fill($request->all());
        $item->save();

        Flash::success(__('messages.updated', ['model' => __('models/items.singular')]));

        return redirect(route('items.index'));
    }

    /**
     * Remove the specified Item from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            Flash::error(__('messages.not_found', ['model' => __('models/items.singular')]));

            return redirect(route('items.index'));
        }

        $item->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/items.singular')]));

        return redirect(route('items.index'));
    }
}
