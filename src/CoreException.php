<?php
namespace FLA\Core;

use Exception;
use FLA\Core\Util\GeneralUtil;

/**
 * Class CoreException
 * @package FLA\Core
 *
 * @author Congky, 2018-05-10
 */
class CoreException extends Exception
{

    private $errorCode;
    private $errorType;
    private $errorMessage;

    public function __construct($code, $type, $message, ...$args) {
        $this->errorCode = is_numeric($code) ? $code : 0;
        $this->errorType = $type;
        $this->errorMessage = GeneralUtil::generateMessage($message, $args);
        return $this;
    }

    public function getErrorCode() {
        return $this->errorCode;
    }

    public function getErrorType() {
        return $this->errorType;
    }

    public function getErrorMessage() {
        return $this->errorMessage;
    }
}