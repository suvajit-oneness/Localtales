<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Blog extends Model
{
    protected $fillable = [
        'title', 'slug','blog_category_id','blog_sub_category_id','image','content','meta_title','meta_key','meta_description','status'
    ];

    public function category() {
        return $this->belongsTo('App\Models\BlogCategory', 'blog_category_id', 'id');
    }
    public function subcategory() {
        return $this->belongsTo('App\Models\SubCategory', 'blog_sub_category_id', 'id');
    }
 public function subcategorylevel() {
        return $this->belongsTo('App\Models\SubCategoryLevel', 'blog_tertiary_category_id', 'id');
    }
    public function pincodedetails() {
        return $this->belongsTo('App\Models\PinCode', 'pincode', 'id');
    }
    public function suburb() {
        return $this->belongsTo('App\Models\Suburb', 'suburb_id', 'id');
    }

    public static function insertData($data, $count, $successArr, $failureArr) {
        $value = DB::table('blogs')->where('title', $data['title'])->get();
        if($value->count() == 0) {
           DB::table('blogs')->insert($data);
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
}
