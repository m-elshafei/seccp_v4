@extends('layouts.app')

@section('title', __('models/districts.plural'))

@section('breadcrumbs', __('models/districts.plural'))

@section('content')

    <div>

        @include('layouts.partials.messages')

        <div class="card">


            {!! html()->modelForm($district, 'PATCH', route('districts.update', $district->id))->open() !!}

            <div class="card-header">
                <h4 class="card-title">
                    {{ __('models/districts.plural') }} - @lang('crud.edit')
                </h4>
                @include('layouts.partials.form_toolbar', [
                    'screen_name' => 'districts',
                    'action_name' => 'edit',
                ])
            </div>

            <div class="card-body">
                <div class="row">
                    @include('districts.fields')
                </div>
            </div>

            <div class="card-footer">
                {{ html()->button(__('crud.save'))->type('submit')->class('btn btn-primary') }}

                <a href="{{ route('districts.index') }}" class="btn btn-default">
                    @lang('crud.cancel')
                </a>
            </div>

            {!! html()->form()->close() !!}


        </div>
    </div>
@endsection
