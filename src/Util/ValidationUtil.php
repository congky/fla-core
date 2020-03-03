<?php
namespace FLA\Core\Util;

use DateTime;
use FLA\Core\CoreException;
use FLA\Core\GeneralConstant;
use FLA\Core\GeneralExceptionConstant;

/**
 * Class ValidationUtil
 * @package FLA\Core\Util
 *
 * @author Congky, 2018-05-10
 */
class ValidationUtil
{

    public static function dateValidation($format, $arrayDate, $key){
        $date = $arrayDate[$key];
        if(!empty($date)) {
            $d = DateTime::createFromFormat($format, $date);
            if($d && $d->format($format) === $date) {
            } else {
                throw new CoreException(GeneralConstant::ERROR_CODE_DEFAULT,GeneralConstant::ERROR_TYPE_DEFAULT, GeneralExceptionConstant::INVALID_FORMAT_KEY_DATE, $format, $key);
            };
        }
    }

    public static function dateValidationList($format, $list, ...$keys){

        $invalidKey = "";
        foreach ($keys as $value) {
            $date = $list[$value];
            if(!empty($date)) {
                $d = DateTime::createFromFormat($format, $date);
                if($d && $d->format($format) === $date) {
                } else {
                    $invalidKey = $invalidKey.$value.", ";
                };
            }
        }

        $invalidKey = substr($invalidKey, 0, -2);
        if(!empty($invalidKey)){
            throw new CoreException(GeneralConstant::ERROR_CODE_DEFAULT,GeneralConstant::ERROR_TYPE_DEFAULT, GeneralExceptionConstant::INVALID_FORMAT_KEY_DATE, $format, $invalidKey);
        }
    }

    public static function valTime($request, $key, $format="His")
    {
        self::valContainsKey($request, $key);
        self::dateValidation($format, $request, $key);
    }

    public static function valDate($request, $key)
    {
        self::valContainsKey($request, $key);
        self::dateValidation("Ymd", $request, $key);
    }

    public static function valDates($request, ...$keys)
    {
        self::valContainsKeys($request, ...$keys);
        self::dateValidationList("Ymd", $request, ...$keys);

    }

    public static function valDatetime($request, $key)
    {
        self::valContainsKey($request, $key);
        self::dateValidation("YmdHis", $request, $key);
    }

    public static function valDatetimes($request, ...$keys)
    {
        self::valContainsKeys($request, ...$keys);
        self::dateValidationList("YmdHis", $request, ...$keys);
    }

    public static function valContainsKey($request, $key){
        if (!array_key_exists($key, $request)){
            throw new CoreException(GeneralConstant::ERROR_CODE_DEFAULT,GeneralConstant::ERROR_TYPE_DEFAULT, GeneralExceptionConstant::KEY_NOT_FOUND, $key);
        }
    }

    public static function valContainsKeys($request, ...$keys){

        $invalidKey = "";
        foreach ($keys as $value) {
            if (!array_key_exists($value, $request)){
                $invalidKey = $invalidKey.$value.", ";
            }
        }

        $invalidKey = substr($invalidKey, 0, -2);
        if(!empty($invalidKey)){
            throw new CoreException(GeneralConstant::ERROR_CODE_DEFAULT,GeneralConstant::ERROR_TYPE_DEFAULT, GeneralExceptionConstant::KEY_NOT_FOUND, $invalidKey);
        }

    }

    public static function valBlankOrNull($request, $key){
        self::valContainsKey($request, $key);
        if(($request[$key]===NULL || empty($request[$key]) && (string) $request[$key] <> '0')) {
            throw new CoreException(GeneralConstant::ERROR_CODE_DEFAULT,GeneralConstant::ERROR_TYPE_DEFAULT, GeneralExceptionConstant::REQUIRED_FIELD, $key);
        }
    }

    public static function valBlankOrNulls($request, ...$keys){

        self::valContainsKeys($request, ...$keys);
        $invalidKey = "";
        foreach ($keys as $value) {
            if(($request[$value]===NULL || empty($request[$value])) && (string) $request[$value] <> '0') {
                $invalidKey = $invalidKey.$value.", ";
            }
        }
        $invalidKey = substr($invalidKey, 0, -2);
        if(!empty($invalidKey)){
            throw new CoreException(GeneralConstant::ERROR_CODE_DEFAULT,GeneralConstant::ERROR_TYPE_DEFAULT, GeneralExceptionConstant::REQUIRED_FIELD, $invalidKey);
        }
    }

    public static function valNumeric($request, $key) {
        self::valContainsKey($request, $key);
        if(!is_numeric($request[$key])) {
            throw new CoreException(GeneralConstant::ERROR_CODE_DEFAULT,GeneralConstant::ERROR_TYPE_DEFAULT, GeneralExceptionConstant::VALUE_MUST_BE_NUMERIC, $key);
        }
    }

    public static function valNumerics($request, ...$keys) {
        self::valContainsKeys($request, ...$keys);
        $invalidKey = "";
        foreach ($keys as $value) {
            if(!is_numeric($request[$value])) {
                $invalidKey = $invalidKey.$value.", ";
            }
        }
        $invalidKey = substr($invalidKey, 0, -2);
        if(!empty($invalidKey)){
            throw new CoreException(GeneralConstant::ERROR_CODE_DEFAULT,GeneralConstant::ERROR_TYPE_DEFAULT, GeneralExceptionConstant::VALUE_MUST_BE_NUMERIC, $invalidKey);
        }
    }

    public static function valInputFile($request, $key){
        if(is_null($request->file($key))){
            throw new CoreException(GeneralConstant::ERROR_CODE_DEFAULT,GeneralConstant::ERROR_TYPE_DEFAULT, GeneralExceptionConstant::INVALID_FILE_INPUT, $key);
        }
    }

    public static function valImageExtension($request, $key){
        self::valInputFile($request, $key);

        $file = $request->file($key);
        if(!in_array($file->extension(), GeneralConstant::VALID_IMAGES_EXTENSION)) {
            throw new CoreException(GeneralConstant::ERROR_CODE_DEFAULT,GeneralConstant::ERROR_TYPE_DEFAULT, GeneralExceptionConstant::UNSUPPORTED_IMAGE_EXTENSION, $file->extension());
        }

    }

    public static function isValidPassword($passExpected, $passReality){

        if(GeneralConstant::ENCRYPT_TYPE_MD5==env("ENCRYPT_TYPE")){
            return md5($passExpected) == $passReality;
        } else {
            return password_verify($passExpected, $passReality);
        }

    }

    public static function valTokenBlankOrNull($token){
        if(is_null($token)||empty($token)) {
            throw new CoreException(401, GeneralConstant::ERROR_TYPE_DEFAULT, GeneralExceptionConstant::YOU_DO_NOT_HAVE_PERMISSION);
        }
    }

    public static function valNewPassword($newPassword){
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/', $newPassword)) {
            throw new CoreException(GeneralConstant::ERROR_CODE_DEFAULT, GeneralConstant::ERROR_TYPE_DEFAULT, GeneralExceptionConstant::INVALID_PASSWORD_CAUSE_PREG_MATCH);
        }
    }

}