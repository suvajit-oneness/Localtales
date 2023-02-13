<?php

namespace App\Contracts;

/**
 * Interface FaqContract
 * @package App\Contracts
 */
interface FaqContract
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
    public function createfaq(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updatefaq(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deletefaq($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsfaq($id);



    /**
     * @param $id
     * @return mixed
     */
    public function updatefaqStatus(array $params);
}
