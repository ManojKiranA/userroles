<?php

namespace App\Models\Comman\Html\Buttons\Actionbutton;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Crypt;
use Collective\Html\HtmlFacade as Html;

/*
 * This file is part of Table Action Buttons.
 *
 * (c) Manojkiran.A <manojkiran10031998@gmail.com>
 *
 */

trait EditButton
{
    /**
     * Generates the edit Button For the Current Model Object
     *
     * This Will Geneated the Edit Button For the Current Model object
     * Here You can override the Defaut parameters
     *
     * @param array $alternateParms If You need Custom Params Value use this
     * @return Illuminate\Support\HtmlString
     **/
    public function editButton(array $alternateParms = []): HtmlString
    {
        $editButtonRoute = $this->editRouteName();//determines the Current Route Name of the Delete Method
        $actionFiled = $this->editActionFieldName();//gets the action Filed
        $actionId = $this->$actionFiled;//the filed that is used for the current action
        // Start Edit Button Arguments
        $editFunctionTitle = 'Edit';//title for Edit functions
        $editButtonClass = 'btn btn-primary btn-circle';//class for Edit functions
        $editButtonIcon = 'fa fa-pencil';//Icon for the Edit Button
        $editButtonText  = '';//text for the Edit button
        $editButtonTooltopPostion = 'top';//tooltipPosition of the Edit Button
        // End Edit Button Arguments
        $editButtonVal = $alternateParms + ['routeMethod' => $editButtonRoute,'routeMethodValue' => $actionId,'buttonIcon' => $editButtonIcon,'buttonText' => $editButtonText,'buttonClass' => $editButtonClass,'toolTipPosition' => $editButtonTooltopPostion,'toolTipValue' => $editFunctionTitle,'parmEncryption' => false];
        if ($editButtonVal['parmEncryption'] === true) {
            $actionId = Crypt::encrypt($this->$actionFiled);
        }
        $hrefButton = '<i class="' . $editButtonVal['buttonIcon'] . '"></i> ' . $editButtonVal['buttonText'] . '';
        $hrefButtonExtraParms = ['class' => $editButtonVal['buttonClass'],'data-toggle' => 'tooltip','data-placement' => $editButtonVal['toolTipPosition'],'title' => $editButtonVal['toolTipValue']];
        $editButton = Html::link(route($editButtonVal['routeMethod'], $actionId), $hrefButton, $hrefButtonExtraParms, false, false);
        return $this->toHtmlString($editButton);
    }
}
