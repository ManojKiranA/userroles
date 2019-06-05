<?php

namespace App\Models\Comman\Html\Buttons\Actionbutton;

use Illuminate\Support\Facades\Crypt;
use Collective\Html\HtmlFacade as Html;

/*
 * This file is part of Table Action Buttons.
 *
 * (c) Manojkiran.A <manojkiran10031998@gmail.com>
 *
 */

trait ShowButton
{
    /**
     * Generates the show Button For the Current Model Object
     *
     * This Will Geneated the Show Button For the Current Model object
     * Here You can override the Defaut parameters
     *
     * @param array $alternateParms If You need Custom Params Value use this
     * @return Illuminate\Support\HtmlString
     **/
    public function showButton(array $alternateParms = [])
    {
        // Start Show Button Arguments
        $showButtonRoute = $this->showRouteName();//determines the Current Route Name of the Delete Method
        $actionFiled = $this->showActionFieldName();//gets the action Filed
        $actionId = $this->$actionFiled;//the filed that is used for the current action
        $showFunctionTitle = 'Show';//title for Edit functions
        $showButtonClass = 'btn btn-success btn-circle';//Class for the Show Button
        $showButtonIcon = 'fa fa-eye';//Text for the Show button
        $showButtonText = '';//Icon for the Show Button
        $showButtonTooltopPostion = 'top';//Tooltip position for the Show Button
        // End Show Button Arguments
        $showButtonVal = $alternateParms +['routeMethod' => $showButtonRoute,'routeMethodValue' => $actionId,'buttonIcon' => $showButtonIcon,'buttonText' => $showButtonText,'buttonClass' => $showButtonClass,'toolTipPosition' => $showButtonTooltopPostion,'toolTipValue' => $showFunctionTitle,'parmEncryption' => false];
        if ($showButtonVal['parmEncryption'] === true) {
            $actionId = Crypt::encrypt($this->$actionFiled);
        }
        $hrefButton = '<i class="' . $showButtonVal['buttonIcon'] . '"></i> ' . $showButtonVal['buttonText'] . '';
        $hrefButtonExtraParms = [ 'class' => $showButtonVal['buttonClass'],'data-toggle' => 'tooltip','data-placement' => $showButtonVal['toolTipPosition'],'title' => $showButtonVal['toolTipValue']];
        $showButton = Html::link(route($showButtonVal['routeMethod'], $actionId), $hrefButton, $hrefButtonExtraParms, false, false);
        return $this->toHtmlString($showButton);
    }
}
