@extends('layouts.app')

@section('title', __('models/siteSettings.plural'))

@section('breadcrumbs', __('models/siteSettings.plural'))

@section('content')

    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    
                                @lang('models/siteSettings.singular') - @lang('crud.show')
                 
                </h4>
                @include('layouts.partials.form_toolbar', ['screen_name' => 'siteSettings','action_name' => 'show'])
            </div>
            <div class="card-body border-top">
                <div class="row"  style="padding-top: 20px;">
                    @include('site_settings.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
