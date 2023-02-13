<?php

namespace App\Contracts;

/**
 * Interface AboutContract
 * @package App\Contracts
 */
interface AboutContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listaboutus(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findaboutById(int $id);

   

    /**
     * @param array $params
     * @return mixed
     */
    public function updateabout(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteabout($id);

     /**
     * @param $id
     * @return mixed
     */
    public function detailsabout($id);

    public function updateaboutStatus(array $params);

}
