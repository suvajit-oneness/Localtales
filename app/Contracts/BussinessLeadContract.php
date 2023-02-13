<?php

namespace App\Contracts;

/**
 * Interface BussinessLeadContract
 * @package App\Contracts
 */
interface BussinessLeadContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBusinesssLead(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findBusinessLeadById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createLeadBusiness(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateLeadBusiness(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteLeadBusiness($id);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBusinessLeadStatus(array $params);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsBusinessLead($id);
    public function getSearchBussiness(string $term);
    public function getSearchBussinesscouncil(string $term);
}

//     /**
//      * @param $pinCode
//      * @return mixed
//      */
//     public function getBusinessByPinCode($pinCode);

//     /**
//      * @param $pinCode
//      * @return mixed
//      */
//     public function getTrendingBusinessByPinCode($pinCode);

//     /**
//      * @param $pinCode
//      * @param $categoryId
//      * @return mixed
//      */
//     public function getBusinessByCategory($pinCode,$categoryId);

//     /**
//      * @param business_id
//      * @param user_id
//      * @return Userbusiness|mixed
//      */
//     public function saveUserBusiness($business_id,$user_id);

//     /**
//      * @param business_id
//      * @param user_id
//      * @return bool
//      */
//     public function deleteUserBusiness($business_id,$user_id);

//     /**
//      * @param $user_id
//      * @return mixed
//      */
//     public function UserBusinesses($user_id);

//     /**
//      * @param business_id
//      * @param $user_id
//      * @return mixed
//      */
//     public function checkUserBusinesses($business_id, $user_id);
// }
