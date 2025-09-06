@extends('layouts.app')

@section('title', __('models/branches.plural'))

@section('breadcrumbs', __('models/branches.plural'))

@section('content')

    <div>

        @include('layouts.partials.messages')

        <div class="card">

            {!! html()->modelForm($branch, 'PATCH', route('branches.update', $branch->id))->open() !!}

            <div class="card-header">
                <h4 class="card-title">
                    {{ __('models/branches.plural') }} - @lang('crud.edit')
                </h4>
                @include('layouts.partials.form_toolbar', ['screen_name' => 'branches','action_name' => 'edit'])
            </div>

            <div class="card-body">
                <div class="row">
                    @include('branches.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! html()->submit(__('crud.save'))->class('btn btn-primary') !!}
                <a href="{{ route('branches.index') }}" class="btn btn-default">
                    @lang('crud.cancel')
                </a>
            </div>

            {!! html()->form()->close() !!}


        </div>
    </div>
@endsection
