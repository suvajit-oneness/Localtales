<?php

namespace App\Contracts;

/**
 * Interface DirectoryCategoryContract
 * @package App\Contracts
 */
interface DirectoryCategoryContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listdirectoryCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function finddirectoryCategoryById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createdirectoryCategory(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updatedirectoryCategory(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deletedirectoryCategory($id);

     /**
     * @param $id
     * @return mixed
     */
    public function detailsdirectoryCategory($id);

    public function updatedirectoryCatStatus(array $params);
    public function getSearchCategory(string $term);
}
