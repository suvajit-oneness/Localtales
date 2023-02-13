<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function category() {
        return $this->belongsTo('App\Models\JobCategory', 'category_id', 'id');
    }

}
