<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class HelpArticle extends Model
{
    public function category() {
        return $this->belongsTo('App\Models\HelpCategory', 'cat_id', 'id');
    }
    public function subcategory() {
        return $this->belongsTo('App\Models\HelpSubCategory', 'sub_cat_id', 'id');
    }


    public static function insertData($data,$count, $successArr, $failureArr) {
        $value = DB::table('help_articles')->where('title', $data['title'])->get();
        if($value->count() == 0) {
           DB::table('help_articles')->insert($data);
           array_push($successArr, $data['title']);
           $count++;
        } else {
            array_push($failureArr, $data['title']);
        }
        $resp = [
            "count" => $count,
            "successArr" => $successArr,
            "failureArr" => $failureArr
        ];
        return $resp;
    }

}
