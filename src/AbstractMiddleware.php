<?php
namespace FLA\Core\Middleware;

use Exception;
use Closure;
use FLA\Core\GeneralConstant;
use FLA\Core\Util\DateUtil;
use FLA\Core\Util\ResponseUtil;

/**
 * Class AbstractMiddleware
 * @package FLA\Core\Middleware
 *
 * @author Congky, 2018-05-10
 */
abstract class AbstractMiddleware
{
    abstract protected function beforeRequest($request);
    abstract protected function afterRequest($request, &$response);

    public function handle($request, Closure $next)
    {

        try {

            $_headers["FLA-TOKEN"] = $request->header("FLA-TOKEN", "");
            $_headers["currentDatetime"] = DateUtil::currentDatetime();
            $_headers["currentDate"] = DateUtil::currentDate();

            $request["_headers"] = $_headers;

            // handle before request here
            $resultBefore = $this->beforeRequest($request);
            if($resultBefore!=null && $resultBefore!=GeneralConstant::EMPTY_VALUE) {
                return $resultBefore;
            }

            // on request
            $response = $next($request);
            $responseContent = json_decode($response->getContent());

            if(property_exists($responseContent, "status")) {
                $request["status"] = $responseContent->status;
            } else {
                $request["status"] = GeneralConstant::FAIL;
            }

            // handle after request here
            $resultAfter = $this->afterRequest($request, $response);
            if($resultAfter!=null && $resultAfter!=GeneralConstant::EMPTY_VALUE) {
                return $resultAfter;
            }

            return $response;

        } catch (Exception $e) {
            return ResponseUtil::isUnauthorized($e);
        }
    }
}