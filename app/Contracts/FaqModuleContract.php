<?php

namespace App\Contracts;

/**
 * Interface AboutContract
 * @package App\Contracts
 */
interface FaqModuleContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listfaq(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findfaqById(int $id);



    /**
     * @param array $params
     * @return mixed
     */
    public function updatefaq(array $params);



     /**
     * @param $id
     * @return mixed
     */
    public function detailsfaq($id);



}
