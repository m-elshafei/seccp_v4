<!-- Id Field -->
<div class="col-sm-12">
    {!! html()->label(__('models/branches.fields.id') . ':')->for('id') !!}
    <p>{{ $branch->id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! html()->label(__('models/branches.fields.name') . ':')->for('name') !!}
    <p>{{ $branch->name }}</p>
</div>

<!-- City Id Field -->
<div class="col-sm-12">
    {!! html()->label(__('models/branches.fields.city_id') . ':')->for('city_id') !!}
    <p>{{ $branch->city->name ?? "" }}</p>
</div>

<!-- District Id Field -->
<div class="col-sm-12">
    {!! html()->label(__('models/branches.fields.district_id') . ':')->for('district_id') !!}
    <p>{{ $branch->district->name ?? "" }}</p>
</div>

<!-- Is Main Branch Field -->
<div class="col-sm-12">
    {!! html()->label(__('models/branches.fields.is_main_branch') . ':')->for('is_main_branch') !!}
    <p>{{ $branch->is_main_branch ? __('yes') : __('no') }}</p>
</div>
