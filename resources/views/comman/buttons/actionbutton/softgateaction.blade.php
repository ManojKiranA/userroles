@foreach ($buttonsList as $buttonName => $buttonOptions)

    @if ($buttonName === 'FORCE_DELETE' )
        @can($buttonOptions['permission'])
            @include('comman.buttons.actionbutton.forcedelete',
                [
                    'route' => $buttonOptions['route'],
                    'modelObject' => $modelObject
                ])
        @endcan
    @endif

    @if ($buttonName === 'RESTORE' )
        @can($buttonOptions['permission'])
            @include('comman.buttons.actionbutton.restore',
                [
                    'route' => $buttonOptions['route'],
                    'modelObject' => $modelObject
                ])
        @endcan
    @endif

@endforeach
