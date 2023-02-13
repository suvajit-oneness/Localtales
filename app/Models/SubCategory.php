<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'title','slug', 'category_id', 'status'
    ];


    public function blogcategory() {
        return $this->belongsTo('App\Models\BlogCategory', 'category_id', 'id');
    }

    public static function insertData($data) {
        $value = DB::table('sub_categories')->where('title', $data['title'])->get();
        if($value->count() == 0) {
           DB::table('sub_categories')->insert($data);
        }
    }
}
