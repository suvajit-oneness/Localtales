<?php

namespace App\Contracts;

/**
 * Interface DealContract
 * @package App\Contracts
 */
interface DealContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listDeals(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findDealById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createDeal(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateDeal(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteDeal($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsDeal($id);

    /**
     * @param $businessId
     * @return mixed
     */
    public function getDealsByBusiness($businessId);

     /**
     * @param $pinCode
     * @return mixed
     */
    public function getDealsByPinCode($pinCode);

    /**
     * @param $pinCode
     * @return mixed
     */
    public function getTrendingDealsByPinCode($pinCode);

    /**
     * @param $pinCode
     * @param $categoryId
     * @param $keyword
     * @return mixed
     */
    public function searchDealsData($pinCode,$categoryId,$keyword);

     /**
     * @param $pinCode
     * @param $categoryId
     * @return mixed
     */
    public function getDealsByCategory($pinCode,$categoryId);

    /**
     * @param $pinCode
     * @param $id
     * @return mixed
     */
    public function getRelatedDeals($pinCode,$id);

    /**
     * @param deal_id
     * @param user_id
     * @return Userdeal|mixed
     */
    public function saveUserDeal($deal_id,$user_id);

    /**
     * @param deal_id
     * @param user_id
     * @return bool
     */
    public function deleteUserDeal($deal_id,$user_id);

    /**
     * @param $user_id
     * @return mixed
     */
    public function userDeals($user_id);

    /**
     * @param deal_id
     * @param $user_id
     * @return mixed
     */
    public function checkUserDeals($deal_id, $user_id);

    /**
     * @param $pinCode
     * @param $categoryId
     * @param $keyword
     * @param $expiryDate
     * @param $minPrice
     * @param $maxPrice
     * @return mixed
     */
    public function filterDealsData($pinCode,$categoryId,$keyword,$expiryDate,$minPrice,$maxPrice);
}