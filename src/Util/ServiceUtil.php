<?php
namespace FLA\Core\Util;

use Illuminate\Support\Facades\App;

/**
 * Class ServiceUtil
 * @package FLA\Core\Util
 *
 * @author Congky, 2019-02-10
 */
class ServiceUtil
{
    public static function call(string $serviceName, $params=[]) {
        $service = App::make($serviceName);
        return $service->execute($params);
    }
}