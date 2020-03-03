<?php
namespace FLA\Core;

/**
 * Class QueryBuilder
 * @package FLA\Core
 *
 * @author Cong, 2018-05-10
 * Digunakan untuk melakukan penggabungan dari beberapa string menjadi sebuah query
 */
class QueryBuilder
{

    private $query;

    public function __construct() {
        $this->query = "";
    }

    /**
     * @param string $query
     * @return $this
     *
     * Menggabungkan string $query menjadi sebuah query
     */
    public function add(string $query){
        $this->query .= $query;
        return $this;
    }

    /**
     * @param string $string
     * @param string $query
     * @return $this
     *
     * Menggabungkan string $query menjadi sebuah query, jika $string tidak kosong/null
     */
    public function addIfNotEmpty(string $string, string $query){
        if($string!=NULL&&$string!='') {
            $this->query .= $query;
        }
        return $this;
    }

    /**
     * @param string $string
     * @param string $query
     * @return $this
     *
     * Menggabungkan string $query menjadi sebuah query, jika $string kosong/null
     */
    public function addIfEmpty(string $string, string $query){
        if($string==NULL||$string=='') {
            $this->query .= $query;
        }
        return $this;
    }

    /**
     * @param $any
     * @param $comparison
     * @param string $query
     * @return $this
     *
     * Menggabungkan string $query menjadi sebuah query, jika $comparison tidak sama dengan $any
     */
    public function addIfNotEquals($any, $comparison, string $query){
        if($comparison!=$any) {
            $this->query .= $query;
        }
        return $this;
    }

    /**
     * @param $any
     * @param $comparison
     * @param string $query
     * @return $this
     *
     * Menggabungkan string $query menjadi sebuah query, jika $comparison sama dengan $any
     */
    public function addIfEquals($any, $comparison, string $query){
        if($comparison==$any) {
            $this->query .= $query;
        }
        return $this;
    }

    /**
     * @param boolean $boolean
     * @param string $query
     * @return $this
     *
     * Menggabungkan string $query menjadi sebuah query, jika $boolean yang dikirim bernilai true
     */
    public function addIfTrue(boolean $boolean, string $query){
        if($boolean) {
            $this->query .= $query;
        }
        return $this;
    }

    /**
     * @param boolean $boolean
     * @param string $query
     * @return $this
     *
     * Menggabungkan string $query menjadi sebuah query, jika $boolean yang dikirim bernilai false
     */
    public function addIfFalse(boolean $boolean, string $query){
        if(!$boolean) {
            $this->query .= $query;
        }
        return $this;
    }

    /**
     * @return string
     *
     * Untuk mengambil hasil penggabungan string menjadi sebuah query
     */
    public function toString(){
        return $this->query;
    }

}