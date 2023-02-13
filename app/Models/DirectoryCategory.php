<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class DirectoryCategory extends Model
{
    protected $fillable = [
        'title', 'slug', 'status'
    ];

    public static function insertData($data,$count, $successArr, $failureArr) {
        $value = DB::table('directory_categories')->where('title', $data['title'])->get();
        if($value->count() == 0) {
           DB::table('directory_categories')->insert($data);
             array_push($successArr, $data['title']);
           $count++;
        } else {
            array_push($failureArr, $data['title']);
        }

        // return $count;

        $resp = [
            "count" => $count,
            "successArr" => $successArr,
            "failureArr" => $failureArr
        ];
        return $resp;
    }

    public function productDetails()
    {
        return $this->hasMany('App\Models\Blog', 'blog_category_id', 'id');
    }
}
