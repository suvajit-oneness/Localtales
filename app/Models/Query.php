<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    public function catagory()
    {
        return $this->belongsTo(QueryCatagory::class, 'query_catagory', 'id');
    }
}
