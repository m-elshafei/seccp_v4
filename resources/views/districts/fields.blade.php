<!-- Name Field -->
<div class="form-group col-sm-6">
    {{ html()->label(__('models/districts.fields.name') . ':')->for('name') }}
    {{ html()->text('name', old('name') ?? $district->name ?? '')
        ->class('form-control')
        ->id('name') }}
</div>

<!-- City Id Field -->
<div class="form-group col-sm-6">
    {{ html()->label(__('models/districts.fields.city_name') . ':')->for('city_id') }}
    {{ html()->select('city_id', $cities, old('city_id') ?? $district->city_id ?? '')
        ->class('select2 form-select form-control')
        ->id('city_id') }}
</div>
