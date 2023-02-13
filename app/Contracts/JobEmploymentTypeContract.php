<?php

namespace App\Contracts;

/**
 * Interface JobEmploymentTypeContract
 * @package App\Contracts
 */
interface JobEmploymentTypeContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listType(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findTypeById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createType(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateType(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteType($id);

     /**
     * @param $id
     * @return mixed
     */
    public function detailsType($id);

    public function updateTypeStatus(array $params);
    public function getSearchType(string $term);

}
