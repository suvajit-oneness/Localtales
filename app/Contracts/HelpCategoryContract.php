<?php

namespace App\Contracts;

/**
 * Interface BlogCategoryContract
 * @package App\Contracts
 */
interface HelpCategoryContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findCategoryById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createCategory(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCategory(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCategory($id);

     /**
     * @param $id
     * @return mixed
     */
    public function detailsCategory($id);



    public function getSearchCategories(string $term);
    public function getSearchSubCategories(string $term);
}
