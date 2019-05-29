@foreach ($buttonsList as $buttonName)
@if ($buttonName === 'EDIT' )
{{ $modelObject->editButton(['buttonText' => 'Edit']) }}
@endif
@if ($buttonName === 'DELETE')
{{ $modelObject->deleteButton(['buttonText' => 'Delete']) }}
@endif
@if ($buttonName === 'SHOW')
{{ $modelObject->showButton(['buttonText' => 'Show']) }}
@endif
@endforeach