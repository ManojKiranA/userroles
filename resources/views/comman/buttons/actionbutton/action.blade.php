@foreach ($buttonsList as $buttonName => $buttonOptions)

    @if ($buttonName === 'EDIT' )
        @include('comman.buttons.actionbutton.edit',
            [
                'route' => $buttonOptions['route'],
                'modelObject' => $modelObject
            ])
    @endif

    @if ($buttonName === 'DELETE' )
        @include('comman.buttons.actionbutton.delete',
            [
                'route' => $buttonOptions['route'],
                'modelObject' => $modelObject
            ])
    @endif

    @if ($buttonName === 'SHOW' )
        @include('comman.buttons.actionbutton.show',
            [
                'route' => $buttonOptions['route'],
                'modelObject' => $modelObject
            ])
    @endif
    
@endforeach
