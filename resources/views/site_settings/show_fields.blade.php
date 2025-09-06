<!-- Site Name Field -->
<div class="col-sm-6">
    <div class="mb-1 row">
        <div class="col-sm-3 fw-bolder bold">
                {!! Form::label('site_name', __('models/siteSettings.fields.site_name').':') !!}
                </div>
        <div class="col-sm-9 ">
            <p>{{ $siteSetting->site_name }}</p>
        </div>
    </div>
</div>

<!-- Logo Path Field -->
<div class="col-sm-6">
    <div class="mb-1 row">
        <div class="col-sm-3 fw-bolder bold">
                {!! Form::label('logo_path', __('models/siteSettings.fields.logo_path').':') !!}
                </div>
        <div class="col-sm-9 ">
            <p>{{ $siteSetting->logo_path }}</p>
        </div>
    </div>
</div>

<!-- Company Nsme Field -->
<div class="col-sm-6">
    <div class="mb-1 row">
        <div class="col-sm-3 fw-bolder bold">
                {!! Form::label('company_name', __('models/siteSettings.fields.company_name').':') !!}
                </div>
        <div class="col-sm-9 ">
            <p>{{ $siteSetting->company_name }}</p>
        </div>
    </div>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    <div class="mb-1 row">
        <div class="col-sm-3 fw-bolder bold">
                {!! Form::label('message_home_page', __('models/siteSettings.fields.message_home_page').':') !!}
                </div>
        <div class="col-sm-9 ">
            <p>{{ $siteSetting->message_home_page }}</p>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="mb-1 row">
        <div class="col-sm-3 fw-bolder bold">
                {!! Form::label('created_at', __('models/siteSettings.fields.created_at').':') !!}
                </div>
        <div class="col-sm-9 ">
            <p>{{ $siteSetting->created_at }}</p>
        </div>
    </div>
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    <div class="mb-1 row">
        <div class="col-sm-3 fw-bolder bold">
                {!! Form::label('updated_at', __('models/siteSettings.fields.updated_at').':') !!}
                </div>
        <div class="col-sm-9 ">
            <p>{{ $siteSetting->updated_at }}</p>
        </div>
    </div>
</div>

