<div>
    <div class="mb-1">
        <label class="form-label" for="amount">رقم المهمه</label>
        <input id="amount" name="mission_number" class="form-control" type="number" placeholder="رقم المهمه" />
    </div>
    <div class="mb-1">
        <label class="form-label" for="amount"> رقم أمر العمل</label>
        <input id="parent_work_order" name="parent_work_order" class="form-control" type="number" placeholder="رقم أمر العمل" />
    </div>
    <div class="mb-1">
        {!! Form::label('mission_typeـid', 'نوع المهمة '. ':') !!}
        {!! Form::select('mission_typeـid', $workOrdersType, null, ['class' => 'select2 form-select form-control']) !!}
    </div>
    <div class="mb-1">
        <label class="form-label" for="amount">رقم الاشتراك</label>
        <input id="amount" name="customer_number" class="form-control" type="number" placeholder="رقم الاشتراك" />
    </div>
    <div class="mb-1">
        {!! Form::label('mission_received_employee_name', 'الفني'.':') !!}
        {!! Form::select('mission_received_employee_name', $Employee,null, ['class' => 'select2 form-select form-control']) !!}
    </div>
    {{-- <div class="mb-1">
        {!! Form::label('mission_received_employee_id', __('models/workOrders.fields.consultant_name').':') !!}
        {!! Form::select('mission_received_employee_id', $Employee,null, ['class' => 'select2 form-select form-control']) !!}
    </div> --}}
    {{-- <div class="mb-1">
        <label class="form-label" for="amount"></label>
        <input id="payment_clearance_id" name="payment_clearance_id" class="form-control" type="number" placeholder="رقم أمر العمل" />
    </div> --}}
    <div class="mb-1">
        <x-date-pickr name="from_received_date" :labelTitle="'من تاريخ'"></x-date-pickr>
    </div>
    <div class="mb-1">
        <x-date-pickr name="to_received_date" :labelTitle="'الي تاريخ'"></x-date-pickr>
    </div>
    {{-- @php
    $PaymentClearance = [
        '' => 'اختر',
        ' صرف مواد' => 'تم صرف مواد',
        ' صرف مواد' => 'لم يتم صرف مواد',
    ];
@endphp
@dd($workOrdersType,$PaymentClearance)

<div class="mb-1">
    {!! Form::label('payment_clearance_id', 'صرف مواد' . ':') !!}
    {!! Form::select('payment_clearance_id', $PaymentClearance, null, ['class' => 'select2 form-select form-control']) !!}
</div> --}}



</div>

