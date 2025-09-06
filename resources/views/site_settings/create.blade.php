@extends('layouts.app')
@section('title', __('models/siteSettings.plural'))

@section('breadcrumbs', __('models/siteSettings.plural'))

@section('content')
    
    <div>

        @include('layouts.partials.messages')

        <div class="card">

            {!! Form::open(['route' => 'siteSettings.store','enctype' => 'multipart/form-data']) !!}
            <div class="card-header">
                
                <h4 class="card-title">
                                @lang('models/siteSettings.singular') - @lang('crud.add_new')
                 
                </h4>
                
                @include('layouts.partials.form_toolbar', ['screen_name' => 'siteSettings','action_name' => 'create'])
            </div>
             
            <div class="card-body">
                <div class="row">
                    @include('site_settings.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('siteSettings.index') }}" class="btn btn-default"> @lang('crud.cancel') </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
