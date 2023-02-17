<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    public $table = "user_codes";
  
    protected $fillable = [
        'business_id',
        'code',
    ];
}
