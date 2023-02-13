<?php

namespace App\Contracts;

/**
 * Interface SearchContract
 * @package App\Contracts
 */
interface SearchContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function index(array $data);



}
