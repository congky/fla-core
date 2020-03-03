<?php
namespace FLA\Core;

use FLA\Core\Util\DateUtil;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class AbstractBusinessTransaction
 * @package FLA\Core
 *
 * @author Congky, 2018-05-10
 */
abstract class AbstractBusinessTransaction implements BusinessObject
{

    abstract protected function prepare(&$input, $oriInput);
    abstract protected function process(&$input, $oriInput);

    public function execute($input) {

        $oriInput = $input;

        try {
            DB::beginTransaction();

            $this->prepare($input, $oriInput);
            $result = $this->process($input, $oriInput);

            DB::commit();
            return $result;

        }
        catch (CoreException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (Exception $e) {
            DB::rollBack();
            throw new CoreException($e->getCode(), GeneralConstant::ERROR_TYPE_DEFAULT, $e->getMessage());
        }
    }

    protected function prepareInsertActive(&$input) {
        $input['active'] = GeneralConstant::YES;
        $input['activeDatetime'] = DateUtil::currentDatetime();
        $input['nonActiveDatetime'] = GeneralConstant::EMPTY_VALUE;
    }

    protected function prepareInsertNonactive(&$input) {
        $input['active'] = GeneralConstant::NO;
        $input['nonActiveDatetime'] = DateUtil::currentDatetime();
        $input['activeDatetime'] = GeneralConstant::EMPTY_VALUE;
    }

    protected function prepareUpdateActive(&$input) {
        $input['active'] = GeneralConstant::YES;
        $input['activeDatetime'] = DateUtil::currentDatetime();
        $input['nonActiveDatetime'] = GeneralConstant::EMPTY_VALUE;
    }

    protected function prepareUpdateNonactive(&$input) {
        $input['active'] = GeneralConstant::NO;
        $input['nonActiveDatetime'] = DateUtil::currentDatetime();
    }

}