<?php
namespace FLA\Core\Util;

use Illuminate\Support\Facades\Schema;

/**
 * Class ModelUtil
 * @package FLA\Core\Util
 *
 * @author Congky, 2018-05-10
 */
class ModelUtil
{
    public static function convertArrayToModel($inputArray, $model) {
        foreach ($inputArray as $key => $value) {
            $key = GeneralUtil::camelCaseToUnderscore($key);
            if (Schema::hasColumn($model->getTable(), $key)){
                $model->$key = $value;
            }
        }

        return $model;
    }
}