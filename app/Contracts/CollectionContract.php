<?php

namespace App\Contracts;

/**
 * Interface CollectionContract
 * @package App\Contracts
 */
interface CollectionContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCollection(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findCollectionById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createCollection(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCollection(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCollection($id);

     /**
     * @param $id
     * @return mixed
     */
    public function detailsCollection($id);

    /**
     * @param $id
     * @return mixed
     */
    public function updateCollectionStatus(array $params);


    public function getAllSuburb();
    public function getSearchCollection(string $term);
    
    
     /**
     * @param $pinCode
     * @param $keyword
     * @return mixed
     */
    
    
    public function searchCollectionData($pinCode,$keyword,$suburb,$category);
}
