@extends('layouts.app')

@section('title', __('models/baladies.plural'))

@section('breadcrumbs', __('models/baladies.plural'))

@section('content')

    <div>

        @include('layouts.partials.messages')

        <div class="card">

            {!! html()->modelForm($balady, 'PATCH', route('baladies.update', $balady->id))->open() !!}
            <div class="card-header">
                <h4 class="card-title">{{ __('models/baladies.plural') }} - @lang('crud.edit')</h4>
                @include('layouts.partials.form_toolbar', [
                    'screen_name' => 'baladies',
                    'action_name' => 'edit',
                ])
            </div>

            <div class="card-body">
                <div class="row">
                    @include('baladies.fields')
                </div>
            </div>

            <div class="card-footer">
                {{ html()->submit(__('crud.save'))->class('btn btn-primary') }}
                <a href="{{ route('baladies.index') }}" class="btn btn-default">
                    @lang('crud.cancel')
                </a>
            </div>
            {!! html()->form()->close() !!}


        </div>
    </div>
@endsection
