@foreach ($buttonsList as $buttonName => $gateAccess)
    @if ($buttonName === 'EDIT')
        @can($gateAccess)
        {{ $modelObject->editButton() }}
        @endcan
    @endif
    @if ($buttonName === 'DELETE')
        @can($gateAccess)
        {{ $modelObject->deleteButton() }}
        @endcan
    @endif
    @if ($buttonName === 'SHOW')
        @can($gateAccess)
        {{ $modelObject->showButton() }}
        @endcan
        
    @endif
@endforeach
