<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! html()->label(__('models/attachmentTypes.fields.title') . ':')->for('title') !!}
    {!! html()->text('title')
        ->class('form-control')
        ->value(old('title') ?? null) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! html()->label(__('models/attachmentTypes.fields.description') . ':')->for('description') !!}
    {!! html()->textarea('description')
        ->class('form-control')
        ->value(old('description') ?? null) !!}
</div>
