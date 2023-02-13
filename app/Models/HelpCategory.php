<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HelpCategory extends Model
{
    protected $fillable = [
        'title', 'description','status'
    ];

    public static function insertData($data) {
        $value = DB::table('help_categories')->where('title', $data['title'])->where('slug', $data['slug'])->get();
        if($value->count() == 0) {
           DB::table('blog_categories')->insert($data);
        }
    }

    
}
