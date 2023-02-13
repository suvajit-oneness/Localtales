<?php

namespace App\Contracts;

/**
 * Interface BussinessLeadContract
 * @package App\Contracts
 */
interface AdvocateRegistrationContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listRegistration(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findRegistrationById(int $id);


    /**
     * @param $id
     * @return mixed
     */
    public function detailsRegistration($id);
    public function getSearchRegistration(string $term);
}
