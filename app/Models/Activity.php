<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table='activities';
    protected $fillable = [
        'user_id','date', 'time', 'type','comment','location','lat','lng'
    ];

    public function users() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
