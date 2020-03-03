<?php
namespace FLA\Core;

use FLA\Core\Util\GeneralUtil;

/**
 * Class ErrorListBuilder
 * @package FLA\Core
 *
 * @author Congky, 2019-03-03
 */
class ErrorListBuilder
{
    private $errorList = [];

    public function __construct() {
        return $this;
    }

    public function add($key, $message, ...$args) {
        $message = GeneralUtil::generateMessage($message, $args);
        $this->errorList[$key] = $message;

        return $this;
    }

    public function getErrorList() {
        return $this->errorList;
    }

}