@foreach ($buttonsList as $buttonName => $gateAccess)
    @if ($buttonName === 'EDIT')
        @can($gateAccess)
        {{ $modelObject->editButton(['buttonText' => 'Edit']) }}
        @endcan
    @endif
    @if ($buttonName === 'DELETE')
        @can($gateAccess)
        {{ $modelObject->deleteButton(['buttonText' => 'Delete']) }}
        @endcan
    @endif
    @if ($buttonName === 'SHOW')
        @can($gateAccess)
        {{ $modelObject->showButton(['buttonText' => 'Show']) }}
        @endcan
        
    @endif
@endforeach
