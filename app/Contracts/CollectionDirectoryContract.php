<?php

namespace App\Contracts;

/**
 * Interface CollectionContract
 * @package App\Contracts
 */
interface CollectionDirectoryContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCollectionDirectory(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findCollectionDirectoryById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createCollectionDirectory(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCollectionDirectory(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCollectionDirectory($id);

     /**
     * @param $id
     * @return mixed
     */
    public function detailsCollectionDirectory($id);

    /**
     * @param $id
     * @return mixed
     */
    public function updateCollectionDirectoryStatus(array $params);


    public function getAllCollection();
    public function getAllDirectory();
    
    
  public function getSearchDirectory($keyword);
}
