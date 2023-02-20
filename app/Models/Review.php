<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function directoryDetails() {
        return $this->belongsTo('App\Models\Directory', 'directory_id', 'id');
    }
}
