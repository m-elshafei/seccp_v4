<?php

namespace App\Http\Controllers;

use App\Models\AssayItem;
use App\Services\AssayItemService;
use Exception;
use Illuminate\Http\Request;
use laracasts\Flash\Flash;

class AssayItemController extends AppBaseController
{
    protected $assayItemService;

    public function __construct(AssayItemService $assayItemService)
    {
        $this->assayItemService = $assayItemService;
    }

    public function store(Request $request)
    {

        request()->validate(AssayItem::$rules);

        $input = $request->all();


        $result = $this->assayItemService->storeOrUpdateAssayItem($input);


        return response()->json([$result]);
    }

    public function show($id)
    {
        try {
            $assayItem = $this->assayItemService->getAssayItemWithItem((int)$id);
            return $assayItem;
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            return redirect(route('assayForms.index'));
        }
    }

    public function edit($id)
    {
        try {

            $assayItem = $this->assayItemService->getAssayItem((int)$id);
            return $assayItem;
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            return redirect(route('assayForms.index'));
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $input = $request->all();
            $assayItem = $this->assayItemService->updateAssayItem((int)$id, $input);
            return $assayItem;
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            return redirect(route('assayForms.index'));
        }
    }

    public function destroy($id)
    {
        try {
            $this->assayItemService->deleteAssayItem((int)$id);
            
            return response()->json(['message' => 'Assay item deleted successfully'], 200);
            
        } catch (Exception $e) {
            Flash::error($e->getMessage()); 
            return redirect(route('assayForms.index'));
        }
    }
}
