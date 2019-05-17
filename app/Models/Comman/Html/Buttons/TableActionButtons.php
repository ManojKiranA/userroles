<?php

namespace App\Models\Comman\Html\Buttons;

use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;

/*
 * This file is part of Table Action Buttons.
 *
 * (c) Manojkiran.A <manojkiran10031998@gmail.com>
 *
 */

trait TableActionButtons
{
    use EditButton,DeleteButton,ShowButton, RouteGuesser;

    /**
     * Transform the string to an Html serializable object
     *
     * @param $html
     * @return \Illuminate\Support\HtmlString
     */
    protected function toHtmlString($html): HtmlString
    {
        return new HtmlString($html);
    }

    /**
     * The Delete Route of the Current Model
     *
     * This Will Generate the Delete Route Name
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function deleteActionFieldName(): string
    {
        if (is_null($this->getProperty('deleteActionField'))) {
            return 'id';
        }
        return $this->getProperty('deleteActionField');
    }

    /**
     * The Edit Route Action Filed of the Current Model
     *
     * This Will Generate the Delete Route Name
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function editActionFieldName(): string
    {
        if (is_null($this->getProperty('editActionField'))) {
            return 'id';
        }
        return $this->getProperty('editActionField');
    }

    /**
     * The Edit Route Action Filed of the Current Model
     *
     * This Will Generate the Delete Route Name
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function showActionFieldName(): string
    {
        if (is_null($this->getProperty('showActionField'))) {
            return 'id';
        }
        return $this->getProperty('showActionField');
    }

    public function getProperty($var)
    {
        return $this->$var;
    }

    /**
     * This Is used To determine the base route name of the Model
     *
     * @return string
     **/
    public function routeName(): string
    {
        return Str::plural(Str::camel( class_basename($this)));
    }

}
