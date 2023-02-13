<?php

namespace App\Contracts;

/**
 * Interface LoopContract
 * @package App\Contracts
 */
interface LoopContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listLoops(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findLoopById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createLoop(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateLoop(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteLoop($id);

    /**
     * @return mixed
     */
    public function getLoops();

    /**
     * @param $id
     * @return mixed
     */
    public function detailsLoop($id);

    /**
     * @param $userId
     * @return mixed
     */
    public function userLoops($userId);

    /**
     * @param $id
     * @return mixed
     */
    public function loopComments($id);

    /**
     * @param array $params
     * @return Loop|mixed
     */
    public function createComment(array $params);

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteLoopComment($id);

    /**
     * @param $userId
     * @param $loopId
     * @return bool
     */
    public function likeLoop($userId,$loopId);
}