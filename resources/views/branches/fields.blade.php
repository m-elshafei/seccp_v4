<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! html()->label(__('models/branches.fields.name') . ':')->for('name') !!}
    {!! html()->text('name')->class('form-control') !!}
</div>

<!-- City Id Field -->
<div class="form-group col-sm-6">
    {!! html()->label(__('models/branches.fields.city_name') . ':')->for('city_id') !!}
    {!! html()->select('city_id', $cities)->class('select2 form-select form-control') !!}
</div>


