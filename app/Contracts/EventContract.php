<?php

namespace App\Contracts;

/**
 * Interface EventContract
 * @package App\Contracts
 */
interface EventContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listEvents(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findEventById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createEvent(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateEvent(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteEvent($id);

    /**
     * @param $id
     * @return mixed
     */
    public function detailsEvent($id);

    /**
     * @param $businessId
     * @return mixed
     */
    public function getEventsByBusiness($businessId);

    /**
     * @param $pinCode
     * @return mixed
     */
    public function getEventsByPinCode($pinCode);

    /**
     * @param $pinCode
     * @return mixed
     */
    public function getTrendingEventsByPinCode($pinCode);

    /**
     * @param $pinCode
     * @param $categoryId
     * @param $keyword
     * @return mixed
     */
    public function searchEventsData($category,$from,$to,$keyword);

    /**
     * @param $pinCode
     * @param $categoryId
     * @return mixed
     */
    public function getEventsByCategory($pinCode,$categoryId);

    /**
     * @param $pinCode
     * @param $id
     * @return mixed
     */
    public function getRelatedEvents($pinCode,$id);

    /**
     * @param event_id
     * @param user_id
     * @return Userevent|mixed
     */
    public function saveUserEvent($event_id,$user_id);

    /**
     * @param event_id
     * @param user_id
     * @return bool
     */
    public function deleteUserEvent($event_id,$user_id);

    /**
     * @param $user_id
     * @return mixed
     */
    public function userEvents($user_id);

    /**
     * @param event_id
     * @param $user_id
     * @return mixed
     */
    public function checkUserEvents($event_id, $user_id);

    /**
     * @param $pinCode
     * @param $eventDate
     * @param $keyword
     * @param $categoryId
     * @param $eventformatId
     * @param $languageId
     * @param $isPaid
     * @param $isRecurring
     * @return mixed
     */
    public function filterEventsData($pinCode,$eventDate,$keyword,$categoryId,$eventformatId,$languageId,$isPaid,$isRecurring);
}