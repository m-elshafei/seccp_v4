@extends('layouts.app')

@section('title', __('models/attachmentTypes.plural'))

@section('breadcrumbs', __('models/attachmentTypes.plural'))

@section('content')

    <div>

        @include('layouts.partials.messages')

        <div class="card">

           {!! html()->form('POST', route('attachmentTypes.store'))->open() !!}
    <div class="card-header">
        <h4 class="card-title">{{ __('models/attachmentTypes.plural') }} - @lang('crud.add_new')</h4>
        @include('layouts.partials.form_toolbar', ['screen_name' => 'attachmentTypes', 'action_name' => 'create'])
    </div>

    <div class="card-body">
        <div class="row">
            @include('attachment_types.fields')
        </div>
    </div>

    <div class="card-footer">
        {!! html()->button(__('crud.save'))
            ->type('submit')
            ->class('btn btn-primary') !!}
        <a href="{{ route('attachmentTypes.index') }}" class="btn btn-default">
            @lang('crud.cancel')
        </a>
    </div>
{!! html()->form()->close() !!}


        </div>
    </div>
@endsection
