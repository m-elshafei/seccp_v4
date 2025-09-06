@extends('layouts.app')

@section('title', __('models/cities.plural'))

@section('breadcrumbs', __('models/cities.plural'))

@section('content')

    <div>

        @include('layouts.partials.messages')

        <div class="card">

            {!! html()->modelForm($city, 'PATCH', route('cities.update', $city->id))->open() !!}

            <div class="card-header">
                <h4 class="card-title">{{ __('models/cities.plural') }} - @lang('crud.edit') </h4>
                @include('layouts.partials.form_toolbar', [
                    'screen_name' => 'cities',
                    'action_name' => 'edit',
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
