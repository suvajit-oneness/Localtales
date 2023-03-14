<?php

namespace App\Contracts;

/**
 * Interface DoctorContract
 * @package App\Contracts
 */
interface DoctorContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listDoctor(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findDoctorById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createDoctor(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateDoctor(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteDoctor($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsDoctor($id);

    /**
     * @param $term
     * @return mixed
     */
    public function getSearchDoctor($term);
}