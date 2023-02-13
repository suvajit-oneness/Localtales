<?php

namespace App\Contracts;

/**
 * Interface StateContract
 * @package App\Contracts
 */
interface DemoImageContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    
    /**
     * @param int $id
     * @return mixed
     */
    public function findDemoImageById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createDemoImage(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateDemoImage(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteDemoImage($id);

    
}
