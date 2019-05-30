<?php

namespace App\Models\Finders;

/**
 * Handels all the comman finders of the application
 */
trait BaseFinder
{
    /**
     * Find the row by field value
     *
     * Find the record based on the field name against the value
     *
     * @param string $column The Column name of the model
     * @param string $value The Value of the Column
     * @return $this
     * @throws conditon
     **/
    public static function findByColumn(string $columnName, string $value)
    {
        return self::where($columnName, $value)
                ->first();
    }

    /**
     * Find the row by field value
     *
     * Find the record based on the field name against the value
     * If the record is not found it will abort with 404
     *
     * @param string $column The Column name of the model
     * @param string $value The Value of the Column
     * @return $this
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     **/
    public static function findOrFailByColumn(string $columnName, string $value)
    {
        return self::where($columnName, $value)
                ->firstOrFail();
    }

    /**
     * Find the row by field value
     *
     * Find the record based on the field name against the value
     * including soft deleted Models
     *
     * @param string $column The Column name of the model
     * @param string $value The Value of the Column
     * @return $this
     * @throws conditon
     **/
    public static function findByColumnWithTrashed(string $columnName, string $value)
    {
        return self::withTrashed()
                ->where($columnName, $value)
                ->first();
    }

    /**
     * Find the row by field value
     *
     * Find the record based on the field name against the value including soft deleted Models
     * If the record is not found it will abort with 404
     *
     * @param string $column The Column name of the model
     * @param string $value The Value of the Column
     * @return $this
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     **/
    public static function findOrFailByColumnWithTrashed(string $columnName, string $value)
    {
        return self::withTrashed()
                ->where($columnName, $value)
                ->firstOrFail();
    }
}
