<?php

namespace App\Contracts;

/**
 * Interface StateContract
 * @package App\Contracts
 */
interface SuburbContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listSuburb(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findSuburbById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createSuburb(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSuburb(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteSuburb($id);

     /**
     * @param $id
     * @return mixed
     */
    public function detailsSuburb($id);

    /**
     * @param $id
     * @return mixed
     */
    public function updateSuburbStatus(array $params);



    public function getAllpincode();
    public function getSearchSuburb(string $term);
    public function searchSuburb($pinCode);
}
