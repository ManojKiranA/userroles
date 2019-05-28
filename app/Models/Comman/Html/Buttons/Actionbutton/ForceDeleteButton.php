<?php

namespace App\Models\Comman\Html\Buttons\Actionbutton;

use Illuminate\Support\Facades\Crypt;
use Collective\Html\FormFacade as Form;
use Illuminate\Support\HtmlString;

/*
 * This file is part of Table Action Buttons.
 *
 * (c) Manojkiran.A <manojkiran10031998@gmail.com>
 *
 */

trait ForceDeleteButton
{
    /**
     * This Will Generate the Delete Buttons for the Current Model Object
     *
     * Here You can Generate The Customised Version of the Delete Button
     *
     * @param array $alternateParms If You need Custom Params Value use this
     * @return Illuminate\Support\HtmlString
     **/
    public function forceDeleteButton(array $alternateParms = []): HtmlString
    {
        $forceDeleteButtonRoute = $this-> forceDeleteRouteName(); //determines the Current Route Name of the Delete Method
        $actionFiled = $this-> forceDeleteActionFieldName(); //gets the action Filed
        $actionId = $this->$actionFiled; //the filed that is used for the current action
        $forceDeleteFunctionTitle = 'Delete'; //title for delete functions
        $forceDeleteButtonClass = 'btn btn-danger btn-circle'; //class name for the deletebutton
        $forceDeleteButtonIcon = 'fa fa-trash'; //Icon for the delete Button
        $forceDeleteButtonText  = ''; //text for the delete button
        $deleteConfirmationDialog = 'Are You Sure you wnat to delete it. It Cannot Be RECORVED??'; //dialog Which needs to be displayes while deleting the record
        $forceDeleteButtonTooltopPostion = 'top'; //here you can specify the position of tooltip
        $delteButtonVal = $alternateParms + ['routeMethod' => $forceDeleteButtonRoute, 'routeMethodValue' => $actionId, 'popUpDialog' => $deleteConfirmationDialog, 'buttonIcon' => $forceDeleteButtonIcon, 'buttonText' => $forceDeleteButtonText, 'buttonClass' => $forceDeleteButtonClass, 'toolTipPosition' => $forceDeleteButtonTooltopPostion, 'toolTipValue' => $forceDeleteFunctionTitle, 'parmEncryption' => false];

        if ($delteButtonVal['parmEncryption'] === true) {
            $actionId = Crypt::encrypt($this->$actionFiled);
        }
        $forceDeleteButton = Form::open(['route' => [$delteButtonVal['routeMethod'], $actionId], 'style' => 'display: inline', 'onSubmit' => 'return confirm("' . $delteButtonVal['popUpDialog'] . '")']);
        $forceDeleteButton .= method_field('DELETE') . csrf_field();
        $forceDeleteButton .= Form::button('<i class="' . $delteButtonVal['buttonIcon'] . '"></i>' . $delteButtonVal['buttonText'] . '', ['type' => 'submit', 'class' => $delteButtonVal['buttonClass'], 'data-toggle' => 'tooltip', 'data-placement' => $delteButtonVal['toolTipPosition'], 'title' => $delteButtonVal['toolTipValue']]);
        $forceDeleteButton .= Form::close();
        return $this->toHtmlString($forceDeleteButton);
    }
}
