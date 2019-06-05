@foreach ($buttonsList as $buttonName)
    @if ($buttonName === 'EDIT' )
    {{ $modelObject->editButton() }}
    @endif

    @if ($buttonName === 'DELETE')
    {{ $modelObject->deleteButton() }}
    @endif
    
    @if ($buttonName === 'SHOW')
    {{ $modelObject->showButton() }}
    @endif
@endforeach