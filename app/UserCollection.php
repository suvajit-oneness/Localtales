<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCollection extends Model
{
    protected $table = 'user_collections';

	protected $fillable = [
	   'user_id', 'collection_id'
	];

	public function collection(){
	    return $this->belongsTo('App\Models\Collection' ,'collection_id', 'id');
	}

	public function user(){
	    return $this->belongsTo('App\Models\User' ,'user_id', 'id');
	}
}
