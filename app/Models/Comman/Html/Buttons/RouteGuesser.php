<?php

namespace App\Models\Comman\Html\Buttons;

/*
 * This file is part of Table Action Buttons.
 *
 * (c) Manojkiran.A <manojkiran10031998@gmail.com>
 *
 */

trait RouteGuesser
{
    use MissingRouteCatcher;
    /**
     * The Delete Route of the Current Model
     *
     * This Will Generate the Delete Route Name
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function deleteRouteName(): string
    {
        if (is_null($this->getProperty('deleteRoute')))
        {
            $routeName = $this->routeName() . '.destroy';
            $this->catchMissingRoute($routeName);
            return $routeName;
        }
        return $this->getProperty('deleteRoute');
    }

    /**
     * The Edit Route of the Current Model
     *
     * This Will Generate the Delete Route Name
     *
     * @throws conditon
     **/
    public function editRouteName(): string
    {
        if (is_null($this->getProperty('editRoute'))) {
            $routeName = $this->routeName() . '.edit';
            $this->catchMissingRoute($routeName);
            return $routeName;
        }
        return $this->getProperty('editRoute');
    }

    /**
     * The Show Route of the Current Model
     *
     * This Will Generate the Show Route Name
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function showRouteName(): string
    {
        if (is_null($this->getProperty('showRoute'))) {
            $routeName = $this->routeName() . '.show';
            $this->catchMissingRoute($routeName);
            return $routeName;
        }
        return $this->getProperty('showRoute');
    }
}
