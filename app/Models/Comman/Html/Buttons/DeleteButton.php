<?php

namespace App\Models\Comman\Html\Buttons;

use Illuminate\Support\Facades\Crypt;
use Collective\Html\FormFacade as Form;
use Illuminate\Support\HtmlString;

/*
 * This file is part of Table Action Buttons.
 *
 * (c) Manojkiran.A <manojkiran10031998@gmail.com>
 *
 */

trait DeleteButton
{
    /**
     * This Will Generate the Delete Buttons for the Current Model Object
     *
     * Here You can Generate The Customised Version of the Delete Button
     *
     * @param array $alternateParms If You need Custom Params Value use this
     * @return Illuminate\Support\HtmlString
     **/
    public function deleteButton(array $alternateParms = []): HtmlString
    {
        $deleteButtonRoute = $this->deleteRouteName();//determines the Current Route Name of the Delete Method
        $actionFiled = $this->deleteActionFieldName();//gets the action Filed
        $actionId = $this->$actionFiled;//the filed that is used for the current action
        $deleteFunctionTitle = 'Delete';//title for delete functions
        $deleteButtonClass = 'btn btn-danger btn-circle';//class name for the deletebutton
        $deleteButtonIcon = 'fa fa-trash';//Icon for the delete Button
        $deleteButtonText  = '';//text for the delete button
        $deleteConfirmationDialog = 'Are You Sure you wnat to delete it ??';//dialog Which needs to be displayes while deleting the record
        $deleteButtonTooltopPostion = 'top';//here you can specify the position of tooltip
        $delteButtonVal = $alternateParms + ['routeMethod' => $deleteButtonRoute,'routeMethodValue' => $actionId,'popUpDialog' => $deleteConfirmationDialog,'buttonIcon' => $deleteButtonIcon,'buttonText' => $deleteButtonText,'buttonClass' => $deleteButtonClass,'toolTipPosition' => $deleteButtonTooltopPostion,'toolTipValue' => $deleteFunctionTitle,'parmEncryption' => false];
        if ($delteButtonVal['parmEncryption'] === true) {
            $actionId = Crypt::encrypt($this->$actionFiled);
        }
        $deleteButton = Form::open(['route' => [$delteButtonVal['routeMethod'], $actionId], 'style' => 'display: inline', 'onSubmit' => 'return confirm("' . $delteButtonVal['popUpDialog'] . '")']);
        $deleteButton .= method_field('DELETE').csrf_field();
        $deleteButton .= Form::button('<i class="' . $delteButtonVal['buttonIcon'] . '"></i>' . $delteButtonVal['buttonText'] . '', ['type' => 'submit', 'class' => $delteButtonVal['buttonClass'], 'data-toggle' => 'tooltip', 'data-placement' => $delteButtonVal['toolTipPosition'], 'title' => $delteButtonVal['toolTipValue']]);
        $deleteButton .= Form::close();
        return $this->toHtmlString($deleteButton);
    }
}
