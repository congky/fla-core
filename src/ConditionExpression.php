<?php
namespace FLA\Core;

/**
 * Class ConditionExpression
 * @package FLA\Core
 *
 * @author Cong, 2018-05-10
 * Untuk membantu mempermudah penulisan suatu kondisi pada suatu query
 */
class ConditionExpression
{

    /**
     * @param string $column (column name)
     * @param string $value (string value)
     * @return string
     *
     * Membuat filter Like (case sensitive) pada suatu query, ex :
     * AKU LIKE '%KU%' is true
     * AKU LIKE '%ku%' is false
     * AKU LIKE '%Aku%' is false
     */
    public static function likeCaseSensitive(string $column, string $value){
        return $column." LIKE '%".$value."%' ";
    }

    /**
     * @param string $column (column name)
     * @param string $value (string value)
     * @return string
     *
     * Membuat filter Like (case insensitive) pada suatu query, ex :
     * AKU LIKE '%KU%' is true
     * AKU LIKE '%ku%' is true
     * AKU LIKE '%Aku%' is true
     */
    public static function likeCaseInsensitive(string $column, string $value){
        return " UPPER(".$column.") LIKE '%".strtoupper($value)."%' ";
    }

    /**
     * @param string $column (column name)
     * @param string $value (string value)
     * @return string
     *
     * Membuat filter equals (case sensitive) pada suat query, ex :
     * AKU = AKU is true
     * AKU = KU is false
     * AKU = Aku is false
     */
    public static function equalCaseSensitive(string $column, string $value){
        return $column." = '".$value."'";
    }

    /**
     * @param string $column (column name)
     * @param string $value (string value)
     * @return string
     *
     * Membuat filter equals (case insensitive) pada suatu query, ex :
     * AKU = AKU is true
     * AKU = KU is false
     * AKU = Aku is true
     */
    public static function equalCaseInsensitive(string $column, string $value){
        return " UPPER(".$column.") = UPPER('".$value."') ";
    }

    /**
     * @param string $column (column name)
     * @param string $value (string value)
     * @return string
     *
     * Membuat filter not equals (case sensitive) pada suqtu query, ex :
     * AKU != AKU is false
     * AKU != KU is true
     * AKU != Aku is true
     */
    public static function notEqualCaseSensitive(string $column, string $value){
        return $column." != '".$value."'";
    }


    /**
     * @param string $column (column name)
     * @param string $value (string value)
     * @return string
     *
     * Membuat filter not equals (case insensitive) pada suqtu query, ex :
     * AKU != AKU is false
     * AKU != KU is true
     * AKU != Aku is false
     */
    public static function notEqualCaseInsensitive(string $column, string $value){
        return " UPPER(".$column.") != UPPER('".$value."') ";
    }

    /**
     * @param string $column (column name)
     * @param mixed ...$valueList (value ex : a, b, c, etc..)
     * @return string
     *
     * Membuat filter IN (case sensitive) pada suatu query, ex :
     *
     * AKU IN (aku, ku) is false
     * AKU IN (AKU, KU) is true
     * AKU IN (AK, KU) is false
     *
     */
    public static function inCaseSensitive(string $column, ...$valueList){

        $values = "";
        foreach($valueList as $value) {
            $values .= "'".$value."',";
        }
        $values = substr($values, 0, -1);

        return $column." IN (".$values.") ";
    }

    /**
     * @param string $column (column name)
     * @param mixed ...$valueList (value ex : a, b, c, etc..)
     * @return string
     *
     * Membuat filter IN (case insensitive) pada suatu query, ex :
     *
     * AKU IN (aku, ku) is true
     * AKU IN (AKU, KU) is true
     * AKU IN (AK, KU) is false
     *
     */
    public static function inCaseInsensitive(string $column, ...$valueList){

        $values = "";
        foreach($valueList as $value) {
            $values .= "'".$value."',";
        }
        $values = strtoupper(substr($values, 0, -1));

        return " UPPER(".$column.") IN (".$values.") ";
    }

    /**
     * @param string $column (column name)
     * @param array $valueList (array value, ex : [a, b, c, etc..])
     * @return string
     *
     * Membuat filter IN (case sensitive) pada suatu query, ex :
     *
     * AKU IN (aku, ku) is false
     * AKU IN (AKU, KU) is true
     * AKU IN (AK, KU) is false
     */
    public static function inListCaseSensitive(string $column, array $valueList){

        $values = "";
        foreach($valueList as $value) {
            $values .= "'".ltrim(rtrim($value))."',";
        }
        $values = substr($values, 0, -1);

        return $column." IN (".$values.") ";
    }

    /**
     * @param string $column (column name)
     * @param array $valueList (array value, ex : [a, b, c, etc..])
     * @return string
     *
     * Membuat filter IN (case insensitive) pada suatu query, ex :
     *
     * AKU IN (aku, ku) is true
     * AKU IN (AKU, KU) is true
     * AKU IN (AK, KU) is false
     */
    public static function inListCaseInsensitive(string $column, array $valueList){

        $values = "";
        foreach($valueList as $value) {
            $values .= "'".ltrim(rtrim($value))."',";
        }
        $values = strtoupper(substr($values, 0, -1));

        return " UPPER(".$column.") IN (".$values.") ";
    }

    /**
     * @param string $column (column name)
     * @param string $value (string value, ex : "'a','b','c', etc...")
     * @return string
     *
     * Membuat filter IN (case sensitive) pada suatu query, ex :
     *
     * AKU IN (aku, ku) is false
     * AKU IN (AKU, KU) is true
     * AKU IN (AK, KU) is false
     */
    public static function inStringCaseSensitive(string $column, string $value){
        return $column." IN (".$value.") ";
    }

    /**
     * @param string $column (column name)
     * @param string $value (string value, ex : "'a','b','c', etc...")
     * @return string
     *
     * Membuat filter IN (case insensitive) pada suatu query, ex :
     *
     * AKU IN (aku, ku) is true
     * AKU IN (AKU, KU) is true
     * AKU IN (AK, KU) is false
     */
    public static function inStringCaseInsensitive(string $column, string $value){
        return " UPPER(".$column.") IN (".strtoupper($value).") ";
    }

}