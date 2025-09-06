<!-- Id Field -->
<div class="col-sm-12">
    {{ html()->label(__('models/districts.fields.id') . ':')->for('id') }}
    <p>{{ $district->id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {{ html()->label(__('models/districts.fields.name') . ':')->for('name') }}
    <p>{{ $district->name }}</p>
</div>

<!-- City Id Field -->
<div class="col-sm-12">
    {{ html()->label(__('models/districts.fields.city_id') . ':')->for('city_id') }}
    <p>{{ $district->city_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {{ html()->label(__('models/districts.fields.created_at') . ':')->for('created_at') }}
    <p>{{ $district->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {{ html()->label(__('models/districts.fields.updated_at') . ':')->for('updated_at') }}
    <p>{{ $district->updated_at }}</p>
</div>
