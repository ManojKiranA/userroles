

@php
    
        $showButtonRoute = $route;
        $showFunctionTitle = 'Show';//title for Edit functions
        $showButtonClass = 'btn btn-success btn-circle';//Class for the Show Button
        $showButtonIcon = 'fa fa-eye';//Text for the Show button
        $showButtonText = '';//Icon for the Show Button
        $showButtonTooltopPostion = 'top';//Tooltip position for the Show Button
        // End Show Button Arguments
        $showButtonVal = ['routeMethod' => $showButtonRoute,'buttonIcon' => $showButtonIcon,'buttonText' => $showButtonText,'buttonClass' => $showButtonClass,'toolTipPosition' => $showButtonTooltopPostion,'toolTipValue' => $showFunctionTitle,'parmEncryption' => false];
        
        $hrefButton = '<i class="' . $showButtonVal['buttonIcon'] . '"></i> ' . $showButtonVal['buttonText'] . '';
        $hrefButtonExtraParms = [ 'class' => $showButtonVal['buttonClass'],'data-toggle' => 'tooltip','data-placement' => $showButtonVal['toolTipPosition'],'title' => $showButtonVal['toolTipValue']];
        
@endphp

{{Html::link(route($showButtonVal['routeMethod'], $modelObject), $hrefButton, $hrefButtonExtraParms, false, false)}}