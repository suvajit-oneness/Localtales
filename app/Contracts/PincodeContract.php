<?php

namespace App\Contracts;

/**
 * Interface StateContract
 * @package App\Contracts
 */
interface PincodeContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listPincode(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findPincodeById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createPincode(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePincode(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deletePincode($id);

     /**
     * @param $id
     * @return mixed
     */
    public function detailsPincode($id);

    /**
     * @param $id
     * @return mixed
     */
    public function updatePincodeStatus(array $params);


    public function getAllState();
    public function getSearchpin(string $term);
    
    
    public function searchPostcodeData($stateId,$keyword);
    public function searchSuburbData($postcode, $keyword,$suburbData);
    public function help(array $params);
}
