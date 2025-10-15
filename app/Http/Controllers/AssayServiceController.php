<?php

namespace App\Http\Controllers;

use App\Models\AssayForm;
use App\Models\AssayService;
use App\Models\WorkOrderService;
use Exception;
use Illuminate\Http\Request;
use App\Services\AssayServiceService;
use laracasts\flash\Flash;


class AssayServiceController extends AppBaseController
{
    protected $assayServiceService;

    public function __construct(AssayServiceService $assayServiceService)
    {
        $this->assayServiceService = $assayServiceService;
    }

    public function store(Request $request)
    {
        request()->validate(AssayService::$rules);

        try {
            $result = $this->assayServiceService->findOrCreateAndUpdate($request->all());

            $result->price = number_format($result->price, 2);
            return response()->json([$result]);
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function show($id)
    {
        try {
            $assayService = $this->assayServiceService->getAssayService((int)$id);
            return $assayService; 
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            return redirect(route('assayForms.index'));
        }
    }

    public function edit($id)
    {
        try {
            $assayService = $this->assayServiceService->getAssayService((int)$id);
            return $assayService;
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            return redirect(route('assayForms.index'));
        }
    }

    public function update(Request $request, $id)
    {
        
        try {
            $assayService = $this->assayServiceService->updateAssayService((int)$id, $request->all());
            return $assayService;
        } catch (Exception $e) {
            Flash::error('Assay item is not found');
            return redirect(route('assayForms.index'));
        }
    }

    public function destroy($id)
    {
        try {
            $this->assayServiceService->deleteAssayService((int)$id);
            return response()->json(null, 204); 
        } catch (Exception $e) {
            Flash::error('Assay service is not found');
            return redirect(route('assayForms.index'));
        }
    }

    public function add_services($id, Request $request)
    {
        $servicesMap = $request->get('services');
        
        try {
            $this->assayServiceService->addServicesToForm((int)$id, $servicesMap);

            Flash::success('تم إضافة البنود بنجاح');
            return response()->json(['message' => 'تم إضافة البنود بنجاح']);
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

}
