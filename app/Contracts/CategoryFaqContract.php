<?php

namespace App\Contracts;

/**
 * Interface BlogContract
 * @package App\Contracts
 */
interface CategoryFaqContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listFaqs(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findFaqById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createFaq(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateFaq(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteFaq($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsFaq($id);
    public function updateFaqStatus(array $params);




}

