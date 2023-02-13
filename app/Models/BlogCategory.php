<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BlogCategory extends Model
{
    protected $fillable = [
        'title', 'slug','status'
    ];

    public static function insertData($data) {
        $value = DB::table('blog_categories')->where('title', $data['title'])->where('slug', $data['slug'])->get();
        if($value->count() == 0) {
           DB::table('blog_categories')->insert($data);
        }
    }

    public function productDetails() {
        return $this->hasMany('App\Models\Blog', 'blog_category_id', 'id');
    }
    public function subcategory() {
        return $this->hasMany('App\Models\SubCategory', 'category_id', 'id');
    }

}
