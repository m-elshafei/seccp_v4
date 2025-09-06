@extends('layouts.app')

@section('title', __('models/cities.plural'))

@section('breadcrumbs', __('models/cities.plural'))

@section('content')

    <div>
        @include('layouts.partials.messages')
        <div class="card">
            {!! html()->form()->route('cities.store')->method('POST')->open() !!}
            <div class="card-header">
                <h4 class="card-title">{{ __('models/cities.plural') }} - @lang('crud.add_new') </h4>
                @include('layouts.partials.form_toolbar', [
                    'screen_name' => 'cities',
                    'action_name' => 'create',
                ])
            </div>
            <div class="card-body">
                <div class="row">
                    @include('cities.fields')
                </div>
            </div>
            <div class="card-footer">
                {{ html()->button(__('crud.save'))->type('submit')->class('btn btn-primary') }}

                <a href="{{ route('cities.index') }}" class="btn btn-default">
                    @lang('crud.cancel')
                </a>
            </div>
            {!! html()->form()->close() !!}
        </div>
    </div>
@endsection
