<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCollection extends Model
{
    protected $table = 'user_collections';

	protected $fillable = [
	   'user_id', 'collection_id'
	];

	//hasOne relation with Event Model
	public function collection(){
        return $this->belongsTo('App\Models\Collection', 'collection_id', 'id');
	}
}
