<!-- start add modal  -->
<x-modal mode="add" modal="layer">
    <h2>اضافة الطبقة</h2>
    <br/>

    <form method="POST" class="row gy-1 gx-2" id="insert_form_test">
        @csrf
        <div class="col-12 col-md-6">
            {{ Form::hidden('_method', 'post') }}
            {{ Form::hidden('work_orders_permit_id', $workOrderFollow->id) }}
            {{ Form::hidden('work_order_id', $workOrderFollow->workOrders()->first()->id) }}

            <x-select2 name="layer_id" :options="$layersList" :labelTitle="__('models/returnSituations.fields.layer_id')"></x-select2>

        </div>

        <div class="col-12 col-md-6">
            <x-date-pickr name="start_date" :labelTitle="__('models/returnSituations.fields.start_date')"></x-date-pickr>
        </div>

        <div class="form-group col-sm-6">
            <x-select2 name="layer_worker_type" class="select2 form-select form-control layer_worker_type" :options="$layerWorkerTypeList"  :labelTitle="__('models/returnSituations.fields.layer_worker_type')"></x-select2>
        </div>

        <div class="form-group col-sm-6" id="div_emps">
            <x-select2 name="layer_employee_id" :options="$employeesList"  :labelTitle="__('models/returnSituations.fields.layer_employee_id')"></x-select2>
        </div>

        <div class="form-group col-sm-6" id="div_conts">
            <x-select2 name="layer_contractor_id" :options="$contractorsList"  :labelTitle="__('models/returnSituations.fields.layer_contractor_id')"></x-select2>
        </div>

        {{-- <div class="form-group col-sm-6">
            <x-select2 name="layer_status" :options="$layerStatusList"  :labelTitle="__('models/returnSituations.fields.layer_status')"></x-select2>
        </div> --}}

        <div class="form-group col-sm-6">
            <x-select2 name="lab_result_status" class="select2 form-select form-control lab_result_status" :options="$labResultStatusList"  :labelTitle="__('models/returnSituations.fields.lab_result_status')"></x-select2>
        </div>

        <div class="form-group col-sm-6" id="note_div">
            <label for="layer_id">سبب الرسوب:</label>
            {!! Form::text('note', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-6">
            <label for="layer_id">{{__('models/returnSituations.fields.description').':'}}</label>
            {!! Form::text('description', null, ['class' => 'form-control']) !!}
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success" name="insert" id="insert"><span class="ion ion-ios-send"></span>&nbsp;&nbsp;{{ __('crud.save') }} </button>
        </div>
    </form>
</x-modal>



<!-- start show modal  -->
<x-modal mode="show" modal="layer">
    <h2>عرض الطبقة</h2>
    <br/>

    <div class="col-12 col-md-6">
        {!! Form::label('id', 'المعرف'.':') !!}
        <span id="id"></span>
    </div>

    <div class="col-12 col-md-6">
        {!! Form::label('layer_id', __('models/returnSituations.fields.layer_id').':') !!}
        <span id="layer_id"></span>
    </div>

    <div class="col-12 col-md-6">
        {!! Form::label('from_date', __('models/returnSituations.fields.start_date').':') !!}
        <span id="start_date"></span>
    </div>

    <div class="col-12 col-md-6">
        {!! Form::label('layer_worker_type', __('models/returnSituations.fields.layer_worker_type').':') !!}
        <span id="layer_worker_type"></span>
    </div>

    <div class="col-12 col-md-6">
        {!! Form::label('worker', "الموظف / المقاول".':') !!}
        <span id="worker"></span>
    </div>

    <div class="col-12 col-md-6">
        {!! Form::label('note', __('models/returnSituations.fields.note').':') !!}
        <span id="note"></span>
    </div>

    <div class="col-12 col-md-6">
        {!! Form::label('description', __('models/returnSituations.fields.description').':') !!}
        <span id="description"></span>
    </div>

</x-modal>
  <!-- end show modal  -->


  <!-- start edit modal -->
<x-modal mode="edit" modal="layer">
    <h2>تعديل الطبقة</h2>
    <br/>
    <form method="post" class="row gy-1 gx-2" id="edit_form_test">
      @csrf
        <div class="col-12 col-md-6">
            {{ Form::hidden('_method', 'PATCH') }}

            {{ Form::hidden('id', '' , array('id' => 'detail_id')) }}

            <x-select2 name="layer_id" :options="$layersList" :labelTitle="__('models/returnSituations.fields.layer_id')"></x-select2>
        </div>

        <div class="col-12 col-md-6">
            <x-date-pickr name="start_date" :labelTitle="__('models/returnSituations.fields.start_date')"></x-date-pickr>
        </div>

        <div class="form-group col-sm-6">
            <x-select2 name="layer_worker_type" class="select2 form-select form-control layer_worker_type" :options="$layerWorkerTypeList"  :labelTitle="__('models/returnSituations.fields.layer_worker_type')"></x-select2>
        </div>

        <div class="form-group col-sm-6" id="e_div_emps">
            <x-select2 name="layer_employee_id" :options="$employeesList"  :labelTitle="__('models/returnSituations.fields.layer_employee_id')"></x-select2>
        </div>

        <div class="form-group col-sm-6" id="e_div_conts">
            <x-select2 name="layer_contractor_id" :options="$contractorsList"  :labelTitle="__('models/returnSituations.fields.layer_contractor_id')"></x-select2>
        </div>

        <div class="form-group col-sm-6">
            <x-select2 name="lab_result_status" class="select2 form-select form-control lab_result_status" :options="$labResultStatusList"  :labelTitle="__('models/returnSituations.fields.lab_result_status')"></x-select2>
        </div>

        <div class="form-group col-sm-6" id="e_note_div">
            <label for="layer_id">سبب الرسوب:</label>
            {!! Form::text('note', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-6">
            <label for="layer_id">{{ __('models/returnSituations.fields.description').':'}}</label>
            {!! Form::text('description', null, ['class' => 'form-control']) !!}
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success" name="update" id="update"><span class="ion ion-ios-send"></span>&nbsp;&nbsp;update</button>
        </div>

    </form>
</x-modal>
  <!-- end edit modal  -->
