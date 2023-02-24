<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HelpCategory extends Model
{
    protected $fillable = [
        'title', 'description','status'
    ];

    public static function insertData($data,$count) {
        $value = DB::table('help_categories')->where('title', $data['title'])->get();
        if($value->count() == 0) {
           DB::table('help_categories')->insert($data);
           $count++;
        }
        $resp = [
            "count" => $count,
        ];
        return $resp;
    }

    
}
