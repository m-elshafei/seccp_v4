<!-- Name Field -->
<div class="form-group col-sm-6">
    {{ html()->label(__('models/cities.fields.name') . ':')->for('name') }}
    {{ html()->text('name')
        ->class('form-control')
        ->id('name') }}
</div>
