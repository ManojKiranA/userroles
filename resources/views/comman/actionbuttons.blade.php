@foreach ($buttonsList as $buttonName)
    @if ($buttonName === 'EDIT' )
        {{ $modelObject->editButton(['buttonText' => 'Edit']) }}
    @endif
    @if ($buttonName === 'DELETE')
        {{ $userValue->deleteButton(['buttonText' => 'Delete']) }}
    @endif
    @if ($buttonName === 'SHOW')
        {{ $userValue->showButton(['buttonText' => 'Show']) }}
    @endif
@endforeach
