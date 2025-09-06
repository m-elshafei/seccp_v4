<!-- Id Field -->
<div class="col-sm-12">
    {!! html()->label(__('models/attachmentTypes.fields.id') . ':')->for('id') !!}
    <p>{{ $attachmentType->id }}</p>
</div>

<!-- Title Field -->
<div class="col-sm-12">
    {!! html()->label(__('models/attachmentTypes.fields.title') . ':')->for('title') !!}
    <p>{{ $attachmentType->title }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! html()->label(__('models/attachmentTypes.fields.description') . ':')->for('description') !!}
    <p>{{ $attachmentType->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! html()->label(__('models/attachmentTypes.fields.created_at') . ':')->for('created_at') !!}
    <p>{{ $attachmentType->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! html()->label(__('models/attachmentTypes.fields.updated_at') . ':')->for('updated_at') !!}
    <p>{{ $attachmentType->updated_at }}</p>
</div>
