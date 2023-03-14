<?php

namespace App\Contracts;

/**
 * Interface SchoolContract
 * @package App\Contracts
 */
interface SchoolContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listSchool(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findSchoolById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createSchool(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSchool(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteSchool($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsSchool($id);

    /**
     * @param $term
     * @return mixed
     */
    public function getSearchSchool($term);
}