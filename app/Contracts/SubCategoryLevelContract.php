<?php

namespace App\Contracts;

/**
 * Interface SubCategoryLevelContract
 * @package App\Contracts
 */
interface SubCategoryLevelContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listSubCategoryLevel(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findSubCategoryLevelById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createSubCategoryLevel(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSubCategoryLevel(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteSubCategoryLevel($id);

     /**
     * @param $id
     * @return mixed
     */
    public function detailsSubCategoryLevel($id);

    /**
     * @param $id
     * @return mixed
     */
    public function updateSubCategoryLevelStatus(array $params);


    /**
     *
     * @return mixed
     */
    public function getSubCategory();
    public function getSearchSubcategorylevel(string $term);


}
