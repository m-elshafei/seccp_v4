<!-- Id Field -->
<div class="col-sm-12">
    {{ html()->label(__('models/cities.fields.id') . ':')->for('id') }}
    <p>{{ $city->id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {{ html()->label(__('models/cities.fields.name') . ':')->for('name') }}
    <p>{{ $city->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {{ html()->label(__('models/cities.fields.created_at') . ':')->for('created_at') }}
    <p>{{ $city->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {{ html()->label(__('models/cities.fields.updated_at') . ':')->for('updated_at') }}
    <p>{{ $city->updated_at }}</p>
</div>
