@extends('layouts.app')

@section('title', __('models/workOrdersProjects.plural'))

@section('breadcrumbs', __('models/workOrdersProjects.plural'))

@section('content')
    
    <div>

        @include('layouts.partials.messages')

        <div class="card">

            {!! Form::open(['route' => 'workOrdersProjects.store']) !!}
            <div class="card-header">
                <h4 class="card-title">{{  __('models/workOrdersProjects.plural') }} - @lang('crud.add_new')  </h4>
                @include('layouts.partials.form_toolbar', ['screen_name' => 'workOrdersProjects','action_name' => 'create'])
            </div>
             
            <div class="card-body">
                <div class="row">
                    @include('work_orders_projects.fields', ["formMode"=>"create"])
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('workOrdersProjects.index') }}" class="btn btn-default">
                 @lang('crud.cancel')
                </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
