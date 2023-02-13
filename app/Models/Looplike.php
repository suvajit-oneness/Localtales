<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Looplike extends Model
{
    protected $table = 'looplikes';

	protected $fillable = [
	   'user_id', 'loop_id'
	];

	//hasOne relation with User Model
	public function user(){
	    return $this->hasOne(User::class, 'id', 'user_id');
	}
}
