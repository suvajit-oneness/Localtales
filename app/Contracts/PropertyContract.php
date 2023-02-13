<?php

namespace App\Contracts;

/**
 * Interface PropertyContract
 * @package App\Contracts
 */
interface PropertyContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listProperties(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findPropertyById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createProperty(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateProperty(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteProperty($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsProperty($id);
}