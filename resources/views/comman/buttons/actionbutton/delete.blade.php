@php

use Illuminate\Support\HtmlString;

$deleteFunctionTitle = 'Delete';//title for delete functions
$deleteButtonClass = 'btn btn-danger btn-circle';//class name for the deletebutton
$deleteButtonIcon = 'fas fa-trash';//Icon for the delete Button
$deleteButtonText  = '';//text for the delete button
$deleteConfirmationDialog = 'Are You Sure you wnat to delete it ??';//dialog Which needs to be displayes while deleting the record
$deleteButtonTooltopPostion = 'top';//here you can specify the position of tooltip
$delteButtonVal =  ['routeMethod' => $route,'popUpDialog' => $deleteConfirmationDialog,'buttonIcon' => $deleteButtonIcon,'buttonText' => $deleteButtonText,'buttonClass' => $deleteButtonClass,'toolTipPosition' => $deleteButtonTooltopPostion,'toolTipValue' => $deleteFunctionTitle,'parmEncryption' => false];

$deleteButton = Form::open(['route' => [$delteButtonVal['routeMethod'], $modelObject], 'style' => 'display: inline', 'onSubmit' => 'return confirm("' . $delteButtonVal['popUpDialog'] . '")']);
$deleteButton .= method_field('DELETE').csrf_field();
$deleteButton .= Form::button('<i class="' . $delteButtonVal['buttonIcon'] .'"></i> ' . $delteButtonVal['buttonText'] . '', ['type' => 'submit', 'class' => $delteButtonVal['buttonClass'], 'data-toggle' => 'tooltip', 'data-placement' => $delteButtonVal['toolTipPosition'], 'title' => $delteButtonVal['toolTipValue']]);
$deleteButton .= Form::close();

@endphp

{{new HtmlString($deleteButton)}}