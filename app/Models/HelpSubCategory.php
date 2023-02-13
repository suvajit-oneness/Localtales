<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class HelpSubCategory extends Model
{
    public $table ='help_subcategories';
    protected $fillable = [
        'title','slug','description', 'category_id', 'status'
    ];


    public function helpcategory() {
        return $this->belongsTo('App\Models\HelpCategory', 'category_id', 'id');
    }

    public static function insertData($data) {
        $value = DB::table('help_sub_categories')->where('title', $data['title'])->get();
        if($value->count() == 0) {
           DB::table('help_sub_categories')->insert($data);
        }
    }
}
