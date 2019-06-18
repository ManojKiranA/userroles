@foreach ($buttonsList as $buttonName => $buttonOptions)

    @if ($buttonName === 'EDIT' )
        @can($buttonOptions['permission'])
            @include('comman.buttons.actionbutton.edit',
                [
                    'route' => $buttonOptions['route'],
                    'modelObject' => $modelObject
                ])
        @endcan
    @endif

    @if ($buttonName === 'DELETE' )
        @can($buttonOptions['permission'])
            @include('comman.buttons.actionbutton.delete',
                [
                    'route' => $buttonOptions['route'],
                    'modelObject' => $modelObject
                ])
        @endcan
    @endif

    @if ($buttonName === 'SHOW' )
        @can($buttonOptions['permission'])
            @include('comman.buttons.actionbutton.show',
                [
                    'route' => $buttonOptions['route'],
                    'modelObject' => $modelObject
                ])
        @endcan
    @endif
@endforeach
