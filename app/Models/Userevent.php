<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userevent extends Model
{
    protected $table = 'userevents';

	protected $fillable = [
	   'user_id', 'event_id'
	];

	//hasOne relation with Event Model
	public function event(){
	    return $this->hasOne(Event::class, 'id', 'event_id');
	}
}
