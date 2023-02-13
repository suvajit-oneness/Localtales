<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpArticle extends Model
{
    public function category() {
        return $this->belongsTo('App\Models\HelpCategory', 'cat_id', 'id');
    }
    public function subcategory() {
        return $this->belongsTo('App\Models\HelpSubCategory', 'sub_cat_id', 'id');
    }
}
