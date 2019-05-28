@foreach ($buttonsList as $buttonName)
    @if ($buttonName === 'FORCE_DELETE' )
        {{$userValue->forceDeleteButton('buttonText' => 'Delete')}}
    @endif
    @if ($buttonName === 'RESTORE')
        {{$userValue->restoreButton()}}
    @endif
@endforeach