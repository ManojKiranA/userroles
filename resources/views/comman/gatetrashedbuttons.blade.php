
                     
@foreach ($buttonsList as $buttonName => $gateAccess)
    @if ($buttonName === 'FORCE_DELETE' )
        @can($gateAccess)
        {{$modelObject->forceDeleteButton(['buttonText' => 'Delete'])}}
        @endcan
    @endif
    @if ($buttonName === 'RESTORE')
        @can($gateAccess)
        {{$modelObject->restoreButton()}}
        @endcan
    @endif
@endforeach