
@foreach ($buttonsList as $buttonName => $buttonOptions)

    @if ($buttonName === 'FORCE_DELETE' )
        @include('comman.buttons.actionbutton.forcedelete',
                  [
                     'modelObject' => $modelObject,
                     'route' => $buttonOptions['route'],
                  ])
    @endif

    @if ($buttonName === 'RESTORE' )
        @include('comman.buttons.actionbutton.restore',
            [
                'modelObject' => $modelObject,
                'route' => $buttonOptions['route'],
            ])
    @endif

@endforeach