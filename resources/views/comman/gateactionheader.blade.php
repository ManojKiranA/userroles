@php $viewTimes = 0 @endphp
@foreach ($permissionList as $permissionName)
    @can($permissionName)
        @if ($viewTimes === 0)
            <td class="text-center">
            Actions
            </td>
        @php ++$viewTimes @endphp
        @endif
    @endcan
@endforeach