<?php
namespace FLA\Core\Util;

use Faker\Provider\Uuid;

/**
 * Class GeneralUtil
 * @package FLA\Core\Util
 *
 * @author Congky, 2018-05-10
 */
class GeneralUtil
{
    public static function camelCaseToUnderscore($camelCase) {
        return strtolower(preg_replace('/(?<=\w)(?=[A-Z])/',"_$1", $camelCase));
    }

    public static function generateToken($user, $datetimeNow) {
        return "FLA-".md5(uniqid($user."_".rand()."_".$datetimeNow, true))."-".Uuid::uuid();
    }

    public static function getDefine(string $define, string $default = "") {
        if (defined($define)){
            return constant($define);
        } else {
            return $default;
        }
    }

    public static function setDefine(string $key, string $value = "") {
        if (!defined($key)) define($key,$value);
    }

    public static function generateMessage($message, $paramMsgList) {
        if (is_string($message)) {
            for ($i = 0; $i < count($paramMsgList); $i++) {
                $message = str_replace('{' . $i . '}', $paramMsgList[$i], $message);
            }
        }
        return $message;
    }
}