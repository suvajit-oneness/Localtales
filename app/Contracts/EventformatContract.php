<?php

namespace App\Contracts;

/**
 * Interface EventformatContract
 * @package App\Contracts
 */
interface EventformatContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listEventformats(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findEventformatById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createEventformat(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateEventformat(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteEventformat($id);
}