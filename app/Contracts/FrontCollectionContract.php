<?php

namespace App\Contracts;

/**
 * Interface FrontCollectionContract
 * @package App\Contracts
 */
interface FrontCollectionContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listsfrontcollection(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findfrontcollectionById(int $id);



    /**
     * @param array $params
     * @return mixed
     */
    public function updatefrontcollection(array $params);



     /**
     * @param $id
     * @return mixed
     */
    public function detailsfrontcollection($id);



}
