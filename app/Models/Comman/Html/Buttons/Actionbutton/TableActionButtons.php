<?php

namespace App\Models\Comman\Html\Buttons\Actionbutton;

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
    use EditButton,DeleteButton,ShowButton, RouteGuesser, ForceDeleteButton, RestoreButton;

    /**
     * Transform the string to an Html serializable object
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param $html
     * @return \Illuminate\Support\HtmlString
     */
    protected function toHtmlString($html): HtmlString
    {
        return new HtmlString($html);
    }

    /**
     * The Delete Route key of the Current Model
     * This Will Generate the Delete Route Name
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     * @throws Exception
     **/
    public function deleteActionFieldName(): string
    {
        return $this->getRouteKeyName();

        if (is_null($this->getProperty('deleteActionField')))
        {
            return 'id';
        }
        return $this->getProperty('deleteActionField');
    }

    /**
     * The Force Delete Route key of the Current Model
     * This Will Generate the Force Delete Route Name
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     * @throws Exception
     **/
    public function forceDeleteActionFieldName(): string
    {
        return $this->getRouteKeyName();

        if (is_null($this->getProperty( 'forceDeleteActionField')))
        {
            return 'id';
        }
        return $this->getProperty( 'forceDeleteActionField');
    }

    /**
     * The Restore Route key of the Current Model
     * This Will Generate the Restore Route Name
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     * @throws Exception
     **/
    public function restoreActionFieldName(): string
    {
        return $this->getRouteKeyName();

        if (is_null($this->getProperty('restoreActionField'))) {
            return 'id';
        }
        return $this->getProperty( 'restoreActionField');
    }

    /**
     * The Edit Route Action Filed of the Current Model
     * This Will Generate the Delete Route Name
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     * @throws Exception
     **/
    public function editActionFieldName(): string
    {
        return $this->getRouteKeyName();

        if (is_null($this->getProperty('editActionField'))) {
            return 'id';
        }
        return $this->getProperty('editActionField');
    }

    /**
     * The Edit Route Action Filed of the Current Model
     * This Will Generate the Delete Route Name
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     * @throws Exception
     **/
    public function showActionFieldName(): string
    {
        return $this->getRouteKeyName();

        if (is_null($this->getProperty('showActionField'))) {
            return 'id';
        }
        return $this->getProperty('showActionField');
    }
    /**
     * Get the Property from the object
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param string $var Object Property
     * @return mixed
     **/
    public function getProperty($var)
    {
        return $this->$var;
    }
    /**
     * This Is used To determine the base route name of the Model
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     **/
    public function routeName(): string
    {
        return Str::plural(Str::camel( class_basename($this)));
    }

}
