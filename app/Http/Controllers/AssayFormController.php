<?php

namespace App\Http\Controllers;

use App\DataTables\AssayFormDataTable;
use App\Enums\AssayFormEnum;
use App\Helpers\Helper;
use App\Http\Requests\CreateAssayFormRequest;
use App\Http\Requests\UpdateAssayFormRequest;
use App\Imports\AssayImport;
use App\Models\AssayForm;
use App\Models\AssayItem;
use App\Models\AssayService;
use App\Models\Item;
use App\Models\WorkOrder;
use App\Models\WorkOrderService;
use App\Models\WorkOrdersProject;
use App\Services\AssayFormService;
use Carbon\Carbon;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Response;
use laracasts\Flash\Flash;

class AssayFormController extends AppBaseController
{
    private $assayFormService;

    /**
     * Display a listing of the AssayForm.
     *
     * @return Response
     */
    public function __construct(AssayFormService $assayFormService)
    {
        $this->assayFormService = $assayFormService;
    }

    public function index(AssayFormDataTable $assayFormDataTable)
    {
        return $assayFormDataTable->render('assay_forms.index');
    }

    /**
     * Show the form for creating a new AssayForm.
     *
     * @return Response
     */
    public function create()
    {
        $data = $this->assayFormService->getCreateViewData();

        return view('assay_forms.create', $data);
    }

    /**
     * Store a newly created AssayForm in storage.
     *
     *
     * @return Response
     */
    public function store(CreateAssayFormRequest $request)
    {
        $input = $request->all();

        $assayForm = $this->assayFormService->create($input);

        if (! $assayForm) {
            Flash::error('امر العمل الذي تم اختياره له مقايسة');

            return redirect()->route('assayForms.index');
        }

        Flash::success(__('messages.saved', ['model' => __('models/assayForms.singular')]));

        return Helper::redirectAfterSaving($assayForm->id, $request, 'assayForms');
    }

    /**
     * Display the specified AssayForm.
     *
     * @param  int  $id
     * @return Response
     */
       public function show($id)
    {
        try {
            $assayForm = $this->assayFormService->getAssayFormById($id);
            return view('assay_forms.show')->with('assayForm', $assayForm);

        } catch (Exception $e) {
         
            Flash::error(__('models/assayForms.singular').' '.__('messages.not_found'));

            return redirect(route('assayForms.index'));
        }
    }

 public function print_assay($id)
    {
        try {

            $pdf = $this->assayFormService->generateAssayPrintPdf((int)$id);
            
            return $pdf->stream($id.'.pdf');

        } catch (Exception $e) {

            Flash::error(__('models/assayForms.singular').' '.__('messages.not_found'));

            return redirect(route('assayForms.index'));
        }
    }

   public function edit($id)
    {
        try {
            $data = $this->assayFormService->getEditViewData((int)$id);

            return view('assay_forms.edit', $data);

        } catch (Exception $e) {
            Flash::error(__('messages.not_found', ['model' => __('models/assayForms.singular')]));

            return redirect(route('assayForms.index'));

        } catch (Exception $e) {
            Flash::error($e->getMessage());

            return redirect(route('assayForms.index'));
        }
    }

    /**
     * Update the specified AssayForm in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateAssayFormRequest $request)
    {
        try {

            $assayForm = $this->assayFormService->updateAssayForm((int)$id, $request->validated());


            Flash::success(__('messages.updated', ['model' => __('models/assayForms.singular')]));


            return Helper::redirectAfterSaving($assayForm->id, $request, 'assayForms');
            
        } catch (Exception $e) {

            Flash::error(__('messages.not_found', ['model' => __('models/assayForms.singular')]));

            return redirect(route('assayForms.index'));
        }
    }

    /**
     * Remove the specified AssayForm from storage.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        try {
            $this->assayFormService->deleteAssayForm((int)$id);

            Flash::success(__('messages.deleted', ['model' => __('models/assayForms.singular')]));

            return redirect(route('assayForms.index'));

        } catch (Exception $e) {
            Flash::error(__('messages.not_found', ['model' => __('models/assayForms.singular')]));

            return redirect(route('assayForms.index'));
        }
    }

   public function approval($id)
    {
        try {
            $this->assayFormService->approveAssayForm((int)$id);

            Flash::success(__('messages.updated', ['model' => __('models/assayForms.singular')]));

            return redirect(route('assayForms.index'));

        } catch (Exception $e) {
            Flash::error(__('messages.not_found', ['model' => __('models/assayForms.singular')]));

            return redirect(route('assayForms.index'));

        } catch (Exception $e) {
            Flash::error($e->getMessage());

            return redirect()->back();
        }
    }
}
