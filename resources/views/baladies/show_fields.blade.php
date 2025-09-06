<div class="col-sm-6">
    <strong>{{ html()->label(__('models/baladies.fields.id') . ':')->for('id') }}</strong>
    <p>{{ $balady->id }}</p>
</div>

<div class="col-sm-6">
    <strong>{{ html()->label(__('models/baladies.fields.name') . ':')->for('name') }}</strong>
    <p>{{ $balady->name }}</p>
</div>

<div class="col-sm-6">
    <strong>{{ html()->label(__('models/baladies.fields.city_id') . ':')->for('city_id') }}</strong>
    <p>{{ $balady->city->name }}</p>
</div>

<div class="col-sm-6">
    <strong>{{ html()->label(__('models/baladies.fields.created_at') . ':')->for('created_at') }}</strong>
    <p>{{ $balady->created_at }}</p>
</div>

<div class="col-sm-6">
    <strong>{{ html()->label(__('models/baladies.fields.updated_at') . ':')->for('updated_at') }}</strong>
    <p>{{ $balady->updated_at }}</p>
</div>
