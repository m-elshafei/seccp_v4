@props([
    'name',
    'labelTitle' => '',
    'dateValue' => null,
    'placeholder' => 'YYYY-MM-DD'
])

<div class="date-pickr-container">
    @if($labelTitle)
        {!! Form::label($name, $labelTitle.':') !!}
    @endif
    {!! Form::text(
        $name, 
        $dateValue, 
        array_merge(
            [
                'class' => 'form-control flatpickr-basic',
                'id' => $name,
                'placeholder' => $placeholder,
                'style' => 'width: 75%;',
                'autocomplete' => 'off'
            ],
            $attributes->getAttributes()
        )
    ) !!}
</div>
