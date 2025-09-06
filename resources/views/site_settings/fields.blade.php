<!-- Site Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('site_name_en', __('models/siteSettings.fields.site_name_en') . ':') !!}
    {!! Form::text('site_name_en', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('site_name_ar', __('models/siteSettings.fields.site_name_ar') . ':') !!}
    {!! Form::text('site_name_ar', null, ['class' => 'form-control']) !!}




    
</div>

<!-- Company Nsme Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_name', __('models/siteSettings.fields.company_name') . ':') !!}
    {!! Form::text('company_name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('site_alias', __('models/siteSettings.fields.site_alias') . ':') !!}
    {!! Form::text('site_alias', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('site_main_color', __('models/siteSettings.fields.site_main_color') . ':') !!}
    {!! Form::text('site_main_color', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('site_font_name', __('models/siteSettings.fields.site_font_name') . ':') !!}
    {!! Form::text('site_font_name', null, ['class' => 'form-control']) !!}
</div>
<!-- Logo Path Field -->
<div class="col-md-6">
    <div >
        
        <x-fileinput-custom name="logo_path" labelTitle="{{ __('models/siteSettings.fields.logo_path') }}"></x-fileinput-custom>
    </div>
</div>
<div class="col-md-6">
    <div >
        
        <x-fileinput-custom name="big_photo" labelTitle="{{ __('models/siteSettings.fields.big_photo') }}"></x-fileinput-custom>
    </div>
</div>

<!-- Company Nsme Field -->


<div class="mt-2 mb-2 col-8">
    {!! Form::label('message_home_page', __('models/siteSettings.fields.message_home_page') . ':') !!}
    <textarea class="form-control m-3" id="editor1" name="message_home_page">{{ isset($siteSetting->message_home_page) ? $siteSetting->message_home_page : old('message_home_page') }}</textarea>
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#editor1'), {
            language: {
                ui: 'ar',
                content: 'ar'
            },
            direction: 'rtl',
            fontSize: {
                options: [9, 11, 13, 'default', 17, 19, 21]
            }
        })
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('There was an error initializing the editor:', error);
        });
</script>
