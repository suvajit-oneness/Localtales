<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class SubCategoryLevel extends Model
{
    protected $fillable = [
        'title', 'slug', 'sub_category_id', 'status'
    ];

    public function subcategory() {
        return $this->belongsTo('App\Models\SubCategory', 'sub_category_id', 'id');
    }

    public static function insertData($data) {
        $value = DB::table('sub_category_levels')->where('title', $data['title'])->get();
        if($value->count() == 0) {
           DB::table('sub_category_levels')->insert($data);
        }
    }
}
