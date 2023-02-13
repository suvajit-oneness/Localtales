<?php

namespace App\Contracts;

/**
 * Interface SettingsContract
 * @package App\Contracts
 */
interface SettingsContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listAll(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function listById(int $id);

    /**
     * @param array $params
     * @return mixed
     */

    public function updateSettings(array $data);

    // /**
    //  * @param $id
    //  * @return bool
    //  */
    // public function deletesettings($id);

    //  /**
    //  * @param $id
    //  * @return mixed
    //  */
    // public function detailsSettings($id);

    public function updateStatus(array $params);

}
