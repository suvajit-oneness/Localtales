<?php

namespace App\Contracts;

interface QueryContract
{
    public function listAllQuery();
    public function createQuery($collection);
    public function viewQuery($id);
    public function updateQueryStatus($collection);
    public function deleteQuery($id);
}