<div class="tab-pane" id="work_permit" aria-labelledby="work_permit" role="tabpanel">
    <!-- Needs Drilling Operations Field -->
    @php
        $work_order_permit_status = config('const.work_order_permit_status');
    @endphp
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered fixed-table" id="cities-table">
                        <thead>
                            <tr>
                                <th style="width: 100px;">رقم التصريح</th>
                                <th style="width: 120px;">نوع التصريح</th>
                                <th style="width: 140px;">رقم إحالة السداد</th>
                                <th style="width: 100px;">مبلغ الاصدار</th>
                                <th style="width: 120px;">تاريخ الإصدار</th>
                                <th style="width: 100px;">مدة التصريح</th>
                                <th style="width: 80px;">الحالة</th>
                                <th style="width: 100px;">مده العمل</th>
                                <th style="width: 150px;">المدة المنقضيه من التصريح</th>
                                <th style="width: 150px;">التحويل الي اعاده الوضع</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($workOrder->workOrdersPermits as $permit)
                                <tr>
                                <td>{{$permit->permit_number}}</td>
                                <td>{{$permit->workOrdersPermitType->name}}</td>
                                <td>{{$permit->sadad_number}}</td>
                                <td>{{$permit->issued_amount}}</td>
                                <td>{{$permit->issue_date}}</td>
                                <td>{{$permit->period}}</td>
                                    <td>
                                    @if(isset($work_order_permit_status[$permit->status]))
                                    <span class="badge rounded-pill {{$work_order_permit_status[$permit->status]['class']}}">{{$work_order_permit_status[$permit->status]['title']}}</span>
                                        @else
                                        {{$permit->status}}
                                        @endif
                                    </td>
                                <td>{{$permit->total_permit_period}}</td>
                                    <td>
                                        @if ($permit->total_permit_period_percentage < 100)
                                        <div class="d-flex flex-column"><small class="mb-1">{{$permit->total_permit_period_percentage}} %</small>
                                                <div class="progress w-100 me-3" style="height: 6px;">
                                                <div class="progress-bar badge-light-primary" style="width: {{$permit->total_permit_period_percentage}}%" aria-valuenow="'+data+'%" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge badge-light-danger">منتهي</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($permit->status != 10)
                                            <button type="button" class="btn btn-outline-primary me-75 round"
                                                title="الارسال الى اعادة الوضع" onclick="sendId({{ $permit->id }})">
                                                الارسال الى اعادة الوضع
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" style="text-align:center; color: red; ">لا توجد تصاريح</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
</div>
<script>
    function sendId(id) {
        console.log("ID sent:", id);
        fetch(`/restablishWorkOrders/workOrderFollows/updateStatus/${id}/updatePermit`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    id: id
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.error || 'Failed to update the permit.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the permit.');
            });
    }
</script>
