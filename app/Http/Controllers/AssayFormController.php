<?php

namespace App\Http\Controllers;

use PDF;
use Flash;
use Response;
use Carbon\Carbon;
use App\Models\Item;
use App\Helpers\Helper;
use App\Models\AssayForm;
use App\Models\AssayItem;
use App\Models\WorkOrder;
use App\Imports\AssayImport;
use App\Models\AssayService;
use Illuminate\Http\Request;
use App\Models\WorkOrderService;
use App\Models\WorkOrdersProject;
use Maatwebsite\Excel\Facades\Excel;
use App\DataTables\AssayFormDataTable;
use App\Http\Requests\CreateAssayFormRequest;
use App\Http\Requests\UpdateAssayFormRequest;

class AssayFormController extends AppBaseController
{
    const NEW_ASSAY = 1;
    const APPROVED_ASSAY = 2;
    const MOVED_ASSAY = 3;

    /**
     * Display a listing of the AssayForm.
     *
     * @param AssayFormDataTable $assayFormDataTable
     * @return Response
     */
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

//        $workOrders = WorkOrder::whereIn('status',[2,3,4,5])->get();
//        $workOrders = $workOrders->pluck('work_display_number', 'id');
//        $workOrders->prepend("اختر","");
        $workOrders = WorkOrder::whereIn('status',[2,3,4,5])->whereNull('mission_number')->get()->pluck('work_dispaly_number_permit', 'id');// status -> //لم يبدأ التنفيذ , جارى التنفيذ , تم التنفيذ
        $workOrders->prepend("اختر","");
        //whereIn('status',[2,3,4])->
        $missions = WorkOrder::whereNotNull('mission_number')->get()->pluck('work_dispaly_number_permit', 'id');// status -> //لم يبدأ التنفيذ , جارى التنفيذ , تم التنفيذ
        $missions->prepend("اختر","");

        return view('assay_forms.create',[
            'workOrders' => $workOrders,
            'missions' => $missions,
        ]);
    }

    /**
     * Store a newly created AssayForm in storage.
     *
     * @param CreateAssayFormRequest $request
     *
     * @return Response
     */
    public function store(CreateAssayFormRequest $request)
    {
        $input = $request->all();

        $input['work_order_id'] = ($input['is_mission'] == 0)? $input['work_order_id'] : $input['mission_id'];

        $workOrders = WorkOrder::find($input['work_order_id']);
        $input['work_type_id'] = $workOrders->work_type_id ?? 0;
        $input['status'] = self::NEW_ASSAY;
        $assayForm_count = AssayForm::where('work_order_id', $input['work_order_id'])->count();
        if ($assayForm_count != 0){
            flash("امر العمل الذي تم اختياره له مقايسة")->error();
            return redirect()->route('assayForms.index');
        }
        $assayForm = AssayForm::create($input);
        $workOrders->assay_forms_status = 1;
        $workOrders->save();

        Flash::success(__('messages.saved', ['model' => __('models/assayForms.singular')]));

        return Helper::redirectAfterSaving($assayForm->id,$request,"assayForms");
    }

    /**
     * Display the specified AssayForm.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AssayForm $assayForm */
        $assayForm = AssayForm::find($id);

        if (empty($assayForm)) {
            Flash::error(__('models/assayForms.singular').' '.__('messages.not_found'));

            return redirect(route('assayForms.index'));
        }

        return view('assay_forms.show')->with('assayForm', $assayForm);
    }

    public function print_assay($id)
    {
        // $this->importAssay();//example for import
        
        /** @var AssayForm $assayForm */
        $assayForm = AssayForm::with('assayItem.item.unit','assayService.service','workType','workOrder.consultant')->find($id);
        // $assayForm = AssayForm::find($id);

        if (empty($assayForm)) {
            Flash::error(__('models/assayForms.singular').' '.__('messages.not_found'));

            return redirect(route('assayForms.index'));
        }
        $report = [
            'font_name'=>'calibri',
            'font_size'=>'18',
            'title_background_color'=>'4CAF50'
            ];

        $data = [
            'data'=>$assayForm,
            'dateTime'=>Carbon::now()->format('h:i Y-m-d'),
            // 'total'=>$assayForm->assayService->sum('price'),
            // 'assayItems'=>$assayForm->assayItem,
            // 'assayServices'=>$assayForm->assayService,
            'report'=>$report

        ];
        // dd($data );
        // return view('assay_forms.print_assay')->with('assayForm', $assayForm);
        $pdf = PDF::loadView('assay_forms.print_assay-2', $data);
        return $pdf->stream($id.'.pdf');  
    }

    public function importAssay()
    {
        $import = new AssayImport();
        // $import->onlySheets('Sheet2');
        
        Excel::import($import, 'test_assay2.xlsx');
        
                // Excel::import(new AssayImport, 'test_assay.xlsx');
        dd("i am here");
    }

    /**
     * Show the form for editing the specified AssayForm.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var AssayForm $assayForm */
        $assayForm = AssayForm::find($id);
        if (empty($assayForm)) {
            Flash::error(__('messages.not_found', ['model' => __('models/assayForms.singular')]));

            return redirect(route('assayForms.index'));
        }

        if($assayForm->status == self::APPROVED_ASSAY){
            Flash::error("المقايسة تم اعتمادها من قبل");

            return redirect(route('assayForms.index'));
        }

        if($assayForm->status == self::MOVED_ASSAY){
            Flash::error("المقايسة تم نقلها الي مشروع");

            return redirect(route('assayForms.index'));
        }

        $items = [''=>'إختار من القائمة'];
        Item::with("category")->get()->map(function ($item) use (&$items){
            $items[$item->category->name][$item->id] = $item->name. ' - [' . $item->code.']';
        });

        $services = [''=>'إختار من القائمة'];
        WorkOrderService::with('servicesCategory')->get()->map(function ($item) use (&$services){
            $services[$item->servicesCategory->name][$item->id] = $item->name. ' - [' . $item->code.']';
        });

        $assaysServices = AssayService::where('assay_form_id',$assayForm->id)->with('service')->get();
        $assaysItems = AssayItem::where('assay_form_id',$assayForm->id)->with('item')->get();

        //$workOrders = WorkOrder::get();
        //$workOrders = $workOrders->pluck('work_display_number', 'id');

        return view('assay_forms.edit',[
            'assaysServices' => $assaysServices,
            'assaysItems'    => $assaysItems,
            //'workOrders'     => $workOrders,
            'assayForm'      => $assayForm,
            'items'          => $items,
            'services'       => $services,
        ]);
    }

    /**
     * Update the specified AssayForm in storage.
     *
     * @param  int              $id
     * @param UpdateAssayFormRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAssayFormRequest $request)
    {
        /** @var AssayForm $assayForm */
        $assayForm = AssayForm::find($id);

        if (empty($assayForm)) {
            Flash::error(__('messages.not_found', ['model' => __('models/assayForms.singular')]));

            return redirect(route('assayForms.index'));
        }

        $assayForm->fill($request->all());
        $assayForm->save();

        Flash::success(__('messages.updated', ['model' => __('models/assayForms.singular')]));

        return Helper::redirectAfterSaving($id,$request,"assayForms");
    }

    /**
     * Remove the specified AssayForm from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AssayForm $assayForm */
        $assayForm = AssayForm::find($id);

        if (empty($assayForm)) {
            Flash::error(__('messages.not_found', ['model' => __('models/assayForms.singular')]));

            return redirect(route('assayForms.index'));
        }
        $workOrders = WorkOrder::find($assayForm->work_order_id);
        $workOrders->assay_forms_status = 0;
        $workOrders->save();
        $assayForm->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/assayForms.singular')]));

        return redirect(route('assayForms.index'));
    }

    public function approval($id){
        $assayForm = AssayForm::find($id);

        if (empty($assayForm)) {
            Flash::error(__('messages.not_found', ['model' => __('models/assayForms.singular')]));

            return redirect(route('assayForms.index'));
        }
        if ($assayForm->status != 1){
            Flash::error(__('The assay status should be new'));
            return redirect()->back();
        }
        //TODO: THis condition must be reviewed

        if ($assayForm->workOrder->status != 4 && $assayForm->workOrder->status !=5 ){
            Flash::error(__('The workOrder should be finished before approved the assay'));
            return redirect()->back();
        }
        if ($assayForm->workOrder->project_id != null){
            $workOrdersProject = WorkOrdersProject::find($assayForm->workOrder->project_id);
            if($workOrdersProject->status <> 2){
                Flash::error(__('You are not able to approve this assay because it is related to project'));
                return redirect()->back();
            }
        }
        $assayForm->status = self::APPROVED_ASSAY;
        $assayForm->save();
        $workOrders = WorkOrder::find($assayForm->work_order_id);
        $workOrders->assay_forms_status = 2;
        $workOrders->save();
        Flash::success(__('messages.updated', ['model' => __('models/assayForms.singular')]));

        return redirect(route('assayForms.index'));
    }
}
