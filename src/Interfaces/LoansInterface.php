<?php
namespace App\Interfaces;


interface LoansInterface
{


    /**
     * @param  array $params
     * @param  $id
     * @return mixed
     */
    public function addEdit(array $params, $id);


    /**
     * @param  integer $id
     * @return mixed
     */
    public function delete(int $id);


    /**
     * @param  integer $id
     * @return mixed
     */
    public function show(int $id);


    /**
     * @param  array $params
     * @return mixed
     */
    public function list(array $params);


}//end interface
