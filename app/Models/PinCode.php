<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PinCode extends Model
{
    protected $fillable = [
        'pin', 'description', 'status'
    ];


    public function state() {
        return $this->belongsTo('App\Models\State', 'state_id', 'id');
    }

    public static function insertData($data, $count, $successArr, $failureArr) {
        $value = DB::table('pin_codes')->where('pin', $data['pin'])->get();

        if($value->count() == 0) {
            DB::table('pin_codes')->insert($data);
            array_push($successArr, $data['pin']);
            $count++;
        } else {
            array_push($failureArr, $data['pin']);
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





