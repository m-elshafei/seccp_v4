@extends('layouts.reportPdfLayout')
@section('filter-description')
<x-report.filter-description :reportRouteName="$comp_name"></x-report.filter-description>
@endsection
@section('content')
    <table width="100%" border="1" cellspacing="0" cellpadding="0" dir="rtl" style="border-collapse:collapse;">
        <tr>
            <td width="12%" class="title">رقم المهمة</td>
            <td width="10%" class="title">نوع المهمة</td>
            {{-- <td width="10%" class="title">رقم الاشتراك</td> --}}
            <td width="10%" class="title">شرح العطل</td>
            <td width="7%" class="title">التاريخ</td>
            <td width="10%" class="title">الفنى</td>
            <td width="7%" class="title">أمر العمل</td>
            <td width="7%" class="title">مستخلص</td>
            <td width="7%" class="title">رقم الحجز</td>
            <td width="7%" class="title">امر الشراء</td>
            <td width="7%" class="title">محطه 1</td>
            <td width="7%" class="title">محطه 2</td>
            <td width="7%" class="title">طول كيبل ضغط عالى</td>
            <td width="7%" class="title">منخفض 70</td>
            <td width="7%" class="title">منخفض 185</td>
            <td width="7%" class="title">منخفض 300</td>


        </tr>
            @foreach ($data as $emergencyMissions)
            <tr>
                <td class="TextCenter">{{$emergencyMissions->mission_number}}</td>
                <td class="TextCenter">{{$emergencyMissions->missionType->name}}</td>
                {{-- <td class="TextCenter">{{$emergencyMissions->customer_number}}</td> --}}
                <td class="TextCenter">{{$emergencyMissions->description}}</td>
                <td class="TextCenter">{{$emergencyMissions->received_date}}</td>
                <td class="TextCenter">{{$emergencyMissions->mission_received_employee_name}}</td>
                <td class="TextCenter">{{$emergencyMissions->parent->work_order_number ?? ''}}</td>
                <td class="TextCenter">{{($emergencyMissions->payment_clearance_id)? "نعم" :"لا"}}</td>
                <td class="TextCenter">{{$emergencyMissions->material_reservation_number}}</td>
                <td class="TextCenter">{{$emergencyMissions->purchase_number}}</td>
                <td class="TextCenter">{{$emergencyMissions->electrical_station_number}}</td>
                <td class="TextCenter">{{$emergencyMissions->electrical_station_number_2}}</td>
                <td class="TextCenter">{{$emergencyMissions->landscape->cabel_length_hv}}</td>
                <td class="TextCenter">{{$emergencyMissions->landscape->cabel_length_lv70}}</td>
                <td class="TextCenter">{{$emergencyMissions->landscape->cabel_length_lv185}}</td>
                <td class="TextCenter">{{$emergencyMissions->landscape->cabel_length_lv300}}</td>

            </tr>
        @endforeach
    </table>
    @include('reports.footerReport')

@endsection
