<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Http\Requests;
use App\Models\AssayForm;
use App\Models\AssayItem;
use App\Models\WorkOrder;
use App\Models\AssayService;
use App\Models\WorkOrdersProject;
use App\Enums\WorkOrderStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AppBaseController;
use App\DataTables\WorkOrdersProjectDataTable;
use App\Http\Requests\CreateWorkOrdersProjectRequest;
use App\Http\Requests\UpdateWorkOrdersProjectRequest;

class WorkOrdersProjectController extends AppBaseController
{
    /**
     * Display a listing of the WorkOrdersProject.
     *
     * @param WorkOrdersProjectDataTable $workOrdersProjectDataTable
     * @return Response
     */
    public function index(WorkOrdersProjectDataTable $workOrdersProjectDataTable)
    {
        return $workOrdersProjectDataTable->render('work_orders_projects.index');
    }

    /**
     * Show the form for creating a new WorkOrdersProject.
     *
     * @return Response
     */
    public function create()
    {
        return view('work_orders_projects.create');
    }

    /**
     * Store a newly created WorkOrdersProject in storage.
     *
     * @param CreateWorkOrdersProjectRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkOrdersProjectRequest $request)
    {
        $input = $request->all();

        /** @var WorkOrdersProject $workOrdersProject */
        $workOrdersProject = WorkOrdersProject::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/workOrdersProjects.singular')]));

        return redirect(route('workOrdersProjects.index'));
    }

    /**
     * Display the specified WorkOrdersProject.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var WorkOrdersProject $workOrdersProject */
        $workOrdersProject = WorkOrdersProject::find($id);

        if (empty($workOrdersProject)) {
            Flash::error(__('models/workOrdersProjects.singular').' '.__('messages.not_found'));

            return redirect(route('workOrdersProjects.index'));
        }

        return view('work_orders_projects.show')->with('workOrdersProject', $workOrdersProject);
    }

    /**
     * Show the form for editing the specified WorkOrdersProject.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var WorkOrdersProject $workOrdersProject */
        $workOrdersProject = WorkOrdersProject::find($id);

        $workOrders = WorkOrder::where('project_id',$id)->whereNull('mission_number')->get()->pluck('work_dispaly_number_permit', 'id');// status -> //لم يبدأ التنفيذ , جارى التنفيذ , تم التنفيذ
        $workOrders->prepend("اختر","");

        if (empty($workOrdersProject)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersProjects.singular')]));

            return redirect(route('workOrdersProjects.index'));
        }

        return view('work_orders_projects.edit',compact('workOrdersProject','workOrders'));
    }

    /**
     * Update the specified WorkOrdersProject in storage.
     *
     * @param  int              $id
     * @param UpdateWorkOrdersProjectRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkOrdersProjectRequest $request)
    {
        /** @var WorkOrdersProject $workOrdersProject */
        $workOrdersProject = WorkOrdersProject::find($id);

        if (empty($workOrdersProject)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersProjects.singular')]));

            return redirect(route('workOrdersProjects.index'));
        }

        $workOrdersProject->fill($request->all());
        $workOrdersProject->save();

        Flash::success(__('messages.updated', ['model' => __('models/workOrdersProjects.singular')]));

        return redirect(route('workOrdersProjects.index'));
    }

    /**
     * Remove the specified WorkOrdersProject from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var WorkOrdersProject $workOrdersProject */
        $workOrdersProject = WorkOrdersProject::find($id);

        if (empty($workOrdersProject)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workOrdersProjects.singular')]));

            return redirect(route('workOrdersProjects.index'));
        }

        $workOrdersProject->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/workOrdersProjects.singular')]));

        return redirect(route('workOrdersProjects.index'));
    }

    public function closeProject($id){
        DB::transaction(function() use ($id) {

            $workOrdersProject = WorkOrdersProject::find($id);

            if (empty($workOrdersProject)) {
                Flash::error(__('messages.not_found', ['model' => __('models/workOrdersProjects.singular')]));

                return redirect(route('workOrdersProjects.index'));
            }

            $workOrders = WorkOrder::where('project_id',$id)->orderBy('created_at')->get();

            if ($workOrders->whereIn('status',[WorkOrderStatusEnum::WorkingDone->value,WorkOrderStatusEnum::DeliveryDone->value])->count() != $workOrders->count()){
                Flash::error(__('all workOrders should be finished before close the project'));
                return redirect()->back();
            }
            if($workOrdersProject->copy_from_work_order_id){
                $first = $workOrders->where('id',$workOrdersProject->copy_from_work_order_id)->first();
            }else{
                $first = $workOrders->first();
            }
            if($workOrdersProject->closed_work_order_number){
                $first->work_order_number=  $workOrdersProject->closed_work_order_number;
            }
            $first->project_stage_id = NULL;


            
            /***/
            $parent = WorkOrder::create($first->toArray());

            foreach ($workOrders as $workOrder){
                if(!$workOrder->assay_forms_status) {
                    Flash::error(__('all workOrders should be have assay before close the project'));
                    return redirect()->back();
                }
                $workOrder->parent_id = $parent->id;
                if($workOrder->assay_forms_status ){
                    $workOrder->assay_forms_status = 3;
                }
                
                // TODO: we can also here change work order number to (the forst work order number with stage id)
                if($workOrdersProject->closed_work_order_number){
                    $workOrder->work_order_number= $workOrdersProject->closed_work_order_number.'-'.$workOrder->project_stage_id;
                }
                $workOrder->save();
            }
            //dd($workOrders->pluck('id')->toArray());
            //TODO: This code need to be a  service
            $assays = AssayForm::whereIn('work_order_id',$workOrders->pluck('id')->toArray())->get();
            $services = [];
            $items = [];
            $notes = null;
            foreach ($assays as $assay){
                $assay->status = AssayFormController::MOVED_ASSAY;
                $assay->save();
                $notes += $assay->notes;
                foreach ($assay->assayItem as $item){
                    if(array_key_exists($item->item_id,$items)){
                        $old_item = $items[$item->item_id];
                        $items[$item->item_id] = [
                            'item_id'       => $item->item_id,
                            'spend'         => $old_item['spend'] + $item->spend,
                            'used'          => $old_item['used'] + $item->used,
                            'returned'      => $old_item['returned'] + $item->returned,
                            'returned_spend' => $old_item['returned_spend'] + $item->returned_spend
                        ];
                    }else{
                        $items[$item->item_id]= [
                            'item_id'       => $item->item_id,
                            'spend'         => $item->spend,
                            'used'          => $item->used,
                            'returned'      => $item->returned,
                            'returned_spend' => $item->returned_spend
                        ];
                    }
                }
                foreach ($assay->assayService as $service){
                    if(array_key_exists($service->service_id,$services)){
                        $old_service = $services[$service->service_id];
                        $services[$service->service_id] = [
                            'service_id'    => $service->service_id,
                            'quantity'      => $old_service['quantity'] + $service->quantity,
                            'price'         => $old_service['price'] + $service->price
                        ];
                    }else{
                        $services[$service->service_id]= [
                            'service_id'    => $service->service_id,
                            'quantity'      => $service->quantity,
                            'price'         => $service->price
                        ];
                    }
                }
            }

            if(count($assays)){
                $AssayForm = AssayForm::create([
                    'work_order_id' => $parent->id,
                    'work_type_id' => $parent->work_type_id,
                    'notes' => $notes,
                    'amount' => collect($services)->sum('price'),
                    'status' => AssayFormController::NEW_ASSAY
                ]);
                foreach ($items as $item){
                    AssayItem::create([
                        'assay_form_id' => $AssayForm->id,
                        'item_id'       => $item['item_id'],
                        'spend'         => $item['spend'],
                        'used'          => $item['used'],
                        'returned'      => $item['returned'],
                        'returned_spend' => $item['returned_spend']
                    ]);
                }
                foreach ($services as $service){
                    AssayService::create([
                        'assay_form_id' => $AssayForm->id,
                        'service_id'    => $service['service_id'],
                        'quantity'      => $service['quantity'],
                        'price'         => $service['price']
                    ]);
                }
                //dd($items,$services, $AssayForm);
            }
            $notes += " - تم انشاء هذه المقايسه اليا عند اغلاق المشروع :  " . $workOrdersProject->name  ;
            $workOrdersProject->status = 2;//to be check by tamer
            $workOrdersProject->save();
        });
        Flash::success("تم إغلاق المشروع");
        return redirect(route('workOrdersProjects.index'));
    }
}
