<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CollectionDirectory extends Model
{
    protected $fillable = [
        'collection_id', 'directory_id','status'
    ];


    public function collection() {
        return $this->belongsTo('App\Models\Collection', 'collection_id', 'id');
    }

    public function directory() {
        return $this->belongsTo('App\Models\Directory', 'directory_id', 'id');
    }

    public static function insertData($data) {
        $value = DB::table('collection_directories')->where('collection_id', $data['collection_id'])->get();
        if($value->count() == 0) {
           DB::table('collection_directories')->insert($data);
        }
    }
}
