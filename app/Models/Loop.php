<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loop extends Model
{
    protected $table = 'loops';

	protected $fillable = [
	   'content', 'user_id', 'no_of_likes', 'no_of_dislikes', 'no_of_comments', 'status'
	];

	//hasOne relation with User Model
	public function user(){
	    return $this->hasOne(User::class, 'id', 'user_id');
	}

	//hasMany relation with Loopcomment Model
	public function comments(){
		return $this->hasMany(Loopcomment::class);
	}

	//hasMany relation with Looplike Model
	public function likes(){
		return $this->hasMany(Looplike::class);
	}
}
