<?php

namespace App\Models\Comman\Html\Buttons\Actionbutton;

/*
 * This file is part of Table Action Buttons.
 *
 * (c) Manojkiran.A <manojkiran10031998@gmail.com>
 *
 */

trait MissingRouteCatcher
{
    /**
     * Catches all the missing route guesser exception
     *
     * @param string $routeName Name of the Route
     * @throws Exception
     **/
    public function catchMissingRoute(string $routeName,string $routeProperty)
    {
        try {
            route($routeName);
        } catch (\Exception $exception) {

            $preparedMessage = 'Route [' . $routeName . '] not defined.';
            $exceptionMessage = $exception->getMessage();

            if ($preparedMessage  === $exceptionMessage) {
                throw new \Exception('Unable Guess the Route Name.Try Setting   '.$routeProperty.'  property in ' . get_class($this). '', 1);
            }
        }

    }
}
