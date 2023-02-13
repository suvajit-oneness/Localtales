<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Collection extends Model
{
    protected $fillable = [
        'title', 'slug','short_description','status','bottom_content','description','pin_code','suburb_id','meta_title','meta_key','meta_description'
    ];

    public function suburb() {
        return $this->belongsTo('App\Models\Suburb', 'suburb_id', 'id');
    }

    public static function insertData($data, $count, $successArr, $failureArr) {
        $value = DB::table('collections')->where('title', $data['title'])->get();
        if($value->count() == 0) {
            $insertData = DB::table('collections')->insertGetId($data);
            array_push($successArr, $data['title']);
            $count++;
        } else {
            $insertData = null;
            array_push($failureArr, $data['title']);
        }

        $resp = [
            "count" => $count,
            "successArr" => $successArr,
            "id" => $insertData,
            "failureArr" => $failureArr
        ];
        return $resp;
    }
}

