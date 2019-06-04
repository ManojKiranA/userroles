<?php

namespace App\Models\Finders;

/**
 * Handles all the finder filed of the user Model
 */
trait UserFinder
{
    /**
     * Find the row by name value
     *
     * Find the record based on the field name against the value
     *
     * @param bool $includeTrashed Does  it need to include the softdeteled
     * @param string $value The Value of the Column
     * @return $this
     * @throws conditon
     **/
    public static function findByname(string $value ,$includeTrashed = false)
    {
        if ($includeTrashed === false) {
            return self::findByColumn('name', $value);
        }
        return self::findByColumnWithTrashed('name', $value);
    }

    /**
     * Find or fail the row by name value
     *
     * Find the record based on the field name against the value
     *
     * @param bool $includeTrashed Does  it need to include the softdeteled
     * @param string $value The Value of the Column
     * @return $this
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     **/
    public static function findOrFailByname(string $value, $includeTrashed = false)
    {
        if ($includeTrashed === false) {
            return self:: findOrFailByColumn('name', $value);
        }
        return self:: findOrFailByColumnWithTrashed('name', $value);
    }

    /**
     * Find the row by name value
     *
     * Find the record based on the field name against the value
     *
     * @param bool $includeTrashed Does  it need to include the softdeteled
     * @param string $value The Value of the Column
     * @return $this
     * @throws conditon
     **/
    public static function findByemail(string $value ,$includeTrashed = false)
    {
        if ($includeTrashed === false) {
            return self::findByColumn('email', $value);
        }
        return self::findByColumnWithTrashed('email', $value);
    }

    /**
     * Find or fail the row by name value
     *
     * Find the record based on the field name against the value
     *
     * @param bool $includeTrashed Does  it need to include the softdeteled
     * @param string $value The Value of the Column
     * @return $this
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     **/
    public static function findOrFailByemail(string $value, $includeTrashed = false)
    {
        if ($includeTrashed === false) {
            return self:: findOrFailByColumn('email', $value);
        }
        return self:: findOrFailByColumnWithTrashed('email', $value);
    }

}
