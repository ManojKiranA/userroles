<?php

namespace App\Models\Comman\Html\Buttons\Actionbutton;

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
     * The Edit Route of the Current Model
     * This Will Generate the Edit Route Name
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     **/
    public function editRouteName(): string
    {
        if (is_null($this->getProperty('editRoute'))) {
            $routeName = $this->routeName() . '.edit';
            $this->catchMissingRoute($routeName, 'editRoute');
            return $routeName;
        }
        return $this->getProperty('editRoute');
    }

    /**
     * The Delete Route of the Current Model
     * This Will Generate the Delete Route Name
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     **/
    public function deleteRouteName(): string
    {
        if (is_null($this->getProperty('deleteRoute')))
        {
            $routeName = $this->routeName() . '.destroy';
            $this->catchMissingRoute($routeName, 'deleteRoute');
            return $routeName;
        }
        return $this->getProperty('deleteRoute');
    }

    /**
     * The Show Route of the Current Model
     * This Will Generate the Show Route Name
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     **/
    public function showRouteName(): string
    {
        if (is_null($this->getProperty('showRoute'))) {
            $routeName = $this->routeName() . '.show';
            $this->catchMissingRoute($routeName, 'showRoute');
            return $routeName;
        }
        return $this->getProperty('showRoute');
    }

    /**
     * The Force Delete Route of the Current Model
     * This Will Generate the Force Delete Route Name
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     **/
    public function forceDeleteRouteName(): string
    {
        if (is_null($this->getProperty( 'forceDeleteRoute'))) {
            $routeName = $this->routeName() . '.forcedelete';
            $this->catchMissingRoute($routeName, 'forceDeleteRoute');
            return $routeName;
        }
        return $this->getProperty( 'forceDeleteRoute');
    }

    /**
     * The Restore Route of the Current Model
     * This Will Generate the Restore Route Name
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     **/
    public function restoreRouteName(): string
    {
        if (is_null($this->getProperty('restoreRoute'))) {
            $routeName = $this->routeName() . '.restoreRoute';
            $this->catchMissingRoute($routeName, 'restoreRoute');
            return $routeName;
        }
        return $this->getProperty( 'restoreRoute');
    }
}
