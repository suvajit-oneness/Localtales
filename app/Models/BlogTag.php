<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BlogTag extends Model
{
    protected $fillable = [
        'tag', 'slug','blog_id'
    ];


}
