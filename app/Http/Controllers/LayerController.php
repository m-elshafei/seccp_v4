<?php

namespace App\Http\Controllers;

use App\DataTables\LayerDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLayerRequest;
use App\Http\Requests\UpdateLayerRequest;
use App\Models\Layer;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class LayerController extends AppBaseController
{
    /**
     * Display a listing of the Layer.
     *
     * @param LayerDataTable $layerDataTable
     * @return Response
     */
    public function index(LayerDataTable $layerDataTable)
    {
        return $layerDataTable->render('layers.index');
    }

    /**
     * Show the form for creating a new Layer.
     *
     * @return Response
     */
    public function create()
    {
        return view('layers.create');
    }

    /**
     * Store a newly created Layer in storage.
     *
     * @param CreateLayerRequest $request
     *
     * @return Response
     */
    public function store(CreateLayerRequest $request)
    {
        $input = $request->all();

        /** @var Layer $layer */
        $layer = Layer::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/layers.singular')]));

        return redirect(route('layers.index'));
    }

    /**
     * Display the specified Layer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Layer $layer */
        $layer = Layer::find($id);

        if (empty($layer)) {
            Flash::error(__('models/layers.singular').' '.__('messages.not_found'));

            return redirect(route('layers.index'));
        }

        return view('layers.show')->with('layer', $layer);
    }

    /**
     * Show the form for editing the specified Layer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Layer $layer */
        $layer = Layer::find($id);

        if (empty($layer)) {
            Flash::error(__('messages.not_found', ['model' => __('models/layers.singular')]));

            return redirect(route('layers.index'));
        }

        return view('layers.edit')->with('layer', $layer);
    }

    /**
     * Update the specified Layer in storage.
     *
     * @param  int              $id
     * @param UpdateLayerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLayerRequest $request)
    {
        /** @var Layer $layer */
        $layer = Layer::find($id);

        if (empty($layer)) {
            Flash::error(__('messages.not_found', ['model' => __('models/layers.singular')]));

            return redirect(route('layers.index'));
        }

        $layer->fill($request->all());
        $layer->save();

        Flash::success(__('messages.updated', ['model' => __('models/layers.singular')]));

        return redirect(route('layers.index'));
    }

    /**
     * Remove the specified Layer from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Layer $layer */
        $layer = Layer::find($id);

        if (empty($layer)) {
            Flash::error(__('messages.not_found', ['model' => __('models/layers.singular')]));

            return redirect(route('layers.index'));
        }

        $layer->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/layers.singular')]));

        return redirect(route('layers.index'));
    }
}
