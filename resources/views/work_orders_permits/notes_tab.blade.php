<div class="tab-pane " id="workOrderNotes" aria-labelledby="workOrderNotes-tab" role="tabpanel">
    <!-- Needs Drilling Operations Field -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered" id="cities-table">
                        <thead>
                            <tr>

                                <th>الملاحظة</th>
                                <th>بواسطة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($workOrdersPermit->notes && $workOrdersPermit->workOrdersPermitNote)

                                @if ($workOrdersPermit->notes)
                                    <tr>
                                        <td>{{ $workOrdersPermit->notes }}</td>
                                        <td>{{ $workOrdersPermit->user->name  }}</td>
                                        <td data-bs-toggle="tooltip" title="{{ $workOrdersPermit->created_at }}">
                                            {{ $workOrdersPermit->created_at->toDateString() }}</td>
                                    </tr>
                                @endif
                                @foreach ($workOrdersPermit->workOrdersPermitNote as $file)
                                    <tr>
                                        <td>{{ $file->note }}</td>
                                        <td>{{ $file->user->name ?? $file->user_id }}</td>
                                        <td data-bs-toggle="tooltip" title="{{ $file->created_at }}">
                                            {{ $file->created_at->toDateString() }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" style="text-align:center; color: red;">@lang('No Notes available')</td>
                                </tr>
                            @endif
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
