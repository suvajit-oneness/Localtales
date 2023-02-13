<?php

namespace App\Contracts;

/**
 * Interface BusinessContract
 * @package App\Contracts
 */
interface BusinessContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBusinesss(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findBusinessById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createBusiness(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBusiness(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteBusiness($id);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBusinessStatus(array $params);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsBusiness($id);


    /**
     * @param $pinCode
     * @return mixed
     */
    public function getBusinessByPinCode($pinCode);

    /**
     * @param $pinCode
     * @return mixed
     */
    public function getTrendingBusinessByPinCode($pinCode);

    /**
     * @param $pinCode
     * @param $categoryId
     * @return mixed
     */
    public function getBusinessByCategory($pinCode,$categoryId);

    /**
     * @param business_id
     * @param user_id
     * @return Userbusiness|mixed
     */
   public function saveUserBusiness($directory_id,$user_id,$ip);

    /**
     * @param business_id
     * @param user_id
     * @return bool
     */
   public function deleteUserBusiness($directory_id,$user_id,$ip);

    /**
     * @param $user_id
     * @return mixed
     */
    public function UserBusinesses($user_id);

    /**
     * @param business_id
     * @param $user_id
     * @return mixed
     */
    public function checkUserBusinesses($directory_id,$user_id,$ip);
    
    
    
    
    public function saveUserCollection($directory_id,$user_id,$ip);


    public function deleteUserCollection($directory_id,$user_id,$ip);


    public function UserCollection($user_id);



    public function checkUserCollection($directory_id,$user_id,$ip);
}