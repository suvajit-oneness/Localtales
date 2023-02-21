<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DirectoryLoginCode extends Model
{
    public $table = "directory_login_codes";
  
    protected $fillable = [
        'business_id',
        'code',
    ];
}
