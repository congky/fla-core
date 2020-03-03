<?php
namespace FLA\Core;

use Illuminate\Support\Facades\DB;

/**
 * Class NativeQuery
 * @package FLA\Core
 *
 * @author Cong, 2018-08-03
 * Digunakan untuk melakukan sebuah query menggunakan native query (tanpa menggunakan eloquent laravel)
 * Query ini menggunakan DB::select() yang telah disediakan oleh laravel
 */
class NativeQuery
{

    private $query = "";
    private $params = [];

    public function __construct(string $query) {
        $this->query = $query;
        return $this;
    }

    public function setParameters(array $params){
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function setParameter(string $key, $value){
        $this->params[$key] = $value;
        return $this;
    }

    public function setParameterIfNotNull($condition, string $key, $value){
        if(!is_null($condition) && $condition !== NULL) {
            $this->params[$key] = $value;
        }
        return $this;
    }

    public function setParameterIfNull($condition, string $key, $value){
        if(is_null($condition) || $condition === NULL) {
            $this->params[$key] = $value;
        }
        return $this;
    }

    public function setParameterIfNotEmpty($condition, string $key, $value){
        if(!is_null($condition) && $condition !== GeneralConstant::EMPTY_VALUE) {
            $this->params[$key] = $value;
        }
        return $this;
    }

    public function setParameterIfEmpty($condition, string $key, $value){
        if(!is_null($condition) && $condition === GeneralConstant::EMPTY_VALUE) {
            $this->params[$key] = $value;
        }
        return $this;
    }

    public function getSingleResult(){
        $result = DB::select($this->query, $this->params);

        if(!is_null($result) && !empty($result)) {
            return $result[0];
        }

        return [];
    }

    public function getResultList(){
        $result = DB::select($this->query, $this->params);
        return $result;
    }

    public function process(){
        DB::select($this->query, $this->params);
    }

}