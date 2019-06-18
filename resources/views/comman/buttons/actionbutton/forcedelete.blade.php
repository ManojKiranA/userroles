@php
use Illuminate\Support\HtmlString;
        $forceDeleteFunctionTitle = 'Delete'; //title for delete functions
        $forceDeleteButtonClass = 'btn btn-danger btn-circle'; //class name for the deletebutton
        $forceDeleteButtonIcon = 'fa fa-trash'; //Icon for the delete Button
        $forceDeleteButtonText  = ''; //text for the delete button
        $deleteConfirmationDialog = 'Are You Sure you wnat to delete it. It Cannot Be RECORVED??'; //dialog Which needs to be displayes while deleting the record
        $forceDeleteButtonTooltopPostion = 'top'; //here you can specify the position of tooltip
        $delteButtonVal = [
            'routeMethod' => $route,
            'popUpDialog' => $deleteConfirmationDialog,
            'buttonIcon' => $forceDeleteButtonIcon,
            'buttonText' => $forceDeleteButtonText,
            'buttonClass' => $forceDeleteButtonClass,
            'toolTipPosition' => $forceDeleteButtonTooltopPostion,
            'toolTipValue' => $forceDeleteFunctionTitle,
            ];

        $forceDeleteButton = Form::open(['route' => [$delteButtonVal['routeMethod'], $modelObject], 'style' => 'display: inline', 'onSubmit' => 'return confirm("' . $delteButtonVal['popUpDialog'] . '")']);
        $forceDeleteButton .= method_field('DELETE') . csrf_field();
        $forceDeleteButton .= Form::button('<i class="' . $delteButtonVal['buttonIcon'] . '"></i>' . $delteButtonVal['buttonText'] . '', ['type' => 'submit', 'class' => $delteButtonVal['buttonClass'], 'data-toggle' => 'tooltip', 'data-placement' => $delteButtonVal['toolTipPosition'], 'title' => $delteButtonVal['toolTipValue']]);
        $forceDeleteButton .= Form::close();
@endphp

{{new HtmlString($forceDeleteButton)}}