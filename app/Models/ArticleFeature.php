<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleFeature extends Model
{
    protected $table='article_key_features';


    public function blog() {

        return $this->belongsTo('App\Models\Blog', 'blog_id', 'id');

    }
}
