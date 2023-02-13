<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'name', 'slug', 'status'
    ];

    public static function insertData($data,$count, $successArr, $failureArr) {
        $value = DB::table('states')->where('name', $data['name'])->where('slug', $data['slug'])->get();
        if($value->count() == 0) {
           DB::table('states')->insert($data);
            array_push($successArr, $data['name']);
           $count++;
        } else {
            array_push($failureArr, $data['name']);
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
