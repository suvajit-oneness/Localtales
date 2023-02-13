<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Suburb extends Model
{
    protected $fillable = [
        'name', 'slug','pin_code', 'status'
    ];

    public function pincode() {
        return $this->belongsTo('App\Models\PinCode', 'pin_code', 'id');
    }

    public static function insertData($data, $count, $successArr, $failureArr) {
        $value = DB::table('suburbs')->where('name', $data['name'])->where('pin_code', $data['pin_code'])->get();
        if($value->count() == 0) {
           DB::table('suburbs')->insert($data);
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
