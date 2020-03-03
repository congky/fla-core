<?php
namespace FLA\Core\Util;

use FLA\Core\GeneralConstant;

/**
 * Class ResponseUtil
 * @package FLA\Core\Util
 *
 * @author Congky, 2018-05-10
 */
class ResponseUtil
{
    public static function resultObject($object) {

        $data = $object->getData();

        return $data->response;
    }

    public static function isOk($response) {

        return response()->json([
            "code" => GeneralConstant::SUCCESS_CODE_DEFAULT,
            "status" => GeneralConstant::OK,
            "response" => $response
        ]);

    }

    public static function isFail($ex) {

        return response()->json([
            "code" => $ex->getErrorCode(),
            "errorType" => $ex->getErrorType(),
            "status" => GeneralConstant::FAIL,
            "message" => $ex->getErrorMessage()
        ]);

    }

    public static function isUnauthorized($ex) {

        return response()->json([
            "code" => $ex->getErrorCode(),
            "errorType" => $ex->getErrorType(),
            "status" => GeneralConstant::UNAUTHORIZED,
            "message" => $ex->getErrorMessage()
        ]);

    }
}