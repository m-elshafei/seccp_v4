@extends('layouts.reportPdfLayout')
@section('filter-description')
<x-report.filter-description :reportRouteName="$comp_name"></x-report.filter-description>
@endsection
@section('content')
    <table width="100%" border="1" cellspacing="0" cellpadding="0" dir="rtl" style="border-collapse:collapse;">
        <tr>
            <td width="8%" class="title">رقم أمر العمل</td>
            <td width="5%" class="title">نوع العمل</td>
            <td width="10%" class="title">رقم التصريح</td>
            <td width="6%" class="title">نوع الحفر</td>
            <td width="7%" class="title">الحى</td>
            <td width="5%" class="title">الطول</td>
            <td width="5%" class="title">عمق الحفر</td>
            <td width="8%" class="title">تاريخ الاصدار</td>
            <td width="8%" class="title">تاريخ الانتهاء</td>
            <td width="5%" class="title">مدة التمديد</td>
            <td width="5%" class="title">رسوم التمديد</td>
            <td width="5%" class="title">رسوم الاخلاء</td>
            <td width="5%" class="title">حالة التصريح</td>
            <td width="5%" class="title">المنفذ</td>
            <td width="8%" class="title">أخر طبقة منفذة</td>
            <td width="10%" class="title">الملاحظات</td>
            <td width="5%" class="title">الحالة</td>
        </tr>

            @foreach ($data as $workOrderFollow)
            <tr>
                <td class="TextCenter">{{($workOrderFollow->work_order_number)?  $workOrderFollow->work_order_number :$workOrderFollow->mission_number}}</td>
                <td class="TextCenter">{{($workOrderFollow->work_type_code)?$workOrderFollow->work_type_code:"طوارئ"}}</td>
                <td class="TextCenter">{{$workOrderFollow->permit_number}}</td>
                <td class="TextCenter">{{$workOrderFollow->drilling_type}}</td>
                <td class="TextCenter">{{$workOrderFollow->district_name}}</td>
                <td class="TextCenter">{{$workOrderFollow->length_total}}</td>
                <td class="TextCenter">{{$workOrderFollow->drilling_deep}}</td>
                <td class="TextCenter">{{$workOrderFollow->issue_date}}</td>
                <td class="TextCenter">{{$workOrderFollow->end_date}}</td>
                <td class="TextCenter">{{$workOrderFollow->period}}</td>
                <td class="TextCenter">{{$workOrderFollow->total_extend_amount}}</td>
                <td class="TextCenter">{{$workOrderFollow->clearance_sdad_amount}}</td>
                <td class="TextCenter">{{ ($workOrderFollow->status)? __("models/workOrdersPermits.status.".App\Enums\WorkOrderPermitStatusEnum::getOptions()[$workOrderFollow->status] ): ""}}</td>
                <td class="TextCenter">{{$workOrderFollow->workOrders[0]->landscape->drillingEmployee->name ?? ""}}</td>
                {{-- <td class="TextCenter">{{$workOrderFollow->workOrders[0]->departmentEmployee->name}}</td> --}}
                <td class="TextCenter">{{$workOrderFollow->layer_name}}</td>
                <td class="TextCenter">{{$workOrderFollow->notes}}</td>
                <td class="TextCenter">{{ ($workOrderFollow->workOrders[0]->status)? __("models/workOrders.status.".App\Enums\WorkOrderStatusEnum::getOptions()[$workOrderFollow->workOrders[0]->status] ): ""}}</td>
            </tr>
        @endforeach
    </table>
    @include('reports.footerReport')

@endsection
