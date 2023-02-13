<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loopcomment extends Model
{
    protected $table = 'loopcomments';

	protected $fillable = [
	   'user_id', 'loop_id', 'comment', 'status'
	];

	//hasOne relation with User Model
	public function user(){
	    return $this->hasOne(User::class, 'id', 'user_id');
	}

	//hasOne relation with Loop Model
	public function loop(){
	    return $this->hasOne(Loop::class, 'id', 'loop_id');
	}
}
