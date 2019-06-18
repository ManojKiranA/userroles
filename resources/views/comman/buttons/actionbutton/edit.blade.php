@php

// Start Edit Button Arguments
$editTooltipTitle = 'Edit';//title for Edit functions
$editButtonClass = 'btn btn-primary btn-circle';//class for Edit functions
$editButtonIcon = 'fas fa-edit';//Icon for the Edit Button
$editButtonText  = '';//text for the Edit button
$editButtonTooltopPostion = 'top';//tooltipPosition of the Edit Button
// End Edit Button Arguments
$editButtonVal = [
            'routeMethod' => $route,
            'buttonIcon' => $editButtonIcon,
            'buttonText' => $editButtonText,
            'buttonClass' => $editButtonClass,
            'toolTipPosition' => $editButtonTooltopPostion,
            'toolTipValue' => $editTooltipTitle,
            'parmEncryption' => false];


$hrefButton = '<i class="' . $editButtonVal['buttonIcon'] . '"></i> ' . $editButtonVal['buttonText'] . '';
$hrefButtonExtraParms = [
            'class' => $editButtonVal['buttonClass'],
            'data-toggle' => 'tooltip',
            'data-placement' => $editButtonVal['toolTipPosition'],
            'title' => $editButtonVal['toolTipValue']
            ];  
@endphp
{{Html::link(route($editButtonVal['routeMethod'], $modelObject), $hrefButton, $hrefButtonExtraParms, false, false)}}