<?php

namespace App\Contracts;

/**
 * Interface AboutContract
 * @package App\Contracts
 */
interface ContactContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listcontactus(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findcontactById(int $id);



    /**
     * @param array $params
     * @return mixed
     */
    public function updatecontact(array $params);



     /**
     * @param $id
     * @return mixed
     */
    public function detailscontact($id);



}
