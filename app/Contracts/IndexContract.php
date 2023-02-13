<?php

namespace App\Contracts;

/**
 * Interface IndexContract
 * @package App\Contracts
 */
interface IndexContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listsplash(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findsplashById(int $id);



    /**
     * @param array $params
     * @return mixed
     */
    public function updatesplash(array $params);



     /**
     * @param $id
     * @return mixed
     */
    public function detailssplash($id);



}
